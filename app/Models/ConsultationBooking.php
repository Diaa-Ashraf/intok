<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationBooking extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'service_id', 'preferred_at', 'language', 'notes', 'status'];

    protected function casts(): array
    {
        return ['preferred_at' => 'datetime'];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
