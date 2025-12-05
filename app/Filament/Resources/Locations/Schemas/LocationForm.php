<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            Textarea::make('address')
                ->required()
                ->columnSpanFull(),
            TextInput::make('latitude')
                ->numeric(),
            TextInput::make('longitude')
                ->numeric(),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(self::getFormSchema());
    }
}
