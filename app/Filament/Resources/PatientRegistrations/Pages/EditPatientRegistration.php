<?php

namespace App\Filament\Resources\PatientRegistrations\Pages;

use App\Filament\Resources\PatientRegistrations\PatientRegistrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPatientRegistration extends EditRecord
{
    protected static string $resource = PatientRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
