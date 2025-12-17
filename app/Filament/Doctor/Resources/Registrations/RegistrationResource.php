<?php

namespace App\Filament\Doctor\Resources\Registrations;

use App\Filament\Doctor\Resources\Registrations\Pages\CreateRegistration;
use App\Filament\Doctor\Resources\Registrations\Pages\EditRegistration;
use App\Filament\Doctor\Resources\Registrations\Pages\ListRegistrations;
use App\Filament\Doctor\Resources\Registrations\Schemas\RegistrationForm;
use App\Filament\Doctor\Resources\Registrations\Tables\RegistrationsTable;
use App\Models\Registration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static string|BackedEnum|null $navigationIcon = 'fluentui-patient-20-o';

    protected static ?string $recordTitleAttribute = 'Registration';

    public static function form(Schema $schema): Schema
    {
        return RegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegistrationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'My Patient';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegistrations::route('/'),
            // 'create' => CreateRegistration::route('/create'),
            // 'edit' => EditRegistration::route('/{record}/edit'),
        ];
    }
}
