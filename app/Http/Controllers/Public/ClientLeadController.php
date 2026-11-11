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
        return view('public.register', [
            'services' => $services->activeForLocale(app()->getLocale()),
            'locale' => app()->getLocale(),
        ]);
    }

    public function consultationForm(ServiceCatalogService $services): View
    {
        return view('public.consultation', [
            'services' => $services->activeForLocale(app()->getLocale()),
            'locale' => app()->getLocale(),
        ]);
    }

    public function register(StoreClientRegistrationRequest $request, ClientLeadIntakeService $leads): RedirectResponse
    {
        $leads->register($request->validated(), app()->getLocale());

        return back()->with('status', __('site.registration_success'));
    }

    public function book(StoreConsultationBookingRequest $request, ClientLeadIntakeService $leads): RedirectResponse
    {
        $data = $request->validated();
        $booking = $leads->book([...$data, 'language' => app()->getLocale()]);

        $message = ($booking->booking_type === 'study_abroad')
            ? (app()->getLocale() === 'ar'
                ? 'تم استلام بياناتك بنجاح! فريق INTOK هيراجع طلبك ويتواصل معاك لمساعدتك في اختيار المسار الدراسي المناسب.'
                : __('site.booking_success'))
            : __('site.booking_success');

        return back()->with('status', $message)->with('active_tab', $booking->booking_type ?? 'general');
    }
}
