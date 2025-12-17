<?php

namespace App\Filament\Resources\MyPatients\Pages;

use App\Filament\Resources\MyPatients\MyPatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMyPatient extends CreateRecord
{
    protected static string $resource = MyPatientResource::class;
}
