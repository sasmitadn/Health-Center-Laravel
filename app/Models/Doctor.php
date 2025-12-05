<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'is_active'
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }
}
