<?php

namespace App\Filament\Resources\Doctors\Schemas;

use App\Models\Doctor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('specialization')
                    ->options([
                        'general_practitioner' => 'General Practitioner', // Dokter Umum
                        'dentist' => 'Dentist', // Dokter Gigi
                        'midwife' => 'Midwife', // Bidan (Sering masuk kategori medis di Puskesmas)
                        'pediatrician' => 'Pediatrician', // Spesialis Anak
                        'obgyn' => 'Obstetrician & Gynecologist', // Spesialis Kandungan (Obgyn)
                        'internist' => 'Internist', // Spesialis Penyakit Dalam
                        'clinical_nutritionist' => 'Clinical Nutritionist', // Spesialis Gizi
                        'ent_specialist' => 'ENT Specialist', // Spesialis THT (Telinga, Hidung, Tenggorokan)
                        'ophthalmologist' => 'Ophthalmologist', // Spesialis Mata
                        'dermatologist' => 'Dermatologist', // Spesialis Kulit & Kelamin
                        'pulmonologist' => 'Pulmonologist', // Spesialis Paru (Umum di poli TB/Paru)
                        'psychiatrist' => 'Psychiatrist', // Kesehatan Jiwa
                        'pharmacist' => 'Pharmacist', // Apoteker
                        'nurse' => 'Nurse', // Perawat
                    ])
                    ->searchable()
                    ->native(false),
                ToggleButtons::make('is_active')
                    ->label('Active')
                    ->required()
                    ->options([
                        '1' => 'Active',
                        '0' => 'In-Active'
                    ])->inline(),

                Repeater::make('schedules')
                    ->relationship()
                    ->schema([
                        Select::make('location_id')
                            ->label('Location')
                            ->relationship('location', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                                Textarea::make('address')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('latitude')
                                    ->numeric(),
                                TextInput::make('longitude')
                                    ->numeric(),
                            ]),
                        Select::make('day')
                            ->options([
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu'
                            ])
                            ->required(),
                        TimePicker::make('start_time')->required(),
                        TimePicker::make('end_time')->required(),
                    ])
                    ->reorderableWithButtons()
                    ->columns(4)
                    ->columnSpanFull()


            ])
            ->columns(3);
    }
}
