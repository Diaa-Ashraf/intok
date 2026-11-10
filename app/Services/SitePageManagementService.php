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

    public function publishedAbout(): SitePage
    {
        $page = SitePage::query()->select(['id', 'slug_ar', 'slug_en', 'slug_it', 'title', 'content', 'seo_title', 'seo_description'])
            ->where('kind', 'about')->where('is_published', true)->first();

        if ($page) {
            return $page;
        }

        $anyAbout = SitePage::query()->where('kind', 'about')->first();
        if ($anyAbout) {
            $anyAbout->update(['is_published' => true]);
            return $anyAbout;
        }

        return SitePage::query()->create([
            'kind' => 'about',
            'slug_ar' => 'about-us',
            'slug_en' => 'about-us',
            'slug_it' => 'chi-siamo',
            'title' => [
                'ar' => 'من نحن',
                'en' => 'About Us',
                'it' => 'Chi siamo',
            ],
            'content' => [
                'ar' => "INTOK ACADEMY هي أكاديمية رائدة متخصصة في التدريب اللغوي الاحترافي، الترجمة المعتمدة، وتأهيل الطلاب والشباب للالتحاق بأعرق الجامعات والمدارس بالدول الأوروبية، والاستفادة من المنح الدراسية الشاملة الممولة.\n\nرؤيتنا: تمكين شباب الوطن العربي من امتلاك المهارات اللغوية والمهنية المطلوبة عالمياً، وفتح أبواب الدراسة والعمل القانوني في الدول الأوروبية.\n\nرسالتنا: مرافقة كل طالب ومتدرب خطوة بخطوة، من التدريب واللغة وتجهيز المستندات وحتى حصد المنحة واستلام التأشيرة والوصول لبلد الدراسة.\n\nقيمنا: الاحترافية، الشفافية، الدقة، ودعم الطالب حتى النجاح التام.",
                'en' => "INTOK ACADEMY is a leading institution specializing in professional language training, certified translation, and qualifying students to join prestigious European universities with comprehensive scholarships.",
                'it' => "INTOK ACADEMY è un'accademia leader nella formazione linguistica professionale, traduzioni giurate e orientamento universitario per i paesi europei.",
            ],
            'seo_title' => [
                'ar' => 'من نحن | INTOK ACADEMY',
                'en' => 'About INTOK ACADEMY',
                'it' => 'Chi siamo | INTOK ACADEMY',
            ],
            'seo_description' => [
                'ar' => 'تعرف على أكاديمية INTOK للتدريب اللغوي، الترجمة، والدراسة بالدول الأوروبية.',
                'en' => 'Learn about INTOK ACADEMY for language training, translation, and study in Europe.',
                'it' => 'Scopri INTOK ACADEMY per formazione linguistica e studi nei paesi europei.',
            ],
            'is_published' => true,
        ]);
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
