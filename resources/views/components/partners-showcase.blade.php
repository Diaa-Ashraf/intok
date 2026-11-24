@php
    $locale = app()->getLocale();
    $countries = config('partners.countries', []);

    $defaultSubtitle = match ($locale) {
        'it' => 'Esplora la nostra rete globale di università, college e istituti di formazione accreditati.',
        'en' => 'Explore our global network of accredited universities, colleges, and training institutes.',
        default => 'استكشف شبكتنا الدولية من الجامعات والكليات والمعاهد الأكاديمية والمهنية المعتمدة عالمياً.',
    };

    $partnersData = [];
    foreach ($countries as $cKey => $country) {
        foreach ($country['partners'] as $p) {
            $displayName = ($locale === 'en' || $locale === 'it') ? $p['name_en'] : $p['name_ar'];
            $partnersData[] = [
                'country' => $cKey,
                'name' => $displayName,
                'image' => asset($p['image']),
            ];
        }
    }

    $totalCount = count($partnersData);
    $initialDuration = max(36, (int) round($totalCount * 3.0));

    $activePillClasses = 'bg-[#fe0002] text-white border-[#fe0002] shadow-md shadow-red-600/20';
    $inactivePillClasses = 'bg-white text-neutral-700 border-neutral-200 hover:border-neutral-300 hover:bg-neutral-50 shadow-2xs';
    $cardClasses = 'group/card relative flex items-center justify-center w-44 h-28 sm:w-52 sm:h-32 shrink-0 rounded-2xl border border-neutral-200/80 bg-white p-4 sm:p-5 shadow-2xs transition-all duration-300 ease-out hover:-translate-y-1 hover:border-[#fe0002]/35 hover:shadow-lg hover:shadow-neutral-900/5';
    $cardImageClasses = 'max-h-full max-w-full w-auto h-auto object-contain transition-transform duration-300 ease-out group-hover/card:scale-105 pointer-events-none';
    $groupClasses = 'partners-marquee-group flex items-center gap-4 sm:gap-6 pe-4 sm:pe-6 shrink-0';
@endphp

