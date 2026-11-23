<?php

namespace App\Providers;

use App\Services\ServiceCatalogService;
use App\Services\SitePageManagementService;
use App\Services\SiteSettingsService;
use App\Services\TeamDirectoryService;
use App\Services\TestimonialService;
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
            $view->with('locale', app()->getLocale());
            $view->with('siteSettings', app(SiteSettingsService::class)->all());
            $view->with('legalPages', app(SitePageManagementService::class)->legalPages());
        });
    }
}
