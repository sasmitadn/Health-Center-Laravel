<?php

namespace App\Filament\Resources\MyPatients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use App\Filament\Doctor\Resources\MedicalRecords\MedicalRecordResource;
use App\Models\MyPatient;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Builder;

class MyPatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        // 1. Scope Global: Hanya pasien HARI INI & DOKTER LOGIN, urut antrian
        // ->modifyQueryUsing(fn (Builder $query) => $query
        //     ->where('doctor_id', auth('web')->user()->doctor?->id)
        //     ->whereDate('visit_date', today())
        //     ->orderBy('queue_number', 'asc')
        // )
        ->modifyQueryUsing(function (Builder $query) {
            // 1. Ambil User Login
            $user = auth('web')->user();

            // 2. Debugging Logic (Deepthinker Safety)
            // Pastikan user ini beneran punya data di tabel doctors
            if (! $user || ! $user->doctor) {
                // Jika bukan dokter, return query kosong (biar gak error/bocor)
                return $query->whereRaw('1 = 0');
            }

            // 3. Ambil ID Dokter (Harusnya 2, bukan 5)
            $doctorId = $user->doctor->id;

            // 4. Filter Query
            return $query
                ->where('doctor_id', $doctorId) // Mencari doctor_id = 2
                ->orderBy('queue_number', 'asc');
        })
        // 2. Auto-poll agar antrian update real-time (opsional, 5 detik)
        ->poll('5s')
        ->columns([
            TextColumn::make('queue_number')
                ->label('No. Antrian')
                ->size('lg')
                ->weight('bold')
                ->alignCenter(),

            TextColumn::make('reg_number')
                ->label('No. Reg')
                ->color('gray')
                ->copyable(),

            TextColumn::make('patient.name') // Asumsi ada relasi belongsTo 'patient'
                ->label('Nama Pasien')
                ->searchable()
                ->weight('medium'),

            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'waiting' => 'gray',
                    'examining' => 'warning',
                    'done' => 'success',
                    default => 'gray',
                }),
        ])
        ->filters([
            // 3. Filter Status: Default 'waiting' agar fokus ke antrian
            SelectFilter::make('status')
                ->options([
                    'waiting' => 'Menunggu',
                    'examining' => 'Sedang Diperiksa',
                    'done' => 'Selesai',
                ])
                ->default('waiting'),
        ])
        ->recordActions([
                Action::make('add_medical_record')
                ->label('Periksa')
                ->icon('heroicon-m-clipboard-document-list')
                ->button() // Tampil sebagai tombol
                ->url(fn (MyPatient $record) => MedicalRecordResource::getUrl('create', [
                    // Kirim pre-fill data via query string (tangkap di form() method MedicalRecord)
                    'patient_id' => $record->patient_id,
                    'registration_id' => $record->id
                ])),
            ])
        ->toolbarActions([

            BulkActionGroup::make([

                DeleteBulkAction::make(),

            ]),

        ]);
    }
}
