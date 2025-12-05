<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationPrintController extends Controller
{
    public function __invoke(Registration $registration): View
    {
        // Validasi tambahan jika perlu (misal: hanya user klinik yang bisa cetak)
        // $this->authorize('view', $registration);

        return view('registrations.card', [
            'registration' => $registration->load(['patient', 'doctor']),
        ]);
    }
}
