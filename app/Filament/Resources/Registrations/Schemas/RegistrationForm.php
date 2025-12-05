<?php

namespace App\Filament\Resources\Registrations\Schemas;

use App\Filament\Resources\Doctors\Schemas\DoctorForm;
use App\Filament\Resources\Locations\Schemas\LocationForm;
use App\Filament\Resources\Patients\Schemas\PatientForm;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Registration;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select::make('patient_id')
                //     ->label('Pasien')
                //     ->relationship('patient', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->required()
                //     ->createOptionForm([
                //         TextInput::make('name')
                //             ->required()
                //             ->maxLength(255),
                //         TextInput::make('nik')
                //             ->label('NIK')
                //             ->numeric()
                //             ->required(),
                //         DatePicker::make('dob')
                //             ->label('Tanggal Lahir')
                //             ->required(),
                //         Select::make('gender')
                //             ->options([
                //                 'male' => 'Laki-laki',
                //                 'female' => 'Perempuan'
                //             ])->required(),
                //         Textarea::make('address')
                //             ->rows(2),
                //     ]),

                // // 2. Tanggal Kunjungan
                // DatePicker::make('visit_date')
                //     ->label('Tanggal Kunjungan')
                //     ->default(now())
                //     ->minDate(now())
                //     ->required()
                //     ->live(), // Live update agar dokter terfilter
                //     // ->afterStateUpdated(fn(Set $set) => $set('doctor_id', null)),

                // // 3. Pilih Dokter (Dependent Dropdown)
                // Select::make('doctor_id')
                //     ->label('Dokter Tersedia')
                //     ->options(function (Get $get) {
                //         $date = $get('visit_date');
                //         if (!$date) return [];

                //         $dayName = Carbon::parse($date)->format('l');

                //         // Asumsi relasi 'schedules' ada di model Doctor
                //         return Doctor::whereHas('schedules', function ($query) use ($dayName) {
                //             $query->where('day', $dayName);
                //         })->pluck('name', 'id');
                //     })
                //     ->required()
                //     ->live()
                //     ->helperText(function (Get $get, $state) {
                //         if (!$get('visit_date') || !$state) return null;
                //         // Optional: Tampilkan sisa kuota atau antrian saat ini
                //         $count = Registration::where('doctor_id', $state)
                //             ->where('visit_date', $get('visit_date'))
                //             ->count();
                //         return "Antrian saat ini: " . $count . " pasien.";
                //     }),

                // // 4. Status (Hanya muncul saat edit)
                // Select::make('status')
                //     ->options([
                //         'waiting' => 'Menunggu',
                //         'examining' => 'Diperiksa',
                //         'done' => 'Selesai',
                //         'cancelled' => 'Batal',
                //     ])
                //     ->default('waiting')
                //     ->required()
                //     ->visibleOn('edit'),


                Select::make('patient_id')
                    ->label('Pasien')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm(PatientForm::getFormSchema()),

                // --- PERUBAHAN LOGIC MULAI DARI SINI ---

                // 2. Pilih Lokasi (Step 1)
                Select::make('location_id')
                    ->label('Lokasi Klinik')
                    ->relationship('location', 'name') // Asumsi tabel locations, field name
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->createOptionForm(LocationForm::getFormSchema())
                    ->afterStateUpdated(function (Set $set) {
                        // Reset doctor dan tanggal jika lokasi berubah
                        $set('doctor_id', null);
                        $set('visit_date', null);
                    }),

                // 3. Pilih Dokter (Step 2 - Filter by Location)
                Select::make('doctor_id')
                    ->label('Dokter')
                    ->options(function (Get $get) {
                        $locationId = $get('location_id');
                        if (!$locationId) return [];

                        // Filter dokter berdasarkan location_id
                        return Doctor::whereHas('schedules', function ($query) use ($locationId) { // Ganti 'schedules' sesuai nama fungsi relasi di Model Doctor
                            $query->where('location_id', $locationId);
                        })->pluck('name', 'id');
                    })
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('visit_date', null)) // Reset tanggal jika dokter berubah
                    ->disabled(fn(Get $get) => !$get('location_id')),

                // 4. Info Jadwal (Text Schedule)
                Placeholder::make('schedule_info')
                    ->label('Jadwal Praktik')
                    ->content(function (Get $get) {
                        $doctorId = $get('doctor_id');
                        if (!$doctorId) return '-';

                        // Ambil jadwal dari relasi schedules
                        $schedules = DoctorSchedule::where('doctor_id', $doctorId)->get();

                        if ($schedules->isEmpty()) return 'Tidak ada jadwal tersedia.';

                        // Format tampilan jadwal
                        $list = $schedules->map(fn($s) => "<li><strong>{$s->day}:</strong> {$s->start_time} - {$s->end_time}</li>")->join('');

                        return new HtmlString("<ul class='list-disc pl-4 text-sm'>{$list}</ul>");
                    })
                    ->visible(fn(Get $get) => filled($get('doctor_id'))),

                // 5. Tanggal Kunjungan (Step 3 - Validasi Hari)
                DatePicker::make('visit_date')
                    ->label('Tanggal Kunjungan')
                    ->required()
                    ->minDate(today())
                    ->disabled(fn(Get $get) => !$get('doctor_id'))
                    ->helperText('Pilih tanggal sesuai hari praktik dokter di atas.')
                    // Custom Validation Rule: Cek apakah hari yang dipilih ada di jadwal dokter
                    ->rule(function (Get $get) {
                        return function (string $attribute, $value, \Closure $fail) use ($get) {
                            $doctorId = $get('doctor_id');
                            $selectedDay = Carbon::parse($value)->format('l'); // e.g., 'Monday'

                            // Cek DB apakah dokter punya jadwal di hari tersebut
                            $exists = DoctorSchedule::where('doctor_id', $doctorId)
                                ->where('day', $selectedDay) // Pastikan format 'day' di DB sama (English/Indo)
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
                    ->required()
                    ->visibleOn('edit'),
            ]);
    }
}
