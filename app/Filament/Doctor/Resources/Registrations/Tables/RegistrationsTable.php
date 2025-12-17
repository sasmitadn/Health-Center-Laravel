<?php

namespace App\Filament\Doctor\Resources\Registrations\Tables;

use App\Filament\Doctor\Resources\MedicalRecords\MedicalRecordResource;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Builder;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        // 1. Scope Global: Hanya pasien HARI INI & DOKTER LOGIN, urut antrian
        ->modifyQueryUsing(fn (Builder $query) => $query
            ->where('doctor_id', auth('doctor')->id())
            // ->whereDate('visit_date', today())
            ->orderBy('queue_number', 'asc')
        )
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
                ->url(fn (Registration $record) => MedicalRecordResource::getUrl('create', [
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
