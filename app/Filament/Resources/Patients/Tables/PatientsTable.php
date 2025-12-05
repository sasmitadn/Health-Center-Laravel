<?php

namespace App\Filament\Resources\Patients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->copyable() // Fitur copy cepat (berguna buat input ke P-Care BPJS)
                    ->icon('heroicon-m-identification')
                    ->color('gray'),

                TextColumn::make('no_bpjs')
                    ->label('Status')
                    ->getStateUsing(fn($record) => $record->no_bpjs ?? 'UMUM')
                    ->badge()
                    ->color(fn($state) => $state === 'UMUM' ? 'gray' : 'success')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->where('no_bpjs', 'like', "%{$search}%");
                    }),

                TextColumn::make('dob')
                    ->label('Usia / Tgl Lahir')
                    ->date('d M Y')
                    ->description(fn($record) => $record->dob->age . ' Tahun') // Insight krusial: langsung lihat umur
                    ->sortable(),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30) // Truncate biar tabel gak lebar
                    ->tooltip(fn($record) => $record->address),
            ])
            ->filters([
                TernaryFilter::make('has_bpjs')
                    ->label('Tipe Pasien')
                    ->placeholder('Semua')
                    ->trueLabel('BPJS')
                    ->falseLabel('Umum')
                    ->queries(
                        true: fn($query) => $query->whereNotNull('no_bpjs'),
                        false: fn($query) => $query->whereNull('no_bpjs'),
                    ),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
