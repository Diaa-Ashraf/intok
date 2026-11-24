<?php

namespace App\Providers;

use App\Services\ServiceCatalogService;
use App\Services\SitePageManagementService;
use App\Services\SiteSettingsService;
use App\Services\TeamDirectoryService;
use App\Services\TestimonialService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SiteSettingsService::class);
        $this->app->singleton(SitePageManagementService::class);
        $this->app->singleton(ServiceCatalogService::class);
        $this->app->singleton(TeamDirectoryService::class);
        $this->app->singleton(TestimonialService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('public.*', function ($view): void {
            $request = request();
            $chrome = $request->attributes->get('_public_chrome');
            if (! is_array($chrome)) {
                $chrome = Cache::remember('site.public_chrome', 3600, fn (): array => [
                    'siteSettings' => app(SiteSettingsService::class)->all(),
                    'legalPages' => app(SitePageManagementService::class)->legalPages(),
                    'hasTestimonials' => app(TestimonialService::class)->hasPublished(),
                ]);
                $request->attributes->set('_public_chrome', $chrome);
            }

            $view->with('locale', app()->getLocale());
            $view->with('siteSettings', $chrome['siteSettings']);
            $view->with('legalPages', $chrome['legalPages']);
            $view->with('hasPublishedTestimonials', $chrome['hasTestimonials']);
        });
    }
}
