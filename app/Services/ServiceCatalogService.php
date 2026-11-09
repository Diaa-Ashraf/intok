<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ServiceCatalogService
{
    public function __construct(private readonly ImageUploadService $images)
    {
    }

    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator
    {
        return Service::query()->select(['id', 'slug', 'slug_ar', 'slug_en', 'slug_it', 'title', 'summary', 'sort_order', 'is_active', 'created_at'])
            ->orderBy('sort_order')->orderByDesc('id')->paginate($perPage);
    }

    public function paginateActive(int $perPage = 9): LengthAwarePaginator
    {
        return Service::query()->select(['id', 'slug', 'slug_ar', 'slug_en', 'slug_it', 'title', 'summary', 'icon', 'image_path', 'sort_order'])->where('is_active', true)->orderBy('sort_order')->paginate($perPage);
    }

    public function findPublishedBySlug(string $locale, string $slug): ?Service
    {
        return Service::query()->select(['id', 'slug', 'slug_ar', 'slug_en', 'slug_it', 'title', 'summary', 'description', 'features', 'requirements', 'steps', 'faqs', 'seo_title', 'seo_description', 'icon', 'image_path'])
            ->where('is_active', true)->where('slug_'.$locale, $slug)->first();
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Service
    {
        $image = $data['image'] ?? null;
        unset($data['image']);
        $data = $this->withLocalizedSlugColumns($data);
        $imagePath = $image instanceof \Illuminate\Http\UploadedFile ? $this->images->storeWebp($image, 'services', 1800, 1400) : null;
        if ($imagePath !== null) { $data['image_path'] = $imagePath; }
        try {
            $service = DB::transaction(fn (): Service => Service::query()->create($data));
            Cache::forget('site.sitemap');
            return $service;
        } catch (\Throwable $exception) {
            if ($imagePath !== null) { Storage::disk('public')->delete($imagePath); }
            throw $exception;
        }
    }

    /** @param array<string, mixed> $data */
    public function update(Service $service, array $data): Service
    {
        $image = $data['image'] ?? null;
        unset($data['image']);
        $data = $this->withLocalizedSlugColumns($data);
        $oldImagePath = $service->image_path;
        $newImagePath = $image instanceof \Illuminate\Http\UploadedFile ? $this->images->storeWebp($image, 'services', 1800, 1400) : null;
        if ($newImagePath !== null) { $data['image_path'] = $newImagePath; }
        try {
            $updated = DB::transaction(function () use ($service, $data): Service {
                $service->update($data);
                return $service->refresh();
            });
        } catch (\Throwable $exception) {
            if ($newImagePath !== null) { Storage::disk('public')->delete($newImagePath); }
            throw $exception;
        }
        if ($newImagePath !== null && $oldImagePath !== null) { Storage::disk('public')->delete($oldImagePath); }
        Cache::forget('site.sitemap');
        return $updated;
    }

    /** @param array<string, mixed> $data
     *  @return array<string, mixed>
     */
    private function withLocalizedSlugColumns(array $data): array
    {
        foreach (['features', 'requirements', 'steps'] as $field) {
            foreach (['ar', 'en', 'it'] as $locale) $data[$field][$locale] = $this->textLines($data[$field.'_text'][$locale] ?? '');
            unset($data[$field.'_text']);
        }
        foreach (['ar', 'en', 'it'] as $locale) $data['faqs'][$locale] = $this->faqLines($data['faqs_text'][$locale] ?? '');
        unset($data['faqs_text']);
        foreach (['ar', 'en', 'it'] as $locale) {
            $data['slug_'.$locale] = $data['slug'][$locale] ?? null;
        }

        return $data;
    }

    /** @return list<string> */
    private function textLines(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/u', trim($value)) ?: []), static fn (string $line): bool => $line !== ''));
    }

    /** @return list<array{question: string, answer: string}> */
    private function faqLines(string $value): array
    {
        $faqs = [];
        foreach ($this->textLines($value) as $line) {
            $parts = explode('|', $line, 2);
            if (count($parts) === 2 && trim($parts[0]) !== '' && trim($parts[1]) !== '') $faqs[] = ['question' => trim($parts[0]), 'answer' => trim($parts[1])];
        }
        return $faqs;
    }

    public function delete(Service $service): void
    {
        $imagePath = $service->image_path;
        DB::transaction(fn (): bool => $service->delete());
        if ($imagePath !== null) { Storage::disk('public')->delete($imagePath); }
        Cache::forget('site.sitemap');
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, Service> */
    public function activeForLocale(string $locale): Collection
    {
        return Service::query()
            ->select(['id', 'slug', 'slug_ar', 'slug_en', 'slug_it', 'title', 'summary', 'description', 'icon', 'image_path', 'sort_order'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();
    }
}
