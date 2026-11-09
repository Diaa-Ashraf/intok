<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientRegistration extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'country', 'education_level', 'service_id', 'locale', 'status'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
