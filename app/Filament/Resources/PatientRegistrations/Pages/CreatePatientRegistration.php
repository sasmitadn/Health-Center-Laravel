<?php

namespace App\Filament\Resources\PatientRegistrations\Pages;

use App\Filament\Resources\PatientRegistrations\PatientRegistrationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatientRegistration extends CreateRecord
{
    protected static string $resource = PatientRegistrationResource::class;
}
