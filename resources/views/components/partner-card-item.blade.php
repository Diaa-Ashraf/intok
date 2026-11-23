@php
    $displayName = ($locale === 'en' || $locale === 'it') ? $partner['name_en'] : $partner['name_ar'];
    $secondaryName = ($locale === 'en' || $locale === 'it') ? $partner['name_ar'] : $partner['name_en'];
    $tag = ($locale === 'en' || $locale === 'it') ? $partner['tag_en'] : $partner['tag_ar'];
    $cKey = $partner['country_key'];
@endphp

<div class="partner-slider-card group relative flex flex-col justify-between w-56 sm:w-64 shrink-0 rounded-2xl sm:rounded-3xl border border-neutral-200/90 bg-white p-3.5 sm:p-4 transition-all duration-300 hover:-translate-y-1.5 hover:border-[#fe0002]/40 hover:shadow-xl hover:shadow-neutral-900/5 select-none"
     data-country="{{ $partner['country_key'] }}">
    
    <!-- Country Flag Vector Mini Badge -->
    <div class="flex items-center justify-between gap-1 mb-2.5">
        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-neutral-100 text-[10px] font-bold text-neutral-700">
            @if($cKey === 'italy')
                <svg class="w-3.5 h-2.5 rounded-[1px] shrink-0" viewBox="0 0 3 2">
                    <rect width="1" height="2" fill="#009246"/>
                    <rect width="1" height="2" x="1" fill="#ffffff"/>
                    <rect width="1" height="2" x="2" fill="#ce2b37"/>
                </svg>
            @elseif($cKey === 'germany')
                <svg class="w-3.5 h-2.5 rounded-[1px] shrink-0" viewBox="0 0 5 3">
                    <rect width="5" height="1" fill="#000000"/>
                    <rect width="5" height="1" y="1" fill="#dd0000"/>
                    <rect width="5" height="1" y="2" fill="#ffce00"/>
                </svg>
            @elseif($cKey === 'canada')
                <svg class="w-3.5 h-2.5 rounded-[1px] shrink-0" viewBox="0 0 4 2">
                    <rect width="1" height="2" fill="#d80621"/>
                    <rect width="2" height="2" x="1" fill="#ffffff"/>
                    <rect width="1" height="2" x="3" fill="#d80621"/>
                </svg>
            @elseif($cKey === 'spain')
                <svg class="w-3.5 h-2.5 rounded-[1px] shrink-0" viewBox="0 0 3 2">
                    <rect width="3" height="2" fill="#c60b1e"/>
                    <rect width="3" height="1" y="0.5" fill="#ffc400"/>
                </svg>
            @elseif($cKey === 'turkey')
                <svg class="w-3.5 h-2.5 rounded-[1px] shrink-0" viewBox="0 0 3 2">
                    <rect width="3" height="2" fill="#e30a17"/>
                    <circle cx="1.2" cy="1" r="0.5" fill="#ffffff"/>
                    <circle cx="1.35" cy="1" r="0.4" fill="#e30a17"/>
                </svg>
            @endif
            <span>{{ $partner['country_name'] }}</span>
        </span>
        <span class="size-1.5 rounded-full bg-emerald-500"></span>
    </div>

    <!-- Logo Frame -->
    <div class="relative flex items-center justify-center h-20 sm:h-24 w-full rounded-xl bg-neutral-50/70 p-2.5 overflow-hidden border border-neutral-100 group-hover:bg-white group-hover:border-neutral-200 transition-colors">
        <img src="{{ asset($partner['image']) }}" 
             alt="{{ $displayName }}" 
             loading="lazy"
             draggable="false"
             class="max-h-full max-w-full object-contain filter group-hover:contrast-105 group-hover:scale-105 transition-transform duration-300 pointer-events-none">
    </div>

    <!-- Text Meta -->
    <div class="mt-3 flex flex-col justify-between">
        <div>
            <h4 class="text-xs sm:text-sm font-black text-neutral-900 leading-snug line-clamp-1">
                {{ $displayName }}
            </h4>
            @if(!empty($secondaryName) && $secondaryName !== $displayName)
                <p class="text-[10px] text-neutral-500 font-medium line-clamp-1 mt-0.5 text-start" dir="ltr">
                    {{ $secondaryName }}
                </p>
            @endif
        </div>

        <div class="mt-2.5 pt-2 border-t border-neutral-100 flex items-center justify-between gap-2">
            <span class="text-[10px] font-bold text-[#c27803] line-clamp-1">
                {{ $tag }}
            </span>
            <a href="#consultation" 
               class="relative inline-flex items-center justify-center size-7 rounded-full bg-neutral-100 text-neutral-400 group-hover:bg-[#fe0002] group-hover:text-white transition-colors shrink-0 after:absolute after:-inset-1.5"
               title="{{ match($locale) { 'it' => 'Richiedi info', 'en' => 'Inquire now', default => 'استفسر عن القبول' } }}">
                <svg class="size-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

</div>
