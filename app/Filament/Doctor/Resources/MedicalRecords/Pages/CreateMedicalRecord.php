<?php

namespace App\Filament\Doctor\Resources\MedicalRecords\Pages;

use App\Filament\Doctor\Resources\MedicalRecords\MedicalRecordResource;
use App\Filament\Doctor\Resources\Registrations\RegistrationResource;
use App\Models\Registration;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicalRecord extends CreateRecord
{
    protected static string $resource = MedicalRecordResource::class;

    protected function getRedirectUrl(): string
    {
        return RegistrationResource::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return null;
    }

    protected function afterCreate(): void
    {
        $registrationId = $this->data['registration_id'] ?? null;
        if ($registrationId) {
            Registration::where('id', $registrationId)
                ->update(['status' => 'done']);
        }

        Notification::make()
            ->title('Pemeriksaan Selesai!')
            ->body('Data rekam medis berhasil dicatat dan status antrian pasien telah diperbarui.')
            ->success()
            ->duration(5000)
            ->send();
    }
}
