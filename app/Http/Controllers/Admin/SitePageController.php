<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSitePageRequest;
use App\Models\SitePage;
use App\Services\SitePageManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function __construct(private readonly SitePageManagementService $pages) {}
    public function index(): View { return view('admin.pages.index', ['pages' => $this->pages->paginate()]); }
    public function create(): View { return view('admin.pages.create'); }
    public function store(StoreSitePageRequest $request): RedirectResponse
    {
        $this->pages->create($request->validated());
        return to_route('admin.pages.index')->with('status', 'تم إنشاء الصفحة.');
    }
    public function edit(SitePage $page): View { return view('admin.pages.edit', ['page' => $page]); }
    public function update(StoreSitePageRequest $request, SitePage $page): RedirectResponse
    {
        $this->pages->update($page, $request->validated());
        return to_route('admin.pages.index')->with('status', 'تم حفظ الصفحة.');
    }
    public function destroy(SitePage $page): RedirectResponse
    {
        $this->pages->delete($page);
        return to_route('admin.pages.index')->with('status', 'تم حذف الصفحة.');
    }
}
