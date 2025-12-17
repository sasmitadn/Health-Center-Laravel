<?php

namespace App\Filament\Widgets;

use App\Models\DoctorSchedule;
use App\Models\PatientRegistration;
use App\Models\Registration;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class PatientWidget extends Widget
{
    protected string $view = 'filament.widgets.patient-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        // 1. Ambil registrasi aktif/mendatang milik pasien yang login
        // Asumsi: Auth user adalah Patient, atau relasi user()->patient
        $patientId = auth('web')->user()->patient?->id;

        $registration = PatientRegistration::with(['doctor', 'location'])
            ->where('patient_id', $patientId)
            ->whereIn('status', ['waiting', 'examining']) // Filter status aktif
            ->whereDate('visit_date', '>=', today())
            ->orderBy('visit_date', 'asc')
            ->first();

        $doctorSchedule = null;

        // 2. Jika ada registrasi, ambil jadwal dokter di hari itu (Senin/Selasa/dll)
        if ($registration) {
            $dayName = Carbon::parse($registration->visit_date)->format('l'); // Ex: Monday

            $doctorSchedule = DoctorSchedule::where('doctor_id', $registration->doctor_id)
                ->where('location_id', $registration->location_id)
                ->where('day', $dayName)
                ->first();
        }

        return [
            'registration' => $registration,
            'schedule' => $doctorSchedule,
        ];
    }
}
