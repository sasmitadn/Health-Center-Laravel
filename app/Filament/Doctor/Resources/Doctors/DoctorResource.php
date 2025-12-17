<?php

namespace App\Filament\Doctor\Resources\Doctors;

use App\Filament\Doctor\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Doctor\Resources\Doctors\Pages\EditDoctor;
use App\Filament\Doctor\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Doctor\Resources\Doctors\Schemas\DoctorForm;
use App\Filament\Doctor\Resources\Doctors\Tables\DoctorsTable;
use App\Models\Doctor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static string|BackedEnum|null $navigationIcon = 'fluentui-doctor-28-o';

    protected static ?string $recordTitleAttribute = 'Doctor';

    public static function form(Schema $schema): Schema
    {
        return DoctorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'My Schedule';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctor::route('/create'),
            'edit' => EditDoctor::route('/{record}/edit'),
        ];
    }
}
