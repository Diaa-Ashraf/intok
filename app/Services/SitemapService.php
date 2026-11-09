<?php

namespace App\Services;

use App\Models\Service;
use App\Models\SitePage;
use Illuminate\Support\Facades\Cache;

class SitemapService
{
    /** @return list<array{url: string, lastmod: string}> */
    public function entries(): array
    {
        return Cache::remember('site.sitemap', 3600, function (): array {
            $entries = [];
            foreach (['ar', 'en', 'it'] as $locale) {
                foreach (['home', 'about', 'services.index', 'team', 'testimonials', 'contact', 'registration.create', 'consultation.create'] as $routeName) {
                    $entries[] = ['url' => route($routeName, ['locale' => $locale]), 'lastmod' => now()->toDateString()];
                }
            }

            Service::query()->select(['id', 'updated_at', 'slug_ar', 'slug_en', 'slug_it'])->where('is_active', true)->orderBy('id')->chunkById(200, function ($services) use (&$entries): void {
                foreach ($services as $service) {
                    foreach (['ar', 'en', 'it'] as $locale) {
                        $entries[] = ['url' => route('services.show', ['locale' => $locale, 'slug' => $service->{'slug_'.$locale}]), 'lastmod' => $service->updated_at?->toDateString() ?? now()->toDateString()];
                    }
                }
            });

            SitePage::query()->select(['id', 'kind', 'updated_at', 'slug_ar', 'slug_en', 'slug_it'])->where('is_published', true)->whereNotIn('kind', ['about'])->orderBy('id')->chunkById(200, function ($pages) use (&$entries): void {
                foreach ($pages as $page) {
                    foreach (['ar', 'en', 'it'] as $locale) {
                        $entries[] = ['url' => route('pages.show', ['locale' => $locale, 'slug' => $page->{'slug_'.$locale}]), 'lastmod' => $page->updated_at?->toDateString() ?? now()->toDateString()];
                    }
                }
            });

            return $entries;
        });
    }
}
