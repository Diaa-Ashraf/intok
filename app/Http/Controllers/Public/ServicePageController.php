<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ServiceCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function index(Request $request, ServiceCatalogService $servicesCatalog): View
    {
        $locale = (string) $request->route('locale');
        $services = $servicesCatalog->paginateActive();
        $services->getCollection()->each(function (\App\Models\Service $service): void {
            $service->setAttribute('slug', ['ar' => $service->slug_ar, 'en' => $service->slug_en, 'it' => $service->slug_it]);
        });

        return view('public.services.index', compact('services', 'locale'));
    }

    public function show(string $locale, string $slug, ServiceCatalogService $servicesCatalog): View
    {
        $service = $servicesCatalog->findPublishedBySlug($locale, $slug);

        abort_if($service === null, 404);

        return view('public.services.show', compact('service', 'locale'));
    }
}
