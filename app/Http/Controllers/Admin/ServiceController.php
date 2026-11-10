<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\ServiceCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(private readonly ServiceCatalogService $services)
    {
    }

    public function index(): View
    {
        $services = $this->services->paginateForAdmin();
        $services->getCollection()->each(function (Service $service): void {
            $service->setAttribute('slug', ['ar' => $service->slug_ar, 'en' => $service->slug_en, 'it' => $service->slug_it]);
        });

        $totalCount = Service::query()->count();
        $activeCount = Service::query()->where('is_active', true)->count();
        $inactiveCount = $totalCount - $activeCount;

        return view('admin.services.index', compact('services', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $this->services->create($request->validated());

        return to_route('admin.services.index')->with('status', 'تمت إضافة الخدمة بنجاح.');
    }

    public function edit(Service $service): View
    {
        $service->setAttribute('slug', ['ar' => $service->slug_ar, 'en' => $service->slug_en, 'it' => $service->slug_it]);
        return view('admin.services.edit', ['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $this->services->update($service, $request->validated());
        return to_route('admin.services.index')->with('status', 'تم تحديث الخدمة بنجاح.');
    }

    public function toggle(Service $service): RedirectResponse
    {
        $newState = $this->services->toggleActive($service);
        $message = $newState ? 'تم تفعيل الخدمة وظهورها على الموقع.' : 'تم إيقاف الخدمة وحجبها عن الموقع.';
        return back()->with('status', $message);
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->services->delete($service);
        return to_route('admin.services.index')->with('status', 'تم حذف الخدمة.');
    }
}
