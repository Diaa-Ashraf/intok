<?php

namespace App\Services;

use App\Models\TeamMember;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamDirectoryService
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator
    {
        return TeamMember::query()->select(['id', 'name', 'role', 'sort_order', 'is_active', 'created_at'])->orderBy('sort_order')->paginate($perPage);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): TeamMember
    {
        $photo = $data['photo'] ?? null;
        $data['social_links'] = array_filter([
            'linkedin' => $data['linkedin'] ?? null,
            'instagram' => $data['instagram'] ?? null,
        ]);
        unset($data['linkedin'], $data['instagram']);
        unset($data['photo']);
        $photoPath = $photo instanceof UploadedFile ? $this->images->storeWebp($photo, 'team', 1200, 1200) : null;
        if ($photoPath !== null) {
            $data['photo_path'] = $photoPath;
        }
        try {
            $member = DB::transaction(fn (): TeamMember => TeamMember::query()->create($data));
            $this->flushTeamCache();

            return $member;
        } catch (\Throwable $exception) {
            if ($photoPath !== null) {
                Storage::disk('public')->delete($photoPath);
            }
            throw $exception;
        }
    }

    /** @param array<string, mixed> $data */
    public function update(TeamMember $member, array $data): TeamMember
    {
        $photo = $data['photo'] ?? null;
        $data['social_links'] = array_filter([
            'linkedin' => array_key_exists('linkedin', $data) ? $data['linkedin'] : ($member->social_links['linkedin'] ?? null),
            'instagram' => array_key_exists('instagram', $data) ? $data['instagram'] : ($member->social_links['instagram'] ?? null),
        ]);
        unset($data['linkedin'], $data['instagram']);
        unset($data['photo']);
        $oldPhotoPath = $member->photo_path;
        $newPhotoPath = $photo instanceof UploadedFile ? $this->images->storeWebp($photo, 'team', 1200, 1200) : null;
        if ($newPhotoPath !== null) {
            $data['photo_path'] = $newPhotoPath;
        }
        try {
            $updated = DB::transaction(function () use ($member, $data): TeamMember {
                $member->update($data);

                return $member->refresh();
            });
        } catch (\Throwable $exception) {
            if ($newPhotoPath !== null) {
                Storage::disk('public')->delete($newPhotoPath);
            }
            throw $exception;
        }
        if ($newPhotoPath !== null && $oldPhotoPath !== null) {
            Storage::disk('public')->delete($oldPhotoPath);
        }
        $this->flushTeamCache();

        return $updated;
    }

    public function delete(TeamMember $member): void
    {
        $photoPath = $member->photo_path;
        DB::transaction(fn (): bool => $member->delete());
        if ($photoPath !== null) {
            Storage::disk('public')->delete($photoPath);
        }
        $this->flushTeamCache();
    }

    /** @return Collection<int, TeamMember> */
    public function activeMembers(int $limit = 6): Collection
    {
        return Cache::remember("team.active.{$limit}", 3600, fn (): Collection => TeamMember::query()->select(['id', 'name', 'role', 'bio', 'photo_path', 'social_links'])->where('is_active', true)->orderBy('sort_order')->limit($limit)->get());
    }

    private function flushTeamCache(): void
    {
        Cache::forget('team.active.4');
        Cache::forget('team.active.6');
        Cache::forget('team.active.12');
        Cache::forget('home.payload.ar');
        Cache::forget('home.payload.en');
        Cache::forget('home.payload.it');
        Cache::forget('about.payload.ar');
        Cache::forget('about.payload.en');
        Cache::forget('about.payload.it');
    }
}
