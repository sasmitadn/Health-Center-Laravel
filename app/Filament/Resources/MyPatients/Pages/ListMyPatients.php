<?php

namespace App\Filament\Resources\MyPatients\Pages;

use App\Filament\Resources\MyPatients\MyPatientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMyPatients extends ListRecords
{
    protected static string $resource = MyPatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
