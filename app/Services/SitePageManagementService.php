<?php

namespace App\Services;

use App\Models\SitePage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class SitePageManagementService
{
    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return SitePage::query()->select(['id', 'kind', 'slug_ar', 'title', 'is_published', 'updated_at'])->latest('id')->paginate($perPage);
    }

    /** @return Collection<int, SitePage> */
    public function legalPages(): Collection
    {
        return Cache::remember('site.legal_pages', 3600, fn (): Collection => SitePage::query()->select(['id', 'kind', 'slug_ar', 'slug_en', 'slug_it', 'title'])->where('is_published', true)->whereIn('kind', ['privacy', 'terms'])->orderBy('kind')->get());
    }

    public function findPublishedBySlug(string $locale, string $slug): ?SitePage
    {
        return SitePage::query()->select(['id', 'slug_ar', 'slug_en', 'slug_it', 'title', 'content', 'seo_title', 'seo_description'])
            ->where('is_published', true)->where('slug_'.$locale, $slug)->first();
    }

    public function publishedAbout(): ?SitePage
    {
        return SitePage::query()->select(['id', 'slug_ar', 'slug_en', 'slug_it', 'title', 'content', 'seo_title', 'seo_description'])
            ->where('kind', 'about')->where('is_published', true)->first();
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): SitePage
    {
        return DB::transaction(function () use ($data): SitePage {
            $page = SitePage::query()->create($this->localizedColumns($data));
            Cache::forget('site.sitemap');
            Cache::forget('site.legal_pages');
            return $page;
        });
    }

    /** @param array<string, mixed> $data */
    public function update(SitePage $page, array $data): SitePage
    {
        return DB::transaction(function () use ($page, $data): SitePage {
            $page->update($this->localizedColumns($data));
            Cache::forget('site.sitemap');
            Cache::forget('site.legal_pages');
            return $page->refresh();
        });
    }

    public function delete(SitePage $page): void
    {
        DB::transaction(fn (): bool => $page->delete());
        Cache::forget('site.sitemap');
        Cache::forget('site.legal_pages');
    }

    /** @param array<string, mixed> $data
     *  @return array<string, mixed>
     */
    private function localizedColumns(array $data): array
    {
        foreach (['ar', 'en', 'it'] as $locale) $data['slug_'.$locale] = $data['slug'][$locale];
        unset($data['slug']);
        return $data;
    }
}
