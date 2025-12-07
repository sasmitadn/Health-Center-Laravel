<?php

use App\Http\Controllers\RegistrationPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/registrations/{registration}/print', RegistrationPrintController::class)
        ->name('registrations.print');
