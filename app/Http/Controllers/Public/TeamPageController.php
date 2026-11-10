<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\TeamDirectoryService;
use Illuminate\View\View;

class TeamPageController extends Controller
{
    public function index(TeamDirectoryService $team): View
    {
        return view('public.team', [
            'team' => $team->activeMembers(100),
            'locale' => app()->getLocale(),
        ]);
    }
}
