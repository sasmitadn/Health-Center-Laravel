<?php

namespace App\Filament\Doctor\Resources\MedicalRecords\Schemas;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Registration;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class MedicalRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('patient_id')
                    ->default(fn () => request()->query('patient_id')),

                // Jika tabel medical_records punya kolom registration_id
                Hidden::make('registration_id')
                    ->default(fn () => request()->query('registration_id')),
                Hidden::make('doctor_id')
                    ->default(fn () => auth('doctor')->id()),

                Section::make('Data Pasien')
                    ->schema([
                        Grid::make(3)->schema([
                            Placeholder::make('p_name')
                                ->label('Nama')
                                ->content(function (?MedicalRecord $record) {
                                    // Logic: Kalau Edit pake record, kalau Create pake URL
                                    if ($record) return $record->patient->name;

                                    $patientId = request()->query('patient_id');
                                    return Patient::find($patientId)?->name ?? '-';
                                }),

                            Placeholder::make('p_reg')
                                ->label('No. Reg')
                                ->content(function (?MedicalRecord $record) {
                                    // Kita ambil logic yang sama
                                    if ($record) return $record->reg_number ?? '-'; // Asumsi ada relasi ke patient

                                    // Karena di tabel patient biasanya ga ada reg_number (itu di registration),
                                    // kita ambil dari Registration ID di URL jika perlu,
                                    // TAPI jika reg_number ada di patient, pakai cara di bawah:
                                    $patientId = request()->query('registration_id');
                                    return Registration::find($patientId)?->reg_number ?? '-';
                                }),

                            Placeholder::make('p_age')
                                ->label('Tanggal Lahir')
                                ->content(function (?MedicalRecord $record) {
                                    if ($record) return $record->patient->dob->age;

                                    $patientId = request()->query('patient_id');
                                    return Patient::find($patientId)?->dob ?? '-';
                                }),
                        ]),
                    ])
                    ->compact(),


                Section::make('Riwayat Medis Sebelumnya')
                    ->collapsible()
                    ->collapsed() // Default tertutup agar rapi
                    ->schema([
                        Placeholder::make('history_list')
                            ->hiddenLabel()
                            ->content(function () {
                                $patientId = request()->query('patient_id');

                                if (!$patientId) {
                                    return new HtmlString('<p class="text-gray-500 italic">Data pasien tidak ditemukan.</p>');
                                }

                                $records = MedicalRecord::where('patient_id', $patientId)
                                    ->latest()
                                    ->take(5) // Ambil 5 terakhir saja
                                    ->get();

                                if ($records->isEmpty()) {
                                    return new HtmlString('<p class="text-gray-500 italic">Belum ada riwayat medis.</p>');
                                }

                                // Render simple HTML list
                                $html = '<div class="space-y-4">';
                                foreach ($records as $rec) {
                                    $date = $rec->created_at->format('d M Y H:i');
                                    $html .= "
                                        <div class='p-3 border rounded bg-gray-50 dark:bg-gray-800 mt-3'>
                                            <div class='flex justify-between mb-1'>
                                                <span class='text-xs text-gray-500'>{$date}</span> -
                                                <span class='font-bold text-primary-600'>{$rec->title}</span>
                                            </div>
                                            <p class='text-sm text-gray-600 dark:text-gray-300'>{$rec->description}</p>
                                        </div>
                                    ";
                                }
                                $html .= '</div>';

                                return new HtmlString($html);
                            }),
                    ]),




                Section::make('Rekam Medis')
                ->schema([
                    TextInput::make('title')
                        ->label('Diagnosa / Judul')
                        ->required()
                        ->placeholder('Misal: Flu Berat'),

                    Textarea::make('description')
                        ->label('Catatan Dokter & Resep')
                        ->rows(5)
                        ->required(),
                ]),
            ])->columns(2);
            // ->action(function (array $data, Registration $record) {
            //     // 1. Simpan ke tabel medical_records
            //     MedicalRecord::create([
            //         'patient_id' => $record->patient_id,
            //         'title' => $data['title'],
            //         'description' => $data['description'],
            //         // Jika perlu simpan doctor_id atau registration_id, tambahkan di sini
            //     ]);

            //     // 2. Update status antrian jadi 'done'
            //     $record->update(['status' => 'done']);

            //     // 3. Notifikasi
            //     Notification::make()->title('Pemeriksaan Selesai')->success()->send();
            // });
    }
}
