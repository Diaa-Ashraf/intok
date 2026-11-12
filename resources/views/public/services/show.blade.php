@extends('public.layouts.app')

@php
    $locale = $locale ?? app()->getLocale();
@endphp

@section('title', $service->seo_title[$locale] ?? $service->title[$locale] ?? '')
@section('meta_description', $service->seo_description[$locale] ?? $service->summary[$locale] ?? '')

@section('structured_data')
    <script type="application/ld+json">@php echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service->title[$locale] ?? $service->title['en'] ?? '',
        'description' => $service->summary[$locale] ?? $service->summary['en'] ?? '',
        'url' => url()->current(),
        'provider' => [
            '@type' => 'EducationalOrganization',
            'name' => data_get($siteSettings ?? [], 'site_name.'.$locale, __('site.brand')),
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); @endphp</script>
    @if(!empty($service->faqs[$locale] ?? []))
        <script type="application/ld+json">@php echo json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($service->faqs[$locale])->map(fn($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ])->values()->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); @endphp</script>
    @endif
@endsection

@section('content')
@php
    $locale = $locale ?? app()->getLocale();
@endphp
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 text-slate-900 border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
            <div class="flex items-center gap-3">
                <a href="{{ route('services.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 transition">
                    <span>&larr;</span>
                    <span>{{ __('site.nav_services') }}</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 border border-red-200 px-3 py-1 text-xs font-black text-[#fe0002]">
                    {{ $service->title[$locale] ?? $service->title['en'] ?? '' }}
                </span>
            </div>
            
            <h1 class="mt-4 max-w-4xl text-3xl font-black text-[#c27803] sm:text-5xl leading-tight">
                {{ $service->headline[$locale] ?? $service->title[$locale] ?? $service->title['en'] ?? '' }}
            </h1>
            <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 font-medium">
                {{ $service->summary[$locale] ?? $service->summary['en'] ?? '' }}
            </p>
        </div>
    </section>

    <section class="bg-intok-section py-16 text-slate-900">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1fr_340px] lg:px-8">
            <article class="space-y-8">
                <!-- Overview Card -->
                <div class="card-poster-white p-4 sm:p-7 lg:p-8 bg-white border border-slate-200">
                    <h2 class="text-2xl font-black text-slate-900">{{ $service->title[$locale] ?? $service->title['en'] ?? '' }}</h2>
                    <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700 font-medium">
                        {{ $service->description[$locale] ?? $service->description['en'] ?? '' }}
                    </div>
                </div>

                <!-- Features -->
                @if (!empty($service->features[$locale] ?? []))
                    <div class="card-poster-white p-8 bg-white border border-slate-200">
                        <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                            <span class="text-red-600">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span>{{ __('site.service_features') }}</span>
                        </h3>
                        <ul class="mt-4 space-y-3 text-sm text-slate-700">
                            @foreach ($service->features[$locale] as $feature)
                                <li class="flex items-start gap-3">
                                    <svg class="size-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Requirements -->
                @if (!empty($service->requirements[$locale] ?? []))
                    <div class="card-poster-white p-8 bg-white border border-slate-200">
                        <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                            <span class="text-[#c27803]">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </span>
                            <span>{{ __('site.service_requirements') }}</span>
                        </h3>
                        <ul class="mt-4 space-y-2.5 text-sm text-slate-700">
                            @foreach($service->requirements[$locale] as $requirement)
                                <li class="flex items-start gap-2.5">
                                    <span class="text-amber-500 font-bold">•</span>
                                    <span>{{ $requirement }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Steps -->
                @if (!empty($service->steps[$locale] ?? []))
                    <div class="card-poster-white p-8 bg-white border border-slate-200">
                        <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                            <span class="text-red-600">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                            <span>{{ __('site.service_steps') }}</span>
                        </h3>
                        <ol class="mt-4 space-y-3 text-sm text-slate-700">
                            @foreach($service->steps[$locale] as $stepIndex => $step)
                                <li class="flex items-start gap-3">
                                    <span class="grid size-6 shrink-0 place-items-center rounded-lg bg-red-50 text-xs font-black text-red-600 border border-red-200">{{ $stepIndex + 1 }}</span>
                                    <span>{{ $step }}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                <!-- FAQs -->
                @if (!empty($service->faqs[$locale] ?? []))
                    <div class="card-poster-white p-8 bg-white border border-slate-200">
                        <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                            <span class="text-red-600">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span>{{ __('site.service_faqs') }}</span>
                        </h3>
                        <div class="mt-4 space-y-3">
                            @foreach($service->faqs[$locale] as $faq)
                                @php
                                    $faqQ = $faq['question'] ?? $faq['q'] ?? '';
                                    $faqA = $faq['answer'] ?? $faq['a'] ?? '';
                                @endphp
                                @if($faqQ && $faqA)
                                    <details class="group rounded-2xl border border-slate-200 bg-slate-50 p-5 transition hover:border-red-300">
                                        <summary class="cursor-pointer font-bold text-slate-900 text-sm list-none flex items-center justify-between">
                                            <span>{{ $faqQ }}</span>
                                            <span class="text-red-600 transition-transform group-open:rotate-180">▼</span>
                                        </summary>
                                        <p class="mt-3 text-xs leading-relaxed text-slate-600 pt-3 border-t border-slate-200">{{ $faqA }}</p>
                                    </details>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>

            <!-- Sidebar CTA -->
            <aside class="h-fit card-poster-white p-7 border border-slate-200 bg-white">
                <div class="size-12 rounded-2xl bg-red-50 text-red-600 border border-red-100 grid place-items-center shadow-xs">
                    <svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <h2 class="mt-4 text-xl font-black text-slate-900">{{ __('site.contact_title') }}</h2>
                <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ __('site.hero_text') }}</p>
                <a href="{{ route('consultation.create', ['locale' => $locale, 'service_id' => $service->id]) }}" class="btn-intok-primary mt-6 inline-flex w-full justify-center py-3.5 text-xs font-black shadow-xs">
                    {{ __('site.hero_cta') }}
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" target="_blank" class="mt-3 inline-flex w-full justify-center rounded-full border border-emerald-200 bg-emerald-50 px-5 py-3 text-xs font-bold text-emerald-800 hover:bg-emerald-100 transition">
                    استفسار واتساب سريع
                </a>
            </aside>
        </div>
    </section>
@endsection
