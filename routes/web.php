<?php

use App\Http\Controllers\RegistrationPrintController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/debug-shield', function() {
    $user = \App\Models\User::first(); // Asumsi user pertama adalah super admin
    return [
        'is_super_admin' => $user->hasRole('super_admin'),
        'can_view_any' => $user->can('view_any_registration'),
        'policy_check' => Gate::forUser($user)->allows('viewAny', \App\Models\Registration::class),
    ];
});

Route::get('/registrations/{registration}/print', RegistrationPrintController::class)
        ->name('registrations.print');
