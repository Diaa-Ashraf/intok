<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Models\TeamMember;
use App\Services\TeamDirectoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function __construct(private readonly TeamDirectoryService $team)
    {
    }

    public function index(): View
    {
        return view('admin.team.index', ['members' => $this->team->paginateForAdmin()]);
    }

    public function create(): View
    {
        return view('admin.team.create');
    }

    public function store(StoreTeamMemberRequest $request): RedirectResponse
    {
        $this->team->create($request->validated());
        return to_route('admin.team.index')->with('status', 'تمت إضافة عضو الفريق.');
    }

    public function edit(TeamMember $teamMember): View
    {
        return view('admin.team.edit', ['member' => $teamMember]);
    }

    public function update(StoreTeamMemberRequest $request, TeamMember $teamMember): RedirectResponse
    {
        $this->team->update($teamMember, $request->validated());
        return to_route('admin.team.index')->with('status', 'تم تحديث بيانات عضو الفريق.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $this->team->delete($teamMember);
        return to_route('admin.team.index')->with('status', 'تم حذف عضو الفريق.');
    }
}
