<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationBooking extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'service_id',
        'booking_type',
        'applicant_type',
        'student_name',
        'student_birth_date',
        'current_education_level',
        'target_education_level',
        'qualification_year',
        'destination_country',
        'has_applied_before',
        'preferred_contact_time',
        'preferred_at',
        'language',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'preferred_at' => 'datetime',
            'student_birth_date' => 'date',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
