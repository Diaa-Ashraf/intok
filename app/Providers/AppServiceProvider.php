<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\SiteSettingsService;
use App\Services\SitePageManagementService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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
