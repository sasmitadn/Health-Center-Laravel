<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MySchedule extends Model
{
    protected $table = 'doctors';
    protected $fillable = [
        'specialization',
        'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
