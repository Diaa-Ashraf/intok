<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRegistrationRequest;
use App\Http\Requests\StoreConsultationBookingRequest;
use App\Services\ClientLeadIntakeService;
use App\Services\ServiceCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientLeadController extends Controller
{
    public function registrationForm(ServiceCatalogService $services): View
    {
        return view('public.register', ['services' => $services->activeForLocale(app()->getLocale())]);
    }

    public function consultationForm(ServiceCatalogService $services): View
    {
        return view('public.consultation', ['services' => $services->activeForLocale(app()->getLocale())]);
    }

    public function register(StoreClientRegistrationRequest $request, ClientLeadIntakeService $leads): RedirectResponse
    {
        $leads->register($request->validated(), app()->getLocale());

        return back()->with('status', __('site.registration_success'));
    }

    public function book(StoreConsultationBookingRequest $request, ClientLeadIntakeService $leads): RedirectResponse
    {
        $leads->book([...$request->validated(), 'language' => app()->getLocale()]);

        return back()->with('status', __('site.booking_success'));
    }
}
