@extends('public.layouts.app')

@section('title', $page->seo_title[$locale] ?? $page->title[$locale] ?? '')
@section('meta_description', $page->seo_description[$locale] ?? Str::limit(strip_tags($page->content[$locale] ?? ''), 170))

@section('content')
<section class="relative isolate overflow-hidden bg-intok-hero py-16 text-slate-900 border-b border-slate-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
        <h1 class="max-w-4xl text-3xl font-black text-[#c27803] sm:text-5xl">{{ $page->title[$locale] ?? $page->title['en'] ?? '' }}</h1>
    </div>
</section>

<article class="bg-intok-section py-16 text-slate-900 min-h-[60vh]">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="card-poster-white p-8 sm:p-12 bg-white border border-slate-200">
            <div class="page-content text-sm sm:text-base leading-relaxed text-slate-800">
                {!! Str::markdown($page->content[$locale] ?? $page->content['en'] ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
            </div>
            
            <div class="mt-10 border-t border-slate-100 pt-6 flex flex-wrap gap-4">
                <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="btn-intok-primary px-8 py-3.5 text-xs font-black shadow-lg">
                    {{ __('site.hero_cta') }}
                </a>
                <a href="{{ route('home', ['locale' => $locale]) }}" class="rounded-full border border-slate-300 bg-slate-50 px-6 py-3.5 text-xs font-bold text-slate-700 hover:bg-slate-100 transition">
                    {{ __('site.nav_home') }}
                </a>
            </div>
        </div>
    </div>
</article>
@endsection
