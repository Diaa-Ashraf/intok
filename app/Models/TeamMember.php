<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    /** @var list<string> */
    protected $fillable = ['name', 'role', 'bio', 'photo_path', 'social_links', 'sort_order', 'is_active'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['name' => 'array', 'role' => 'array', 'bio' => 'array', 'social_links' => 'array', 'is_active' => 'boolean'];
    }
}
