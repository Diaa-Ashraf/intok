<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    /** @var list<string> */
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'locale'];
}
