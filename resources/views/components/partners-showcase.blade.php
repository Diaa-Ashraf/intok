@php
    $locale = app()->getLocale();
    $countries = config('partners.countries', []);

    $defaultSubtitle = match($locale) {
        'it' => 'Esplora la nostra rete globale di università, college e istituti di formazione accreditati.',
        'en' => 'Explore our global network of accredited universities, colleges, and training institutes.',
        default => 'استكشف شبكتنا الدولية من الجامعات والكليات والمعاهد الأكاديمية والمهنية المعتمدة عالمياً.',
    };

    // Flatten all partners with country context
    $allPartners = [];
    foreach ($countries as $cKey => $country) {
        foreach ($country['partners'] as $p) {
            $p['country_key'] = $cKey;
            $p['country_name'] = $country['names'][$locale] ?? $country['names']['ar'];
            $p['country_code'] = $country['code'] ?? strtoupper(substr($cKey, 0, 2));
            $allPartners[] = $p;
        }
    }
    $totalCount = count($allPartners);

    // Split partners into two balanced groups for dual-track marquee
    $half = (int) ceil($totalCount / 2);
    $track1Partners = array_slice($allPartners, 0, $half);
    $track2Partners = array_slice($allPartners, $half);
@endphp

<div id="partners-showcase-root" class="w-full select-none">
    <!-- Country Filter Tabs -->
    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-8 reveal-up">
        <!-- All Countries Tab -->
        <button type="button" 
                onclick="filterMarquee('all', this)" 
                data-subtitle="{{ $defaultSubtitle }}"
                class="partner-filter-pill active-partner-pill group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all duration-300 border border-[#fe0002] bg-[#fe0002] text-white shadow-md shadow-red-600/20 cursor-pointer">
            <svg class="size-4 shrink-0 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                <path d="M2 12h20"/>
            </svg>
            <span>{{ match($locale) {
                'it' => 'Tutti i Paesi',
                'en' => 'All Destinations',
                default => 'جميع الدول',
            } }}</span>
            <span class="partner-count-badge size-5 rounded-full text-[10px] font-black inline-flex items-center justify-center font-mono bg-white/20 text-white">
                {{ $totalCount }}
            </span>
        </button>

        @foreach($countries as $cKey => $country)
            @php
                $cName = $country['names'][$locale] ?? $country['names']['ar'];
                $cSubtitle = $country['subtitle'][$locale] ?? $country['subtitle']['ar'];
                $cCount = count($country['partners']);
                $cCode = $country['code'] ?? strtoupper(substr($cKey, 0, 2));
            @endphp
            <button type="button" 
                    onclick="filterMarquee('{{ $cKey }}', this)" 
                    data-subtitle="{{ $cSubtitle }}"
                    class="partner-filter-pill group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all duration-300 border border-neutral-200 bg-white text-neutral-700 hover:border-neutral-300 hover:bg-neutral-50 cursor-pointer shadow-2xs">
                
                <!-- Crisp Vector SVG Flags -->
                @if($cKey === 'italy')
                    <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 3 2">
                        <rect width="1" height="2" fill="#009246"/>
                        <rect width="1" height="2" x="1" fill="#ffffff"/>
                        <rect width="1" height="2" x="2" fill="#ce2b37"/>
                    </svg>
                @elseif($cKey === 'germany')
                    <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 5 3">
                        <rect width="5" height="1" fill="#000000"/>
                        <rect width="5" height="1" y="1" fill="#dd0000"/>
                        <rect width="5" height="1" y="2" fill="#ffce00"/>
                    </svg>
                @elseif($cKey === 'canada')
                    <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 4 2">
                        <rect width="1" height="2" fill="#d80621"/>
                        <rect width="2" height="2" x="1" fill="#ffffff"/>
                        <rect width="1" height="2" x="3" fill="#d80621"/>
                        <path d="M2 0.4l0.2 0.4 0.4-0.1-0.2 0.4 0.4 0.2-0.5 0.1 0.1 0.4-0.4-0.3-0.4 0.3 0.1-0.4-0.5-0.1 0.4-0.2-0.2-0.4 0.4 0.1z" fill="#d80621"/>
                    </svg>
                @elseif($cKey === 'spain')
                    <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 3 2">
                        <rect width="3" height="2" fill="#c60b1e"/>
                        <rect width="3" height="1" y="0.5" fill="#ffc400"/>
                    </svg>
                @elseif($cKey === 'turkey')
                    <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 3 2">
                        <rect width="3" height="2" fill="#e30a17"/>
                        <circle cx="1.2" cy="1" r="0.5" fill="#ffffff"/>
                        <circle cx="1.35" cy="1" r="0.4" fill="#e30a17"/>
                        <polygon points="1.8,1 1.6,0.85 1.65,1.1 1.5,0.95 1.7,0.95" fill="#ffffff"/>
                    </svg>
                @else
                    <span class="px-1 py-0.5 rounded text-[9px] font-mono bg-neutral-100 text-neutral-700">{{ $cCode }}</span>
                @endif

                <span>{{ $cName }}</span>
                <span class="partner-count-badge size-5 rounded-full text-[10px] font-black inline-flex items-center justify-center font-mono bg-neutral-100 text-neutral-600">
                    {{ $cCount }}
                </span>
            </button>
        @endforeach
    </div>

    <!-- Active Country Subtitle Banner -->
    <div id="partner-country-header" class="mb-8 text-center transition-all duration-300">
        <p id="partner-country-subtitle" class="text-xs sm:text-sm text-neutral-600 font-bold max-w-3xl mx-auto leading-relaxed">
            {{ $defaultSubtitle }}
        </p>
    </div>

    <!-- ========================================================
         FULL-WIDTH INFINITE SMOOTH MARQUEE SLIDER
         ======================================================== -->
    <div class="relative w-screen left-1/2 right-1/2 -mx-[50vw] overflow-hidden py-4">
        
        <!-- Edge Gradient Fade Masks (Cinematic Entrance & Exit) -->
        <div class="pointer-events-none absolute inset-y-0 start-0 w-16 sm:w-36 bg-gradient-to-r from-white via-white/80 to-transparent z-20 rtl:bg-gradient-to-l"></div>
        <div class="pointer-events-none absolute inset-y-0 end-0 w-16 sm:w-36 bg-gradient-to-l from-white via-white/80 to-transparent z-20 rtl:bg-gradient-to-r"></div>

        <!-- Marquee Row 1 (Track 1: Moves Left) -->
        <div class="marquee-wrapper group mb-4 sm:mb-6 overflow-hidden flex">
            <div class="marquee-track flex gap-4 sm:gap-6 shrink-0 py-2 group-hover:[animation-play-state:paused]" id="marquee-row-1">
                @foreach(array_merge($track1Partners, $track1Partners) as $partner)
                    @include('components.partner-card-item', ['partner' => $partner, 'locale' => $locale])
                @endforeach
            </div>
            <div class="marquee-track flex gap-4 sm:gap-6 shrink-0 py-2 group-hover:[animation-play-state:paused]" aria-hidden="true">
                @foreach(array_merge($track1Partners, $track1Partners) as $partner)
                    @include('components.partner-card-item', ['partner' => $partner, 'locale' => $locale])
                @endforeach
            </div>
        </div>

        <!-- Marquee Row 2 (Track 2: Moves in Reverse Direction) -->
        <div class="marquee-wrapper group overflow-hidden flex">
            <div class="marquee-track-reverse flex gap-4 sm:gap-6 shrink-0 py-2 group-hover:[animation-play-state:paused]" id="marquee-row-2">
                @foreach(array_merge($track2Partners, $track2Partners) as $partner)
                    @include('components.partner-card-item', ['partner' => $partner, 'locale' => $locale])
                @endforeach
            </div>
            <div class="marquee-track-reverse flex gap-4 sm:gap-6 shrink-0 py-2 group-hover:[animation-play-state:paused]" aria-hidden="true">
                @foreach(array_merge($track2Partners, $track2Partners) as $partner)
                    @include('components.partner-card-item', ['partner' => $partner, 'locale' => $locale])
                @endforeach
            </div>
        </div>

    </div>

    <!-- Bottom Action CTA Banner -->
    <div class="mt-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-neutral-900 border border-neutral-800 p-6 sm:p-10 text-white relative overflow-hidden shadow-2xl reveal-up">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-start">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-500/20 text-red-300 text-xs font-black border border-red-500/30 mb-3">
                        <span class="size-2 rounded-full bg-red-500"></span>
                        <span>{{ match($locale) {
                            'it' => 'Ammissione & Borse di Studio',
                            'en' => 'Direct Admission & Scholarships',
                            default => 'القبول المباشر والمنح الدراسية',
                        } }}</span>
                    </span>
                    <h3 class="text-lg sm:text-2xl font-black text-white leading-tight">
                        {{ match($locale) {
                            'it' => 'Vuoi iscriverti a una di queste prestigiose università?',
                            'en' => 'Looking to secure admission at one of these top institutions?',
                            default => 'جاهز لبدء دراستك في إحدى كبرى الجامعات العالمية المعتمدة؟',
                        } }}
                    </h3>
                    <p class="text-xs sm:text-sm text-neutral-300 font-normal mt-2 leading-relaxed">
                        {{ match($locale) {
                            'it' => 'Il nostro team di consulenti ti guida passo dopo passo: dalla scelta del corso, alla preparazione dei documenti, fino all\'ottenimento della borsa di studio e del visto.',
                            'en' => 'Our educational advisors guide you through every step: program selection, document translation, scholarship eligibility, and visa processing.',
                            default => 'فريق INTOK يرافقك خطوة بخطوة: من اختيار التخصص وتجهيز الملف وترجمته المعتمدة، حتى التقديم على المنح واستخراج التأشيرة الرسمية.',
                        } }}
                    </p>
                </div>
                <a href="#consultation" 
                   class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-[#fe0002] hover:bg-[#d40002] text-white text-xs sm:text-sm font-black transition-all duration-300 shadow-lg shadow-red-600/30 hover:shadow-red-600/50 shrink-0">
                    <span>{{ match($locale) {
                        'it' => 'Richiedi una Consulenza Gratuita',
                        'en' => 'Book Free Consultation',
                        default => 'احجز جلستك الاستشارية المجانية',
                    } }}</span>
                    <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function filterMarquee(country, btn) {
        const pills = document.querySelectorAll('.partner-filter-pill');
        pills.forEach(p => {
            p.classList.remove('active-partner-pill', 'bg-[#fe0002]', 'text-white', 'border-[#fe0002]', 'shadow-md', 'shadow-red-600/20');
            p.classList.add('bg-white', 'text-neutral-700', 'border-neutral-200');
            const b = p.querySelector('.partner-count-badge');
            if (b) {
                b.classList.remove('bg-white/20', 'text-white');
                b.classList.add('bg-neutral-100', 'text-neutral-600');
            }
        });

        btn.classList.add('active-partner-pill', 'bg-[#fe0002]', 'text-white', 'border-[#fe0002]', 'shadow-md', 'shadow-red-600/20');
        btn.classList.remove('bg-white', 'text-neutral-700', 'border-neutral-200');
        const activeBadge = btn.querySelector('.partner-count-badge');
        if (activeBadge) {
            activeBadge.classList.add('bg-white/20', 'text-white');
            activeBadge.classList.remove('bg-neutral-100', 'text-neutral-600');
        }

        // Dynamically update subtitle
        const subtitle = btn.getAttribute('data-subtitle');
        const subtitleEl = document.getElementById('partner-country-subtitle');
        if (subtitle && subtitleEl) {
            subtitleEl.textContent = subtitle;
        }

        const cards = document.querySelectorAll('.partner-slider-card');
        cards.forEach(card => {
            const cardCountry = card.getAttribute('data-country');
            if (country === 'all' || cardCountry === country) {
                card.classList.remove('opacity-25', 'grayscale', 'scale-95');
                card.classList.add('opacity-100', 'scale-100');
            } else {
                card.classList.add('opacity-25', 'grayscale', 'scale-95');
                card.classList.remove('opacity-100', 'scale-100');
            }
        });
    }
</script>

<style>
    @keyframes marqueeScroll {
        0% {
            transform: translate3d(0, 0, 0);
        }
        100% {
            transform: translate3d(-50%, 0, 0);
        }
    }

    @keyframes marqueeScrollReverse {
        0% {
            transform: translate3d(-50%, 0, 0);
        }
        100% {
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes marqueeScrollRtl {
        0% {
            transform: translate3d(0, 0, 0);
        }
        100% {
            transform: translate3d(50%, 0, 0);
        }
    }

    @keyframes marqueeScrollReverseRtl {
        0% {
            transform: translate3d(50%, 0, 0);
        }
        100% {
            transform: translate3d(0, 0, 0);
        }
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: marqueeScroll 45s linear infinite;
        will-change: transform;
    }

    .marquee-track-reverse {
        display: flex;
        width: max-content;
        animation: marqueeScrollReverse 45s linear infinite;
        will-change: transform;
    }

    [dir="rtl"] .marquee-track {
        animation-name: marqueeScrollRtl;
    }

    [dir="rtl"] .marquee-track-reverse {
        animation-name: marqueeScrollReverseRtl;
    }

    @media (max-width: 768px) {
        .marquee-track {
            animation-duration: 32s;
        }
        .marquee-track-reverse {
            animation-duration: 32s;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .marquee-track,
        .marquee-track-reverse {
            animation: none !important;
            overflow-x: auto;
            max-width: 100vw;
        }
    }
</style>
