<?php

namespace App\Filament\Resources\Doctors\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->searchable(),
                // TextColumn::make("specialization")
                //     ->searchable()
                //     ->sortable(),

                TextColumn::make("specialization")
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'general_practitioner' => 'General Practitioner',
                        'dentist' => 'Dentist',
                        'midwife' => 'Midwife',
                        'pediatrician' => 'Pediatrician',
                        'obgyn' => 'Obstetrician & Gynecologist',
                        'internist' => 'Internist',
                        'clinical_nutritionist' => 'Clinical Nutritionist',
                        'ent_specialist' => 'ENT Specialist',
                        'ophthalmologist' => 'Ophthalmologist',
                        'dermatologist' => 'Dermatologist',
                        'pulmonologist' => 'Pulmonologist',
                        'psychiatrist' => 'Psychiatrist',
                        'pharmacist' => 'Pharmacist',
                        'nurse' => 'Nurse',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable()
                    ->badge() // Opsional: Biar tampilannya kotak berwarna (seperti kategori)
                    ->color('info'),

                TextColumn::make('schedules_list') // Ganti nama agar tidak auto-detect relasi list
                    ->label('Jadwal Praktek')
                    ->html()
                    ->state(function ($record) {
                        // 1. Cek Kosong
                        if ($record->schedules->isEmpty()) {
                            return '<span class="text-gray-400 italic">Belum ada jadwal</span>';
                        }

                        // 2. Setup Variable
                        $dayMap = [
                            'Monday'    => ['rank' => 1, 'label' => 'Senin'],
                            'Tuesday'   => ['rank' => 2, 'label' => 'Selasa'],
                            'Wednesday' => ['rank' => 3, 'label' => 'Rabu'],
                            'Thursday'  => ['rank' => 4, 'label' => 'Kamis'],
                            'Friday'    => ['rank' => 5, 'label' => 'Jumat'],
                            'Saturday'  => ['rank' => 6, 'label' => 'Sabtu'],
                            'Sunday'    => ['rank' => 7, 'label' => 'Minggu'],
                        ];

                        // 3. Logic: Unique -> Sort -> Format -> Implode
                        return $record->schedules
                            // Unik berdasarkan kombinasi Hari + Jam Mulai
                            ->unique(fn($item) => $item->day . $item->start_time)
                            // Urutkan berdasarkan Ranking Hari
                            ->sortBy(fn($item) => $dayMap[$item->day]['rank'] ?? 99)
                            // Format teks
                            ->map(function ($schedule) use ($dayMap) {
                                $dayIndo = $dayMap[$schedule->day]['label'] ?? $schedule->day;
                                $start   = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                                $end     = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');

                                return "{$dayIndo} {$start} - {$end}";
                            })
                            // Gabung jadi satu string HTML
                            ->implode('<br>');
                    }),

                ToggleColumn::make('is_active')
                    ->sortable(),
            ])
            ->filters([
                //
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
