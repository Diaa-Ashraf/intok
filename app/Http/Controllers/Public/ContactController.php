<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiryRequest;
use App\Services\InquiryIntakeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('public.contact', ['locale' => app()->getLocale()]);
    }

    public function store(StoreInquiryRequest $request, InquiryIntakeService $inquiries): RedirectResponse
    {
        $inquiries->create([...$request->validated(), 'locale' => app()->getLocale()]);

        return back()->with('status', __('site.inquiry_success'));
    }
}
