@extends('public.layouts.app')

@section('title', __('site.nav_services'))
@section('meta_description', __('site.hero_text'))

@php
    $locale = $locale ?? app()->getLocale();
    $allTracks = [];

    foreach (($services ?? []) as $svc) {
        $svcTitle = data_get($svc->title, $locale, data_get($svc->title, 'ar', ''));
        $svcSlug = $svc->{'slug_'.$locale} ?? $svc->slug_ar ?? (string) $svc->id;
        $svcSummary = data_get($svc->summary, $locale, data_get($svc->summary, 'ar', ''));
        $svcDesc = data_get($svc->description, $locale, data_get($svc->description, 'ar', $svcSummary));
        $svcBadge = data_get($svc->badge, $locale, data_get($svc->badge, 'ar', 'برنامج معتمد'));
        $svcCat = data_get($svc->category_label, $locale, data_get($svc->category_label, 'ar', 'مسار تدريبي معتمد'));
        $svcLevel = data_get($svc->level, $locale, data_get($svc->level, 'ar', 'جميع المؤهلات'));
        $svcDuration = data_get($svc->duration, $locale, data_get($svc->duration, 'ar', 'مكثف ومباشر'));
        $svcMode = data_get($svc->mode, $locale, data_get($svc->mode, 'ar', 'قاعات مجهزة + أونلاين'));
        $svcTarget = data_get($svc->target_audience, $locale, data_get($svc->target_audience, 'ar', 'الطلاب والخريجون والباحثون عن التطوير'));
        $svcSalary = data_get($svc->salary_range, $locale, data_get($svc->salary_range, 'ar', 'تأهيل وظيفي مباشر'));
        $svcWaMsg = data_get($svc->whatsapp_message, $locale, data_get($svc->whatsapp_message, 'ar', 'مرحباً، أود الاستفسار والتسجيل في: '.$svcTitle));
        $svcPoints = data_get($svc->features, $locale, data_get($svc->features, 'ar', []));
        if (empty($svcPoints)) {
            $svcPoints = ['شهادة معتمدة بعد إتمام البرنامج', 'تطبيق عملي وتدريب مباشر', 'متابعة مستمرة وإرشاد وظيفي'];
        }

        $iconSvg = match ($svc->icon) {
            'academic-cap', 'italy' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>',
            'language', 'translation' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>',
            'documents', 'certificate' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
            'presentation' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
            'edit' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
            'book-open' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
            default => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>',
        };

        $badgeClass = match (true) {
            str_contains((string)$svcBadge, 'منحة') || str_contains((string)$svcBadge, '8,000') => 'bg-amber-100 text-amber-900 border-amber-300',
            str_contains((string)$svcBadge, 'عمل حر') => 'bg-blue-50 text-blue-700 border-blue-200',
            str_contains((string)$svcBadge, 'سفار') || str_contains((string)$svcBadge, 'معتمدة') => 'bg-amber-50 text-amber-800 border-amber-200',
            str_contains((string)$svcBadge, 'ضمان') || str_contains((string)$svcBadge, '100%') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            str_contains((string)$svcBadge, 'TOT') => 'bg-purple-50 text-purple-700 border-purple-200',
            default => 'bg-red-50 text-[#fe0002] border-red-200',
        };

        $categoryKey = match (true) {
            str_contains(mb_strtolower($svcTitle), 'لغ') || $svc->icon === 'language' => 'languages',
            str_contains(mb_strtolower($svcTitle), 'ترجم') || in_array($svc->icon, ['translation', 'documents', 'certificate']) => 'translation',
            str_contains(mb_strtolower($svcTitle), 'جامع') || str_contains(mb_strtolower($svcTitle), 'منح') || str_contains(mb_strtolower($svcTitle), 'استقبال') || in_array($svc->icon, ['academic-cap', 'italy']) => 'italy',
            default => 'career',
        };

        $allTracks[] = [
            'id' => (string) $svc->id,
            'category' => $categoryKey,
            'category_label' => $svcCat,
            'badge' => $svcBadge,
            'badge_class' => $badgeClass,
            'icon' => $iconSvg,
            'title' => $svcTitle,
            'level' => $svcLevel,
            'duration' => $svcDuration,
            'mode' => $svcMode,
            'target' => $svcTarget,
            'points' => $svcPoints,
            'full_desc' => $svcDesc,
            'slug' => $svcSlug,
            'wa_msg' => $svcWaMsg,
            'image_path' => $svc->image_path,
        ];
    }

    $initialTrack = $allTracks[0] ?? null;
@endphp

