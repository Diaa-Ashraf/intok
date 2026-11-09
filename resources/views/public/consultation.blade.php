@extends('public.layouts.app')

@section('title', __('site.booking_title'))

@section('content')
<section class="relative isolate overflow-hidden bg-intok-hero py-16 text-slate-900 border-b border-slate-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
        <span class="inline-block rounded-full border border-red-200 bg-white/90 px-4 py-1 text-xs font-black text-red-600 shadow-xs">
            {{ data_get($siteSettings ?? [], 'consultation_badge.'.$locale, 'جلسة إرشادية 1-on-1') }}
        </span>
        <h1 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">{{ data_get($siteSettings ?? [], 'consultation_title.'.$locale, __('site.booking_title')) }}</h1>
        <p class="mt-4 max-w-2xl leading-relaxed text-slate-600 font-medium">{{ data_get($siteSettings ?? [], 'consultation_intro.'.$locale, __('site.booking_intro')) }}</p>
    </div>
</section>

<section class="bg-intok-section py-16 text-slate-900 min-h-[60vh]">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('consultation.store', ['locale' => app()->getLocale()]) }}" class="card-poster-white space-y-6 p-4 sm:p-7 md:p-10 bg-white border border-slate-200">
            @csrf
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">
            <div class="absolute -left-[10000px] h-px w-px overflow-hidden" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" tabindex="-1" autocomplete="off"></div>
            
            @if(session('status'))
                <div role="status" class="flex items-center gap-2 rounded-2xl border border-emerald-500/30 bg-emerald-50 p-4 text-sm font-bold text-emerald-800">
                    <svg class="size-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @foreach(['name'=>'contact_name','phone'=>'contact_phone','email'=>'contact_email'] as $field=>$key)
                <div>
                    <label for="{{ $field }}" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.'.$key) }}</label>
                    <input id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}" @if($field === 'email') type="email" @endif @if($field !== 'email') required @endif maxlength="255" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                    @error($field)<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                </div>
            @endforeach

            <div>
                <label for="preferred_at" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.preferred_time') }}</label>
                <input id="preferred_at" name="preferred_at" type="datetime-local" min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" value="{{ old('preferred_at') }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                @error('preferred_at')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="service_id" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.interested_service') }}</label>
                <select id="service_id" name="service_id" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                    <option value="" class="bg-white">{{ __('site.optional') }}</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" @selected(old('service_id', request()->query('service_id')) == $service->id) class="bg-white">{{ $service->title[app()->getLocale()] ?? $service->title['en'] }}</option>
                    @endforeach
                </select>
                @error('service_id')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="notes" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.notes') }}</label>
                <textarea id="notes" name="notes" rows="4" maxlength="2000" placeholder="اذكر لنا تخصصك المطلوب، درجاتك الحالية، أو أي استفسار ترغب بمناقشته..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">{{ old('notes') }}</textarea>
                @error('notes')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-intok-primary w-full py-4 text-sm font-black shadow-lg">
                {{ __('site.submit_booking') }}
            </button>
        </form>
    </div>
</section>
@endsection
