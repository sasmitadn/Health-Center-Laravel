<?php

namespace App\Filament\Patient\Resources\Registrations\Pages;

use App\Filament\Patient\Resources\Registrations\RegistrationsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistrations extends EditRecord
{
    protected static string $resource = RegistrationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
