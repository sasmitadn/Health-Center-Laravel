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

class PatientForm1
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Identitas Peserta')
                ->description('Data wajib sesuai KTP/KK')
                ->schema([
                    TextInput::make('nik')
                        ->label('NIK')
                        ->required()
                        ->numeric()
                        ->length(16)
                        ->unique(ignoreRecord: true) // Penting: ignore saat edit
                        ->validationMessages([
                            'unique' => 'NIK ini sudah terdaftar.',
                            'digits' => 'NIK harus 16 digit.',
                        ]),

                    TextInput::make('no_bpjs')
                        ->label('Nomor BPJS')
                        ->numeric()
                        ->maxLength(13) // Sesuaikan standar BPJS
                        ->placeholder('Opsional jika pasien umum'),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state)) // Hanya simpan jika ada isinya
                        ->required(fn (string $context): bool => $context === 'create'),

                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255), // Agar nama panjang muat
                ])->columns(2),

            Section::make('Detail Pribadi')
                ->schema([

                    Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple() // User bisa punya banyak role
                        ->preload()
                        ->searchable(),

                    DatePicker::make('dob')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->maxDate(now()) // Tidak boleh tanggal masa depan
                        ->native(false), // Pakai JS datepicker agar lebih UX friendly

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(table: 'users')
                        ->maxLength(255), // Agar nama panjang muat

                    Hidden::make('type')->default('patient'),

                    // Opsional: Tambahkan Select Gender jika ada di migration
                    // Select::make('gender')...

                    Textarea::make('address')
                        ->label('Alamat Domisili')
                        ->rows(3)
                        ->required()
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
