@extends('public.layouts.app')

@section('title', __('site.nav_testimonials'))

@section('content')
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 text-slate-900 border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
            <span class="inline-block rounded-full border border-red-200 bg-white/90 px-3.5 py-1 text-xs font-black text-red-600 shadow-xs">
                قصص واقعية وتجارب ملهمة
            </span>
            <h1 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">{{ __('site.testimonials_title') }}</h1>
            <p class="mt-4 max-w-2xl leading-relaxed text-slate-600 font-medium">{{ __('site.testimonials_intro') }}</p>
        </div>
    </section>

    <section class="bg-intok-section py-16 text-slate-900 min-h-[60vh]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($testimonials as $testimonial)
                    <article class="card-poster-white flex flex-col justify-between p-7 bg-white border border-slate-200">
                        <div>
                            <div class="flex items-center gap-3">
                                @if($testimonial->photo_path)
                                    <img src="{{ asset('storage/'.$testimonial->photo_path) }}" alt="{{ $testimonial->name[app()->getLocale()] ?? '' }}" loading="lazy" class="size-14 rounded-2xl object-cover border border-slate-200">
                                @else
                                    <div class="size-14 rounded-2xl bg-red-50 text-red-600 border border-red-200 grid place-items-center text-lg font-black shadow-xs">
                                        {{ mb_substr($testimonial->name[app()->getLocale()] ?? $testimonial->name['en'] ?? 'T', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h2 class="text-base font-black text-slate-900">{{ $testimonial->name[app()->getLocale()] ?? $testimonial->name['en'] ?? '' }}</h2>
                                    <p class="text-xs font-bold text-red-600">{{ $testimonial->destination[app()->getLocale()] ?? 'طالب مبتعث' }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-1 text-[#c27803]" aria-label="{{ $testimonial->rating }} من 5">
                                @for($i = 0; $i < $testimonial->rating; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>

                            <blockquote class="mt-4 text-xs leading-relaxed text-slate-600 font-medium">
                                “{{ $testimonial->quote[app()->getLocale()] ?? $testimonial->quote['en'] ?? '' }}”
                            </blockquote>
                        </div>

                        @if($testimonial->video_url)
                            <div class="mt-6 border-t border-slate-100 pt-4">
                                <a href="{{ $testimonial->video_url }}" target="_blank" rel="noopener noreferrer" class="badge-red-pill inline-flex items-center gap-1.5 py-2 px-3 text-xs hover:brightness-110 transition">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                    <span>{{ __('site.watch_story') }}</span>
                                </a>
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="col-span-full rounded-3xl border border-slate-200 bg-white p-12 text-center text-slate-500">
                        {{ __('site.testimonials_empty') }}
                    </div>
                @endforelse
            </div>
            <div class="mt-10">{{ $testimonials->links() }}</div>
        </div>
    </section>
@endsection
