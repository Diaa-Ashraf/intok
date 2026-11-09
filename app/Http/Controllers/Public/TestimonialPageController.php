<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\TestimonialService;
use Illuminate\View\View;

class TestimonialPageController extends Controller
{
    public function index(TestimonialService $testimonials): View
    {
        return view('public.testimonials', ['testimonials' => $testimonials->allPublished()]);
    }
}
