<?php

namespace App\Filament\Patient\Resources\Registrations\Pages;

use App\Filament\Patient\Resources\Registrations\RegistrationsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
