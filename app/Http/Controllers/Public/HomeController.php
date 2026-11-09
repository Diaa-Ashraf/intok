<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ServiceCatalogService;
use App\Services\TeamDirectoryService;
use App\Services\TestimonialService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(ServiceCatalogService $services, TeamDirectoryService $team, TestimonialService $testimonials): View
    {
        return view('public.home', ['services' => $services->activeForLocale(app()->getLocale()), 'team' => $team->activeMembers(4), 'testimonials' => $testimonials->featured(), 'locale' => app()->getLocale()]);
    }
}
