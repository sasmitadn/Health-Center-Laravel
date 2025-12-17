<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PatientForm
{
    public static function getFormSchema(): array
    {
        return [
            // ==========================================
            // BAGIAN 1: DATA AKUN (Tabel Users)
            // ==========================================
            Section::make('Informasi Akun')
                ->description('Informasi login dan identitas utama sistem')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(table: 'users', ignoreRecord: true)
                        ->maxLength(255),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->required(fn (string $operation): bool => $operation === 'create'),

                ])->columns(2),

            // ==========================================
            // BAGIAN 2: DATA PASIEN (Tabel Patients)
            // Menggunakan ->relationship('patient')
            // ==========================================
            Section::make('Detail Data Pasien')
                ->description('Data medis dan kependudukan (Disimpan otomatis ke tabel patients)')
                ->relationship('patient') // <--- INI MAGIC-NYA: Auto handle user_id & save order
                ->schema([
                    TextInput::make('nik')
                        ->label('NIK')
                        ->required()
                        ->numeric()
                        ->length(16)
                        ->unique(table: 'patients', ignoreRecord: true)
                        ->validationMessages([
                            'unique' => 'NIK ini sudah terdaftar di sistem.',
                            'digits' => 'NIK harus tepat 16 digit.',
                        ]),

                    TextInput::make('no_bpjs')
                        ->label('Nomor BPJS')
                        ->numeric()
                        ->maxLength(13)
                        ->placeholder('Kosongkan jika pasien umum'),

                    DatePicker::make('dob')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->maxDate(now())
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    Textarea::make('address')
                        ->label('Alamat Domisili')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(self::getFormSchema());
    }
}
