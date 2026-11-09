<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{
    protected $fillable = ['kind', 'slug_ar', 'slug_en', 'slug_it', 'title', 'content', 'seo_title', 'seo_description', 'is_published'];

    protected function casts(): array
    {
        return ['title' => 'array', 'content' => 'array', 'seo_title' => 'array', 'seo_description' => 'array', 'is_published' => 'boolean'];
    }
}
