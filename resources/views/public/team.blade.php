@extends('public.layouts.app')

@php
    $locale = $locale ?? app()->getLocale();
@endphp

@section('title', __('site.nav_team'))
@section('meta_description', __('site.hero_text'))

@section('content')
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 text-slate-900 border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
            <span class="inline-block rounded-full border border-red-200 bg-white/90 px-3.5 py-1 text-xs font-black text-red-600 shadow-xs">
                {{ data_get($siteSettings ?? [], 'team_badge.'.$locale, 'خبراء التعليم الدولي') }}
            </span>
            <h1 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">{{ data_get($siteSettings ?? [], 'team_page_title.'.$locale, __('site.nav_team')) }}</h1>
            <p class="mt-4 max-w-2xl leading-relaxed text-slate-600 font-medium">{{ data_get($siteSettings ?? [], 'team_intro.'.$locale, __('site.hero_text')) }}</p>
        </div>
    </section>

    <section class="bg-intok-section py-16 text-slate-900 min-h-[60vh]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($team as $member)
                    <article class="card-poster-white p-6 flex flex-col justify-between bg-white border border-slate-200">
                        <div>
                            <div class="aspect-square w-full rounded-2xl overflow-hidden border border-slate-200 shadow-xs">
                                <img src="{{ $member->photo_url }}" alt="{{ $member->name[app()->getLocale()] ?? '' }}" loading="lazy" class="size-full object-cover">
                            </div>
                            <h2 class="mt-4 text-lg font-black text-slate-900">{{ $member->name[app()->getLocale()] ?? $member->name['en'] ?? '' }}</h2>
                            <p class="mt-1 text-xs font-bold text-red-600">{{ $member->role[app()->getLocale()] ?? $member->role['en'] ?? '' }}</p>
                            <p class="mt-3 text-xs leading-relaxed text-slate-600 line-clamp-3 font-medium">{{ $member->bio[app()->getLocale()] ?? $member->bio['en'] ?? '' }}</p>
                        </div>
                        <div class="mt-4 flex gap-2 border-t border-slate-100 pt-3">
                            @foreach(['linkedin'=>'LinkedIn','instagram'=>'Instagram'] as $network=>$label)
                                @if($member->social_links[$network] ?? null)
                                    <a href="{{ $member->social_links[$network] }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] font-bold text-slate-700 hover:text-red-600 hover:border-red-300 transition">
                                        {{ $label }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-3xl border border-slate-200 bg-white p-12 text-center text-slate-500">
                        {{ __('site.team_empty') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
