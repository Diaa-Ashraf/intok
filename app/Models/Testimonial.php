<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'quote', 'destination', 'photo_path', 'video_url', 'rating', 'sort_order', 'is_published'];
    protected function casts(): array { return ['name' => 'array', 'quote' => 'array', 'destination' => 'array', 'is_published' => 'boolean', 'rating' => 'integer']; }
}
