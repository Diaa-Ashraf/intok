<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function __construct(private readonly TestimonialService $testimonials) {}
    public function index(): View { return view('admin.testimonials.index', ['testimonials' => $this->testimonials->paginate()]); }
    public function create(): View { return view('admin.testimonials.create'); }
    public function store(StoreTestimonialRequest $request): RedirectResponse { $this->testimonials->create($request->validated()); return to_route('admin.testimonials.index')->with('status', 'تمت إضافة قصة النجاح.'); }
    public function edit(Testimonial $testimonial): View { return view('admin.testimonials.edit', ['testimonial' => $testimonial]); }
    public function update(StoreTestimonialRequest $request, Testimonial $testimonial): RedirectResponse { $this->testimonials->update($testimonial, $request->validated()); return to_route('admin.testimonials.index')->with('status', 'تم تحديث قصة النجاح.'); }
    public function destroy(Testimonial $testimonial): RedirectResponse { $this->testimonials->delete($testimonial); return to_route('admin.testimonials.index')->with('status', 'تم حذف قصة النجاح.'); }
}
