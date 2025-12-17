<?php

namespace App\Filament\Doctor\Resources\Doctors\Pages;

use App\Filament\Doctor\Resources\Doctors\DoctorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctor extends CreateRecord
{
    protected static string $resource = DoctorResource::class;
}
