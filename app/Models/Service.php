<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'slug',
        'slug_ar',
        'slug_en',
        'slug_it',
        'title',
        'headline',
        'summary',
        'description',
        'badge',
        'category_label',
        'level',
        'duration',
        'mode',
        'target_audience',
        'salary_range',
        'whatsapp_message',
        'features',
        'seo_title',
        'seo_description',
        'requirements',
        'steps',
        'faqs',
        'image_path',
        'icon',
        'sort_order',
        'is_active',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'title' => 'array',
            'headline' => 'array',
            'summary' => 'array',
            'description' => 'array',
            'badge' => 'array',
            'category_label' => 'array',
            'level' => 'array',
            'duration' => 'array',
            'mode' => 'array',
            'target_audience' => 'array',
            'salary_range' => 'array',
            'whatsapp_message' => 'array',
            'features' => 'array',
            'requirements' => 'array',
            'steps' => 'array',
            'faqs' => 'array',
            'seo_title' => 'array',
            'seo_description' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
