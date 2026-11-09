<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'slug', 'slug_ar', 'slug_en', 'slug_it', 'title', 'summary', 'description', 'features', 'seo_title',
        'seo_description', 'requirements', 'steps', 'faqs', 'image_path', 'icon', 'sort_order', 'is_active',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'slug' => 'array', 'title' => 'array', 'summary' => 'array',
            'description' => 'array', 'features' => 'array', 'requirements' => 'array', 'steps' => 'array', 'faqs' => 'array', 'seo_title' => 'array',
            'seo_description' => 'array', 'is_active' => 'boolean',
        ];
    }
}
