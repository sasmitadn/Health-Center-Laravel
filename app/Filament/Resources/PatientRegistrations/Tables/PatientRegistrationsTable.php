<?php

namespace App\Filament\Resources\PatientRegistrations\Tables;

use App\Models\PatientRegistration;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PatientRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('queue_number')
                    ->label('No.')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('reg_number')
                    ->label('No. Reg')
                    ->searchable()
                    ->limit(5)
                    ->tooltip(fn($record) => $record->reg_number)
                    ->copyable(),

                TextColumn::make('visit_date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('patient.name')
                    ->label('Pasien')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('doctor.name')
                    ->label('Dokter')
                    ->description(fn (PatientRegistration $record) => $record->doctor->specialization ?? '-'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'gray',
                        'examining' => 'warning',
                        'done' => 'success',
                        'cancelled' => 'danger',
                    }),
            ])
            ->filters([

            ])
            ->recordActions([
                Action::make('print_card') // Pindahkan ke sini
                    ->label('Cetak Tiket')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (PatientRegistration $record) => route('registrations.print', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
