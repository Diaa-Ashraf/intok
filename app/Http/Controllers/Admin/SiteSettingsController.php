<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSiteSettingsRequest;
use App\Services\SiteSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    public function edit(SiteSettingsService $settings): View
    {
        return view('admin.settings.edit', ['settings' => $settings->all()]);
    }

    public function update(UpdateSiteSettingsRequest $request, SiteSettingsService $settings): RedirectResponse
    {
        $settings->save($request->validated());

        return back()->with('status', 'تم حفظ إعدادات الموقع بنجاح.');
    }
}
