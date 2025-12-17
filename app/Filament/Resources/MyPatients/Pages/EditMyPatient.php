<?php

namespace App\Filament\Resources\MyPatients\Pages;

use App\Filament\Resources\MyPatients\MyPatientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMyPatient extends EditRecord
{
    protected static string $resource = MyPatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
