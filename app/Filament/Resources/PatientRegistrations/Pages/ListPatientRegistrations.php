<?php

namespace App\Filament\Resources\PatientRegistrations\Pages;

use App\Filament\Resources\PatientRegistrations\PatientRegistrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPatientRegistrations extends ListRecords
{
    protected static string $resource = PatientRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
