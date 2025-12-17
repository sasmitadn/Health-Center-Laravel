<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\Patient;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function afterCreate(): void
    {
        // Ambil user yang baru saja dibuat
        $user = $this->record;

        // Assign Role secara backend
        $user->assignRole('patient');

        // (Opsional) Jika kamu pakai Shield dan ingin memastikan user ini valid di panel
        // $user->givePermissionTo('access_patient_panel');
    }
}
