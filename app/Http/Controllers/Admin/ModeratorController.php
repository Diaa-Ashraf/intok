<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModeratorRequest;
use App\Http\Requests\UpdateModeratorRequest;
use App\Models\User;
use App\Services\ModeratorManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ModeratorController extends Controller
{
    public function __construct(private readonly ModeratorManagementService $moderatorService)
    {
    }

    public function index(): View
    {
        return view('admin.moderators.index', [
            'moderators' => $this->moderatorService->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.moderators.create');
    }

    public function store(StoreModeratorRequest $request): RedirectResponse
    {
        $this->moderatorService->store($request->validated());

        return to_route('admin.moderators.index')->with('status', 'تمت إضافة المشرف بنجاح ويمكنه الآن تسجيل الدخول إلى لوحة الإدارة.');
    }

    public function edit(User $moderator): View
    {
        return view('admin.moderators.edit', [
            'moderator' => $moderator->loadMissing('roles'),
        ]);
    }

    public function update(UpdateModeratorRequest $request, User $moderator): RedirectResponse
    {
        $this->moderatorService->update($moderator, $request->validated());

        return to_route('admin.moderators.index')->with('status', 'تم تحديث بيانات المشرف بنجاح.');
    }

    public function destroy(User $moderator): RedirectResponse
    {
        try {
            $this->moderatorService->delete($moderator, auth()->user());

            return to_route('admin.moderators.index')->with('status', 'تم حذف حساب المشرف بنجاح.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
}

