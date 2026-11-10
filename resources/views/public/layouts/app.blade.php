<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}" dir="{{ ($locale ?? app()->getLocale()) === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @php
        $localizedRouteParameters = Route::current() ? Route::current()->parameters() : [];
        $currentRouteName = Route::currentRouteName() ?? 'home';
        $alternateLinks = [];

        if ($currentRouteName !== 'contact.store') {
            foreach (['ar', 'en', 'it'] as $supportedLocale) {
                $parameters = $localizedRouteParameters;
                $parameters['locale'] = $supportedLocale;

                if ($currentRouteName === 'services.show' && isset($service)) {
                    $parameters['slug'] = $service->{'slug_'.$supportedLocale};
                } elseif ($currentRouteName === 'pages.show' && isset($page)) {
                    $parameters['slug'] = $page->{'slug_'.$supportedLocale};
                }

                $alternateLinks[$supportedLocale] = route($currentRouteName, $parameters);
            }
        }
    @endphp
    @foreach ($alternateLinks as $alternateLocale => $alternateUrl)
        <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}">
    @endforeach
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', data_get($siteSettings ?? [], 'default_seo_description.'.app()->getLocale(), data_get($siteSettings ?? [], 'tagline.'.app()->getLocale(), __('site.tagline'))))">
    @if (data_get($siteSettings ?? [], 'search_console_tag'))<meta name="google-site-verification" content="{{ data_get($siteSettings, 'search_console_tag') }}">@endif
    <meta property="og:title" content="@yield('title', __('site.brand')) | {{ __('site.brand') }}">
    <meta property="og:description" content="@yield('meta_description', __('site.tagline'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', data_get($siteSettings ?? [], 'default_seo_title.'.app()->getLocale(), __('site.brand'))) | {{ data_get($siteSettings ?? [], 'site_name.'.app()->getLocale(), __('site.brand')) }}</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=2">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/intok-logo.jpg') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <script type="application/ld+json">@php echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => data_get($siteSettings ?? [], 'site_name.'.app()->getLocale(), __('site.brand')),
        'description' => data_get($siteSettings ?? [], 'tagline.'.app()->getLocale(), __('site.tagline')),
        'url' => url('/'.app()->getLocale()),
        'telephone' => data_get($siteSettings ?? [], 'contact_phone', '+201008238323'),
        'sameAs' => array_values(data_get($siteSettings ?? [], 'social_links', [])),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); @endphp</script>
    @include('components.assets')
    @if (data_get($siteSettings ?? [], 'ga4_id'))<script async src="https://www.googletagmanager.com/gtag/js?id={{ rawurlencode(data_get($siteSettings, 'ga4_id')) }}"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config',@json(data_get($siteSettings, 'ga4_id')));</script>@endif
    @yield('structured_data')
