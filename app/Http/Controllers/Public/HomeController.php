<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ServiceCatalogService;
use App\Services\TeamDirectoryService;
use App\Services\TestimonialService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(ServiceCatalogService $services, TeamDirectoryService $team, TestimonialService $testimonials): View
    {
        $locale = app()->getLocale();
        $payload = Cache::remember("home.payload.{$locale}", 3600, fn (): array => [
            'services' => $services->activeForLocale($locale),
            'team' => $team->activeMembers(4),
            'testimonials' => $testimonials->featured(),
        ]);

        return view('public.home', array_merge($payload, ['locale' => $locale]));
    }
}
