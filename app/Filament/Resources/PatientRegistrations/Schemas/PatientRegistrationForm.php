<?php

namespace App\Filament\Resources\PatientRegistrations\Schemas;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PatientRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Hidden::make('patient_id')
                    ->default(fn() => auth('web')->user()->patient?->id)
                    ->dehydrated(),

                // 2. Pilih Lokasi (Step 1)
                Select::make('location_id')
                    ->label('Lokasi Klinik')
                    ->relationship('location', 'name') // Asumsi tabel locations, field name
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        // Reset doctor dan tanggal jika lokasi berubah
                        $set('doctor_id', null);
                        $set('visit_date', null);
                    }),

                // 3. Pilih Dokter (Step 2 - Filter by Location)

                // 1. SELECT DOKTER
                Select::make('doctor_id')
                    ->label('Dokter')
                    ->options(function (Get $get) {
                        $locationId = $get('location_id');
                        if (! $locationId) return [];

                        // Query ke DOCTOR, bukan User
                        return Doctor::query()
                            // Filter dokter yang punya jadwal di lokasi ini
                            ->whereHas('schedules', function ($query) use ($locationId) {
                                $query->where('location_id', $locationId);
                            })
                            ->with('user') // Load user untuk ambil namanya
                            ->get()
                            // --- INI KUNCINYA ---
                            // Key (Value) = Doctor ID (untuk Database)
                            // Value (Label) = User Name (untuk Tampilan)
                            ->mapWithKeys(function ($doctor) {
                                return [$doctor->id => $doctor->user->name ?? 'Tanpa Nama'];
                            });
                    })
                    ->required()
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(fn(Set $set) => $set('visit_date', null))
                    ->disabled(fn(Get $get) => ! $get('location_id')),


                // 2. PLACEHOLDER JADWAL (Logic lebih simple)
                Placeholder::make('schedule_info')
                    ->label('Jadwal Praktik')
                    ->content(function (Get $get) {
                        // Karena sekarang value-nya Doctor ID, kita bisa langsung query
                        $doctorId = $get('doctor_id');
                        if (!$doctorId) return '-';

                        $schedules = DoctorSchedule::where('doctor_id', $doctorId)->get();

                        if ($schedules->isEmpty()) return 'Tidak ada jadwal tersedia.';

                        $list = $schedules->map(fn($s) => "<li><strong>{$s->day}:</strong> {$s->start_time} - {$s->end_time}</li>")->join('');

                        return new HtmlString("<ul class='list-disc pl-4 text-sm'>{$list}</ul>");
                    })
                    ->visible(fn(Get $get) => filled($get('doctor_id'))),


                // 3. DATE PICKER & VALIDASI (Logic lebih simple)
                DatePicker::make('visit_date')
                    ->label('Tanggal Kunjungan')
                    ->required()
                    ->minDate(today())
                    ->disabled(fn(Get $get) => !$get('doctor_id'))
                    ->helperText('Pilih tanggal sesuai hari praktik dokter di atas.')
                    ->rule(function (Get $get) {
                        return function (string $attribute, $value, \Closure $fail) use ($get) {
                            // Ini sudah Doctor ID, tidak perlu lookup User->Doctor lagi
                            $doctorId = $get('doctor_id');

                            $selectedDay = \Carbon\Carbon::parse($value)->format('l');

                            $exists = DoctorSchedule::where('doctor_id', $doctorId)
                                ->where('day', $selectedDay)
                                ->exists();

                            if (!$exists) {
                                $fail("Dokter tidak praktik pada hari {$selectedDay}.");
                            }
                        };
                    }),
                // 6. Status (Edit Only)
                Select::make('status')
                    ->options([
                        'waiting' => 'Menunggu',
                        'examining' => 'Diperiksa',
                        'done' => 'Selesai',
                        'cancelled' => 'Batal',
                    ])
                    ->default('waiting')
                    ->disabled()
                    ->visibleOn('edit'),
            ]);
    }
}