</head>
<body id="top" class="min-h-screen bg-white text-slate-900 antialiased selection:bg-[#fe0002] selection:text-white overflow-x-clip max-w-full relative">

    <!-- GLOBAL ACTIVE LIVING ANIMATED BACKGROUND (Runs on all pages) -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden" aria-hidden="true">
        <!-- Active 60fps Ambient Particle Canvas -->
        <canvas id="global-ambient-canvas" class="absolute inset-0 h-full w-full opacity-40"></canvas>
        
        <!-- Ambient Aurora Energy Glows (Dual Brand Colors: Red & Mustard - Hidden on mobile for peak performance) -->
        <div class="hidden md:block animate-aurora-1 absolute -top-40 start-1/4 size-[40rem] rounded-full bg-gradient-to-br from-red-500/12 to-amber-500/12 blur-[130px]"></div>
        <div class="hidden md:block animate-aurora-2 absolute top-1/2 -end-32 size-[36rem] rounded-full bg-gradient-to-tr from-[#c27803]/10 to-rose-500/10 blur-[120px]"></div>
        <div class="hidden md:block animate-aurora-3 absolute -bottom-32 start-10 size-[36rem] rounded-full bg-gradient-to-tl from-amber-400/10 to-red-500/8 blur-[110px]"></div>
        <div class="hidden md:block animate-aurora-1 absolute top-1/4 start-1/2 size-[28rem] rounded-full bg-amber-500/8 blur-[100px]"></div>

        <!-- Dynamic Live Meteors Streaking Through the Sky -->
        <div class="meteor-streak-item" style="top: 8%; right: 12%; animation-delay: 0.5s;"></div>
        <div class="meteor-streak-item" style="top: 30%; right: 45%; animation-delay: 3.5s;"></div>
        <div class="meteor-streak-item" style="top: 55%; right: 20%; animation-delay: 6.5s;"></div>
        <div class="meteor-streak-item" style="top: 80%; right: 60%; animation-delay: 9.5s;"></div>
    </div>

    @php
        $activeNavLinks = [
            ['route' => 'home', 'label' => __('site.nav_home')],
            ['route' => 'about', 'label' => __('site.nav_about')],
            ['route' => 'services.index', 'label' => __('site.nav_services')],
            ['route' => 'team', 'label' => __('site.nav_team')],
            ['route' => 'registration.create', 'label' => __('site.registration_title')],
            ['route' => 'contact', 'label' => __('site.nav_contact')],
        ];
        if (\App\Models\Testimonial::query()->where('is_published', true)->exists()) {
            array_splice($activeNavLinks, 4, 0, [['route' => 'testimonials', 'label' => __('site.nav_testimonials')]]);
        }
    @endphp

    <!-- Main Navigation Bar (Logo Red #fe0002) -->
    <header class="sticky top-0 z-40 bg-[#fe0002] text-white shadow-md transition-all duration-300 border-b border-black/10 overflow-hidden w-full max-w-full">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-3.5 sm:px-6 lg:px-8 flex-nowrap gap-2" aria-label="{{ __('site.brand') }}">
            <!-- Brand Logo -->
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="group flex items-center gap-2 sm:gap-3 shrink-0">
                <div class="relative size-10 sm:size-11 shrink-0 overflow-hidden rounded-full border-2 border-white bg-white p-0.5 shadow-md transition-transform duration-300 group-hover:scale-105">
                    <img src="{{ asset('assets/images/intok-logo.jpg') }}" alt="INTOK Logo" class="h-full w-full object-cover rounded-full">
                </div>
                <div class="shrink-0">
                    <div class="flex items-center gap-1.5">
                        <span class="text-base sm:text-xl font-black tracking-tight text-white group-hover:text-amber-200 transition">IN TOK</span>
                        <span class="rounded-md bg-white/20 px-1.5 py-0.5 text-[9px] sm:text-[10px] font-black text-white border border-white/40">ACADEMY</span>
                    </div>
                    <p class="hidden xs:block text-[9px] sm:text-[10px] font-semibold text-white/90 tracking-wider">Connecting You to the World</p>
                </div>
            </a>

            <!-- Desktop Navigation Links (xl and up ONLY) -->
            <div class="desktop-nav-links hidden items-center gap-3.5 xl:flex shrink-0">
                @foreach($activeNavLinks as $link)
                    <a class="nav-link {{ Route::currentRouteName() === $link['route'] ? 'nav-link-active' : '' }}" href="{{ route($link['route'], ['locale' => app()->getLocale()]) }}">{{ $link['label'] }}</a>
                @endforeach
            </div>

            <!-- Header Right: Language Switcher & White Pill CTA Button & Hamburger -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <div class="relative">
                    <label class="sr-only" for="locale-switch">{{ __('site.language') }}</label>
                    <select id="locale-switch" aria-label="{{ __('site.language') }}" class="appearance-none rounded-xl border border-white/30 bg-black/20 py-2 pe-7 ps-2.5 sm:ps-3 text-xs font-bold text-white transition hover:bg-black/30 focus:outline-none focus:ring-2 focus:ring-white/40" onchange="window.location.href=this.value">
                        @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $loc => $label)
                            @php($localizedRouteParameters['locale'] = $loc)
                            @if (Route::currentRouteName() === 'services.show' && isset($service))
                                @php($localizedRouteParameters['slug'] = $service->{'slug_'.$loc})
                            @endif
                            <option value="{{ route(Route::currentRouteName() ?? 'home', $localizedRouteParameters) }}" @selected(app()->getLocale() === $loc) class="bg-[#fe0002] text-white">{{ $label }}</option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 end-2 flex items-center text-white/80 text-xs">▼</span>
                </div>

                <!-- Primary CTA Button (Crisp White on Logo Red) -->
                <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="hidden sm:inline-flex items-center gap-2 rounded-full bg-white px-4 lg:px-5 py-2.5 text-xs font-black text-[#fe0002] shadow-md transition hover:bg-amber-50 hover:scale-105">
                    <span>{{ __('site.hero_cta') }}</span>
                </a>

                <!-- Mobile & Tablet Hamburger Menu Toggle Button (Visible below xl) -->
                <button type="button" id="mobile-menu-open-btn" aria-label="فتح القائمة الرئيسية" class="xl:hidden inline-flex size-10 items-center justify-center rounded-xl bg-white/15 text-white hover:bg-white/25 focus:outline-none focus:ring-2 focus:ring-white/40 cursor-pointer transition">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Full-Featured Responsive Mobile Slide-Over Drawer -->
    <div id="mobile-nav-backdrop" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300"></div>
    <aside id="mobile-nav-drawer" class="fixed inset-y-0 z-50 w-full max-w-xs sm:max-w-sm bg-white text-slate-900 shadow-2xl transition-transform duration-300 ease-in-out flex flex-col justify-between overflow-y-auto" style="{{ (app()->getLocale() === 'ar') ? 'right: 0; transform: translateX(100%);' : 'left: 0; transform: translateX(-100%);' }}">
        
        <!-- Header of Drawer -->
        <div class="p-5 border-b border-white/10 flex items-center justify-between bg-gradient-to-r from-[#fe0002] to-red-700 text-white">
            <div class="flex items-center gap-3">
                <div class="size-11 rounded-full border-2 border-white bg-white p-0.5 shadow-sm shrink-0">
                    <img src="{{ asset('assets/images/intok-logo.jpg') }}" alt="INTOK Logo" class="size-full object-cover rounded-full">
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight block">IN TOK ACADEMY</span>
                    <p class="text-[10px] text-red-100 font-bold">بوابتك للدراسة والعمل الدولي</p>
                </div>
            </div>
            <button type="button" id="mobile-menu-close-btn" aria-label="إغلاق القائمة" class="size-9 rounded-xl bg-white/20 hover:bg-white/30 text-white grid place-items-center cursor-pointer transition">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Links in Drawer -->
        <div class="p-4 sm:p-5 space-y-1.5 flex-1">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider px-2 block mb-2">أقسام الموقع:</span>
            @foreach($activeNavLinks as $link)
                <a href="{{ route($link['route'], ['locale' => app()->getLocale()]) }}" class="flex items-center justify-between p-3.5 rounded-2xl text-xs sm:text-sm font-black transition {{ Route::currentRouteName() === $link['route'] ? 'bg-red-50 text-[#fe0002] border border-red-200 shadow-xs' : 'text-slate-800 hover:bg-slate-50' }}">
                    <span class="flex items-center gap-2.5">
                        <span class="size-2 rounded-full {{ Route::currentRouteName() === $link['route'] ? 'bg-[#fe0002]' : 'bg-slate-300' }}"></span>
                        <span>{{ $link['label'] }}</span>
                    </span>
                    <span class="text-xs text-slate-400 font-bold">←</span>
                </a>
            @endforeach
        </div>

        <!-- Quick Contacts & Direct CTAs inside Drawer -->
        <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50 space-y-2.5">
            <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary w-full py-3.5 px-4 text-center text-xs font-black shadow-md flex items-center justify-center">
                <span>{{ __('site.hero_cta') }}</span>
            </a>

            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode('مرحباً، أود استشارة أكاديمية من خلال موقع INTOK ACADEMY') }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 rounded-full border-2 border-emerald-500 bg-emerald-50 py-3 text-xs font-black text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-xs">
                <span>تواصل فوري واتساب (24/7)</span>
            </a>

            <a href="tel:{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}" class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white py-2.5 text-xs font-bold text-slate-700 shadow-2xs hover:bg-slate-100 transition">
                <span>{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}</span>
            </a>
        </div>
    </aside>

    <!-- Page Content Container -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- WhatsApp Quick Contact Floating Button (Official Brand SVG) -->
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer" class="fixed bottom-5 end-4 sm:bottom-6 sm:end-6 z-40 group flex size-12 sm:size-14 items-center justify-center rounded-full bg-emerald-600 text-white shadow-xl shadow-emerald-600/30 transition-all duration-300 hover:scale-110 hover:bg-emerald-500 focus:outline-none">
        <svg class="size-6 sm:size-7 fill-white" viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.99.54 1.787.82 2.796.821 3.183 0 5.77-2.586 5.77-5.766.001-3.182-2.585-5.768-5.77-5.768zm0 10.373c-.886 0-1.579-.247-2.312-.682l-.165-.098-1.58.414.422-1.541-.107-.171c-.482-.767-.736-1.517-.736-2.529 0-2.539 2.066-4.605 4.606-4.605 2.539 0 4.606 2.066 4.606 4.605 0 2.54-2.067 4.607-4.606 4.607z"/>
        </svg>
    </a>

    <!-- Footer (Refined Obsidian Slate with Clean Typography & Architectural Accent) -->
    <footer class="relative mt-24 border-t border-slate-800 bg-[#0b0f19] text-slate-300 overflow-hidden">
        
        <!-- Architectural Silhouette Watermark -->
        <div class="pointer-events-none absolute bottom-0 inset-x-0 h-40 opacity-5 flex justify-between items-end overflow-hidden">
            <svg class="w-full h-32" viewBox="0 0 1200 120" fill="none" preserveAspectRatio="none">
                <path d="M0,120 L0,90 Q30,70 60,90 L60,120 M80,120 L80,75 Q110,55 140,75 L140,120 M160,120 L160,60 Q200,30 240,60 L240,120 M260,120 L260,75 Q290,55 320,75 L320,120 M340,120 L340,90 Q370,70 400,90 L400,120 M420,120 L420,50 Q480,10 540,50 L540,120 M560,120 L560,75 Q590,55 620,75 L620,120 M640,120 L640,90 Q670,70 700,90 L700,120 M720,120 L720,60 Q760,30 800,60 L800,120 M820,120 L820,75 Q850,55 880,75 L880,120 M900,120 L900,90 Q930,70 960,90 L960,120 M980,120 L980,45 Q1040,10 1100,45 L1100,120 M1120,120 L1120,75 Q1150,55 1180,75 L1180,120" stroke="#ffffff" stroke-width="2"/>
            </svg>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="size-11 overflow-hidden rounded-2xl border border-slate-700 bg-white p-0.5">
                            <img src="{{ asset('assets/images/intok-logo.jpg') }}" alt="INTOK Logo" class="h-full w-full object-cover rounded-xl">
                        </div>
                        <div>
                            <span class="text-xl font-black text-white">IN TOK</span>
                            <p class="text-[11px] font-bold text-amber-400">Connecting You to the World</p>
                        </div>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        {{ data_get($siteSettings ?? [], 'footer_text.'.app()->getLocale(), data_get($siteSettings ?? [], 'tagline.'.app()->getLocale(), __('site.tagline'))) }}
                    </p>
                    @if (data_get($siteSettings ?? [], 'social_links'))
                        <div class="flex flex-wrap gap-2 pt-2">
                            @foreach (data_get($siteSettings, 'social_links', []) as $network => $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-slate-800 bg-slate-900/60 px-3 py-1.5 text-xs text-slate-300 transition hover:border-amber-400 hover:text-amber-400">{{ ucfirst($network) }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Fast Links -->
                <div>
                    <h4 class="text-sm font-black uppercase tracking-wider text-white">روابط سريعة</h4>
                    <ul class="mt-4 space-y-2.5 text-xs text-slate-400">
                        @foreach($activeNavLinks as $footerLink)
                            <li><a href="{{ route($footerLink['route'], ['locale' => app()->getLocale()]) }}" class="hover:text-amber-400 transition">{{ $footerLink['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Academic Services -->
                <div>
                    <h4 class="text-sm font-black uppercase tracking-wider text-white">الخدمات والبرامج</h4>
                    <ul class="mt-4 space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="hover:text-amber-400 transition">تقييم الملف والاستشارة الأكاديمية</a></li>
                        <li><a href="{{ route('registration.create', ['locale' => app()->getLocale()]) }}" class="hover:text-amber-400 transition">التقديم لمنح إيطاليا DSU الشاملة</a></li>
                        <li><a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="hover:text-amber-400 transition">ترجمة وتصديق المستندات الرسمية</a></li>
                        <li><a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="hover:text-amber-400 transition">تدريب الكول سنتر واللغات الاحترافية</a></li>
                    </ul>
                </div>

                <!-- Direct Contact -->
                <div>
                    <h4 class="text-sm font-black uppercase tracking-wider text-white">تواصل مباشر</h4>
                    <div class="mt-4 space-y-3 text-xs text-slate-300">
                        <div class="flex items-center gap-2">
                            <span class="text-red-400 font-bold">هاتف:</span>
                            <a href="tel:{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}" class="font-bold hover:text-white" dir="ltr">{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">واتساب:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" class="hover:text-emerald-300 font-bold" target="_blank">واتساب مباشر (خدمة 24/7)</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-amber-400 font-bold">الأكاديمية:</span>
                            <span class="font-bold tracking-wider">INTOKACADEMY</span>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary flex w-full justify-center items-center gap-2 py-3 text-xs font-black shadow-lg">
                                <span>احجز استشارتك الأكاديمية الآن</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Subfooter -->
            <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 sm:flex-row text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} {{ data_get($siteSettings ?? [], 'footer_copyright.'.app()->getLocale(), 'INTOK ACADEMY. All Rights Reserved. Connecting You to the World.') }}</p>
                @if(($legalPages ?? collect())->isNotEmpty())
                    <nav class="flex flex-wrap gap-4">
                        @foreach($legalPages as $legalPage)
                            <a class="hover:text-amber-400 transition" href="{{ route('pages.show', ['locale'=>app()->getLocale(),'slug'=>$legalPage->{'slug_'.app()->getLocale()}]) }}">{{ $legalPage->title[app()->getLocale()] ?? '' }}</a>
                        @endforeach
                    </nav>
                @endif
            </div>
        </div>
    </footer>

    <!-- Global Scroll Reveal & Ambient Background Particles Engine -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. GLOBAL INTERSECTION OBSERVER FOR SCROLL REVEALS
            const revealElements = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-scale');
            
            if ('IntersectionObserver' in window && revealElements.length > 0) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -40px 0px'
                });

                revealElements.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 20) {
                        setTimeout(() => el.classList.add('revealed'), 50);
                    } else {
                        revealObserver.observe(el);
                    }
                });
            } else {
                revealElements.forEach(el => el.classList.add('revealed'));
            }

            // 2. GLOBAL AMBIENT 60FPS BACKGROUND PARTICLES (Desktop Only for Peak Speed)
            const gCanvas = document.getElementById('global-ambient-canvas');
            if (gCanvas && window.innerWidth >= 1024) {
                const gCtx = gCanvas.getContext('2d');
                let gWidth = gCanvas.width = window.innerWidth;
                let gHeight = gCanvas.height = window.innerHeight;

                window.addEventListener('resize', () => {
                    if (gCanvas) {
                        gWidth = gCanvas.width = window.innerWidth;
                        gHeight = gCanvas.height = window.innerHeight;
                    }
                });

                const pCount = Math.min(Math.floor(gWidth / 20), 65);
                const pList = [];
                const pColors = [
                    'rgba(254, 0, 2, ',      // Brand Red
                    'rgba(194, 120, 3, ',    // Brand Mustard Gold
                    'rgba(245, 158, 11, ',   // Warm Sun Amber
                    'rgba(148, 163, 184, '   // Crisp Silver Slate
                ];

                for (let i = 0; i < pCount; i++) {
                    pList.push({
                        x: Math.random() * gWidth,
                        y: Math.random() * gHeight,
                        vx: (Math.random() - 0.5) * 0.65,
                        vy: (Math.random() - 0.5) * 0.65,
                        radius: Math.random() * 2.2 + 0.9,
                        color: pColors[Math.floor(Math.random() * pColors.length)],
                        alpha: Math.random() * 0.45 + 0.2
                    });
                }

                let mousePos = { x: null, y: null };
                window.addEventListener('mousemove', (e) => {
                    mousePos.x = e.clientX;
                    mousePos.y = e.clientY;
                });

                function renderGlobalCanvas() {
                    gCtx.clearRect(0, 0, gWidth, gHeight);

                    for (let i = 0; i < pList.length; i++) {
                        const p = pList[i];
                        p.x += p.vx;
                        p.y += p.vy;

                        if (p.x < 0 || p.x > gWidth) p.vx *= -1;
                        if (p.y < 0 || p.y > gHeight) p.vy *= -1;

                        if (mousePos.x !== null && mousePos.y !== null) {
                            const dx = mousePos.x - p.x;
                            const dy = mousePos.y - p.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);
                            if (dist < 130) {
                                const f = (130 - dist) / 130;
                                p.x += (dx / dist) * f * 0.9;
                                p.y += (dy / dist) * f * 0.9;
                            }
                        }

                        gCtx.fillStyle = p.color + p.alpha + ')';
                        gCtx.beginPath();
                        gCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                        gCtx.fill();

                        for (let j = i + 1; j < pList.length; j++) {
                            const p2 = pList[j];
                            const dx = p.x - p2.x;
                            const dy = p.y - p2.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);

                            if (dist < 110) {
                                const a = (1 - dist / 110) * 0.22;
                                gCtx.strokeStyle = `rgba(194, 120, 3, ${a})`;
                                gCtx.lineWidth = 0.75;
                                gCtx.beginPath();
                                gCtx.moveTo(p.x, p.y);
                                gCtx.lineTo(p2.x, p2.y);
                                gCtx.stroke();
                            }
                        }
                    }

                    requestAnimationFrame(renderGlobalCanvas);
                }

                renderGlobalCanvas();
            }

            // 3. RESPONSIVE MOBILE DRAWER LOGIC
            const mobileOpenBtn = document.getElementById('mobile-menu-open-btn');
            const mobileCloseBtn = document.getElementById('mobile-menu-close-btn');
            const mobileBackdrop = document.getElementById('mobile-nav-backdrop');
            const mobileDrawer = document.getElementById('mobile-nav-drawer');

            function openMobileDrawer() {
                if (!mobileDrawer || !mobileBackdrop) return;
                mobileBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                mobileBackdrop.classList.add('opacity-100');
                mobileDrawer.style.transform = 'translateX(0)';
                document.body.style.overflow = 'hidden';
            }

            function closeMobileDrawer() {
                if (!mobileDrawer || !mobileBackdrop) return;
                mobileBackdrop.classList.add('opacity-0', 'pointer-events-none');
                mobileBackdrop.classList.remove('opacity-100');
                const isRtl = document.documentElement.dir === 'rtl';
                mobileDrawer.style.transform = isRtl ? 'translateX(100%)' : 'translateX(-100%)';
                document.body.style.overflow = '';
            }

            if (mobileOpenBtn) mobileOpenBtn.addEventListener('click', openMobileDrawer);
            if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileDrawer);
            if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileDrawer);
        });
    </script>
</body>
</html>
