<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = [
        'reg_number',
        'patient_id',
        'doctor_id',
        'location_id',
        'visit_date',
        'queue_number', // auto generate
        'status' // default 1
    ];

    protected $cast = [
        'visit_date' => 'date'
    ];

    protected static function booted(): void
    {
        static::creating(function (Registration $registration) {
            // 1. Generate Reg Number: REG-YYYYMMDD-RANDOM
            $today = Carbon::now()->format('Ymd');
            $registration->reg_number = 'REG-' . $today . '-' . strtoupper(substr(uniqid(), -4));

            // 2. Generate Queue Number berdasarkan Dokter & Tanggal yang sama
            $lastQueue = Registration::where('doctor_id', $registration->doctor_id)
                ->where('visit_date', $registration->visit_date)
                ->max('queue_number');

            $registration->queue_number = ($lastQueue ?? 0) + 1;

            // Set default status jika belum ada
            if (!$registration->status) {
                $registration->status = 'waiting';
            }
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
