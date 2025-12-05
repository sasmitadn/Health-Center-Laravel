<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'dob',
        'nik',
        'password',
        'email',
        'no_bpjs',
        'address',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
