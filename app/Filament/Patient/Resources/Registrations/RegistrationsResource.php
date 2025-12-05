<?php

namespace App\Filament\Patient\Resources\Registrations;

use App\Filament\Patient\Resources\Registrations\Pages\CreateRegistrations;
use App\Filament\Patient\Resources\Registrations\Pages\EditRegistrations;
use App\Filament\Patient\Resources\Registrations\Pages\ListRegistrations;
use App\Filament\Patient\Resources\Registrations\Schemas\RegistrationsForm;
use App\Filament\Patient\Resources\Registrations\Tables\RegistrationsTable;
use App\Models\Registration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegistrationsResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Registration';

    public static function form(Schema $schema): Schema
    {
        return RegistrationsForm::configure($schema);
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

    public static function getPages(): array
    {
        return [
            'index' => ListRegistrations::route('/'),
            'create' => CreateRegistrations::route('/create'),
            'edit' => EditRegistrations::route('/{record}/edit'),
        ];
    }
}