@section('content')
    <!-- ==========================================================
         HERO SECTION: EXECUTIVE TRAINING HUB HEADER
         ========================================================== -->
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 sm:py-20 text-slate-900 border-b border-slate-100">
        <!-- Ambient living glows -->
        <div class="animate-aurora-1 pointer-events-none absolute -top-24 start-10 -z-10 size-[32rem] rounded-full bg-red-500/10 blur-[110px]"></div>
        <div class="animate-aurora-2 pointer-events-none absolute top-1/4 end-10 -z-10 size-[30rem] rounded-full bg-amber-500/10 blur-[100px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center reveal-up">
            <span class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white/90 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                <span class="relative flex size-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                    <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                </span>
                <span>{{ data_get($siteSettings ?? [], 'services_badge.'.$locale, match($locale) {
                    'it' => '10 Servizi Educativi e Professionali Integrati',
                    'en' => '10 Integrated Educational & Career Services',
                    default => '10 خدمات تعليمية ومهنية متكاملة'
                }) }}</span>
            </span>

            @php
                $rawTitle = data_get($siteSettings ?? [], 'services_title.'.$locale, match($locale) {
                    'it' => 'INTOK - Servizi educativi e professionali integrati',
                    'en' => 'INTOK - Integrated Educational & Professional Services',
                    default => 'INTOK  خدمات تعليمية ومهنية متكاملة',
                });
                $titleWithoutPrefix = preg_replace('/^INTOK\s*[-—]?\s*/iu', '', $rawTitle);
            @endphp
            <h1 class="mt-5 text-3xl font-black text-slate-900 sm:text-5xl lg:text-6xl tracking-tight">
                <span class="text-[#fe0002] inline-block">INTOK</span> — {{ $titleWithoutPrefix }}
            </h1>

            <p class="mt-4 max-w-2xl mx-auto leading-relaxed text-slate-600 font-medium sm:text-lg">
                {{ data_get($siteSettings ?? [], 'services_subtitle.'.$locale, match($locale) {
                    'it' => "Offriamo soluzioni educative e professionali integrate che partono dall'apprendimento delle lingue e dalle traduzioni asseverate, passano per la formazione professionale fino agli studi all'estero e ai servizi accademici internazionali.",
                    'en' => "We offer integrated educational and professional solutions starting from language learning and certified translation, through vocational training, to studying abroad and international academic services.",
                    default => "بنقدم لك حلول تعليمية ومهنية متكاملة تبدأ من تعلم اللغات والترجمة المعتمدة، مرورًا بالتأهيل والتدريب المهني، وصولًا للدراسة بالخارج والخدمات الأكاديمية الدولية."
                }) }}
            </p>

            <!-- Search & Filter Ribbon -->
            <div class="mt-8 max-w-3xl mx-auto">
                <div class="relative">
                    <input type="text" id="services-search-input" placeholder="{{ match($locale) {
                        'it' => 'Cerca per nome, es: call center, studio in Europa, borse di studio, traduzione, IELTS...',
                        'en' => 'Search by keyword, e.g. call center, study in Europe, translation, IELTS...',
                        default => 'ابحث بالاسم، مثل: كول سنتر، الدراسة في أوروبا، منح دراسية، ترجمة، آيلتس...'
                    } }}" class="w-full rounded-2xl border-2 border-slate-200 bg-white py-3.5 pe-4 ps-12 text-xs sm:text-sm font-bold text-slate-800 shadow-sm focus:border-[#fe0002] focus:outline-none focus:ring-4 focus:ring-red-500/10 transition">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                </div>

                <!-- Modern Interactive Domain Switcher Pills -->
                <div class="mt-4 flex flex-wrap items-center justify-center gap-2" id="services-tabs-container">
                    <button type="button" class="service-filter-tab active-service-tab" data-filter="all">
                        <span>{{ match($locale) { 'it' => 'Tutti ('.count($allTracks).')', 'en' => 'All ('.count($allTracks).')', default => 'الكل ('.count($allTracks).')' } }}</span>
                    </button>
                    <button type="button" class="service-filter-tab" data-filter="career">
                        <span>{{ match($locale) { 'it' => 'Lavoro e Call Center', 'en' => 'Career & Call Center', default => 'الكول سنتر وسوق العمل' } }}</span>
                    </button>
                    <button type="button" class="service-filter-tab" data-filter="italy">
                        <span>{{ match($locale) { 'it' => 'Studio in Europa e Borse', 'en' => 'Study in Europe & Scholarships', default => 'الدراسة في الدول الأوروبية والمنح' } }}</span>
                    </button>
                    <button type="button" class="service-filter-tab" data-filter="translation">
                        <span>{{ match($locale) { 'it' => 'Traduzioni e Asseverazione', 'en' => 'Translation & Certification', default => 'الترجمة والاعتماد الرسمي' } }}</span>
                    </button>
                    <button type="button" class="service-filter-tab" data-filter="languages">
                        <span>{{ match($locale) { 'it' => 'Corsi di Lingua e Docenza', 'en' => 'Languages & Instructor Prep', default => 'اللغات وتأهيل المحاضرين' } }}</span>
                    </button>
                </div>
            </div>

            <!-- View Mode Switcher (Console vs Grid) -->
            <div class="mt-8 flex items-center justify-center gap-3 text-xs font-black">
                <span class="text-slate-500">{{ match($locale) { 'it' => 'Modalità di visualizzazione:', 'en' => 'Display mode:', default => 'طريقة العرض المفضلة:' } }}</span>
                <div class="inline-flex rounded-xl border border-slate-200 bg-slate-100 p-1">
                    <button type="button" id="btn-view-console" class="rounded-lg bg-white px-3.5 py-1.5 font-black text-[#fe0002] shadow-xs transition flex items-center gap-1.5">
                        <span>{{ match($locale) { 'it' => 'Console Interattiva', 'en' => 'Interactive Console', default => 'العرض التفاعلي' } }}</span>
                    </button>
                    <button type="button" id="btn-view-grid" class="rounded-lg px-3.5 py-1.5 font-bold text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                        <span>{{ match($locale) { 'it' => 'Griglia Schede', 'en' => 'Cards Grid', default => 'شبكة البطاقات' } }}</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         VIEW 1: MASTER INTERACTIVE CONSOLE (FEATURED SHOWCASE)
         ========================================================== -->
    <section id="services-console-view" class="relative bg-intok-section py-16 border-b border-slate-200/80 w-full max-w-full overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full min-w-0 max-w-full">
            <div class="grid gap-8 lg:grid-cols-12 items-start w-full min-w-0 max-w-full" id="services-interactive-showcase">
                
                <!-- Left Column: The Interactive Track Rail (Selector) -->
                <div class="w-full min-w-0 max-w-full lg:col-span-5 xl:col-span-4 space-y-2 reveal-left" id="track-rail-container">
                    <div class="mb-2 px-1 flex items-center justify-between text-xs font-black text-slate-500 uppercase tracking-wider">
                        <span class="flex items-center gap-1.5">
                            <span>{{ match($locale) { 'it' => 'Servizi Accreditati:', 'en' => 'Approved Services:', default => 'الخدمات المعتمدة:' } }}</span>
                            <span class="text-[10px] text-slate-400 font-normal lg:hidden">{{ match($locale) { 'it' => '(Scorri per selezionare ↔)', 'en' => '(Swipe to choose ↔)', default => '(اسحب لاختيار الخدمة ↔)' } }}</span>
                        </span>
                        <span class="text-red-600 font-mono text-xs font-black">{{ count($allTracks) }} {{ match($locale) { 'it' => 'Servizi', 'en' => 'Services', default => 'خدمات' } }}</span>
                    </div>

                    <!-- On mobile/tablet: Horizontal touch-swipeable track strip. On desktop (lg+): Vertical scroll list -->
                    <div class="w-full min-w-0 max-w-full flex lg:flex-col gap-2 overflow-x-auto lg:overflow-y-auto no-scrollbar lg:pe-1 pb-2 lg:pb-0 lg:max-h-[640px]" id="track-rail-list">
                        @foreach($allTracks as $idx => $item)
                            <button type="button"
                                class="track-rail-btn shrink-0 lg:shrink w-auto lg:w-full snap-start {{ $idx === 0 ? 'active-track' : '' }} text-start p-3 sm:p-3.5 rounded-2xl border transition-all duration-200 flex items-center justify-between gap-3 group cursor-pointer"
                                data-track-id="{{ $item['id'] }}"
                                data-category="{{ $item['category'] }}"
                                data-index="{{ $idx }}"
                                data-track-data='@json($item)'>
                                
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-slate-100 text-slate-600 border border-slate-200 group-hover:bg-red-50 group-hover:text-red-600 group-hover:border-red-200 transition-colors track-rail-icon-box">
                                        {!! $item['icon'] !!}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[11px] font-mono font-black text-slate-400 track-item-num">0{{ $idx + 1 }}</span>
                                            <h3 class="text-xs sm:text-sm font-black text-slate-900 group-hover:text-red-600 track-item-title leading-snug line-clamp-1">
                                                {{ $item['title'] }}
                                            </h3>
                                        </div>
                                        <p class="text-[11px] font-medium text-slate-500 truncate mt-0.5 track-rail-level-text">
                                            {{ $item['level'] }}
                                        </p>
                                    </div>
                                </div>

                                <div class="shrink-0 flex items-center gap-1.5 track-rail-badge-box">
                                    <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[9px] font-black {{ $item['badge_class'] }} track-rail-badge">
                                        {{ $item['badge'] }}
                                    </span>
                                    <span class="hidden lg:inline text-slate-300 font-bold text-xs group-hover:text-red-600 group-hover:translate-x-[-2px] transition-all track-arrow">←</span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Right Column: The Master Cinematic Stage -->
                <div class="w-full min-w-0 max-w-full lg:col-span-7 xl:col-span-8 lg:sticky lg:top-24 reveal-right" id="service-stage-wrapper">
                    <div class="card-poster-white w-full min-w-0 max-w-full p-5 sm:p-8 lg:p-10 border border-slate-200/80 bg-white rounded-3xl shadow-xl shadow-slate-200/50 relative overflow-hidden" id="service-main-stage">
                        
                        <!-- Top Ambient Header Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-2.5 mb-6 pb-4 border-b border-slate-100 w-full min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span id="stage-badge" class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-black {{ $initialTrack['badge_class'] }}">
                                    {{ $initialTrack['badge'] }}
                                </span>
                                <span id="stage-cat-label" class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-bold text-slate-700">
                                    <span id="stage-cat-icon">{!! $initialTrack['icon'] !!}</span>
                                    <span id="stage-cat-name">{{ $initialTrack['category_label'] }}</span>
                                </span>
                            </div>
                            <span class="inline-flex items-center gap-1.5 text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                                <svg class="size-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>{{ match($locale) { 'it' => 'Ufficialmente Accreditato da INTOK', 'en' => 'Officially Accredited at INTOK', default => 'معتمد رسمياً في INTOK' } }}</span>
                            </span>
                        </div>

                        <!-- Stage Hero: Icon & Big Title -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-5 mb-5 w-full min-w-0">
                            <div id="stage-big-icon" class="grid size-14 sm:size-16 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-md shadow-red-500/20">
                                {!! $initialTrack['icon'] !!}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 id="stage-title" class="text-2xl sm:text-3xl font-black text-[#0f172a] leading-tight break-words">
                                    {{ $initialTrack['title'] }}
                                </h3>
                                <p id="stage-level" class="text-xs sm:text-sm font-bold text-red-600 mt-1 flex items-center gap-1.5">
                                    <span class="size-1.5 rounded-full bg-red-600"></span>
                                    <span>{{ $initialTrack['level'] }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Narrative Paragraph (Clear & Clean - No nested gray box!) -->
                        <p id="stage-desc" class="text-sm sm:text-base leading-relaxed text-slate-600 font-normal mb-6 pb-6 border-b border-slate-100 break-words">
                            {{ $initialTrack['full_desc'] }}
                        </p>

                        <!-- Outcomes & Skills Matrix -->
                        <div class="mb-6 w-full min-w-0">
                            <h4 class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <span class="size-2 rounded-full bg-red-600"></span>
                                <span>{{ match($locale) { 'it' => 'Caratteristiche e vantaggi del percorso:', 'en' => 'Key Outcomes & Program Highlights:', default => 'أبرز مخرجات ومميزات هذا المسار:' } }}</span>
                            </h4>
                            <div class="grid gap-3 sm:grid-cols-2 w-full min-w-0" id="stage-points-grid">
                                @foreach($initialTrack['points'] as $pIdx => $point)
                                    <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 hover:bg-slate-50 transition min-w-0">
                                        <div class="size-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                        <span class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug break-words flex-1">{{ $point }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Unified Metadata Stat Ribbon (Single Clean Row) -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 sm:p-4 rounded-2xl bg-slate-50 border border-slate-200/70 mb-6 w-full min-w-0 text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-red-600 shadow-2xs font-bold text-xs">⏱</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">{{ match($locale) { 'it' => 'Durata e calendario', 'en' => 'Duration & Schedule', default => 'المدة والجدول' } }}</span>
                                    <span id="stage-duration" class="font-black text-slate-900 block truncate">{{ $initialTrack['duration'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 min-w-0 border-t sm:border-t-0 sm:border-r sm:pr-3 border-slate-200/80 pt-2 sm:pt-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-amber-600 shadow-2xs font-bold text-xs">🏛</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">{{ match($locale) { 'it' => 'Modalità di fruizione', 'en' => 'Attendance Mode', default => 'نظام الحضور' } }}</span>
                                    <span id="stage-mode" class="font-black text-slate-900 block truncate">{{ $initialTrack['mode'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 min-w-0 border-t sm:border-t-0 sm:border-r sm:pr-3 border-slate-200/80 pt-2 sm:pt-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-blue-600 shadow-2xs font-bold text-xs">🎯</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">{{ match($locale) { 'it' => 'Destinatari', 'en' => 'Target Audience', default => 'الفئة المستهدفة' } }}</span>
                                    <span id="stage-target" class="font-black text-slate-900 block truncate" title="{{ $initialTrack['target'] }}">{{ $initialTrack['target'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Actions Bar -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2 w-full min-w-0">
                            <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 flex-1">
                                <a id="stage-cta-btn" href="{{ route('consultation.create', ['locale' => $locale]) }}" class="btn-intok-primary w-full sm:w-auto px-6 py-3.5 text-xs sm:text-sm font-black shadow-md flex items-center justify-center gap-2">
                                    <span>{{ match($locale) { 'it' => 'Prenota il tuo posto in questo percorso', 'en' => 'Book Your Seat in This Track', default => 'احجز مقعدك في هذا المسار' } }}</span>
                                    <span>←</span>
                                </a>

                                <a id="stage-wa-btn" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode($initialTrack['wa_msg']) }}" target="_blank" class="w-full sm:w-auto px-5 py-3.5 rounded-full border-2 border-emerald-500 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white font-black text-xs sm:text-sm transition shadow-xs flex items-center justify-center gap-2">
                                    <svg class="size-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    <span>{{ match($locale) { 'it' => 'WhatsApp Diretto', 'en' => 'Direct WhatsApp', default => 'واتساب مباشر' } }}</span>
                                </a>
                            </div>

                            <a id="stage-details-link" href="{{ route('services.show', ['locale' => $locale, 'slug' => $initialTrack['slug']]) }}" class="text-xs font-black text-slate-500 hover:text-[#fe0002] transition flex items-center justify-center sm:justify-start gap-1 py-1">
                                <span>{{ match($locale) { 'it' => 'Scheda Dettagliata Completa', 'en' => 'Full Details Page', default => 'صفحة التفاصيل الكاملة' } }}</span>
                                <span>&larr;</span>
                            </a>
                        </div>

                        <!-- Mobile Quick Switcher Bar (Visible on < lg) -->
                        <div class="lg:hidden flex items-center justify-between pt-3 mt-4 border-t border-slate-100 text-xs font-bold text-slate-500 w-full min-w-0">
                            <button type="button" id="stage-prev-btn" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition active:scale-95 text-xs font-black">
                                <span>{{ match($locale) { 'it' => '← Percorso Prec.', 'en' => '← Previous Track', default => '← المسار السابق' } }}</span>
                            </button>
                            <span id="stage-track-counter" class="text-xs font-mono text-slate-500 font-bold">1 / {{ count($allTracks) }}</span>
                            <button type="button" id="stage-next-btn" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition active:scale-95 text-xs font-black">
                                <span>{{ match($locale) { 'it' => 'Percorso Succ. →', 'en' => 'Next Track →', default => 'المسار التالي →' } }}</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         VIEW 2: DETAILED CARD GRID (TOGGLEABLE)
         ========================================================== -->
    <section id="services-grid-view" class="hidden relative bg-intok-section py-16 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="services-grid-container">
                @foreach ($allTracks as $item)
                    @php
                        $staggerNum = ($loop->index % 4) + 1;
                    @endphp

                    <article class="service-card-item service-card-anim reveal-up stagger-{{ $staggerNum }} group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/90 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-[#fe0002]/40 hover:shadow-xl hover:shadow-red-500/10"
                        data-category="{{ $item['category'] }}"
                        data-track-data='@json($item)'>

                        <div>
                            <!-- Top Header -->
                            <div class="mb-4 flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] font-bold text-slate-700">
                                    <span class="text-[#fe0002] inline-flex items-center">{!! $item['icon'] !!}</span>
                                    <span>{{ $item['category_label'] }}</span>
                                </span>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-black {{ $item['badge_class'] }}">
                                    {{ $item['badge'] }}
                                </span>
                            </div>

                            <!-- Icon & Title -->
                            <div class="mb-3 flex items-start gap-3.5">
                                <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-red-50 to-red-100/60 border border-red-200 text-[#fe0002] shadow-xs group-hover:scale-105 group-hover:border-[#fe0002] transition-all">
                                    {!! $item['icon'] !!}
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900 group-hover:text-[#c27803] transition-colors leading-snug">
                                        {{ $item['title'] }}
                                    </h3>
                                    <span class="text-[11px] font-bold text-slate-600 block mt-0.5">
                                        {{ $item['level'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Summary -->
                            <p class="text-xs leading-relaxed text-slate-600 font-medium line-clamp-2 mb-4">
                                {{ $item['full_desc'] }}
                            </p>

                            <!-- Highlights -->
                            <div class="space-y-2 border-t border-slate-100 pt-3 mb-4">
                                <span class="block text-[10px] font-black uppercase tracking-wider text-slate-600">{{ match($locale) { 'it' => 'Vantaggi del percorso:', 'en' => 'Key Highlights:', default => 'أبرز ما يوفره المسار:' } }}</span>
                                <ul class="space-y-1.5 text-xs text-slate-700">
                                    @foreach ($item['points'] as $pt)
                                        <li class="flex items-start gap-2 text-[11px] leading-tight">
                                            <svg class="size-3.5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            <span class="line-clamp-2 font-medium">{{ $pt }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Metadata & Actions -->
                        <div>
                            <div class="mb-4 flex flex-wrap items-center gap-1.5 text-[10px] font-bold text-slate-700">
                                <span class="rounded-lg bg-slate-100 px-2 py-0.5 border border-slate-200/80">{{ $item['duration'] }}</span>
                                <span class="rounded-lg bg-slate-100 px-2 py-0.5 border border-slate-200/80">{{ $item['mode'] }}</span>
                            </div>

                            <div class="flex items-center gap-2 border-t border-slate-100 pt-3">
                                <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="btn-intok-primary flex-1 py-2 px-3 text-center text-xs font-black shadow-xs flex items-center justify-center">
                                    <span>{{ match($locale) { 'it' => 'Prenota il tuo posto', 'en' => 'Book Your Seat', default => 'احجز مقعدك' } }}</span>
                                </a>
                                <button type="button" class="quick-view-trigger rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-black text-slate-700 hover:border-red-400 hover:text-[#fe0002] transition shadow-xs flex items-center gap-1" title="{{ match($locale) { 'it' => 'Anteprima dettagli', 'en' => 'Preview Details', default => 'معاينة تفاصيل البرنامج' } }}">
                                    <span>{{ match($locale) { 'it' => 'Dettagli', 'en' => 'Details', default => 'تفاصيل' } }}</span>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==========================================================
         ACADEMY QUALITY & ACCREDITATION PILLARS
         ========================================================== -->
    <section class="relative bg-white py-16 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span>{{ data_get($siteSettings ?? [], 'services_why_badge.'.$locale, match($locale) { 'it' => 'Standard di Qualità e Accreditamento Ufficiale', 'en' => 'Quality Standards & Official Accreditation', default => 'معايير الجودة والاعتماد الأكاديمي' }) }}</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-4xl">
                    {{ data_get($siteSettings ?? [], 'services_why_title.'.$locale, match($locale) { 'it' => 'Perché migliaia di studenti scelgono INTOK ACADEMY?', 'en' => 'Why Thousands Trust INTOK ACADEMY Programs?', default => 'لماذا يثق الآلاف في برامج INTOK ACADEMY؟' }) }}
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-600 font-medium">
                    {{ data_get($siteSettings ?? [], 'services_why_subtitle.'.$locale, match($locale) { 'it' => 'Uniamo formazione pratica diretta, accreditamento consolare ufficiale e accordi internazionali per l inserimento accademico e professionale.', 'en' => 'We combine direct practical training, official consular authentication, and international partnerships qualifying you for careers and university study.', default => 'نجمع بين التدريب العملي المباشر، والاعتماد القنصلي الرسمي، والشراكات الدولية المؤهلة للتوظيف والدراسة.' }) }}
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up stagger-1">
                    <div>
                        <div class="size-11 rounded-2xl bg-red-50 border border-red-200 text-[#fe0002] grid place-items-center mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-1.5">{{ data_get($siteSettings ?? [], 'services_pillar1_title.'.$locale, match($locale) { 'it' => 'Aule Multimediali e Simulazione Reale', 'en' => 'Smart Screens & Real-world Simulation', default => 'شاشات ذكية ومحاكاة واقعية' }) }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            {{ data_get($siteSettings ?? [], 'services_pillar1_desc.'.$locale, match($locale) { 'it' => 'Formazione applicata sui sistemi dei grandi call center internazionali e aule multimediali che riproducono l ambiente lavorativo effettivo.', 'en' => 'Hands-on practice on international call center systems and smart classrooms mirroring real workplaces.', default => 'تدريب تطبيقي على أنظمة كبرى شركات الكول سنتر العالمية وقاعات ذكية تحاكي بيئة العمل الفعلية.' }) }}
                        </p>
                    </div>
                </div>

                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up stagger-2">
                    <div>
                        <div class="size-11 rounded-2xl bg-amber-50 border border-amber-200 text-[#c27803] grid place-items-center mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-1.5">{{ data_get($siteSettings ?? [], 'services_pillar2_title.'.$locale, match($locale) { 'it' => 'Accreditamento e Asseverazione Consolare 100%', 'en' => '100% Consular Certification & Authentication', default => 'اعتماد وتوثيق قنصلي 100%' }) }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            {{ data_get($siteSettings ?? [], 'services_pillar2_desc.'.$locale, match($locale) { 'it' => 'Attestati di formazione riconosciuti e traduzioni giurate ufficiali per l ambasciata italiana e tutte le autorità consolari europee.', 'en' => 'Verified training certificates and certified translations recognized by European embassies and official entities.', default => 'شهادات تدريب موثقة وترجمات معتمدة رسمياً أمام السفارة الإيطالية وكافة السفارات والجهات الحكومية.' }) }}
                        </p>
                    </div>
                </div>

                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up stagger-3">
                    <div>
                        <div class="size-11 rounded-2xl bg-blue-50 border border-blue-200 text-blue-600 grid place-items-center mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-1.5">{{ data_get($siteSettings ?? [], 'services_pillar3_title.'.$locale, match($locale) { 'it' => 'Qualificazione Professionale per Multinazionali', 'en' => 'Direct Hiring Qualification for Top Firms', default => 'تأهيل وظيفي وترشيح مباشر' }) }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            {{ data_get($siteSettings ?? [], 'services_pillar3_desc.'.$locale, match($locale) { 'it' => 'Preparazione e simulazioni per colloqui di assunzione con canali preferenziali per multinazionali con retribuzioni competitive.', 'en' => 'Targeted mock interviews and direct qualification for major multinational firms with competitive packages.', default => 'توصيات مباشرة وتأهيل لاجتياز مقابلات الـ HR والـ Operations برواتب تصل 30,000+ ج.م.' }) }}
                        </p>
                    </div>
                </div>

                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up stagger-4">
                    <div>
                        <div class="size-11 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 grid place-items-center mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-base font-black text-slate-900 mb-1.5">{{ data_get($siteSettings ?? [], 'services_pillar4_title.'.$locale, match($locale) { 'it' => 'Orientamento Studi e Borse in Europa', 'en' => 'Study in Europe & Scholarships Guidance', default => 'التأهيل للدراسة في أوروبا والمنح' }) }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            {{ data_get($siteSettings ?? [], 'services_pillar4_desc.'.$locale, match($locale) { 'it' => 'Assistenza completa per borse di studio, alloggio e immatricolazione in atenei europei per studenti e diplomati.', 'en' => 'Full guidance on regional scholarships, tuition exemption, and housing in European universities.', default => 'تأهيل شامل للمنح الدراسية والإعفاء من المصروفات والسكن الجامعي بالجامعات الأوروبية.' }) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         BOTTOM CTA BANNER
         ========================================================== -->
    <section class="relative bg-gradient-to-r from-[#fe0002] to-red-700 py-14 text-white text-center overflow-hidden">
        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <span class="inline-block rounded-full bg-white/20 border border-white/30 px-4 py-1 text-xs font-black text-amber-200 mb-3">
                {{ data_get($siteSettings ?? [], 'services_cta_badge.'.$locale, match($locale) { 'it' => 'Il tuo primo passo verso un futuro internazionale', 'en' => 'Your First Step Toward an International Future', default => 'خطوتك الأولى نحو مستقبلك الدولي' }) }}
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                {{ data_get($siteSettings ?? [], 'services_cta_title.'.$locale, match($locale) { 'it' => 'Hai bisogno di aiuto per scegliere il percorso formativo più adatto a te?', 'en' => 'Need Help Choosing the Best Training Track for You?', default => 'هل تحتاج لمساعدة في اختيار المسار التدريبي الأنسب لك؟' }) }}
            </h2>
            <p class="mt-3 text-xs sm:text-sm text-red-100 font-medium max-w-xl mx-auto leading-relaxed">
                {{ data_get($siteSettings ?? [], 'services_cta_subtitle.'.$locale, match($locale) { 'it' => 'Prenota una sessione di orientamento gratuita per esaminare i tuoi titoli e obiettivi e definire il tuo piano formativo.', 'en' => 'Book a free consultation session with our educational advisors to assess your profile and set your career plan.', default => 'احجز جلسة استشارة مجانية مع مستشارك الأكاديمي لمراجعة مؤهلك وهدفك وتحديد خطتك التدريبية والمهنية.' }) }}
            </p>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="rounded-full bg-white px-7 py-3.5 text-xs sm:text-sm font-black text-[#fe0002] shadow-lg hover:bg-amber-100 transition transform hover:scale-105">
                    {{ match($locale) { 'it' => 'Prenota la Consulenza Gratuita', 'en' => 'Book Free Consultation', default => 'احجز استشارتك المجانية' } }}
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode(match($locale) { 'it' => 'Ciao, vorrei maggiori informazioni sui percorsi formativi di INTOK ACADEMY', 'en' => 'Hello, I want to inquire about training tracks at INTOK ACADEMY', default => 'مرحباً، أود استشارة لتحديد المسار التدريبي المناسب لي في أكاديمية إنتوك' }) }}" target="_blank" class="rounded-full border-2 border-white/40 bg-white/10 px-6 py-3.5 text-xs sm:text-sm font-black text-white backdrop-blur-md hover:bg-white hover:text-slate-900 transition">
                    {{ match($locale) { 'it' => 'Informa su WhatsApp', 'en' => 'Inquire via WhatsApp', default => 'استفسار عبر الواتساب' } }}
                </a>
            </div>
        </div>
    </section>

    <!-- Quick View Modal for Services -->
    <div id="service-quick-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0 pointer-events-none" role="dialog" aria-modal="true" aria-labelledby="modal-service-title">
        <div class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white p-7 text-start shadow-2xl transition-all scale-95 border border-slate-200" id="service-quick-modal-panel">
            <button type="button" id="service-quick-modal-close" class="absolute top-5 left-5 grid size-9 place-items-center rounded-full bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-[#fe0002] transition" aria-label="إغلاق">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="flex items-center gap-2 mb-3">
                <span id="modal-service-badge" class="inline-flex items-center rounded-full px-3 py-1 text-xs font-black bg-red-50 text-[#fe0002] border border-red-200">
                    {{ match($locale) { 'it' => 'Accreditato', 'en' => 'Accredited', default => 'معتمد' } }}
                </span>
                <span id="modal-service-cat" class="text-xs font-bold text-slate-600">
                    {{ match($locale) { 'it' => 'Categoria', 'en' => 'Category', default => 'الفئة' } }}
                </span>
            </div>

            <div class="flex items-center gap-3.5 mb-4">
                <div id="modal-service-icon" class="grid size-14 place-items-center rounded-2xl bg-red-50 text-[#fe0002] border border-red-100 shadow-xs">
                    {!! $allTracks[0]['icon'] !!}
                </div>
                <div>
                    <h3 id="modal-service-title" class="text-xl font-black text-[#c27803] leading-snug">
                        {{ match($locale) { 'it' => 'Titolo Servizio', 'en' => 'Service Title', default => 'عنوان الخدمة' } }}
                    </h3>
                    <span id="modal-service-level" class="text-xs font-bold text-slate-600">
                        {{ match($locale) { 'it' => 'Livello e Tipo', 'en' => 'Level & Type', default => 'المستوى والنوع' } }}
                    </span>
                </div>
            </div>

            <p id="modal-service-desc" class="text-xs leading-relaxed text-slate-600 font-medium mb-5 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                {{ match($locale) { 'it' => 'Descrizione completa del servizio', 'en' => 'Full service description', default => 'وصف الخدمة الكامل' } }}
            </p>

            <div class="space-y-3 mb-6">
                <span class="block text-xs font-black text-slate-800">{{ match($locale) { 'it' => 'Caratteristiche e vantaggi del percorso:', 'en' => 'Key Highlights & Program Benefits:', default => 'أهم مميزات ومخرجات المسار:' } }}</span>
                <div id="modal-service-points" class="space-y-2">
                    <!-- Injected points -->
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 text-[11px] font-bold text-slate-700 bg-slate-50 p-3 rounded-2xl border border-slate-100 mb-6">
                <div>{{ match($locale) { 'it' => 'Durata:', 'en' => 'Duration:', default => 'المدة:' } }} <span id="modal-service-duration" class="font-black text-slate-900">-</span></div>
                <div>{{ match($locale) { 'it' => 'Modalità:', 'en' => 'Mode:', default => 'النظام:' } }} <span id="modal-service-mode" class="font-black text-slate-900">-</span></div>
                <div class="col-span-2 mt-1">{{ match($locale) { 'it' => 'Destinatari:', 'en' => 'Target Audience:', default => 'الفئة المستهدفة:' } }} <span id="modal-service-target" class="font-black text-slate-900">-</span></div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <a id="modal-service-cta" href="{{ route('consultation.create', ['locale' => $locale]) }}" class="btn-intok-primary w-full sm:flex-1 py-3 text-center text-xs font-black shadow-md flex items-center justify-center">
                    <span>{{ match($locale) { 'it' => 'Prenota la tua consulenza per questo percorso', 'en' => 'Book Consultation for This Track', default => 'احجز استشارتك في هذا المسار' } }}</span>
                </a>
                <a id="modal-service-whatsapp" href="https://wa.me/201008238323" target="_blank" class="w-full sm:w-auto px-5 py-3 rounded-full bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-500 transition shadow-xs flex items-center justify-center">
                    <span>{{ match($locale) { 'it' => 'Richiedi info su WhatsApp', 'en' => 'Inquire via WhatsApp', default => 'استفسار واتساب' } }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Interactive Engine for Services Hub -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allTracksData = {!! json_encode($allTracks, JSON_UNESCAPED_UNICODE) !!};

            // 1. View Switcher (Console vs Grid)
            const btnConsole = document.getElementById('btn-view-console');
            const btnGrid = document.getElementById('btn-view-grid');
            const consoleView = document.getElementById('services-console-view');
            const gridView = document.getElementById('services-grid-view');

            if (btnConsole && btnGrid && consoleView && gridView) {
                btnConsole.addEventListener('click', () => {
                    consoleView.classList.remove('hidden');
                    gridView.classList.add('hidden');
                    btnConsole.classList.add('bg-white', 'text-[#fe0002]', 'shadow-xs');
                    btnConsole.classList.remove('text-slate-600');
                    btnGrid.classList.remove('bg-white', 'text-[#fe0002]', 'shadow-xs');
                    btnGrid.classList.add('text-slate-600');
                });

                btnGrid.addEventListener('click', () => {
                    gridView.classList.remove('hidden');
                    consoleView.classList.add('hidden');
                    btnGrid.classList.add('bg-white', 'text-[#fe0002]', 'shadow-xs');
                    btnGrid.classList.remove('text-slate-600');
                    btnConsole.classList.remove('bg-white', 'text-[#fe0002]', 'shadow-xs');
                    btnConsole.classList.add('text-slate-600');
                });
            }

            // 2. Interactive Split Stage Rail Engine
            const trackButtons = document.querySelectorAll('.track-rail-btn');
            const stage = document.getElementById('service-main-stage');
            const stageBadge = document.getElementById('stage-badge');
            const stageCatIcon = document.getElementById('stage-cat-icon');
            const stageCatName = document.getElementById('stage-cat-name');
            const stageBigIcon = document.getElementById('stage-big-icon');
            const stageTitle = document.getElementById('stage-title');
            const stageLevel = document.getElementById('stage-level');
            const stageDesc = document.getElementById('stage-desc');
            const stagePointsGrid = document.getElementById('stage-points-grid');
            const stageDuration = document.getElementById('stage-duration');
            const stageMode = document.getElementById('stage-mode');
            const stageTarget = document.getElementById('stage-target');
            const stageWaBtn = document.getElementById('stage-wa-btn');
            const stageDetailsLink = document.getElementById('stage-details-link');
            const stageTrackCounter = document.getElementById('stage-track-counter');
            const stagePrevBtn = document.getElementById('stage-prev-btn');
            const stageNextBtn = document.getElementById('stage-next-btn');

            function getVisibleTrackBtns() {
                return Array.from(trackButtons).filter(btn => btn.style.display !== 'none');
            }

            function updateStage(track, activeIndex, totalCount) {
                if (!track) return;

                if (stage) {
                    stage.classList.remove('track-stage-anim');
                    void stage.offsetWidth;
                    stage.classList.add('track-stage-anim');
                }

                if (stageTrackCounter && typeof activeIndex === 'number' && totalCount) {
                    stageTrackCounter.textContent = `${activeIndex + 1} / ${totalCount}`;
                }

                if (stageBadge) {
                    stageBadge.textContent = track.badge;
                    stageBadge.className = `inline-flex items-center rounded-full border px-3 py-1 text-xs font-black ${track.badge_class}`;
                }
                if (stageCatIcon) stageCatIcon.innerHTML = track.icon;
                if (stageCatName) stageCatName.textContent = track.category_label;
                if (stageBigIcon) stageBigIcon.innerHTML = track.icon;
                if (stageTitle) stageTitle.textContent = track.title;
                if (stageLevel) stageLevel.textContent = track.level;
                if (stageDesc) stageDesc.textContent = track.full_desc;
                if (stageDuration) stageDuration.textContent = track.duration;
                if (stageMode) stageMode.textContent = track.mode;
                if (stageTarget) {
                    stageTarget.textContent = track.target;
                    stageTarget.title = track.target;
                }

                if (stagePointsGrid && Array.isArray(track.points)) {
                    stagePointsGrid.innerHTML = track.points.map(pt => `
                        <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 hover:bg-slate-50 transition min-w-0">
                            <div class="size-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5"><svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug break-words flex-1">${pt}</span>
                        </div>
                    `).join('');
                }

                if (stageWaBtn) {
                    const waNum = "{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}";
                    stageWaBtn.href = `https://wa.me/${waNum}?text=${encodeURIComponent(track.wa_msg || '')}`;
                }

                if (stageDetailsLink) {
                    stageDetailsLink.href = `/{{ $locale }}/services/${encodeURIComponent(track.slug)}`;
                }
            }

            trackButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    trackButtons.forEach(b => b.classList.remove('active-track'));
                    btn.classList.add('active-track');

                    try {
                        const trackData = JSON.parse(btn.getAttribute('data-track-data') || '{}');
                        const visibleBtns = getVisibleTrackBtns();
                        const activeIdx = visibleBtns.indexOf(btn);
                        updateStage(trackData, activeIdx >= 0 ? activeIdx : 0, visibleBtns.length || trackButtons.length);

                        // Smoothly center the pill horizontally
                        btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    } catch (e) {
                        console.error('Track parse error', e);
                    }
                });
            });

            // Mobile Next/Prev buttons
            if (stagePrevBtn) {
                stagePrevBtn.addEventListener('click', () => {
                    const visible = getVisibleTrackBtns();
                    const active = document.querySelector('.track-rail-btn.active-track');
                    const idx = visible.indexOf(active);
                    if (idx > 0) {
                        visible[idx - 1].click();
                    } else if (visible.length > 0) {
                        visible[visible.length - 1].click();
                    }
                });
            }

            if (stageNextBtn) {
                stageNextBtn.addEventListener('click', () => {
                    const visible = getVisibleTrackBtns();
                    const active = document.querySelector('.track-rail-btn.active-track');
                    const idx = visible.indexOf(active);
                    if (idx >= 0 && idx < visible.length - 1) {
                        visible[idx + 1].click();
                    } else if (visible.length > 0) {
                        visible[0].click();
                    }
                });
            }

            // 3. Category Filter Tabs & Live Search
            const filterTabs = document.querySelectorAll('.service-filter-tab');
            const searchInput = document.getElementById('services-search-input');
            const gridCards = document.querySelectorAll('.service-card-item');

            let currentFilter = 'all';
            let currentSearch = '';

            function applyFilters() {
                // Filter Console Track Buttons
                let firstVisibleBtn = null;
                trackButtons.forEach(btn => {
                    const cat = btn.getAttribute('data-category');
                    const text = btn.innerText.toLowerCase();
                    const matchesFilter = (currentFilter === 'all' || cat === currentFilter);
                    const matchesSearch = (!currentSearch || text.includes(currentSearch));

                    if (matchesFilter && matchesSearch) {
                        btn.style.display = 'flex';
                        if (!firstVisibleBtn) firstVisibleBtn = btn;
                    } else {
                        btn.style.display = 'none';
                    }
                });

                // If currently active button is hidden, switch to first visible
                const currentActive = document.querySelector('.track-rail-btn.active-track');
                if (firstVisibleBtn && (!currentActive || currentActive.style.display === 'none')) {
                    firstVisibleBtn.click();
                }

                // Filter Grid View Cards
                gridCards.forEach(card => {
                    const cat = card.getAttribute('data-category');
                    const text = card.innerText.toLowerCase();
                    const matchesFilter = (currentFilter === 'all' || cat === currentFilter);
                    const matchesSearch = (!currentSearch || text.includes(currentSearch));

                    if (matchesFilter && matchesSearch) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    filterTabs.forEach(t => t.classList.remove('active-service-tab'));
                    tab.classList.add('active-service-tab');
                    currentFilter = tab.getAttribute('data-filter') || 'all';
                    applyFilters();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    currentSearch = e.target.value.trim().toLowerCase();
                    applyFilters();
                });
            }

            // 4. Quick View Modal for Cards
            const quickModal = document.getElementById('service-quick-modal');
            const quickModalPanel = document.getElementById('service-quick-modal-panel');
            const quickModalClose = document.getElementById('service-quick-modal-close');
            const quickViewTriggers = document.querySelectorAll('.quick-view-trigger');

            const modalBadge = document.getElementById('modal-service-badge');
            const modalCat = document.getElementById('modal-service-cat');
            const modalIcon = document.getElementById('modal-service-icon');
            const modalTitle = document.getElementById('modal-service-title');
            const modalLevel = document.getElementById('modal-service-level');
            const modalDesc = document.getElementById('modal-service-desc');
            const modalPoints = document.getElementById('modal-service-points');
            const modalDuration = document.getElementById('modal-service-duration');
            const modalMode = document.getElementById('modal-service-mode');
            const modalTarget = document.getElementById('modal-service-target');
            const modalWhatsapp = document.getElementById('modal-service-whatsapp');

            function openServiceModal(data) {
                if (!quickModal || !data) return;

                if (modalBadge) modalBadge.innerText = data.badge;
                if (modalCat) modalCat.innerText = data.category_label;
                if (modalIcon) modalIcon.innerHTML = data.icon;
                if (modalTitle) modalTitle.innerText = data.title;
                if (modalLevel) modalLevel.innerText = data.level;
                if (modalDesc) modalDesc.innerText = data.full_desc;
                if (modalDuration) modalDuration.innerText = data.duration;
                if (modalMode) modalMode.innerText = data.mode;
                if (modalTarget) modalTarget.innerText = data.target;

                if (modalPoints && Array.isArray(data.points)) {
                    modalPoints.innerHTML = data.points.map(pt => `
                        <div class="flex items-start gap-2 text-xs text-slate-700 leading-snug">
                            <svg class="size-3.5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span class="font-medium">${pt}</span>
                        </div>
                    `).join('');
                }

                if (modalWhatsapp) {
                    const waNum = "{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}";
                    modalWhatsapp.href = `https://wa.me/${waNum}?text=${encodeURIComponent(data.wa_msg || '')}`;
                }

                quickModal.classList.remove('hidden');
                requestAnimationFrame(() => {
                    quickModal.classList.remove('opacity-0', 'pointer-events-none');
                    quickModal.classList.add('opacity-100', 'pointer-events-auto');
                    if (quickModalPanel) {
                        quickModalPanel.classList.remove('scale-95');
                        quickModalPanel.classList.add('scale-100');
                    }
                });
                document.body.style.overflow = 'hidden';
            }

            function closeServiceModal() {
                if (!quickModal) return;
                quickModal.classList.remove('opacity-100', 'pointer-events-auto');
                quickModal.classList.add('opacity-0', 'pointer-events-none');
                if (quickModalPanel) {
                    quickModalPanel.classList.remove('scale-100');
                    quickModalPanel.classList.add('scale-95');
                }
                setTimeout(() => {
                    quickModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 200);
            }

            quickViewTriggers.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const card = btn.closest('.service-card-item');
                    if (card) {
                        try {
                            const data = JSON.parse(card.getAttribute('data-track-data') || '{}');
                            openServiceModal(data);
                        } catch (err) {
                            console.error(err);
                        }
                    }
                });
            });

            if (quickModalClose) quickModalClose.addEventListener('click', closeServiceModal);
            if (quickModal) {
                quickModal.addEventListener('click', (e) => {
                    if (e.target === quickModal) closeServiceModal();
                });
            }
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && quickModal && !quickModal.classList.contains('hidden')) {
                    closeServiceModal();
                }
            });
        });
    </script>
@endsection