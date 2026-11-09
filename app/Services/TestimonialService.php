<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestimonialService
{
    public function __construct(private readonly ImageUploadService $images) {}
    public function paginate(int $perPage = 20): LengthAwarePaginator { return Testimonial::query()->select(['id', 'name', 'rating', 'sort_order', 'is_published', 'created_at'])->orderBy('sort_order')->latest('id')->paginate($perPage); }
    public function featured(int $limit = 3): \Illuminate\Database\Eloquent\Collection { return Testimonial::query()->select(['id', 'name', 'quote', 'destination', 'photo_path', 'video_url', 'rating'])->where('is_published', true)->orderBy('sort_order')->limit($limit)->get(); }
    public function allPublished(int $perPage = 12): LengthAwarePaginator { return Testimonial::query()->select(['id', 'name', 'quote', 'destination', 'photo_path', 'video_url', 'rating'])->where('is_published', true)->orderBy('sort_order')->paginate($perPage); }
    /** @param array<string, mixed> $data */
    public function create(array $data): Testimonial
    {
        $photo = $data['photo'] ?? null; unset($data['photo']);
        $path = $photo instanceof UploadedFile ? $this->images->storeWebp($photo, 'testimonials', 1000, 1000) : null;
        if ($path) $data['photo_path'] = $path;
        try { return DB::transaction(fn (): Testimonial => Testimonial::query()->create($data)); }
        catch (\Throwable $exception) { if ($path) Storage::disk('public')->delete($path); throw $exception; }
    }
    /** @param array<string, mixed> $data */
    public function update(Testimonial $testimonial, array $data): Testimonial
    {
        $photo = $data['photo'] ?? null; unset($data['photo']);
        $oldPath = $testimonial->photo_path;
        $newPath = $photo instanceof UploadedFile ? $this->images->storeWebp($photo, 'testimonials', 1000, 1000) : null;
        if ($newPath) $data['photo_path'] = $newPath;
        try { $updated = DB::transaction(function () use ($testimonial, $data): Testimonial { $testimonial->update($data); return $testimonial->refresh(); }); }
        catch (\Throwable $exception) { if ($newPath) Storage::disk('public')->delete($newPath); throw $exception; }
        if ($newPath && $oldPath) Storage::disk('public')->delete($oldPath);
        return $updated;
    }
    public function delete(Testimonial $testimonial): void
    {
        $path = $testimonial->photo_path;
        DB::transaction(fn (): bool => $testimonial->delete());
        if ($path) Storage::disk('public')->delete($path);
    }
}
