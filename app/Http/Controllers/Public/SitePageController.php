<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SitePageManagementService;
use App\Services\TeamDirectoryService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function about(string $locale, SitePageManagementService $pages, TeamDirectoryService $team): View
    {
        $payload = Cache::remember("about.payload.{$locale}", 3600, fn (): array => [
            'page' => $pages->publishedAbout(),
            'teamMembers' => $team->activeMembers(6),
        ]);

        return view('public.about', array_merge($payload, ['locale' => $locale]));
    }

    public function show(string $locale, string $slug, SitePageManagementService $pages): View
    {
        $page = $pages->findPublishedBySlug($locale, $slug);
        abort_if($page === null, 404);

        return view('public.page', compact('page', 'locale'));
    }
}