<div id="partners-showcase-root" class="w-full select-none">
    <!-- Country Filter Pills & Dynamic Subtitle (Aligned inside max-w-7xl) -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-6 reveal-up" role="group" aria-label="{{ match ($locale) {
            'it' => 'Filtra partner per paese',
            'en' => 'Filter partners by country',
            default => 'تصفية الشركاء حسب الدولة',
        } }}">
            <!-- All Destinations Tab -->
            <button type="button"
                    onclick="switchPartnerCountry('all', this)"
                    data-subtitle="{{ $defaultSubtitle }}"
                    aria-pressed="true"
                    class="partner-filter-pill group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all duration-300 border cursor-pointer {{ $activePillClasses }}">
                <svg class="size-4 shrink-0 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                    <path d="M2 12h20"/>
                </svg>
                <span>{{ match ($locale) {
                    'it' => 'Tutti i Paesi',
                    'en' => 'All Destinations',
                    default => 'جميع الدول',
                } }}</span>
                <span class="partner-count-badge size-5 rounded-full text-[10px] font-black inline-flex items-center justify-center font-mono bg-white/20 text-white tabular-nums">
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
                        onclick="switchPartnerCountry('{{ $cKey }}', this)"
                        data-subtitle="{{ $cSubtitle }}"
                        aria-pressed="false"
                        class="partner-filter-pill group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all duration-300 border cursor-pointer {{ $inactivePillClasses }}">
                    @if($cKey === 'italy')
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 3 2" aria-hidden="true">
                            <rect width="1" height="2" fill="#009246"/>
                            <rect width="1" height="2" x="1" fill="#ffffff"/>
                            <rect width="1" height="2" x="2" fill="#ce2b37"/>
                        </svg>
                    @elseif($cKey === 'germany')
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 5 3" aria-hidden="true">
                            <rect width="5" height="1" fill="#000000"/>
                            <rect width="5" height="1" y="1" fill="#dd0000"/>
                            <rect width="5" height="1" y="2" fill="#ffce00"/>
                        </svg>
                    @elseif($cKey === 'canada')
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 4 2" aria-hidden="true">
                            <rect width="1" height="2" fill="#d80621"/>
                            <rect width="2" height="2" x="1" fill="#ffffff"/>
                            <rect width="1" height="2" x="3" fill="#d80621"/>
                            <path d="M2 0.4l0.2 0.4 0.4-0.1-0.2 0.4 0.4 0.2-0.5 0.1 0.1 0.4-0.4-0.3-0.4 0.3 0.1-0.4-0.5-0.1 0.4-0.2-0.2-0.4 0.4 0.1z" fill="#d80621"/>
                        </svg>
                    @elseif($cKey === 'spain')
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 3 2" aria-hidden="true">
                            <rect width="3" height="2" fill="#c60b1e"/>
                            <rect width="3" height="1" y="0.5" fill="#ffc400"/>
                        </svg>
                    @elseif($cKey === 'turkey')
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-2xs shrink-0 overflow-hidden" viewBox="0 0 3 2" aria-hidden="true">
                            <rect width="3" height="2" fill="#e30a17"/>
                            <circle cx="1.2" cy="1" r="0.5" fill="#ffffff"/>
                            <circle cx="1.35" cy="1" r="0.4" fill="#e30a17"/>
                            <polygon points="1.8,1 1.6,0.85 1.65,1.1 1.5,0.95 1.7,0.95" fill="#ffffff"/>
                        </svg>
                    @else
                        <span class="px-1 py-0.5 rounded text-[9px] font-mono bg-neutral-100 text-neutral-700">{{ $cCode }}</span>
                    @endif

                    <span>{{ $cName }}</span>
                    <span class="partner-count-badge size-5 rounded-full text-[10px] font-black inline-flex items-center justify-center font-mono bg-neutral-100 text-neutral-600 tabular-nums">
                        {{ $cCount }}
                    </span>
                </button>
            @endforeach
        </div>

        <div class="mb-8 text-center">
            <p id="partner-country-subtitle" class="text-xs sm:text-sm text-neutral-600 font-bold max-w-3xl mx-auto leading-relaxed">
                {{ $defaultSubtitle }}
            </p>
        </div>
    </div>

    <!-- Single-Track Full-Width Moving Logo Slider -->
    <div id="partners-marquee-viewport"
         class="relative w-full overflow-hidden py-3 group transition-opacity duration-200"
         dir="ltr">
        <!-- Cinematic Edge Fade Masks -->
        <div class="partners-edge-mask pointer-events-none absolute inset-y-0 left-0 w-14 sm:w-32 bg-gradient-to-r from-white via-white/85 to-transparent z-20" aria-hidden="true"></div>
        <div class="partners-edge-mask pointer-events-none absolute inset-y-0 right-0 w-14 sm:w-32 bg-gradient-to-l from-white via-white/85 to-transparent z-20" aria-hidden="true"></div>

        <div id="partners-single-track"
             class="partners-marquee-track flex items-center will-change-transform group-hover:[animation-play-state:paused]"
             style="animation-duration: {{ $initialDuration }}s;">
            @foreach([false, true] as $isClone)
                <div class="{{ $groupClasses }}" @if($isClone) aria-hidden="true" @endif>
                    @foreach($partnersData as $partner)
                        <div class="{{ $cardClasses }}" title="{{ $partner['name'] }}">
                            <img src="{{ $partner['image'] }}"
                                 alt="{{ $partner['name'] }}"
                                 loading="eager"
                                 decoding="async"
                                 draggable="false"
                                 class="{{ $cardImageClasses }}">
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    (() => {
        const allPartners = @json($partnersData);
        const minCardsPerGroup = 14;
        const activeClasses = @json(explode(' ', $activePillClasses));
        const inactiveClasses = @json(explode(' ', $inactivePillClasses));
        const cardClasses = @json($cardClasses);
        const cardImageClasses = @json($cardImageClasses);
        const groupClasses = @json($groupClasses);
        let filterTimer = null;

        function buildCardElement(partner) {
            const card = document.createElement('div');
            card.className = cardClasses;
            card.title = partner.name || '';

            const img = document.createElement('img');
            img.src = partner.image;
            img.alt = partner.name || '';
            img.loading = 'eager';
            img.decoding = 'async';
            img.draggable = false;
            img.className = cardImageClasses;

            card.appendChild(img);
            return card;
        }

        function buildMarqueeGroup(items, isClone) {
            const group = document.createElement('div');
            group.className = groupClasses;
            if (isClone) {
                group.setAttribute('aria-hidden', 'true');
            }
            items.forEach(item => group.appendChild(buildCardElement(item)));
            return group;
        }

        window.switchPartnerCountry = function (country, btn) {
            const pills = document.querySelectorAll('.partner-filter-pill');
            pills.forEach(pill => {
                pill.classList.remove(...activeClasses);
                pill.classList.add(...inactiveClasses);
                pill.setAttribute('aria-pressed', 'false');
                const badge = pill.querySelector('.partner-count-badge');
                if (badge) {
                    badge.classList.remove('bg-white/20', 'text-white');
                    badge.classList.add('bg-neutral-100', 'text-neutral-600');
                }
            });

            btn.classList.remove(...inactiveClasses);
            btn.classList.add(...activeClasses);
            btn.setAttribute('aria-pressed', 'true');
            const activeBadge = btn.querySelector('.partner-count-badge');
            if (activeBadge) {
                activeBadge.classList.add('bg-white/20', 'text-white');
                activeBadge.classList.remove('bg-neutral-100', 'text-neutral-600');
            }

            const subtitle = btn.getAttribute('data-subtitle');
            const subtitleEl = document.getElementById('partner-country-subtitle');
            if (subtitle && subtitleEl) {
                subtitleEl.textContent = subtitle;
            }

            const viewport = document.getElementById('partners-marquee-viewport');
            const track = document.getElementById('partners-single-track');
            if (!viewport || !track) return;

            const filtered = country === 'all'
                ? allPartners
                : allPartners.filter(item => item.country === country);

            if (!filtered.length) return;

            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const groupItems = [];
            if (reducedMotion) {
                groupItems.push(...filtered);
            } else {
                const repeatTimes = filtered.length < minCardsPerGroup
                    ? Math.ceil(minCardsPerGroup / filtered.length)
                    : 1;
                for (let i = 0; i < repeatTimes; i++) {
                    groupItems.push(...filtered);
                }
            }

            const applyTrackUpdate = () => {
                if (reducedMotion) {
                    track.replaceChildren(buildMarqueeGroup(groupItems, false));
                } else {
                    track.replaceChildren(
                        buildMarqueeGroup(groupItems, false),
                        buildMarqueeGroup(groupItems, true)
                    );
                }

                const durationSeconds = Math.max(32, Math.round(groupItems.length * 3.0));
                track.style.animation = 'none';
                void track.offsetWidth;
                track.style.animation = '';
                track.style.animationDuration = `${durationSeconds}s`;

                viewport.classList.remove('opacity-0');
                viewport.classList.add('opacity-100');
            };

            if (filterTimer) {
                clearTimeout(filterTimer);
            }

            if (reducedMotion) {
                applyTrackUpdate();
                return;
            }

            viewport.classList.add('opacity-0');
            viewport.classList.remove('opacity-100');
            filterTimer = setTimeout(applyTrackUpdate, 160);
        };
    })();
</script>

<style>
    @keyframes partnersMarqueeLtr {
        0% {
            transform: translate3d(0, 0, 0);
        }
        100% {
            transform: translate3d(-50%, 0, 0);
        }
    }

    @keyframes partnersMarqueeRtl {
        0% {
            transform: translate3d(-50%, 0, 0);
        }
        100% {
            transform: translate3d(0, 0, 0);
        }
    }

    .partners-marquee-track {
        width: max-content;
        animation-name: partnersMarqueeLtr;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    html[dir="rtl"] .partners-marquee-track {
        animation-name: partnersMarqueeRtl;
    }

    @media (prefers-reduced-motion: reduce) {
        .partners-marquee-track {
            animation: none !important;
            width: 100%;
            overflow-x: auto;
            padding-inline: 1rem;
        }

        .partners-marquee-group[aria-hidden="true"],
        .partners-edge-mask {
            display: none;
        }
    }
</style>
