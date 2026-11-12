<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    /** @var list<string> */
    protected $fillable = ['name', 'role', 'bio', 'photo_path', 'social_links', 'sort_order', 'is_active'];

    protected $appends = ['photo_url'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['name' => 'array', 'role' => 'array', 'bio' => 'array', 'social_links' => 'array', 'is_active' => 'boolean'];
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo_path) {
            if (str_starts_with($this->photo_path, 'http') || str_starts_with($this->photo_path, 'assets/')) {
                return asset($this->photo_path);
            }
            return asset('storage/' . $this->photo_path);
        }

        $defaultPhotos = [
            1 => 'assets/images/team/member-1.jpg',
            2 => 'assets/images/team/member-2.jpg',
            3 => 'assets/images/team/member-3.jpg',
            4 => 'assets/images/team/member-4.jpg',
        ];

        return asset($defaultPhotos[$this->sort_order] ?? 'assets/images/team/member-1.jpg');
    }
}
