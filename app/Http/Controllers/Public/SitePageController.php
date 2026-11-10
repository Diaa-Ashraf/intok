<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SitePageManagementService;
use App\Services\TeamDirectoryService;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function about(string $locale, SitePageManagementService $pages, TeamDirectoryService $team): View
    {
        $page = $pages->publishedAbout();
        $teamMembers = $team->activeMembers(6);
        return view('public.about', compact('page', 'locale', 'teamMembers'));
    }

    public function show(string $locale, string $slug, SitePageManagementService $pages): View
    {
        $page = $pages->findPublishedBySlug($locale, $slug);
        abort_if($page === null, 404);
        return view('public.page', compact('page', 'locale'));
    }
}
