@extends('public.layouts.app')

@section('title', __('site.nav_contact'))
@section('meta_description', __('site.hero_text'))

@section('content')
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 text-slate-900 border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
            <span class="inline-block rounded-full border border-red-200 bg-white/90 px-3.5 py-1 text-xs font-black text-red-600 shadow-xs">
                {{ data_get($siteSettings ?? [], 'contact_badge.'.$locale, 'قنوات التواصل المباشر') }}
            </span>
            <h1 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">{{ data_get($siteSettings ?? [], 'contact_page_title.'.$locale, __('site.contact_title')) }}</h1>
            <p class="mt-4 max-w-2xl leading-relaxed text-slate-600 font-medium">{{ data_get($siteSettings ?? [], 'contact_intro.'.$locale, __('site.hero_text')) }}</p>
        </div>
    </section>

    <section class="bg-intok-section py-16 text-slate-900 min-h-[60vh]">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1fr_360px] lg:px-8">
            <!-- Contact Form -->
            <div class="card-poster-white p-4 sm:p-7 md:p-10 bg-white border border-slate-200">
                @if (session('status'))
                    <div role="status" class="mb-6 flex items-center gap-2 rounded-2xl border border-emerald-500/30 bg-emerald-50 p-4 text-sm font-bold text-emerald-800">
                        <svg class="size-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" class="space-y-6">
                    @csrf
                    <div class="absolute -left-[10000px] h-px w-px overflow-hidden" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" tabindex="-1" autocomplete="off"></div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_name') }}</label>
                            <input id="name" name="name" value="{{ old('name') }}" required maxlength="150" autocomplete="name" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @error('name')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_email') }}</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @error('email')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_phone') }}</label>
                            <input id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel" maxlength="30" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @error('phone')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="subject" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_subject') }}</label>
                            <input id="subject" name="subject" value="{{ old('subject') }}" maxlength="200" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @error('subject')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_message') }}</label>
                        <textarea id="message" name="message" rows="5" required maxlength="5000" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-intok-primary w-full sm:w-auto px-8 py-3.5 text-xs font-black shadow-lg">
                        {{ __('site.contact_send') }}
                    </button>
                </form>
            </div>

            <!-- Aside Info -->
            <aside class="space-y-6">
                <div class="card-poster-white p-7 bg-white border border-slate-200">
                    <div class="size-12 rounded-2xl bg-red-50 text-red-600 border border-red-200 grid place-items-center shadow-xs">
                        <svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </div>
                    <h2 class="mt-4 text-xl font-black text-slate-900">{{ data_get($siteSettings ?? [], 'site_name.'.app()->getLocale(), __('site.brand')) }}</h2>
                    <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ data_get($siteSettings ?? [], 'tagline.'.app()->getLocale(), __('site.tagline')) }}</p>
                    
                    <div class="mt-6 space-y-3 border-t border-slate-100 pt-4 text-xs">
                        <div class="flex items-center gap-2 text-slate-700">
                            <svg class="size-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <a href="tel:{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}" class="font-bold hover:text-red-600">{{ data_get($siteSettings ?? [], 'contact_phone', __('site.phone')) }}</a>
                        </div>
                        <div class="flex items-center gap-2 text-slate-700">
                            <svg class="size-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" target="_blank" class="hover:text-emerald-700 font-bold">واتساب مباشر للدعم</a>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" target="_blank" class="flex w-full justify-center items-center gap-2 rounded-full bg-emerald-600 py-3 text-xs font-bold text-white hover:bg-emerald-500 transition shadow-xs">
                            <span>محادثة واتساب سريعة</span>
                        </a>
                        <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary flex w-full justify-center items-center gap-2 py-3 text-xs font-black shadow-xs">
                            <span>{{ __('site.hero_cta') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Map container -->
                <div class="card-poster-white p-5 bg-white border border-slate-200">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_map') }}</h3>
                    @php($mapUrl = data_get($siteSettings ?? [], 'map_embed') ?: config('intok.google_map_embed'))
                    @if($mapUrl && str_starts_with($mapUrl, 'https://www.google.com/maps/embed'))
                        <iframe class="mt-3 h-52 w-full rounded-2xl border-0" src="{{ $mapUrl }}" title="{{ __('site.contact_map') }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                    @else
                        <div class="mt-3 grid h-40 place-items-center rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center text-xs text-slate-500">
                            {{ __('site.contact_map_placeholder') }}
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>
@endsection
