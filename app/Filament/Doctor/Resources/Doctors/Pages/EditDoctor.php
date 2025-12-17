<?php

namespace App\Filament\Doctor\Resources\Doctors\Pages;

use App\Filament\Doctor\Resources\Doctors\DoctorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctor extends EditRecord
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
