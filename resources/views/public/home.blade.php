@extends('public.layouts.app')

@section('title', __('site.nav_home'))
@section('meta_description', __('site.hero_text'))
@php
    $locale = app()->getLocale();
    $defaultRobotQuotes = [
        '"الدبلوم الفني ليس نهاية المطاف.. شهادتك بوابتك الرسمية للدراسة بالدول الأوروبية."',
        '"مستقبلك يبدأ من هنا.. خطوة مدروسة تحول طموحك إلى واقع أوروبي."',
        '"المنح الدراسية تغطي مصروفاتك بالكامل مع سكن جامعي مجاني وبدل سنوي حتى 8,000 يورو."',
        '"تدريب الكول سنتر واللغات في INTOK يفتح لك أبواب العمل بكبرى الشركات العالمية."',
        '"ترجمة معتمدة رسمياً وموثقة للسفارات الأوروبية بأعلى معايير الدقة الدبلوماسية."'
    ];
    $robotQuotesList = data_get($siteSettings ?? [], 'robot_quotes') ?: $defaultRobotQuotes;

    $heroScenes = [
        [
            'tab' => data_get($siteSettings ?? [], 'hero_scene_1_tab.'.$locale, match($locale) { 'it' => 'Orientamento agli Studi', 'en' => 'Study Qualification', default => 'التأهيل للدراسة' }),
            'image' => data_get($siteSettings ?? [], 'hero_scene_1_img') ? asset('storage/'.data_get($siteSettings, 'hero_scene_1_img')) : asset('assets/images/schools/san-giorgio.jpg'),
            'badge' => data_get($siteSettings ?? [], 'hero_scene_1_badge.'.$locale, match($locale) { 'it' => 'Il tuo primo passo verso l\'Europa', 'en' => 'Your First Step Toward Europe', default => 'خطوتك الأولى نحو الدراسة في أوروبا' }),
            'title' => data_get($siteSettings ?? [], 'hero_scene_1_title.'.$locale, match($locale) { 'it' => 'Il tuo primo passo verso lo studio in Europa', 'en' => 'Your First Step Toward Studying in Europe', default => 'خطوتك الأولى نحو الدراسة في أوروبا' }),
            'desc' => data_get($siteSettings ?? [], 'hero_scene_1_desc.'.$locale, match($locale) { 'it' => 'Opportunità educative in oltre 10 paesi europei, assistenza nella scelta dell ateneo e preparazione del dossier.', 'en' => 'Educational opportunities in 10+ European countries, helping you select universities and prepare applications.', default => 'فرص تعليمية في أكثر من 10 دول أوروبية، ومساعدتك في اختيار الجامعة والتخصص وتجهيز ملف التقديم.' }),
            'stat' => data_get($siteSettings ?? [], 'hero_scene_1_stat.'.$locale, match($locale) { 'it' => '10+ Paesi Europei', 'en' => '10+ European Countries', default => '10+ دول أوروبية' }),
        ],
        [
            'tab' => data_get($siteSettings ?? [], 'hero_scene_2_tab.'.$locale, match($locale) { 'it' => 'Lingue e Traduzioni', 'en' => 'Languages & Translation', default => 'اللغات والترجمة' }),
            'image' => data_get($siteSettings ?? [], 'hero_scene_2_img') ? asset('storage/'.data_get($siteSettings, 'hero_scene_2_img')) : asset('assets/images/academy/italian-classroom-lecture.jpg'),
            'badge' => data_get($siteSettings ?? [], 'hero_scene_2_badge.'.$locale, match($locale) { 'it' => '02 — Lingue e Traduzioni', 'en' => '02 — Languages & Translation', default => '02 — اللغات والترجمة' }),
            'title' => data_get($siteSettings ?? [], 'hero_scene_2_title.'.$locale, match($locale) { 'it' => 'La tua lingua apre nuove porte', 'en' => 'Your Language Opens New Doors', default => 'لغتك تفتحلك أبواب جديدة' }),
            'desc' => data_get($siteSettings ?? [], 'hero_scene_2_desc.'.$locale, match($locale) { 'it' => 'Apprendi le lingue con corsi dedicati e traduzioni giurate a supporto del tuo percorso.', 'en' => 'Learn foreign languages through specialized training and certified translation assisting your career.', default => 'تعلم اللغات الأجنبية مع برامج تدريبية متخصصة، وخدمات ترجمة معتمدة تساعدك في خطواتك الأكاديمية والمهنية.' }),
            'stat' => data_get($siteSettings ?? [], 'hero_scene_2_stat.'.$locale, match($locale) { 'it' => 'Traduzione giurata e certificazioni', 'en' => 'Certified Translation & Diplomas', default => 'ترجمة معتمدة وشهادات دولية' }),
        ],
        [
            'tab' => data_get($siteSettings ?? [], 'hero_scene_3_tab.'.$locale, match($locale) { 'it' => 'Formazione Professionale', 'en' => 'Career Training', default => 'التدريب المهني' }),
            'image' => data_get($siteSettings ?? [], 'hero_scene_3_img') ? asset('storage/'.data_get($siteSettings, 'hero_scene_3_img')) : asset('assets/images/academy/live-speaker-training.jpg'),
            'badge' => data_get($siteSettings ?? [], 'hero_scene_3_badge.'.$locale, match($locale) { 'it' => '03 — Formazione e Qualificazione Professionale', 'en' => '03 — Vocational & Career Training', default => '03 — التدريب والتأهيل المهني' }),
            'title' => data_get($siteSettings ?? [], 'hero_scene_3_title.'.$locale, match($locale) { 'it' => 'Sviluppa competenze per il lavoro', 'en' => 'Upgrade Skills & Prepare for the Market', default => 'طوّر مهاراتك واستعد لسوق العمل' }),
            'desc' => data_get($siteSettings ?? [], 'hero_scene_3_desc.'.$locale, match($locale) { 'it' => 'Programmi pratici in call center e settori vari per acquisire competenze richieste.', 'en' => 'Practical training programs in Call Center and diverse fields helping you acquire in-demand skills.', default => 'برامج تدريب عملية في الكول سنتر، ومجالات مختلفة تساعدك تكتسب مهارات مطلوبة.' }),
            'stat' => data_get($siteSettings ?? [], 'hero_scene_3_stat.'.$locale, match($locale) { 'it' => 'Simulazione pratica e mercato diretto', 'en' => 'Practical Simulation & Direct Market', default => 'محاكاة عملية وسوق عمل مباشر' }),
        ],
        [
            'tab' => data_get($siteSettings ?? [], 'hero_scene_4_tab.'.$locale, match($locale) { 'it' => 'Servizi Accademici', 'en' => 'Academic Services', default => 'الخدمات الأكاديمية' }),
            'image' => data_get($siteSettings ?? [], 'hero_scene_4_img') ? asset('storage/'.data_get($siteSettings, 'hero_scene_4_img')) : asset('assets/images/schools/galileo-galilei.jpg'),
            'badge' => data_get($siteSettings ?? [], 'hero_scene_4_badge.'.$locale, match($locale) { 'it' => '04 — Servizi Accademici e Internazionali', 'en' => '04 — Academic & International Services', default => '04 — الخدمات الأكاديمية والدولية' }),
            'title' => data_get($siteSettings ?? [], 'hero_scene_4_title.'.$locale, match($locale) { 'it' => 'Porta la tua ambizione più lontano', 'en' => 'Take Your Ambitions Further', default => 'خلّي طموحك يوصل أبعد' }),
            'desc' => data_get($siteSettings ?? [], 'hero_scene_4_desc.'.$locale, match($locale) { 'it' => 'Ti guidiamo nelle domande universitarie, prenotazione test internazionali, appuntamenti consolari e borse di studio.', 'en' => 'Assisting with university applications, international exams, embassy bookings, graduate studies and scholarships.', default => 'بنساعدك في إجراءات التقديم للجامعات، وحجز الاختبارات الدولية، ومواعيد السفارات، والتقديم للدراسات العليا والمنح.' }),
            'stat' => data_get($siteSettings ?? [], 'hero_scene_4_stat.'.$locale, match($locale) { 'it' => '100% Preparazione e supporto', 'en' => '100% File Compliance & Guidance', default => '100% تجهيز ومتابعة دقيقة' }),
        ],
    ];

    $liveSlides = [
        [
            'image' => data_get($siteSettings ?? [], 'live_slide_1_img') ? asset('storage/'.data_get($siteSettings, 'live_slide_1_img')) : asset('assets/images/academy/italian-classroom-lecture.jpg'),
            'badge' => data_get($siteSettings ?? [], 'live_slide_1_badge.'.$locale, match($locale) { 'it' => 'Lingue Straniere', 'en' => 'Foreign Languages', default => 'اللغات الأجنبية والترجمة' }),
            'title' => data_get($siteSettings ?? [], 'live_slide_1_title.'.$locale, match($locale) { 'it' => 'Impara una lingua che apre nuove opportunità', 'en' => 'Learn a language that opens new doors', default => 'اتعلم لغة تفتحلك فرص جديدة' }),
            'desc' => data_get($siteSettings ?? [], 'live_slide_1_desc.'.$locale, match($locale) { 'it' => 'Esercitazioni pratiche per sviluppare conversazione e comunicazione in diverse lingue straniere.', 'en' => 'Hands-on practice to develop spoken communication and fluency across multiple languages.', default => 'تدريبات عملية لتطوير مهارات التحدث والتواصل بمختلف اللغات.' }),
        ],
        [
            'image' => data_get($siteSettings ?? [], 'live_slide_2_img') ? asset('storage/'.data_get($siteSettings, 'live_slide_2_img')) : asset('assets/images/academy/live-speaker-training.jpg'),
            'badge' => data_get($siteSettings ?? [], 'live_slide_2_badge.'.$locale, match($locale) { 'it' => 'Futuro Professionale', 'en' => 'Career Preparation', default => 'التدريب وسوق العمل' }),
            'title' => data_get($siteSettings ?? [], 'live_slide_2_title.'.$locale, match($locale) { 'it' => 'Qualificati per il tuo futuro professionale', 'en' => 'Get qualified for your professional future', default => 'اتأهل لمستقبلك المهني' }),
            'desc' => data_get($siteSettings ?? [], 'live_slide_2_desc.'.$locale, match($locale) { 'it' => 'Formazione pratica in call center, traduzione e abilità richieste dal mercato del lavoro.', 'en' => 'Practical training in Call Center, translation, and high-demand skills for the modern job market.', default => 'تدريب عملي في الكول سنتر والترجمة وتطوير المهارات المطلوبة لسوق العمل.' }),
        ],
        [
            'image' => data_get($siteSettings ?? [], 'live_slide_3_img') ? asset('storage/'.data_get($siteSettings, 'live_slide_3_img')) : asset('assets/images/schools/galileo-galilei.jpg'),
            'badge' => data_get($siteSettings ?? [], 'live_slide_3_badge.'.$locale, match($locale) { 'it' => 'Passo Accademico', 'en' => 'Academic Step', default => 'الدراسة في أوروبا' }),
            'title' => data_get($siteSettings ?? [], 'live_slide_3_title.'.$locale, match($locale) { 'it' => 'Prepara il tuo percorso accademico con fiducia', 'en' => 'Prepare your academic journey with confidence', default => 'جهّز خطوتك الأكاديمية بثقة' }),
            'desc' => data_get($siteSettings ?? [], 'live_slide_3_desc.'.$locale, match($locale) { 'it' => 'Orientamento per studiare in Europa, preparazione dossier di candidatura e test internazionali.', 'en' => 'Qualification for studying in Europe, application preparation, and international test coaching.', default => 'تأهيل للدراسة في أوروبا، وتجهيز ملفات التقديم والتدريب على الاختبارات الدولية.' }),
        ],
    ];
@endphp

@section('content')
    <!-- ==========================================================
         HERO SECTION: CLEAN, AIRY, EXECUTIVE LIGHT DESIGN + 60FPS CONSTELLATION & 3D MASCOT
         ========================================================== -->
    <section class="relative isolate overflow-hidden bg-intok-hero py-14 lg:py-24 min-h-[700px] flex items-center border-b border-slate-100">
        
        <!-- ACTIVE LIVING BACKGROUND 1: Full-width Interactive Constellation Canvas -->
        <canvas id="hero-interactive-canvas" class="pointer-events-none absolute inset-0 z-0 h-full w-full opacity-60"></canvas>

        <!-- ACTIVE LIVING BACKGROUND 2: Subtle Floating Ambient Glows (Gentle & Comfortable to Eyes) -->
        <div class="animate-aurora-1 pointer-events-none absolute -top-24 start-10 -z-10 size-[32rem] rounded-full bg-red-500/10 blur-[110px]"></div>
        <div class="animate-aurora-2 pointer-events-none absolute top-1/4 end-10 -z-10 size-[30rem] rounded-full bg-amber-500/10 blur-[100px]"></div>
        <div class="pointer-events-none absolute bottom-0 start-1/3 -z-10 size-[24rem] rounded-full bg-rose-400/10 blur-[90px]"></div>

        <!-- ACTIVE LIVING BACKGROUND 3: Shooting Luminous Laser Meteors -->
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="meteor-live" style="top: 12%; right: 15%; animation: meteorStreakLive 6s linear infinite 0.5s;"></div>
            <div class="meteor-live" style="top: 35%; right: 35%; animation: meteorStreakLive 8s linear infinite 2.5s;"></div>
            <div class="meteor-live" style="top: 20%; right: 70%; animation: meteorStreakLive 7s linear infinite 4.5s;"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-8">
                
                <!-- Left Column: Inspiring & Powerful Brand Messaging -->
                <div class="lg:col-span-7 text-start">
                    
                    <!-- Top Dynamic Badge -->
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-red-200 bg-white/90 px-4 py-2 text-xs font-black text-red-600 backdrop-blur-md shadow-xs">
                        <span class="relative flex size-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex size-2.5 rounded-full bg-red-600"></span>
                        </span>
                        <span>{{ data_get($siteSettings ?? [], 'hero_badge.'.$locale, match($locale) {
                            'it' => 'Il tuo partner di fiducia per il successo • INTOK Academy',
                            'en' => 'Your Trusted Partner to Success • INTOK Academy',
                            default => 'شريكك الموثوق نحو النجاح • INTOK Academy',
                        }) }}</span>
                    </div>

                    <!-- Main Punchy Headline -->
                    @php
                        $heroTitleText = data_get($siteSettings ?? [], 'hero_title.'.$locale, match($locale) {
                            'it' => 'INTOK - La tua porta per imparare, crescere e costruire il futuro',
                            'en' => 'INTOK - Your Gateway to Learning, Growth & Future Building',
                            default => 'INTOK - بوابتك للتعلم والتطور وبناء مستقبلك',
                        });
                        $heroTitleWithoutPrefix = preg_replace('/^INTOK\s*[-—]\s*/iu', '', $heroTitleText);
                    @endphp
                    <h1 class="mt-6 text-3xl font-black leading-[1.25] tracking-tight sm:text-5xl lg:text-6xl text-slate-900">
                        <span class="text-[#fe0002] inline-block">INTOK</span> — {{ $heroTitleWithoutPrefix }}
                    </h1>

                    <!-- Empowering Subtitle -->
                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg font-medium">
                        {{ data_get($siteSettings ?? [], 'hero_text.'.$locale, match($locale) {
                            'it' => "Dall'apprendimento delle lingue e traduzioni asseverate alla formazione professionale, servizi accademici e studi in oltre 10 paesi europei. Ti offriamo conoscenza, qualificazione e supporto per compiere il tuo prossimo passo con sicurezza.",
                            'en' => "From language learning and certified translation to professional career training, academic services, and studying in 10+ European countries. We provide knowledge, qualification, and support to take your next step with confidence.",
                            default => "من تعلم اللغات والترجمة المعتمدة، إلى التدريب المهني والخدمات الأكاديمية والدراسة في أكثر من 10 دول أوروبية. بنوفرلك المعرفة والتأهيل والدعم اللي يساعدك تخطّي خطوتك الجاية بثقة.",
                        }) }}
                    </p>

                    <!-- Primary CTAs -->
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary flex items-center gap-3 px-8 py-4 text-sm font-black shadow-lg">
                            <span>{{ data_get($siteSettings ?? [], 'hero_cta.'.$locale, match($locale) {
                                'it' => 'Inizia il tuo percorso con INTOK',
                                'en' => 'Start Your Journey with INTOK',
                                default => 'ابدأ رحلتك مع INTOK',
                            }) }}</span>
                        </a>

                        <a href="#services-section" class="flex items-center gap-2.5 rounded-full border-2 border-slate-200 bg-white px-6 py-4 text-sm font-black text-slate-700 transition hover:border-slate-400 hover:text-red-600 shadow-xs">
                            <span>{{ data_get($siteSettings ?? [], 'hero_secondary_cta.'.$locale, match($locale) {
                                'it' => 'Scopri i nostri servizi',
                                'en' => 'Explore Our Services',
                                default => 'استكشف خدماتنا',
                            }) }}</span>
                            <span class="text-[#fe0002]">↓</span>
                        </a>
                    </div>

                    <!-- Trust Metrics -->
                    <div class="mt-10 grid grid-cols-3 gap-4 border-t border-slate-200 pt-6 max-w-lg text-start">
                        <div>
                            <p class="text-2xl font-black text-[#fe0002] sm:text-3xl">{{ data_get($siteSettings ?? [], 'hero_stat_1_val', '10+') }}</p>
                            <p class="text-xs font-black text-slate-900 mt-1">{{ data_get($siteSettings ?? [], 'hero_stat_1_lbl.'.$locale, match($locale) { 'it' => 'Paesi Europei', 'en' => 'European Countries', default => 'دول أوروبية' }) }}</p>
                            <p class="text-[10px] font-bold text-slate-500">{{ match($locale) { 'it' => 'Destinazioni varie', 'en' => 'Diverse destinations', default => 'وجهات دراسية متنوعة' } }}</p>
                        </div>
                        <div class="border-s border-slate-200 ps-4">
                            <p class="text-2xl font-black text-[#fe0002] sm:text-3xl">{{ data_get($siteSettings ?? [], 'hero_stat_2_val', '1,200+') }}</p>
                            <p class="text-xs font-black text-slate-900 mt-1">{{ data_get($siteSettings ?? [], 'hero_stat_2_lbl.'.$locale, match($locale) { 'it' => 'Studenti e corsisti', 'en' => 'Students & Trainees', default => 'طالب ومتدرب' }) }}</p>
                            <p class="text-[10px] font-bold text-emerald-600">{{ match($locale) { 'it' => 'Qualificati con successo', 'en' => 'Successfully qualified', default => 'تم تأهيلهم بنجاح' } }}</p>
                        </div>
                        <div class="border-s border-slate-200 ps-4">
                            <p class="text-2xl font-black text-[#fe0002] sm:text-3xl">{{ data_get($siteSettings ?? [], 'hero_stat_3_val', '100%') }}</p>
                            <p class="text-xs font-black text-slate-900 mt-1">{{ data_get($siteSettings ?? [], 'hero_stat_3_lbl.'.$locale, match($locale) { 'it' => 'Completamento Fascicoli', 'en' => 'File Completion', default => 'استكمال الملفات' }) }}</p>
                            <p class="text-[10px] font-bold text-slate-500">{{ data_get($siteSettings ?? [], 'hero_stat_3_sub.'.$locale, match($locale) { 'it' => 'Monitoraggio e preparazione secondo i requisiti', 'en' => 'File tracking and preparation as required', default => 'متابعة وتجهيز الملفات وفق المتطلبات' }) }}</p>
                        </div>
                    </div>

                    <!-- Official Accreditation Guarantee Bar -->
                    <div class="mt-6 flex flex-wrap items-center gap-2.5 text-xs font-bold text-slate-700">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-emerald-800 shadow-2xs">
                            <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>شراكات واعتمادات رسمية بالدول الأوروبية</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-amber-900 shadow-2xs">
                            <span>توثيق قنصلي وترجمة معتمدة 100%</span>
                        </span>
                    </div>
                </div>

                <!-- Right Column: Cinematic Italian Academic Gateway Stage (Luxury 3D Showcase) -->
                <div class="lg:col-span-5 relative flex flex-col items-center justify-center pt-8 lg:pt-0" id="hero-stage-column">
                    
                    <!-- Ambient Glow Behind Stage -->
                    <div class="pointer-events-none absolute -top-8 -end-8 size-72 rounded-full bg-gradient-to-br from-[#fe0002]/20 to-[#c27803]/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -start-8 size-64 rounded-full bg-amber-400/15 blur-2xl"></div>

                    <!-- 3D Perspective Card Container with Parallax Mouse Tilt -->
                    <div id="hero-academic-stage" class="relative w-full max-w-lg transition-transform duration-300 ease-out select-none">
                        
                        <!-- Main Cinematic Frame -->
                        <div class="relative overflow-hidden rounded-3xl border-2 border-amber-300/60 bg-slate-950 p-2 sm:p-2.5 shadow-2xl backdrop-blur-xl group">
                            
                            <!-- Live Media Stage Container -->
                            <div class="relative h-[340px] sm:h-[400px] w-full overflow-hidden rounded-2xl bg-slate-900">
                                
                                <!-- Background Image with Smooth Fade & Zoom -->
                                <img id="hero-stage-img"
                                    src="{{ $heroScenes[0]['image'] }}"
                                    alt="{{ $heroScenes[0]['title'] }}"
                                    class="size-full object-cover transition-all duration-700 ease-out group-hover:scale-105">

                                <!-- Film Vignette & Shadow Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-black/20 pointer-events-none"></div>

                                <!-- Top Badge Ribbon on Image -->
                                <div class="absolute top-3.5 inset-x-3.5 z-20 flex items-center justify-between gap-2">
                                    <span id="hero-stage-badge" class="inline-flex items-center gap-1.5 rounded-full bg-black/60 backdrop-blur-md border border-white/20 px-3 py-1 text-[11px] font-black text-amber-300 shadow-md">
                                        <span class="size-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span id="hero-stage-badge-text">{{ $heroScenes[0]['badge'] }}</span>
                                    </span>
                                    
                                    <span class="rounded-full bg-emerald-500/90 backdrop-blur-xs px-2.5 py-0.5 text-[10px] font-black text-white shadow-xs">
                                        متاح التقديم
                                    </span>
                                </div>

                                <!-- Center/Bottom Captions on Image -->
                                <div class="absolute bottom-3 inset-x-3.5 z-20 text-start text-white">
                                    <h3 id="hero-stage-title" class="text-lg sm:text-xl font-black text-white leading-tight drop-shadow-md transition-opacity duration-300">
                                        {{ $heroScenes[0]['title'] }}
                                    </h3>
                                    <p id="hero-stage-desc" class="mt-1 text-xs text-slate-200 font-medium line-clamp-2 leading-relaxed transition-opacity duration-300">
                                        {{ $heroScenes[0]['desc'] }}
                                    </p>

                                    <!-- Bottom Fast CTA inside card -->
                                    <div class="mt-3.5 flex items-center justify-between gap-2 pt-2.5 border-t border-white/15">
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-amber-300">
                                            <span id="hero-stage-stat">{{ $heroScenes[0]['stat'] }}</span>
                                        </div>
                                        <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="rounded-full bg-[#fe0002] px-3.5 py-1.5 text-[11px] font-black text-white hover:bg-red-700 transition shadow-md flex items-center gap-1">
                                            <span>فحص قبولك</span>
                                            <span>&larr;</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Mini Progress Bar for Auto-Cycle -->
                                <div class="absolute bottom-0 inset-x-0 h-1 bg-white/20 z-30">
                                    <div id="hero-stage-progress" class="h-full bg-amber-400 w-0 transition-all duration-300"></div>
                                </div>
                            </div>

                            <!-- Interactive Destination / Track Selector Ribbon (4 Pills) -->
                            <div class="grid grid-cols-4 gap-1 p-1.5 bg-slate-900/95 rounded-2xl mt-1.5 border border-white/10" id="hero-stage-selector">
                                @foreach($heroScenes as $sIdx => $scene)
                                    <button type="button" class="hero-stage-tab {{ $sIdx === 0 ? 'active-hero-tab' : '' }}" data-scene="{{ $sIdx }}">
                                        <span class="block text-xs font-black truncate py-1">{{ $scene['tab'] }}</span>
                                    </button>
                                @endforeach
                            </div>

                        </div>

                        <!-- FLOATING LUXURY 3D BADGES (Layered over the card) -->
                        
                        <!-- Top-Start Floating Badge: Academic & Professional Qualification -->
                        <div class="pointer-events-none absolute -top-5 -start-3 sm:-start-5 z-30 flex items-center gap-2.5 rounded-2xl border-2 border-emerald-400/80 bg-white/95 px-3 py-1.5 sm:px-3.5 sm:py-2 text-slate-900 shadow-xl backdrop-blur-md animate-float-drift-1">
                            <span class="grid size-8 sm:size-9 shrink-0 place-items-center rounded-xl bg-emerald-100 text-emerald-700 text-xs font-black">
                                <svg class="size-4 sm:size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                            </span>
                            <div class="text-start">
                                <span class="text-[11px] font-black text-emerald-800 block leading-tight">{{ data_get($siteSettings ?? [], 'hero_float_1_title.'.$locale, match($locale) { 'it' => 'Qualificazione Accademica e Professionale', 'en' => 'Academic & Career Qualification', default => 'تأهيل أكاديمي ومهني' }) }}</span>
                                <span class="text-[9px] sm:text-[10px] font-bold text-slate-600 block">{{ data_get($siteSettings ?? [], 'hero_float_1_sub.'.$locale, match($locale) { 'it' => 'Programmi e opportunità formative varie', 'en' => 'Diverse training & study opportunities', default => 'برامج تدريبية وفرص تعليمية متنوعة' }) }}</span>
                            </div>
                        </div>

                        <!-- Bottom-End Floating Badge: File Preparation & Support -->
                        <div class="pointer-events-none absolute -bottom-5 -end-3 sm:-end-5 z-30 flex items-center gap-2.5 rounded-2xl border-2 border-red-300 bg-white/95 px-3 py-1.5 sm:px-3.5 sm:py-2 text-slate-900 shadow-xl backdrop-blur-md animate-float-drift-2">
                            <span class="grid size-8 sm:size-9 shrink-0 place-items-center rounded-xl bg-red-100 text-[#fe0002] text-xs font-black">
                                <svg class="size-4 sm:size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            <div class="text-start">
                                <span class="text-[11px] font-black text-[#fe0002] block leading-tight">{{ data_get($siteSettings ?? [], 'hero_float_2_title.'.$locale, match($locale) { 'it' => 'Supporto e Preparazione Dossier', 'en' => 'File Support & Preparation', default => 'دعم وتجهيز الملفات' }) }}</span>
                                <span class="text-[9px] sm:text-[10px] font-bold text-slate-600 block">{{ data_get($siteSettings ?? [], 'hero_float_2_sub.'.$locale, match($locale) { 'it' => 'Monitoraggio accurato per ogni ente', 'en' => 'Strict compliance with institution requirements', default => 'متابعة دقيقة وفق متطلبات كل جهة' }) }}</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         SUCCESS PARTNERS & COOPERATION PROTOCOLS (PROMINENT TOP POSITION)
         ========================================================== -->
    <section id="partners-section" class="relative bg-white py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>{{ match($locale) {
                        'it' => 'Partnership Ufficiali e Accordi Istituzionali',
                        'en' => 'Official Strategic Partnerships & Agreements',
                        default => 'شراكات استراتيجية وبروتوكولات تعاون رسمية',
                    } }}</span>
                </span>
                
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ match($locale) {
                        'it' => 'Partner del Successo e Protocolli di Cooperazione',
                        'en' => 'Success Partners & Cooperation Protocols',
                        default => 'شركاء النجاح وبروتوكولات التعاون',
                    } }}
                </h2>
                
                <p class="mt-4 text-base text-slate-600 font-medium leading-relaxed">
                    {{ match($locale) {
                        'it' => 'Insieme raggiungiamo traguardi più grandi: siamo orgogliosi delle nostre relazioni istituzionali e protocolli di cooperazione con prestigiose università europee e istituti leader in Egitto e all\'estero.',
                        'en' => 'Together we unlock greater horizons: we take pride in our official institutional partnerships and cooperation protocols with prestigious European universities and leading organizations inside Egypt and abroad.',
                        default => 'مع بعض بنقدر نوصل لفرص أكبر؛ نفخر بعلاقات وبروتوكولات التعاون الرسمية مع كبرى الجامعات الأوروبية والمؤسسات التعليمية والمهنية داخل مصر وخارجها.',
                    } }}
                </p>

                <!-- Interactive Switcher Tabs -->
                <div class="mt-8 inline-flex items-center p-1.5 bg-slate-100 rounded-2xl border border-slate-200 shadow-inner" id="partners-tabs-nav">
                    <button type="button" class="partner-tab-btn active-partner-tab px-5 py-2.5 rounded-xl text-xs sm:text-sm font-black transition cursor-pointer flex items-center gap-2" data-target="partners-egypt">
                        <span>🇪🇬</span>
                        <span>{{ match($locale) { 'it' => 'Partner in Egitto', 'en' => 'Partners in Egypt', default => 'شركاء النجاح داخل مصر' } }}</span>
                    </button>
                    <button type="button" class="partner-tab-btn px-5 py-2.5 rounded-xl text-xs sm:text-sm font-black text-slate-600 hover:text-slate-900 transition cursor-pointer flex items-center gap-2" data-target="partners-intl">
                        <span>🇪🇺</span>
                        <span>{{ match($locale) { 'it' => 'Università Europee (Estero)', 'en' => 'European Universities (Abroad)', default => 'شركاء النجاح خارج مصر (الجامعات الأوروبية)' } }}</span>
                    </button>
                </div>
            </div>

            <!-- Tab Panels Container -->
            <div class="relative max-w-5xl mx-auto">
                
                <!-- Panel 1: Partners Inside Egypt -->
                <div id="panel-partners-egypt" class="partner-panel transition-all duration-500">
                    <div class="relative overflow-hidden rounded-3xl border-2 border-slate-200 bg-white p-4 sm:p-8 shadow-xl group">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                                    <span class="size-3 rounded-full bg-[#fe0002]"></span>
                                    <span>{{ match($locale) { 'it' => 'Rete di Partner Istituzionali e Aziendali in Egitto', 'en' => 'Institutional & Corporate Partners Network in Egypt', default => 'شبكة شركاء النجاح والمؤسسات والشركات المعتمدة داخل مصر' } }}</span>
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mt-1">
                                    {{ match($locale) { 'it' => 'Collaborazioni con università, scuole internazionali, agenzie di traduzione e multinazionali', 'en' => 'Collaborations with universities, international schools, translation academies & multinationals', default => 'تعاون مع جامعات ومدارس دولية ومصانع ومراكز ترجمة معتمدة وكبرى شركات الكول سنتر' } }}
                                </p>
                            </div>
                            <button type="button" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-egypt.jpg') }}', 'شركاء النجاح داخل مصر')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-[#fe0002] hover:text-white text-slate-700 text-xs font-black transition cursor-pointer shadow-2xs">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                <span>{{ match($locale) { 'it' => 'Ingrandisci', 'en' => 'Zoom In', default => 'تكبير العرض' } }}</span>
                            </button>
                        </div>

                        <!-- Image Frame -->
                        <div class="relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200 cursor-pointer" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-egypt.jpg') }}', 'شركاء النجاح داخل مصر')">
                            <img src="{{ asset('assets/images/partners/partners-egypt.jpg') }}" alt="شركاء النجاح داخل مصر" class="w-full h-auto object-contain transition duration-500 group-hover:scale-[1.02]">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-black/75 text-white text-xs font-black px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                                    {{ match($locale) { 'it' => 'Clicca per ingrandire tutti i loghi', 'en' => 'Click to expand all logos', default => 'اضغط لمشاهدة جميع الشعارات بوضوح كامل' } }}
                                </span>
                            </div>
                        </div>

                        <!-- Bottom Meta Bar -->
                        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100 text-xs text-slate-600 font-bold">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="size-2 rounded-full bg-emerald-500"></span>
                                <span>{{ match($locale) { 'it' => '+40 Enti e Aziende Partner', 'en' => '40+ Partner Institutions & Firms', default => 'أكثر من 40 جهة ومؤسسة وشريك نجاح' } }}</span>
                            </span>
                            <span class="text-slate-400 font-mono">{{ match($locale) { 'it' => 'Scuole • Università • Traduzioni • Multinazionali', 'en' => 'Schools • Universities • Translation • Multinationals', default => 'مدارس دولية • جامعات • مراكز ترجمة • كبرى الشركات' } }}</span>
                        </div>
                    </div>
                </div>

                <!-- Panel 2: Partners Outside Egypt (European Universities) -->
                <div id="panel-partners-intl" class="partner-panel hidden transition-all duration-500">
                    <div class="relative overflow-hidden rounded-3xl border-2 border-slate-200 bg-white p-4 sm:p-8 shadow-xl group">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                                    <span class="size-3 rounded-full bg-[#c27803]"></span>
                                    <span>{{ match($locale) { 'it' => 'Università Europee e Atenei Accreditati', 'en' => 'Accredited European Partner Universities', default => 'أعرق الجامعات الأوروبية والمؤسسات التعليمية المعتمدة' } }}</span>
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mt-1">
                                    {{ match($locale) { 'it' => 'Politecnico di Milano, Bologna, Sapienza, Pisa, Torino, Napoli Federico II, Padova, Bicocca', 'en' => 'Politecnico di Milano, Bologna, Sapienza, Pisa, Torino, Napoli Federico II, Padova, Bicocca', default => 'بوليتكنيك ميلانو، بولونيا، سابينزا، بيزا، تورينو، نابولي، بادوفا، بافيا، روما، بارما وغيرها' } }}
                                </p>
                            </div>
                            <button type="button" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-international.jpg') }}', 'شركاء النجاح خارج مصر - الجامعات الأوروبية')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-[#fe0002] hover:text-white text-slate-700 text-xs font-black transition cursor-pointer shadow-2xs">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                <span>{{ match($locale) { 'it' => 'Ingrandisci', 'en' => 'Zoom In', default => 'تكبير العرض' } }}</span>
                            </button>
                        </div>

                        <!-- Image Frame -->
                        <div class="relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200 cursor-pointer" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-international.jpg') }}', 'شركاء النجاح خارج مصر - الجامعات الأوروبية')">
                            <img src="{{ asset('assets/images/partners/partners-international.jpg') }}" alt="شركاء النجاح خارج مصر" class="w-full h-auto object-contain transition duration-500 group-hover:scale-[1.02]">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-black/75 text-white text-xs font-black px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                                    {{ match($locale) { 'it' => 'Clicca per ingrandire tutti gli atenei', 'en' => 'Click to inspect all university crests', default => 'اضغط لمشاهدة جميع شعارات الجامعات الأوروبية بدقة عالية' } }}
                                </span>
                            </div>
                        </div>

                        <!-- Bottom Meta Bar -->
                        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100 text-xs text-slate-600 font-bold">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="size-2 rounded-full bg-emerald-500"></span>
                                <span>{{ match($locale) { 'it' => 'Università Statali e Politecnici d\'Eccellenza', 'en' => 'Top Public Universities & Polytechnics', default => 'جامعات حكومية وبوليتكنيك مصنفة عالمياً' } }}</span>
                            </span>
                            <span class="text-slate-400 font-mono">{{ match($locale) { 'it' => 'Milano • Roma • Bologna • Pisa • Torino • Padova', 'en' => 'Milan • Rome • Bologna • Pisa • Turin • Padua', default => 'ميلانو • روما • بولونيا • بيزا • تورينو • بادوفا • نابولي' } }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         OFFICIAL CORE SERVICES & SPECIALIZATIONS
         ========================================================== -->
    <section id="services-section" class="relative bg-intok-section py-16 sm:py-24 border-b border-slate-200/80 w-full max-w-full overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full min-w-0 max-w-full">
            <div class="text-center max-w-3xl mx-auto mb-10 lg:mb-14 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-red-700 shadow-xs">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>{{ data_get($siteSettings ?? [], 'services_badge.'.$locale, match($locale) { 'it' => '10 Servizi Educativi e Professionali', 'en' => '10 Integrated Services', default => '10 خدمات تعليمية ومهنية متكاملة' }) }}</span>
                </span>
                @php
                    $rawServicesTitle = data_get($siteSettings ?? [], 'services_title.'.$locale, match($locale) {
                        'it' => 'INTOK - Servizi educativi e professionali integrati',
                        'en' => 'INTOK - Integrated Educational & Professional Services',
                        default => 'INTOK  خدمات تعليمية ومهنية متكاملة',
                    });
                    $servicesTitleWithoutPrefix = preg_replace('/^INTOK\s*[-—]?\s*/iu', '', $rawServicesTitle);
                @endphp
                <h2 class="mt-4 text-3xl font-black sm:text-5xl tracking-tight text-slate-900">
                    <span class="text-[#fe0002]">INTOK</span> — {{ $servicesTitleWithoutPrefix }}
                </h2>
                <p class="mt-4 text-base text-slate-600 font-medium leading-relaxed max-w-2xl mx-auto">
                    {{ data_get($siteSettings ?? [], 'services_subtitle.'.$locale, match($locale) {
                        'it' => "Offriamo soluzioni educative e professionali integrate che partono dall'apprendimento delle lingue e dalle traduzioni asseverate, passano per la formazione professionale fino agli studi all'estero e ai servizi accademici internazionali.",
                        'en' => "We offer integrated educational and professional solutions starting from language learning and certified translation, through vocational training, to studying abroad and international academic services.",
                        default => "بنقدم لك حلول تعليمية ومهنية متكاملة تبدأ من تعلم اللغات والترجمة المعتمدة، مرورًا بالتأهيل والتدريب المهني، وصولًا للدراسة بالخارج والخدمات الأكاديمية الدولية.",
                    }) }}
                </p>
            </div>

            @php
                $locale = $locale ?? app()->getLocale();
                $trackItems = [];

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
                        str_contains((string)$svcBadge, 'منحة') || str_contains((string)$svcBadge, '8,000') => 'bg-amber-50 text-amber-900 border-amber-300',
                        str_contains((string)$svcBadge, 'عمل حر') => 'bg-blue-50 text-blue-700 border-blue-200',
                        str_contains((string)$svcBadge, 'سفار') || str_contains((string)$svcBadge, 'معتمدة') => 'bg-amber-50 text-amber-800 border-amber-200',
                        str_contains((string)$svcBadge, 'ضمان') || str_contains((string)$svcBadge, '100%') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        str_contains((string)$svcBadge, 'TOT') => 'bg-purple-50 text-purple-700 border-purple-200',
                        default => 'bg-red-50 text-[#fe0002] border-red-200',
                    };

                    $trackItems[] = [
                        'id' => (string) $svc->id,
                        'slug' => $svcSlug,
                        'title' => $svcTitle,
                        'category' => 'track-'.$svc->id,
                        'category_label' => $svcCat,
                        'badge' => $svcBadge,
                        'badge_class' => $badgeClass,
                        'icon' => $iconSvg,
                        'level' => $svcLevel,
                        'duration' => $svcDuration,
                        'mode' => $svcMode,
                        'target' => $svcTarget,
                        'salary' => $svcSalary,
                        'summary' => $svcSummary,
                        'points' => $svcPoints,
                        'full_desc' => $svcDesc,
                        'image_path' => $svc->image_path,
                        'wa_msg' => $svcWaMsg,
                    ];
                }

                $initialTrack = $trackItems[0] ?? null;
            @endphp

            <!-- ==========================================================
                 INNOVATIVE INTERACTIVE SPLIT SHOWCASE (CONSOLED EXPERIENCE)
                 ========================================================== -->
            <div class="grid gap-6 lg:gap-8 lg:grid-cols-12 items-start w-full min-w-0 max-w-full" id="services-interactive-showcase">
                
                <!-- Left Column: The Interactive Track Rail (Selector) -->
                <div class="w-full min-w-0 max-w-full lg:col-span-5 xl:col-span-4 space-y-2 reveal-left" id="track-rail-container">
                    <div class="mb-2 px-1 flex items-center justify-between text-xs font-black text-slate-500 uppercase tracking-wider">
                        <span class="flex items-center gap-1.5">
                            <span>{{ __('site.tracks_approved') }}</span>
                            <span class="text-[10px] text-slate-400 font-normal lg:hidden">{{ __('site.tracks_swipe_hint') }}</span>
                        </span>
                        <span class="text-red-600 font-mono text-xs font-black">{{ __('site.tracks_count', ['count' => count($trackItems)]) }}</span>
                    </div>

                    <!-- On mobile/tablet: Horizontal touch-swipeable track strip. On desktop (lg+): Vertical scroll list -->
                    <div class="w-full min-w-0 max-w-full flex lg:flex-col gap-2 overflow-x-auto lg:overflow-y-auto no-scrollbar lg:pe-1 pb-2 lg:pb-0 lg:max-h-[640px]" id="track-rail-list">
                        @foreach($trackItems as $idx => $item)
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
                                <svg class="size-3.5 text-emerald-600 shrink-0" width="14" height="14" style="width: 14px; height: 14px; min-width: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>{{ __('site.track_intok_accredited') }}</span>
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
                                <span>{{ __('site.track_outcomes_title') }}</span>
                            </h4>
                            <div id="stage-points-container" class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full min-w-0">
                                @foreach($initialTrack['points'] as $pt)
                                    <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 hover:bg-slate-50 transition min-w-0">
                                        <div class="size-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                        <span class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug break-words flex-1">{{ $pt }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Unified Metadata Stat Ribbon (Single Clean Row) -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 sm:p-4 rounded-2xl bg-slate-50 border border-slate-200/70 mb-6 w-full min-w-0 text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-red-600 shadow-2xs font-bold text-xs">⏱</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">{{ __('site.track_duration_label') }}</span>
                                    <span id="stage-duration" class="font-black text-slate-900 block truncate">{{ $initialTrack['duration'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 min-w-0 border-t sm:border-t-0 sm:border-r sm:pr-3 border-slate-200/80 pt-2 sm:pt-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-amber-600 shadow-2xs font-bold text-xs">🏛</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">{{ __('site.track_mode_label') }}</span>
                                    <span id="stage-mode" class="font-black text-slate-900 block truncate">{{ $initialTrack['mode'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 min-w-0 border-t sm:border-t-0 sm:border-r sm:pr-3 border-slate-200/80 pt-2 sm:pt-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-blue-600 shadow-2xs font-bold text-xs">🎯</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">{{ __('site.track_target_label') }}</span>
                                    <span id="stage-target" class="font-black text-slate-900 block truncate" title="{{ $initialTrack['target'] }}">{{ $initialTrack['target'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2 w-full min-w-0">
                            <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 flex-1">
                                <a id="stage-cta-btn" href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary w-full sm:w-auto px-6 py-3.5 text-center text-xs sm:text-sm font-black shadow-md flex items-center justify-center gap-2">
                                    <span>{{ __('site.track_book_seat') }}</span>
                                    <span>←</span>
                                </a>
                                <a id="stage-details-btn" href="{{ $initialTrack ? route('services.show', ['locale' => app()->getLocale(), 'slug' => $initialTrack['slug']]) : '#' }}" class="w-full sm:w-auto px-5 py-3.5 rounded-full border border-slate-300 bg-white text-slate-700 hover:border-red-300 hover:bg-red-50 hover:text-red-700 font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 shadow-2xs">
                                    <span>{{ __('site.track_full_details') }}</span>
                                    <span>&larr;</span>
                                </a>
                                <a id="stage-whatsapp-btn" href="https://wa.me/201008238323?text={{ urlencode('مرحباً، أود الاستفسار والتسجيل في برنامج: ' . ($initialTrack['title'] ?? '')) }}" target="_blank" class="w-full sm:w-auto px-5 py-3.5 rounded-full border-2 border-emerald-500 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white font-black text-xs sm:text-sm transition shadow-xs flex items-center justify-center gap-2">
                                    <svg class="size-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    <span>{{ __('site.track_whatsapp_direct') }}</span>
                                </a>
                            </div>
                            <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="text-xs font-bold text-slate-500 hover:text-red-600 transition flex items-center justify-center gap-1 shrink-0 py-2">
                                <span>{{ __('site.all_services_and_tracks') }}</span>
                                <span>&larr;</span>
                            </a>
                        </div>

                        <!-- Mobile Quick Switcher Bar (Visible on < lg) -->
                        <div class="lg:hidden flex items-center justify-between pt-3 mt-4 border-t border-slate-100 text-xs font-bold text-slate-500 w-full min-w-0">
                            <button type="button" id="stage-prev-btn" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition active:scale-95 text-xs font-black">
                                <span>{{ __('site.track_prev') }}</span>
                            </button>
                            <span id="stage-track-counter" class="text-xs font-mono text-slate-500 font-bold">1 / {{ count($trackItems) }}</span>
                            <button type="button" id="stage-next-btn" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition active:scale-95 text-xs font-black">
                                <span>{{ __('site.track_next') }}</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         LIVE ACADEMY SHATTER SLIDER: REAL CLASSROOM & TRAINING SESSIONS
         ========================================================== -->
    <section id="academy-live-showcase" class="relative bg-white py-24 border-b border-slate-200/80 overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-[#fe0002]">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>{{ data_get($siteSettings ?? [], 'live_slider_badge.'.$locale, match($locale) {
                        'it' => 'Esperienze dal vivo • INTOK Academy',
                        'en' => 'Live Experience • INTOK Academy',
                        default => 'لقطات حقيقية وتجارب متدربينا',
                    }) }}</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ data_get($siteSettings ?? [], 'live_slider_title.'.$locale, match($locale) {
                        'it' => 'Scopri come INTOK ti aiuta a costruire il tuo futuro',
                        'en' => 'See How INTOK Helps You Build Your Future',
                        default => 'شوف INTOK بتساعدك تطور مستقبلك إزاي',
                    }) }}
                </h2>
                <p class="mt-3 text-base text-slate-600 font-medium max-w-2xl mx-auto">
                    {{ data_get($siteSettings ?? [], 'live_slider_subtitle.'.$locale, match($locale) {
                        'it' => 'Riprese reali dai nostri corsi, lezioni, servizi educativi ed esperienze concrete degli studenti in INTOK.',
                        'en' => 'Real moments from our training, lectures, educational services, and student experiences inside INTOK.',
                        default => 'لقطات حقيقية من تدريباتنا، محاضراتنا، خدماتنا التعليمية وتجارب المتدربين داخل INTOK.',
                    }) }}
                </p>
            </div>

            <!-- Shatter Slider Container -->
            <div class="relative max-w-5xl mx-auto reveal-scale" id="shatter-slider-component">
                
                <!-- Main Visual Screen with 3D Slice Shatter Effect -->
                <div class="shatter-container relative h-[440px] sm:h-[560px] w-full rounded-3xl overflow-hidden bg-slate-950 shadow-2xl border border-slate-200" id="shatter-screen">
                    
                    <!-- Base/Incoming Image Display -->
                    <div id="shatter-base-layer" class="absolute inset-0 bg-cover bg-center transition-transform duration-700"></div>

                    <!-- Shatter Strips Slice Container (Created dynamically during transition) -->
                    <div id="shatter-slices-stage" class="absolute inset-0 pointer-events-none z-10 overflow-hidden"></div>

                    <!-- Dark Gradient Vignette for Readability -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent pointer-events-none z-20"></div>

                    <!-- Active Slide Content & Captions -->
                    <div class="absolute bottom-0 inset-x-0 p-6 sm:p-10 z-30 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                        <div class="max-w-2xl text-start" id="shatter-caption-box">
                            <span id="shatter-slide-badge" class="inline-block rounded-full bg-[#fe0002] px-3.5 py-1 text-xs font-black text-white shadow-md">
                                {{ $liveSlides[0]['badge'] }}
                            </span>
                            <h3 id="shatter-slide-title" class="mt-3 text-xl sm:text-3xl font-black text-white tracking-tight drop-shadow-md transition-opacity duration-300">
                                {{ $liveSlides[0]['title'] }}
                            </h3>
                            <p id="shatter-slide-desc" class="mt-2 text-xs sm:text-sm text-slate-200 line-clamp-2 font-medium leading-relaxed drop-shadow transition-opacity duration-300">
                                {{ $liveSlides[0]['desc'] }}
                            </p>
                        </div>

                        <!-- Right: Quick Action & Counter -->
                        <div class="flex items-center gap-4 shrink-0">
                            <span id="shatter-counter" class="text-sm font-black text-white font-mono tracking-widest bg-black/40 px-3 py-1.5 rounded-xl border border-white/20">
                                01 / {{ sprintf('%02d', count($liveSlides)) }}
                            </span>
                            <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="rounded-full bg-white px-5 py-2.5 text-xs font-black text-[#fe0002] shadow-lg transition hover:bg-amber-100 hover:scale-105">
                                {{ __('site.join_next_batch') }}
                            </a>
                        </div>
                    </div>

                    <!-- Slide Progress Bar (5s filling) -->
                    <div class="absolute bottom-0 inset-x-0 h-1.5 bg-white/20 z-40">
                        <div id="shatter-progress-fill" class="h-full bg-[#fe0002] w-0"></div>
                    </div>

                    <!-- Left / Right Nav Arrows -->
                    <button type="button" id="shatter-prev-btn" aria-label="{{ __('site.image_prev') }}" class="absolute start-4 top-1/2 -translate-y-1/2 z-40 size-11 rounded-full bg-black/40 border border-white/20 text-white flex items-center justify-center text-xl font-bold backdrop-blur-md transition hover:bg-[#fe0002] hover:scale-110 shadow-lg cursor-pointer">
                        ‹
                    </button>
                    <button type="button" id="shatter-next-btn" aria-label="{{ __('site.image_next') }}" class="absolute end-4 top-1/2 -translate-y-1/2 z-40 size-11 rounded-full bg-black/40 border border-white/20 text-white flex items-center justify-center text-xl font-bold backdrop-blur-md transition hover:bg-[#fe0002] hover:scale-110 shadow-lg cursor-pointer">
                        ›
                    </button>
                </div>

                <!-- Bottom Dots Indicator -->
                <div class="mt-6 flex items-center justify-center gap-2.5" id="shatter-dots-bar">
                    <!-- Dots rendered by JS -->
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         SMART TRACK & SCHOLARSHIP FINDER CONSOLE
         ========================================================== -->
    <section class="relative z-20 -mt-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 reveal-up">
        <div class="glass-intok p-6 shadow-xl border border-slate-200 bg-white/95">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 items-center">
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-700 mb-1.5">{{ data_get($siteSettings ?? [], 'finder_step1_label.'.$locale, match($locale) { 'it' => '1. Percorso di studi attuale', 'en' => '1. Current Education', default => '1. مسارك التعليمي الحالي' }) }}</label>
                    <select id="finder-track" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <option value="diploma">{{ match($locale) { 'it' => 'Diploma tecnico (industriale, commerciale, agrario)', 'en' => 'Technical Diploma (Industrial, Commercial, Agricultural)', default => 'دبلوم فني (صنايع / تجارة / زراعة)' } }}</option>
                        <option value="highschool">{{ match($locale) { 'it' => 'Maturità / Diploma di scuola superiore', 'en' => 'High School Diploma / Secondary Certificate', default => 'ثانوية عامة / لغات / أزهرية' } }}</option>
                        <option value="grad">{{ match($locale) { 'it' => 'Laureato (Master / Lavoro)', 'en' => 'University Graduate (Master\'s / Career)', default => 'خريج جامعي (ماجستير / تأهيل مهني)' } }}</option>
                        <option value="languages">{{ match($locale) { 'it' => 'Corsi di lingue e Call Center', 'en' => 'Language & Call Center Training', default => 'باحث عن تدريب كول سنتر ولغات' } }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-700 mb-1.5">{{ data_get($siteSettings ?? [], 'finder_step2_label.'.$locale, match($locale) { 'it' => '2. Il tuo obiettivo', 'en' => '2. Desired Goal', default => '2. هدفك المنشود' }) }}</label>
                    <select id="finder-goal" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <option value="europe-study">{{ match($locale) { 'it' => 'Studi in Europa + Borse di Studio', 'en' => 'Study in Europe + Full Scholarships', default => 'دراسة جامعية بالدول الأوروبية + المنح الشاملة' } }}</option>
                        <option value="callcenter">{{ match($locale) { 'it' => 'Lavoro nei Call Center Internazionali', 'en' => 'Work in Multinational Call Centers', default => 'العمل في الكول سنتر الدولي' } }}</option>
                        <option value="translation">{{ match($locale) { 'it' => 'Traduzione Giurata per Ambasciate', 'en' => 'Certified Translation for Embassies', default => 'احتراف وترجمة معتمدة للسفارات' } }}</option>
                        <option value="ielts">{{ match($locale) { 'it' => 'Certificazioni CILS, IELTS e TOEFL', 'en' => 'Pass CILS, IELTS & TOEFL Exams', default => 'اجتياز اختبارات CILS و IELTS و TOEFL' } }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-700 mb-1.5">{{ data_get($siteSettings ?? [], 'finder_step3_label.'.$locale, match($locale) { 'it' => '3. Sessione di ingresso', 'en' => '3. Target Intake', default => '3. موسم الالتحاق' }) }}</label>
                    <select id="finder-intake" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <option value="fast">{{ match($locale) { 'it' => 'Prossima sessione disponibile', 'en' => 'Earliest Available Intake / Batch', default => 'أقرب دفعة تدريبية / تقديم متاح' } }}</option>
                        <option value="fall-2026">{{ match($locale) { 'it' => 'Semestre Autunnale (Ottobre 2026)', 'en' => 'Fall Semester (October 2026)', default => 'الفصل الدراسي الأول (أكتوبر 2026)' } }}</option>
                        <option value="spring-2027">{{ match($locale) { 'it' => 'Semestre Primaverile (Febbraio 2027)', 'en' => 'Spring Semester (February 2027)', default => 'الفصل الدراسي الثاني (فبراير 2027)' } }}</option>
                    </select>
                </div>

                <div class="sm:col-span-2 lg:col-span-1 pt-1 sm:pt-0">
                    <label class="hidden lg:block text-[11px] font-bold text-transparent mb-1.5">{{ match($locale) { 'it' => 'Azione', 'en' => 'Action', default => 'إجراء' } }}</label>
                    <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary flex w-full items-center justify-center gap-2 py-3 text-xs font-black shadow-xs">
                        <span>{{ data_get($siteSettings ?? [], 'finder_btn_text.'.$locale, match($locale) { 'it' => 'Verifica Requisiti e Borse', 'en' => 'Check Eligibility & Scholarships', default => 'فحص شروط القبول والمنحة' }) }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         WHY CHOOSE US: HIGH-END BENTO GRID (CRISP WHITE + BRAND RED)
         ========================================================== -->
    <section class="relative bg-intok-section py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span>{{ data_get($siteSettings ?? [], 'why_badge.'.$locale, match($locale) {
                        'it' => 'Standard di eccellenza e leadership internazionale',
                        'en' => 'Standards of Trust & International Leadership',
                        default => 'معايير الثقة والريادة الدولية',
                    }) }}</span>
                </span>
                @php
                    $rawWhyTitle = data_get($siteSettings ?? [], 'why_title.'.$locale);
                    $whyTitle = ($rawWhyTitle && !str_contains($rawWhyTitle, 'لماذا تختار'))
                        ? $rawWhyTitle
                        : match($locale) {
                            'it' => 'Perché INTOK è il passo giusto per il tuo futuro?',
                            'en' => 'Why INTOK is the Right Step for Your Future?',
                            default => 'ليه INTOK هي خطوتك الصح لمستقبلك؟',
                        };

                    $rawWhySub = data_get($siteSettings ?? [], 'why_subtitle.'.$locale);
                    $whySub = ($rawWhySub && !str_contains($rawWhySub, 'منظومة متكاملة لا تكتفي'))
                        ? $rawWhySub
                        : match($locale) {
                            'it' => 'In INTOK uniamo formazione, istruzione, qualificazione professionale e servizi accademici per aiutarti a sviluppare competenze e raggiungere i tuoi obiettivi con passi chiari e supporto dedicato.',
                            'en' => 'At INTOK, we combine education, practical training, professional qualification, and academic services to help you build skills and achieve your goals with clear steps and expert support.',
                            default => 'في INTOK بنجمع بين التعليم والتدريب والتأهيل المهني والخدمات الأكاديمية، علشان نساعدك تطور مهاراتك وتحقق أهدافك بخطوات واضحة ودعم متخصص.',
                        };
                @endphp
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ $whyTitle }}
                </h2>
                <p class="mt-4 text-base text-slate-600 font-medium leading-relaxed">
                    {{ $whySub }}
                </p>
            </div>

            @php
                $parsePoints = static function ($val, array $defaultPoints) use ($locale): array {
                    if (is_array($val)) {
                        if (isset($val[$locale]) && is_string($val[$locale])) $val = $val[$locale];
                        elseif (isset($val['ar']) && is_string($val['ar'])) $val = $val['ar'];
                        else return $val;
                    }
                    if (is_string($val) && trim($val) !== '') {
                        $lines = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $val))));
                        if (!empty($lines)) return array_values($lines);
                    }
                    return $defaultPoints;
                };

                                                $bentoFallbacks = [
                    'ar' => [
                        'services' => [
                            'nav_title' => 'خدمات تعليمية ومهنية متكاملة',
                            'nav_sub' => '10 خدمات متنوعة تحت سقف واحد',
                            'badge' => 'منظومة شاملة تحت سقف واحد',
                            'badge_color' => 'bg-red-50 text-[#fe0002] border-red-200',
                            'title' => '01 – خدمات تعليمية ومهنية متكاملة',
                            'desc' => 'في INTOK بنوفر مجموعة متنوعة من الخدمات التعليمية والمهنية والأكاديمية، علشان تلاقي كل اللي تحتاجه في مكان واحد.',
                            'stat_val' => '10',
                            'stat_unit' => 'خدمات',
                            'stat_label' => 'القيمة المضافة: تجربة متكاملة بدل البحث عن أكثر من جهة.',
                            'stat_sub' => 'حلول متكاملة للأفراد والطلاب والخريجين',
                            'points' => [
                                '10 خدمات متنوعة تحت سقف واحد.',
                                'مسارات تعليمية وتدريبية متعددة.',
                                'حلول تناسب أهدافك الأكاديمية والمهنية.',
                                'خدمات للأفراد والطلاب والخريجين.'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'التعامل مع جهات مختلفة لكل خدمة وتشتت الجهد والوقت بدون خطة موحدة',
                                'intok' => 'تجربة متكاملة بدل البحث عن أكثر من جهة'
                            ],
                            'cta_text' => 'استكشف الـ 10 خدمات كاملة',
                            'wa_msg' => 'مرحباً، أود الاستفسار عن باقة خدمات INTOK المتكاملة والمسارات المتاحة'
                        ],
                        'practical' => [
                            'nav_title' => 'تدريب عملي وتطبيق واقعي',
                            'nav_sub' => 'تطبيقات وتدريبات تحاكي الواقع',
                            'badge' => 'محاكاة واقعية وتطبيق حي',
                            'badge_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'title' => '02 – تدريب عملي وتطبيق واقعي',
                            'desc' => 'مش بنكتفي بالمعلومات النظرية؛ بنهتم بالتطبيق العملي والتدريب على مواقف حقيقية تساعدك تفهم المجال وتطور مهاراتك.',
                            'stat_val' => '100%',
                            'stat_unit' => 'تطبيقي',
                            'stat_label' => 'القيمة المضافة: مهارات قابلة للتطبيق في الواقع.',
                            'stat_sub' => 'جاهزية فورية لسوق العمل والمقابلات',
                            'points' => [
                                'تدريبات عملية حسب طبيعة كل برنامج.',
                                'محاكاة لمواقف العمل الحقيقية.',
                                'تطبيقات وتمارين تفاعلية.',
                                'تقييم مستمر لمستوى المتدرب.'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'تدريب نظري محدود ومحاضرات تلقين بدون ممارسة أو محاكاة للمقابلات',
                                'intok' => 'مهارات قابلة للتطبيق في الواقع وتدريب على مواقف عمل حقيقية'
                            ],
                            'cta_text' => 'احجز مقعدك في التدريب العملي',
                            'wa_msg' => 'مرحباً، أود الاستفسار عن برامج التدريب العملي والمحاكاة التفاعلية في INTOK'
                        ],
                        'trainers' => [
                            'nav_title' => 'مدربون ومتخصصون في مجالاتهم',
                            'nav_sub' => 'خبرات في مجالات التعليم والتدريب',
                            'badge' => 'إشراف نخبة متخصصة',
                            'badge_color' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'title' => '03 – مدربون ومتخصصون في مجالاتهم',
                            'desc' => 'نتيح برامج تدريبية وتعليمية بإشراف متخصصين في مجالاتهم، مع التركيز على نقل الخبرة وتقديم محتوى يناسب احتياجات المتدربين.',
                            'stat_val' => 'نخبة',
                            'stat_unit' => 'متخصصة',
                            'stat_label' => 'القيمة المضافة: تعلم على إيد متخصصين.',
                            'stat_sub' => 'نقل خبرة السوق الحقيقية والتوجيه المباشر',
                            'points' => [
                                'محتوى تدريبي متخصص.',
                                'شرح وتطبيق وفق طبيعة المجال.',
                                'متابعة وتوجيه خلال التدريب.',
                                'الاهتمام بتطوير مستوى المتدرب.'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'محاضرون غير متخصصين ميدانياً ومحتوى تقليدي غير مواكب لاحتياجات الواقع',
                                'intok' => 'تعلم على يد متخصصين وممارسين حقيقيين ينقلون خبرة العمل الفعلية'
                            ],
                            'cta_text' => 'تعرف على برامجنا ومدرّبينا',
                            'wa_msg' => 'مرحباً، أود الاستفسار عن كادر المدربين والمناهج المعتمدة في الأكاديمية'
                        ],
                        'support' => [
                            'nav_title' => 'متابعة ودعم مستمر',
                            'nav_sub' => 'دعم ومتابعة خلال رحلتك',
                            'badge' => 'دعم وإرشاد مستمر',
                            'badge_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'title' => '04 – متابعة ودعم مستمر',
                            'desc' => 'رحلتك مع INTOK مش مجرد تسجيل في خدمة؛ بنهتم بمتابعة خطواتك وتقديم الدعم والإرشاد وفق طبيعة الخدمة اللي اخترتها.',
                            'stat_val' => '24/7',
                            'stat_unit' => 'متابعة',
                            'stat_label' => 'القيمة المضافة: مش بتكون لوحدك في رحلتك.',
                            'stat_sub' => 'فريق استشاري وإداري يرافقك خطوة بخطوة',
                            'points' => [
                                'متابعة مراحل التدريب أو تقديم الخدمة.',
                                'الرد على الاستفسارات.',
                                'توضيح الخطوات والمتطلبات.',
                                'دعم مستمر حسب طبيعة كل خدمة.'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'إهمال استفسارات العملاء والتأخر في الرد وعدم وضوح الخطوات والمواعيد',
                                'intok' => 'مش بتكون لوحدك في رحلتك؛ متابعة مستمرة وتوضيح الخطوات أولاً بأول'
                            ],
                            'cta_text' => 'احجز جلستك الاستشارية الآن',
                            'wa_msg' => 'مرحباً، أود الاستفسار عن نظام المتابعة والدعم المستمر لخدمات الأكاديمية'
                        ],
                        'customized' => [
                            'nav_title' => 'حلول تناسب أهدافك',
                            'nav_sub' => 'خدمات تناسب احتياجاتك وأهدافك',
                            'badge' => 'توجيه فردي دقيق',
                            'badge_color' => 'bg-amber-50 text-amber-800 border-amber-200',
                            'title' => '05 – حلول تناسب أهدافك',
                            'desc' => 'كل شخص عنده هدف مختلف، علشان كده بنساعدك تختار الخدمة أو المسار الأنسب لاحتياجاتك وإمكانياتك وخطتك المستقبلية.',
                            'stat_val' => '1-on-1',
                            'stat_unit' => 'تخصيص',
                            'stat_label' => 'القيمة المضافة: تبدأ من المكان المناسب لهدفك.',
                            'stat_sub' => 'توفير الوقت والجهد على المسار الأنسب لطموحك',
                            'points' => [
                                'فهم احتياجاتك قبل اختيار الخدمة.',
                                'توجيهك للمسار المناسب.',
                                'توضيح المتطلبات والتفاصيل.',
                                'اقتراح خطوات واضحة للبدء.'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'فرض مسارات وقوالب موحدة على الجميع دون تقييم احتياج أو مؤهل الطالب',
                                'intok' => 'تبدأ من المكان المناسب لهدفك بحلول مخصصة تناسب قدراتك'
                            ],
                            'cta_text' => 'احصل على خطتك المخصصة',
                            'wa_msg' => 'مرحباً، أود استشارة لتحديد المسار الأنسب لمؤهلي وخلفيتي الدراسية'
                        ],
                        'future' => [
                            'nav_title' => 'تأهيل لمستقبلك الأكاديمي والمهني',
                            'nav_sub' => 'تطوير مهاراتك الأكاديمية والمهنية',
                            'badge' => 'جاهزية أكاديمية ومهنية',
                            'badge_color' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'title' => '06 – تأهيل لمستقبلك الأكاديمي والمهني',
                            'desc' => 'بنساعدك تطور قدراتك وتستعد لخطوات جديدة في التعليم والعمل، من خلال برامج التأهيل والتدريب والخدمات الأكاديمية المتخصصة.',
                            'stat_val' => 'المستقبل',
                            'stat_unit' => 'جاهزية',
                            'stat_label' => 'القيمة المضافة: خطوات واضحة ومدروسة نحو مستقبلك.',
                            'stat_sub' => 'تأهيل يفتح لك آفاق التعليم والعمل في أوروبا',
                            'points' => [
                                'التأهيل للدراسة في أوروبا.',
                                'الاستعداد للاختبارات الدولية.',
                                'تطوير المهارات اللغوية والمهنية.',
                                'المساعدة في إجراءات القبول الأكاديمي.'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'صعوبة معرفة الإجراءات ومتطلبات التقديم ومحدودية الفرص التعليمية',
                                'intok' => 'خطوات واضحة وتأهيل شامل للدراسة في أوروبا وسوق العمل'
                            ],
                            'cta_text' => 'ابدأ خطوتك نحو المستقبل',
                            'wa_msg' => 'مرحباً، أود بدء خطتي للتأهيل للدراسة في أوروبا وتطوير مهاراتي المستقبلية'
                        ]
                    ],
                    'it' => [
                        'services' => [
                            'nav_title' => 'Servizi Integrati',
                            'nav_sub' => '10 Servizi Accademici e Professionali',
                            'badge' => 'Ecosistema unico',
                            'badge_color' => 'bg-red-50 text-[#fe0002] border-red-200',
                            'title' => 'Servizi educativi, professionali e accademici integrati',
                            'desc' => 'In INTOK offriamo una gamma completa di servizi educativi, professionali e accademici, per trovare tutto ciò di cui hai bisogno in un unico posto con supporto esperto.',
                            'stat_val' => '10',
                            'stat_unit' => 'Servizi',
                            'stat_label' => 'Copertura completa di ogni esigenza',
                            'stat_sub' => 'Per studenti, laureati e professionisti',
                            'points' => [
                                '10 servizi diversi sotto un unico tetto',
                                'Percorsi formativi e accademici a più livelli',
                                'Soluzioni adatte ai tuoi obiettivi futuri',
                                'Servizi per studenti, diplomati e lavoratori',
                                'Un\'esperienza integrata senza dispersione'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Rivolgersi a enti diversi per ciascun servizio senza una visione d\'insieme',
                                'intok' => 'Servizi formativi, linguistici e accademici completi in un unico posto'
                            ],
                            'cta_text' => 'Scopri tutti i 10 servizi',
                            'wa_msg' => 'Ciao, vorrei maggiori informazioni sui servizi integrati di INTOK'
                        ],
                        'practical' => [
                            'nav_title' => 'Formazione Pratica',
                            'nav_sub' => 'Applicazioni reali',
                            'badge' => 'Simulazioni dal vivo',
                            'badge_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'title' => 'Formazione pratica e simulazioni reali per il lavoro',
                            'desc' => 'Non ci limitiamo alla teoria: puntiamo sull\'applicazione pratica e su simulazioni che ti preparano ad affrontare colloqui e contesti reali.',
                            'stat_val' => '100%',
                            'stat_unit' => 'Pratico',
                            'stat_label' => 'Simulazioni e pratica sul campo',
                            'stat_sub' => 'Abilità subito spendibili',
                            'points' => [
                                'Esercitazioni pratiche mirate per ciascun programma',
                                'Simulazione di scenari reali di lavoro e colloqui',
                                'Esercizi interattivi con feedback immediato',
                                'Valutazione continua dei progressi dello studente',
                                'Competenze immediatamente applicabili nel settore'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Teoria astratta senza simulazioni né preparazione reale ai colloqui',
                                'intok' => 'Addestramento pratico, simulazione colloqui e preparazione per il mercato del lavoro'
                            ],
                            'cta_text' => 'Prenota la formazione pratica',
                            'wa_msg' => 'Ciao, vorrei informazioni sulla formazione pratica e simulazioni'
                        ],
                        'trainers' => [
                            'nav_title' => 'Docenti Esperti',
                            'nav_sub' => 'Esperienze sul campo',
                            'badge' => 'Staff qualificato',
                            'badge_color' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'title' => 'Docenti e professionisti specializzati nei loro settori',
                            'desc' => 'Programmi condotti da specialisti di settore, focalizzati sul trasmettere competenze concrete e contenuti su misura per le esigenze di mercato.',
                            'stat_val' => 'Top',
                            'stat_unit' => 'Docenti',
                            'stat_label' => 'Esperienza reale di insegnamento',
                            'stat_sub' => 'Guida individuale e supporto',
                            'points' => [
                                'Contenuti formativi aggiornati agli standard internazionali',
                                'Spiegazioni chiare e applicazione secondo il settore',
                                'Tutoraggio e orientamento continuo durante il corso',
                                'Attenzione personalizzata al livello di ogni corsista',
                                'Apprendimento diretto da professionisti del settore'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Insegnanti generici privi di esperienza diretta sul mercato estero',
                                'intok' => 'Specialisti qualificati con esperienza diretta sul campo e supporto dedicato'
                            ],
                            'cta_text' => 'Scopri i nostri docenti',
                            'wa_msg' => 'Ciao, vorrei maggiori dettagli sui docenti e i programmi formativi'
                        ],
                        'support' => [
                            'nav_title' => 'Supporto Continuo',
                            'nav_sub' => 'Assistenza lungo il percorso',
                            'badge' => 'Assistenza passo dopo passo',
                            'badge_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'title' => 'Monitoraggio e supporto continuo in ogni fase',
                            'desc' => 'Il tuo percorso in INTOK non è una semplice iscrizione: seguiamo i tuoi progressi e ti forniamo assistenza su misura fino al traguardo.',
                            'stat_val' => '24/7',
                            'stat_unit' => 'Supporto',
                            'stat_label' => 'Team sempre al tuo fianco',
                            'stat_sub' => 'Non sarai mai solo',
                            'points' => [
                                'Monitoraggio costante delle fasi del servizio o corso',
                                'Risposte puntuali a ogni dubbio o quesito',
                                'Chiarezza totale sui passaggi e requisiti richiesti',
                                'Assistenza dedicata in base alla tipologia di servizio',
                                'Un percorso sicuro e sereno dalla partenza al successo'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Interruzione dei contatti e ritardi nelle risposte dopo l\'iscrizione',
                                'intok' => 'Supporto continuo, chiarimento dei passaggi e monitoraggio costante'
                            ],
                            'cta_text' => 'Richiedi assistenza personalizzata',
                            'wa_msg' => 'Ciao, vorrei sapere di più sul sistema di assistenza e tutoraggio'
                        ],
                        'customized' => [
                            'nav_title' => 'Soluzioni su Misura',
                            'nav_sub' => 'Per le tue reali esigenze',
                            'badge' => 'Percorsi personalizzati',
                            'badge_color' => 'bg-amber-50 text-amber-800 border-amber-200',
                            'title' => 'Soluzioni personalizzate per i tuoi obiettivi e potenzialità',
                            'desc' => 'Ogni persona ha un obiettivo unico. Ti aiutiamo a scegliere il servizio o percorso più adatto alle tue possibilità e al tuo piano futuro.',
                            'stat_val' => '1-on-1',
                            'stat_unit' => 'Su misura',
                            'stat_label' => 'Orientamento specifico sul tuo profilo',
                            'stat_sub' => 'Parti dal punto giusto',
                            'points' => [
                                'Analisi attenta dei tuoi titoli e obiettivi prima di scegliere',
                                'Indirizzamento verso la scelta più vantaggiosa per te',
                                'Informazioni dettagliate sui costi e tempi previsti',
                                'Passaggi chiari per iniziare senza incertezze',
                                'Ottimizzazione del tempo e delle risorse sul percorso vincente'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Soluzioni standardizzate uguali per tutti senza valutare le differenze',
                                'intok' => 'Comprensione delle esigenze individuali e soluzioni studiate sul tuo profilo'
                            ],
                            'cta_text' => 'Trova il percorso adatto a te',
                            'wa_msg' => 'Ciao, vorrei una consulenza per valutare il percorso più adatto al mio profilo'
                        ],
                        'future' => [
                            'nav_title' => 'Preparazione al Futuro',
                            'nav_sub' => 'Competenze per il domani',
                            'badge' => 'Pronti per Europa e lavoro',
                            'badge_color' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'title' => 'Qualificazione per il tuo futuro accademico e professionale',
                            'desc' => 'Ti aiutiamo a sviluppare competenze e a prepararti a nuovi traguardi educativi e lavorativi in oltre 10 paesi europei.',
                            'stat_val' => 'Futuro',
                            'stat_unit' => 'Solido',
                            'stat_label' => 'Competenze internazionali certificate',
                            'stat_sub' => 'Passi chiari verso la meta',
                            'points' => [
                                'Preparazione mirata per studiare in oltre 10 paesi europei',
                                'Preparazione a esami internazionali di lingua e ammissione',
                                'Miglioramento delle abilità linguistiche e comunicative richieste',
                                'Supporto professionale nelle pratiche di ammissione accademica',
                                'Passi chiari e concreti verso una carriera internazionale di successo'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Difficoltà a comprendere requisiti e procedure senza una guida solida',
                                'intok' => 'Aiuto nella scelta del percorso, preparazione dossier e monitoraggio pratiche'
                            ],
                            'cta_text' => 'Costruisci il tuo futuro oggi',
                            'wa_msg' => 'Ciao, vorrei iniziare la preparazione per studiare in Europa e costruire il mio futuro'
                        ]
                    ],
                    'en' => [
                        'services' => [
                            'nav_title' => 'Integrated Services',
                            'nav_sub' => '10 Academic & Career Services',
                            'badge' => 'All-in-one ecosystem',
                            'badge_color' => 'bg-red-50 text-[#fe0002] border-red-200',
                            'title' => 'Integrated Educational, Vocational & Academic Services',
                            'desc' => 'At INTOK, we offer a diverse range of educational, vocational, and academic services so you find everything you need in one place with expert backing.',
                            'stat_val' => '10',
                            'stat_unit' => 'Services',
                            'stat_label' => 'Full coverage of all your needs',
                            'stat_sub' => 'For students, graduates, and professionals',
                            'points' => [
                                '10 diverse services under one roof',
                                'Multiple educational and career tracks',
                                'Solutions aligned with your ambitions',
                                'Services for students, graduates, and companies',
                                'Integrated experience without hassle'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Dealing with multiple uncoordinated entities for each individual service',
                                'intok' => 'Complete educational, language, and academic services under one roof'
                            ],
                            'cta_text' => 'Explore All 10 Services',
                            'wa_msg' => 'Hello, I would like to inquire about INTOK integrated services package'
                        ],
                        'practical' => [
                            'nav_title' => 'Practical Training',
                            'nav_sub' => 'Real-world simulations',
                            'badge' => 'Realistic hands-on practice',
                            'badge_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'title' => 'Hands-on Practical Training Qualifying You for Work',
                            'desc' => 'We go beyond theoretical knowledge: we focus on practical applications and realistic scenarios that prepare you for genuine career demands.',
                            'stat_val' => '100%',
                            'stat_unit' => 'Practical',
                            'stat_label' => 'Direct practical simulation',
                            'stat_sub' => 'Immediately actionable skills',
                            'points' => [
                                'Targeted hands-on sessions for each program',
                                'Realistic workplace and job interview simulations',
                                'Interactive drills using cutting-edge tools',
                                'Continuous assessment of trainee performance',
                                'Acquisition of skills ready for immediate workplace use'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Theoretical lectures without practice, interactive screens, or interview drills',
                                'intok' => 'Practical training, job readiness, and realistic interview simulations'
                            ],
                            'cta_text' => 'Book Your Practical Training Seat',
                            'wa_msg' => 'Hello, I would like to inquire about practical training programs at INTOK'
                        ],
                        'trainers' => [
                            'nav_title' => 'Expert Trainers',
                            'nav_sub' => 'Field-tested experience',
                            'badge' => 'Certified specialists',
                            'badge_color' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'title' => 'Specialized Instructors with Deep Field Experience',
                            'desc' => 'We offer educational programs led by sector specialists, dedicated to transferring real knowledge and up-to-date curricula.',
                            'stat_val' => 'Elite',
                            'stat_unit' => 'Faculty',
                            'stat_label' => 'Practical field-tested knowledge',
                            'stat_sub' => 'Individual guidance and care',
                            'points' => [
                                'Curriculum developed to modern international standards',
                                'Clear explanation and direct practical application',
                                'Continuous individual guidance throughout training',
                                'Dedicated focus on elevating each trainee\'s skills',
                                'Direct learning from seasoned active professionals'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Generic instructors lacking direct real-world experience in international markets',
                                'intok' => 'Dedicated field-experienced trainers transferring authentic workplace practice'
                            ],
                            'cta_text' => 'Meet Our Programs & Instructors',
                            'wa_msg' => 'Hello, I would like to learn more about the faculty and curriculum at INTOK'
                        ],
                        'support' => [
                            'nav_title' => 'Continuous Support',
                            'nav_sub' => 'Dedicated guidance along the way',
                            'badge' => 'Step-by-step guidance',
                            'badge_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'title' => 'Continuous Follow-up and Guidance at Every Step',
                            'desc' => 'Your journey with INTOK is more than registering for a service; we actively track your progress and provide continuous advice until your goal is reached.',
                            'stat_val' => '24/7',
                            'stat_unit' => 'Support',
                            'stat_label' => 'Dedicated team by your side',
                            'stat_sub' => 'You are never alone on any step',
                            'points' => [
                                'Meticulous tracking of every training and service phase',
                                'Prompt and thorough responses to questions and inquiries',
                                'Clear pre-requisite guidance with zero ambiguity',
                                'Personalized support tailored to each specific service',
                                'Real peace of mind throughout your academic journey'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Communication cutoff and delayed answers after signing up with generic offices',
                                'intok' => 'Continuous assistance, transparent steps, and structured deadline follow-up'
                            ],
                            'cta_text' => 'Book Your Advisory Session',
                            'wa_msg' => 'Hello, I would like to inquire about ongoing support and guidance at INTOK'
                        ],
                        'customized' => [
                            'nav_title' => 'Tailored Solutions',
                            'nav_sub' => 'Matching your actual needs',
                            'badge' => 'Personalized pathways',
                            'badge_color' => 'bg-amber-50 text-amber-800 border-amber-200',
                            'title' => 'Customized Solutions Aligned with Your Capabilities',
                            'desc' => 'Everyone has distinct goals. That is why we help you choose the pathway that perfectly matches your qualifications and future plans.',
                            'stat_val' => '1-on-1',
                            'stat_unit' => 'Custom',
                            'stat_label' => 'Roadmap designed for your profile',
                            'stat_sub' => 'Start from the right place',
                            'points' => [
                                'In-depth assessment of your background before choosing a service',
                                'Directing you to the most rewarding academic or career path',
                                'Transparent overview of timelines, requirements, and fees',
                                'Actionable steps for a confident, structured start',
                                'Ensuring your investment of time and effort yields peak results'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'One-size-fits-all generic templates forced on every applicant regardless of background',
                                'intok' => 'Personal profile evaluation and customized solutions built specifically for your goals'
                            ],
                            'cta_text' => 'Get Your Tailored Plan',
                            'wa_msg' => 'Hello, I would like a consultation to determine the ideal path for my background'
                        ],
                        'future' => [
                            'nav_title' => 'Future Readiness',
                            'nav_sub' => 'Skills for tomorrow',
                            'badge' => 'Ready for Europe & careers',
                            'badge_color' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'title' => 'Comprehensive Preparation for Your Academic & Career Future',
                            'desc' => 'We help you develop high-demand capabilities and prepare for major milestones in study and employment across 10+ European destinations.',
                            'stat_val' => 'Future',
                            'stat_unit' => 'Driven',
                            'stat_label' => 'Certified international qualification',
                            'stat_sub' => 'Clear steps toward your ambition',
                            'points' => [
                                'Preparation for studying in 10+ prestigious European countries',
                                'Readiness for international language certificates and university entrance exams',
                                'Development of spoken linguistic and professional communication skills',
                                'Professional support throughout university admission procedures',
                                'Concrete, well-studied steps toward a thriving international future'
                            ],
                            'vs_traditional' => [
                                'traditional' => 'Ambiguous procedures, unfamiliarity with European requirements, and lost chances',
                                'intok' => 'Assistance in pathway choice, file preparation, and official application follow-up'
                            ],
                            'cta_text' => 'Build Your Future Today',
                            'wa_msg' => 'Hello, I want to start my qualification journey for study in Europe and future career'
                        ]
                    ]
                ];

                $pillarIcons = [
                    'services' => '<svg class="size-5 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
                    'practical' => '<svg class="size-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                    'trainers' => '<svg class="size-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                    'support' => '<svg class="size-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                    'customized' => '<svg class="size-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>',
                    'future' => '<svg class="size-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'
                ];

                $pillarKeys = ['services', 'practical', 'trainers', 'support', 'customized', 'future'];
                $currentFallbacks = $bentoFallbacks[$locale] ?? $bentoFallbacks['ar'];
                $whyPillars = [];

                foreach ($pillarKeys as $pKey) {
                    $fb = $currentFallbacks[$pKey] ?? ($bentoFallbacks['ar'][$pKey] ?? []);
                    $whyPillars[] = [
                        'id' => $pKey,
                        'icon' => $pillarIcons[$pKey] ?? '',
                        'nav_title' => data_get($siteSettings ?? [], "why_bento_{$pKey}_nav_title.{$locale}", $fb['nav_title']),
                        'nav_sub' => data_get($siteSettings ?? [], "why_bento_{$pKey}_nav_sub.{$locale}", $fb['nav_sub']),
                        'badge' => data_get($siteSettings ?? [], "why_bento_{$pKey}_badge.{$locale}", $fb['badge']),
                        'badge_color' => $fb['badge_color'] ?? 'bg-red-50 text-[#fe0002] border-red-200',
                        'title' => data_get($siteSettings ?? [], "why_bento_{$pKey}_title.{$locale}", $fb['title']),
                        'desc' => data_get($siteSettings ?? [], "why_bento_{$pKey}_desc.{$locale}", $fb['desc']),
                        'stat_val' => data_get($siteSettings ?? [], "why_bento_{$pKey}_stat_val", $fb['stat_val']),
                        'stat_unit' => data_get($siteSettings ?? [], "why_bento_{$pKey}_stat_unit.{$locale}", $fb['stat_unit']),
                        'stat_label' => data_get($siteSettings ?? [], "why_bento_{$pKey}_stat_label.{$locale}", $fb['stat_label']),
                        'stat_sub' => data_get($siteSettings ?? [], "why_bento_{$pKey}_stat_sub.{$locale}", $fb['stat_sub']),
                        'points' => $parsePoints(data_get($siteSettings ?? [], "why_bento_{$pKey}_points"), $fb['points']),
                        'vs_traditional' => [
                            'traditional' => data_get($siteSettings ?? [], "why_bento_{$pKey}_vs_traditional.{$locale}", $fb['vs_traditional']['traditional']),
                            'intok' => data_get($siteSettings ?? [], "why_bento_{$pKey}_vs_intok.{$locale}", $fb['vs_traditional']['intok'])
                        ],
                        'cta_text' => data_get($siteSettings ?? [], "why_bento_{$pKey}_cta_text.{$locale}", $fb['cta_text']),
                        'cta_url' => $pKey === 'trans' ? route('contact', ['locale' => $locale]) : route('consultation.create', ['locale' => $locale]),
                        'wa_msg' => $fb['wa_msg']
                    ];
                }
                $initialPillar = $whyPillars[0];
            @endphp

            <!-- ==========================================================
                 INNOVATIVE INTERACTIVE PILLARS CONSOLE (NON-TRADITIONAL)
                 ========================================================== -->
            <div class="space-y-8 w-full min-w-0 max-w-full" id="why-interactive-deck">
                
                <!-- 1. Horizontal Interactive Pillars Ribbon (6 Pillars) -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 reveal-up w-full min-w-0 max-w-full" id="why-pillars-nav">
                    @foreach($whyPillars as $pIdx => $pillar)
                        <button type="button"
                            class="why-pillar-tab {{ $pIdx === 0 ? 'active-why-pillar' : '' }}"
                            data-pillar-id="{{ $pillar['id'] }}"
                            data-pillar-index="{{ $pIdx }}">
                            
                            <div class="flex items-center gap-2 mb-2 w-full">
                                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-slate-50 border border-slate-200 text-lg shadow-2xs group-hover:scale-110 transition-transform">
                                    {!! $pillar['icon'] !!}
                                </span>
                                <span class="text-[10px] font-black text-slate-400 font-mono ms-auto">0{{ $pIdx + 1 }}</span>
                            </div>

                            <h3 class="text-xs font-black text-slate-900 truncate w-full pillar-tab-title transition-colors">
                                {{ $pillar['nav_title'] }}
                            </h3>
                            <p class="text-[10px] font-bold text-slate-500 truncate w-full mt-0.5">
                                {{ $pillar['nav_sub'] }}
                            </p>

                            <span class="pillar-tab-indicator"></span>
                        </button>
                    @endforeach
                </div>

                <!-- 2. Master Cinematic Stage (Split Screen: Value Offer + Reality Check HUD) -->
                <div class="card-poster-white w-full min-w-0 max-w-full p-4 sm:p-7 lg:p-10 border-2 border-slate-200 bg-white shadow-xl relative overflow-hidden reveal-scale" id="why-main-stage">
                    
                    <!-- Background Ambient Glow -->
                    <div class="pointer-events-none absolute -top-24 end-0 size-80 rounded-full bg-gradient-to-br from-amber-400/10 to-red-500/10 blur-[90px]"></div>

                    <div class="grid gap-8 lg:grid-cols-12 items-center relative z-10 w-full min-w-0 max-w-full" id="why-stage-content">
                        
                        <!-- Left/Center Column: Comprehensive Value Proposition (7 Cols) -->
                        <div class="lg:col-span-7 space-y-6 text-start w-full min-w-0">
                            
                            <!-- Status Badges -->
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span id="why-stage-badge" class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-black {{ $initialPillar['badge_color'] }}">
                                    <span class="relative flex size-2">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-current opacity-75"></span>
                                        <span class="relative inline-flex size-2 rounded-full bg-current"></span>
                                    </span>
                                    <span id="why-stage-badge-text">{{ $initialPillar['badge'] }}</span>
                                </span>

                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 border border-slate-200 px-3 py-1 text-[11px] font-black text-slate-700">
                                    <span>{{ __('site.official_excellence_standard') }}</span>
                                </span>
                            </div>

                            <!-- Big Headline & Description -->
                            <div>
                                <div class="flex items-center gap-3">
                                    <span id="why-stage-icon" class="text-3xl sm:text-4xl">
                                        {!! $initialPillar['icon'] !!}
                                    </span>
                                    <h3 id="why-stage-title" class="text-2xl sm:text-3xl font-black text-[#c27803] leading-tight">
                                        {{ $initialPillar['title'] }}
                                    </h3>
                                </div>
                                <p id="why-stage-desc" class="mt-4 text-sm sm:text-base leading-relaxed text-slate-600 font-medium">
                                    {{ $initialPillar['desc'] }}
                                </p>
                            </div>

                            <!-- 5 Concrete Advantage Checkmarks -->
                            <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-5 space-y-3" id="why-stage-points">
                                @foreach($initialPillar['points'] as $pPoint)
                                    <div class="flex items-start gap-3 text-xs sm:text-sm font-semibold text-slate-700">
                                        <span class="grid size-5 shrink-0 place-items-center rounded-full bg-emerald-100 text-emerald-700 mt-0.5 shadow-2xs">
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </span>
                                        <span>{{ $pPoint }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Direct Action CTAs -->
                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <a id="why-stage-cta" href="{{ $initialPillar['cta_url'] }}" class="btn-intok-primary inline-flex items-center gap-2.5 px-6 py-3.5 text-xs sm:text-sm font-black shadow-md">
                                    <span id="why-stage-cta-text">{{ $initialPillar['cta_text'] }}</span>
                                </a>

                                <a id="why-stage-wa" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode($initialPillar['wa_msg']) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border-2 border-emerald-500 bg-emerald-50 px-5 py-3 text-xs sm:text-sm font-black text-emerald-700 transition hover:bg-emerald-600 hover:text-white shadow-xs">
                                    <span>{{ __('site.instant_whatsapp_inquiry') }}</span>
                                </a>
                            </div>

                        </div>

                        <!-- Right Column: Interactive Reality Check HUD (5 Cols) -->
                        <div class="lg:col-span-5 space-y-5">
                            
                            <!-- Stat Card with Big Number -->
                            <div class="rounded-3xl bg-gradient-to-br from-red-50/60 via-amber-50/40 to-white border-2 border-red-200 p-6 text-center shadow-md relative overflow-hidden">
                                <div class="relative z-10">
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-1">{{ __('site.why_achieved_value') }}</span>
                                    <div class="flex items-baseline justify-center gap-2">
                                        <span id="why-stat-val" class="text-4xl sm:text-5xl font-black text-[#fe0002] tracking-tight font-mono">
                                            {{ $initialPillar['stat_val'] }}
                                        </span>
                                        <span id="why-stat-unit" class="text-base sm:text-lg font-black text-slate-800">
                                            {{ $initialPillar['stat_unit'] }}
                                        </span>
                                    </div>
                                    <p id="why-stat-label" class="mt-2 text-xs sm:text-sm font-black text-slate-800">
                                        {{ $initialPillar['stat_label'] }}
                                    </p>
                                    <p id="why-stat-sub" class="mt-1 text-[11px] font-bold text-slate-500">
                                        {{ $initialPillar['stat_sub'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Direct Reality Comparison Box: Traditional vs INTOK -->
                            <div class="rounded-3xl bg-slate-900 text-white p-6 shadow-lg border border-slate-800 space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                    <span class="text-xs font-black text-amber-400 flex items-center gap-1.5">
                                        <span>{{ __('site.why_comparison_reality') }}</span>
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400">{{ data_get($siteSettings ?? [], 'why_comparison_title.'.$locale, 'لماذا إنتوك أفضل؟') }}</span>
                                </div>

                                <!-- The Traditional Downside -->
                                <div class="rounded-2xl bg-red-950/40 border border-red-800/40 p-3.5 flex items-start gap-3">
                                    <span class="grid size-6 shrink-0 place-items-center rounded-full bg-red-900/80 text-red-300 mt-0.5">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </span>
                                    <div>
                                        <span class="text-[11px] font-black text-red-400 block mb-0.5">{{ __('site.why_traditional_offices') }}</span>
                                        <p id="why-vs-traditional" class="text-xs text-slate-300 leading-snug">
                                            {{ $initialPillar['vs_traditional']['traditional'] }}
                                        </p>
                                    </div>
                                </div>

                                <!-- The INTOK Guarantee -->
                                <div class="rounded-2xl bg-emerald-950/40 border border-emerald-800/40 p-3.5 flex items-start gap-3">
                                    <span class="grid size-6 shrink-0 place-items-center rounded-full bg-emerald-900/80 text-emerald-300 mt-0.5">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    </span>
                                    <div>
                                        <span class="text-[11px] font-black text-emerald-400 block mb-0.5">{{ __('site.why_intok_standard') }}</span>
                                        <p id="why-vs-intok" class="text-xs text-slate-200 font-semibold leading-snug">
                                            {{ $initialPillar['vs_traditional']['intok'] }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Trust Footer -->
                                <div class="pt-1 flex items-center justify-between text-[10px] font-bold text-slate-400">
                                    <span>{{ __('site.official_certified_accreditation') }}</span>
                                    <span class="text-amber-400">{{ __('site.satisfaction_rate') }}</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- 3. Interactive Full Comparison Matrix Drawer (Toggleable Button & Accordion) -->
                <div class="reveal-up">
                    <button type="button" id="toggle-why-matrix-btn" class="w-full flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-[#fe0002] transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="grid size-10 place-items-center rounded-xl bg-red-50 text-[#fe0002] border border-red-200 text-lg font-bold group-hover:scale-105 transition-transform">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                            </span>
                            <div class="text-start">
                                <h4 class="text-sm font-black text-[#c27803] group-hover:text-[#fe0002] transition-colors">
                                    إيه اللي بيميز منظومة INTOK ؟ مقارنة بين الطرق التقليدية ومنظومة INTOK المتكاملة
                                </h4>
                                <p class="text-xs font-medium text-slate-500">
                                    اضغط لاستعراض المقارنة في المجالات الستة: تنوع الخدمات، اللغات، الترجمة، التأهيل المهني، الدراسة في أوروبا، والاختبارات الدولية
                                </p>
                            </div>
                        </div>

                        <span id="why-matrix-arrow" class="size-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-600 transition-transform duration-300">
                            ▼
                        </span>
                    </button>

                    <!-- Expandable Comparison Matrix Drawer -->
                    <div id="why-matrix-panel" class="hidden mt-4 overflow-hidden rounded-3xl border-2 border-slate-200 bg-white shadow-xl transition-all">
                        <div class="overflow-x-auto">
                            <table class="w-full text-start text-xs sm:text-sm border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-800">
                                        <th class="p-4 text-start font-black">مجال التقديم والخدمة</th>
                                        <th class="p-4 text-start font-black text-red-600 bg-red-50/50">المكاتب والوسائل العادية</th>
                                        <th class="p-4 text-start font-black text-emerald-700 bg-emerald-50/60">منظومة INTOK ACADEMY</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">1. تنوع الخدمات</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">التعامل مع جهات مختلفة لكل خدمة وتشتت الجهد</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">خدمات تعليمية وتدريبية وأكاديمية متعددة في مكان واحد بخطة واضحة</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">2. تعلم اللغات</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">كورسات عامة تقليدية بدون مسار واضح أو تطبيق</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">برامج لغات بمستويات ومسارات تدريبية منظمة تركز على الطلاقة</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">3. الترجمة المعتمدة</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">البحث عن مترجمين وجهات مختلفة مع احتمالية الأخطاء</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">خدمات ترجمة معتمدة وتدقيق لغوي رسمي للمستندات والشهادات</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">4. التأهيل المهني</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">تدريب نظري محدود بدون محاكاة لبيئة العمل</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">تدريب عملي وتأهيل مباشر لسوق العمل ومحاكاة لمقابلات الشركات</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">5. التأهيل للدراسة بأوروبا</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">صعوبة معرفة الإجراءات ومتطلبات التقديم وتضارب المعلومات</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">مساعدة في اختيار المسار وتجهيز الملفات ومتابعة إجراءات التقديم خطوة بخطوة</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">6. الاختبارات والخدمات الدولية</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">تعدد الجهات وصعوبة متابعة المواعيد والإجراءات</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">تأهيل للاختبارات الدولية ومساعدة في حجز المواعيد والخدمات المرتبطة بها</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- JavaScript Engine for the Why Choose Us Interactive Deck -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const pillarsData = {!! json_encode($whyPillars, JSON_UNESCAPED_UNICODE) !!};
                    const tabs = document.querySelectorAll('.why-pillar-tab');
                    const stage = document.getElementById('why-main-stage');

                    const badgeEl = document.getElementById('why-stage-badge');
                    const badgeTextEl = document.getElementById('why-stage-badge-text');
                    const iconEl = document.getElementById('why-stage-icon');
                    const titleEl = document.getElementById('why-stage-title');
                    const descEl = document.getElementById('why-stage-desc');
                    const pointsEl = document.getElementById('why-stage-points');
                    const ctaEl = document.getElementById('why-stage-cta');
                    const ctaTextEl = document.getElementById('why-stage-cta-text');
                    const waEl = document.getElementById('why-stage-wa');

                    const statValEl = document.getElementById('why-stat-val');
                    const statUnitEl = document.getElementById('why-stat-unit');
                    const statLabelEl = document.getElementById('why-stat-label');
                    const statSubEl = document.getElementById('why-stat-sub');

                    const vsTradEl = document.getElementById('why-vs-traditional');
                    const vsIntokEl = document.getElementById('why-vs-intok');

                    let activeIdx = 0;
                    let autoTimer = null;

                    function switchPillar(idx) {
                        if (!pillarsData[idx]) return;
                        activeIdx = idx;
                        const data = pillarsData[idx];

                        // Update tabs active state
                        tabs.forEach((tab, tIdx) => {
                            if (tIdx === idx) {
                                tab.classList.add('active-why-pillar');
                            } else {
                                tab.classList.remove('active-why-pillar');
                            }
                        });

                        // Trigger smooth animation
                        if (stage) {
                            stage.classList.remove('pillar-stage-anim');
                            void stage.offsetWidth; // trigger reflow
                            stage.classList.add('pillar-stage-anim');
                        }

                        // Update Stage contents
                        if (badgeTextEl) badgeTextEl.textContent = data.badge;
                        if (badgeEl) {
                            badgeEl.className = `inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-black ${data.badge_color}`;
                        }
                        if (iconEl) iconEl.innerHTML = data.icon;
                        if (titleEl) titleEl.textContent = data.title;
                        if (descEl) descEl.textContent = data.desc;

                        // Update points list
                        if (pointsEl) {
                            pointsEl.innerHTML = data.points.map(pt => `
                                <div class="flex items-start gap-3 text-xs sm:text-sm font-semibold text-slate-700">
                                    <span class="grid size-5 shrink-0 place-items-center rounded-full bg-emerald-100 text-emerald-700 mt-0.5 shadow-2xs">
                                        <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    </span>
                                    <span>${pt}</span>
                                </div>
                            `).join('');
                        }

                        // Update CTAs
                        if (ctaEl) ctaEl.href = data.cta_url;
                        if (ctaTextEl) ctaTextEl.textContent = data.cta_text;
                        if (waEl) {
                            const waNum = "{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}";
                            waEl.href = `https://wa.me/${waNum}?text=${encodeURIComponent(data.wa_msg)}`;
                        }

                        // Update HUD Stats
                        if (statValEl) statValEl.textContent = data.stat_val;
                        if (statUnitEl) statUnitEl.textContent = data.stat_unit;
                        if (statLabelEl) statLabelEl.textContent = data.stat_label;
                        if (statSubEl) statSubEl.textContent = data.stat_sub;

                        // Update Vs Reality
                        if (vsTradEl) vsTradEl.textContent = data.vs_traditional.traditional;
                        if (vsIntokEl) vsIntokEl.textContent = data.vs_traditional.intok;
                    }

                    tabs.forEach(tab => {
                        tab.addEventListener('click', () => {
                            const idx = parseInt(tab.dataset.pillarIndex, 10);
                            switchPillar(idx);
                            stopAutoTimer();
                        });
                    });

                    function startAutoTimer() {
                        stopAutoTimer();
                        autoTimer = setInterval(() => {
                            const next = (activeIdx + 1) % pillarsData.length;
                            switchPillar(next);
                        }, 7500);
                    }

                    function stopAutoTimer() {
                        if (autoTimer) {
                            clearInterval(autoTimer);
                            autoTimer = null;
                        }
                    }

                    if (stage) {
                        stage.addEventListener('mouseenter', stopAutoTimer);
                        stage.addEventListener('mouseleave', startAutoTimer);
                    }

                    startAutoTimer();

                    // 4. Matrix Panel Drawer Toggle
                    const matrixToggleBtn = document.getElementById('toggle-why-matrix-btn');
                    const matrixPanel = document.getElementById('why-matrix-panel');
                    const matrixArrow = document.getElementById('why-matrix-arrow');

                    if (matrixToggleBtn && matrixPanel) {
                        matrixToggleBtn.addEventListener('click', () => {
                            const isHidden = matrixPanel.classList.contains('hidden');
                            if (isHidden) {
                                matrixPanel.classList.remove('hidden');
                                if (matrixArrow) matrixArrow.style.transform = 'rotate(180deg)';
                            } else {
                                matrixPanel.classList.add('hidden');
                                if (matrixArrow) matrixArrow.style.transform = 'rotate(0deg)';
                            }
                        });
                    }
                });
            </script>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         4-STEP ADMISSION & TRAINING ROADMAP
         ========================================================== -->
    <section class="relative bg-white py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-red-700">
                    {{ data_get($siteSettings ?? [], 'roadmap_badge.'.$locale, 'خارطة طريق واضحة ومضمونة') }}
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ data_get($siteSettings ?? [], 'roadmap_title.'.$locale, __('site.process_title')) }}
                </h2>
                <p class="mt-3 text-base text-slate-600">
                    {{ data_get($siteSettings ?? [], 'roadmap_subtitle.'.$locale, 'أربع مراحل مدروسة بعناية تحول طموحك بالدراسة والعمل الدولي إلى حقيقة مؤكدة.') }}
                </p>
            </div>

            <div class="relative grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $roadmapSteps = [
                        [
                            'num' => '01',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step1_title.'.$locale, match($locale) { 'it' => '01. Consulenza e Definizione del Percorso', 'en' => '01. Consultation & Pathway Mapping', default => '01. الاستشارة وتحديد المسار' }),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step1_desc.'.$locale, match($locale) { 'it' => 'Comprendiamo i tuoi obiettivi e le tue esigenze e ti guidiamo nella scelta del servizio o programma più adatto.', 'en' => 'We understand your goals and needs, helping you choose the most suitable service or educational program.', default => 'بنفهم هدفك واحتياجاتك، ونساعدك تختار الخدمة أو البرنامج الأنسب ليك ولطموحك.' }),
                            'dir' => 'reveal-left stagger-1',
                            'pct' => 25
                        ],
                        [
                            'num' => '02',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step2_title.'.$locale, match($locale) { 'it' => '02. Valutazione e Preparazione', 'en' => '02. Evaluation & Preparation', default => '02. التقييم والتجهيز' }),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step2_desc.'.$locale, match($locale) { 'it' => 'Esaminiamo le tue qualifiche e il tuo livello, definendo i passaggi di formazione e preparazione richiesti.', 'en' => 'We review your qualifications, current level, and requirements, defining the training and preparation roadmap.', default => 'بنراجع مؤهلاتك ومستواك ومتطلباتك، ونحدد خطوات التأهيل والتجهيز المطلوبة بكل دقة.' }),
                            'dir' => 'reveal-up stagger-2',
                            'pct' => 50
                        ],
                        [
                            'num' => '03',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step3_title.'.$locale, match($locale) { 'it' => '03. Formazione e Presentazione Candidatura', 'en' => '03. Training & Application Submission', default => '03. التدريب والتقديم' }),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step3_desc.'.$locale, match($locale) { 'it' => 'Forniamo la formazione necessaria e ti assistiamo nelle procedure di domanda e monitoraggio in base al servizio.', 'en' => 'We provide necessary training and support application procedures and follow-up according to each service.', default => 'بنوفرلك التأهيل والتدريب اللازم، وبنساعدك في إجراءات التقديم والمتابعة حسب نوع الخدمة.' }),
                            'dir' => 'reveal-up stagger-3',
                            'pct' => 75
                        ],
                        [
                            'num' => '04',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step4_title.'.$locale, match($locale) { 'it' => '04. Monitoraggio e Completamento Pratiche', 'en' => '04. Follow-up & File Completion', default => '04. المتابعة واستكمال الإجراءات' }),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step4_desc.'.$locale, match($locale) { 'it' => 'Seguiamo con te tutti i passaggi, ti aiutiamo a completare il fascicolo per essere pronto al prossimo traguardo.', 'en' => 'We monitor the required steps, helping you finalize your file and get fully ready for your upcoming leap.', default => 'بنتابع معاك الخطوات المطلوبة، ونساعدك تستكمل ملفك وتكون جاهز تماماً لخطوتك القادمة.' }),
                            'dir' => 'reveal-right stagger-4',
                            'pct' => 100
                        ],
                    ];
                @endphp
                @foreach($roadmapSteps as $stepItem)
                    <div class="card-poster-white p-6 flex flex-col justify-between bg-white border border-slate-200 {{ $stepItem['dir'] }}">
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-red-50 border border-red-200 text-base font-black text-[#fe0002] shadow-xs">
                                {{ $stepItem['num'] }}
                            </span>
                            <span class="size-8 grid place-items-center">
                                {!! $stepItem['icon'] !!}
                            </span>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-base font-black text-[#c27803]">{{ $stepItem['title'] }}</h3>
                            <p class="mt-2 text-xs leading-relaxed text-slate-600 font-medium">
                                {{ $stepItem['desc'] }}
                            </p>
                        </div>

                        <div class="mt-6 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-[#fe0002] to-amber-500 rounded-full" style="width: {{ $stepItem['pct'] }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    
    <!-- ==========================================================
         ACADEMY LOCATION & CAMPUS HEADQUARTERS (GOOGLE MAPS)
         ========================================================== -->
    <section id="academy-location-section" class="relative bg-slate-50 py-20 sm:py-28 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>{{ match($locale) {
                        'it' => 'Sede Ufficiale e Campus Didattico',
                        'en' => 'Official Campus & Live Training Hub',
                        default => 'مقرنا الرئيسي وقاعاتنا التدريبية التفاعلية',
                    } }}</span>
                </span>
                
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ match($locale) {
                        'it' => 'Visita la Sede di INTOK ACADEMY',
                        'en' => 'Visit INTOK ACADEMY Campus & Headquarters',
                        default => 'تفضل بزيارة مقر وقاعات INTOK ACADEMY',
                    } }}
                </h2>
                
                <p class="mt-4 text-base text-slate-600 font-medium leading-relaxed">
                    {{ match($locale) {
                        'it' => 'Un ambiente all\'avanguardia dotato di aule multimediali e schermi interattivi, per accoglierti e offrirti consulenze personalizzate e formazione d\'eccellenza.',
                        'en' => 'A state-of-the-art campus equipped with interactive smart screens, welcoming you for 1-on-1 consultations and top-tier career qualification.',
                        default => 'مقر مجهز بأحدث الشاشات الذكية والقاعات التفاعلية، نرحب بكم يومياً لتقديم جلسات الاستشارة الأكاديمية والمهنية والتأهيل العملي المباشر.',
                    } }}
                </p>
            </div>

            <!-- Campus & Maps Grid -->
            <div class="grid gap-8 lg:grid-cols-12 items-stretch max-w-6xl mx-auto">
                
                <!-- Left Details Card (5 cols) -->
                <div class="lg:col-span-5 flex flex-col justify-between rounded-3xl bg-white border-2 border-slate-200 p-6 sm:p-8 shadow-xl reveal-left">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="grid size-11 place-items-center rounded-2xl bg-red-50 text-[#fe0002] border border-red-200 shadow-2xs font-bold">
                                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-black text-slate-900 text-base sm:text-lg">INTOK ACADEMY</h3>
                                    <p class="text-xs font-bold text-red-600">{{ match($locale) { 'it' => 'Sede Principale', 'en' => 'Headquarters & Training Hub', default => 'المقر الرئيسي وقاعات التدريب' } }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-black text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>{{ match($locale) { 'it' => 'Aperto', 'en' => 'Open Now', default => 'مفتوح لاستقبالكم' } }}</span>
                            </span>
                        </div>

                        <!-- Address Info -->
                        <div class="space-y-4 text-xs sm:text-sm">
                            <div class="flex items-start gap-3 text-slate-700">
                                <span class="size-5 shrink-0 mt-0.5 text-slate-400">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </span>
                                <div>
                                    <p class="font-black text-slate-900">{{ match($locale) { 'it' => 'Indirizzo del Campus', 'en' => 'Campus Address', default => 'عنوان المقر' } }}</p>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5 leading-relaxed">{{ data_get($siteSettings ?? [], 'academy_address.'.$locale, 'القاهرة / الجيزة - مصر (بالقرب من محطات المترو الرئيسية وسهولة تامة في الوصول)') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 text-slate-700">
                                <span class="size-5 shrink-0 mt-0.5 text-slate-400">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <div>
                                    <p class="font-black text-slate-900">{{ match($locale) { 'it' => 'Orari di Lavoro', 'en' => 'Operating Hours', default => 'مواعيد العمل والمحاضرات' } }}</p>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ match($locale) { 'it' => 'Dom - Gio: 9:00 - 18:00 (Consulenze)', 'en' => 'Sun - Thu: 9:00 AM - 6:00 PM (Consultations)', default => 'الأحد - الخميس: 9:00 ص - 6:00 م (استشارات وخدمة عملاء)' } }}</p>
                                    <p class="text-xs text-slate-500 font-medium">{{ match($locale) { 'it' => 'Ven - Sab: Corsi e workshop intensivi', 'en' => 'Fri - Sat: Intensive lectures & workshops', default => 'الجمعة والسبت: محاضرات وتدريب عملي تفاعلي مكثف' } }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Highlights Pills -->
                        <div class="flex flex-wrap gap-2 pt-2 border-t border-slate-100 text-[11px] font-bold text-slate-600">
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 border border-slate-200">🖥️ شاشات ذكية تفاعلية</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 border border-slate-200">❄️ قاعات مكيفة ومريحة</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 border border-slate-200">⚡ إنترنت فائق السرعة</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 border border-slate-200">🅿️ مواقف سيارات متوفرة</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-slate-100 space-y-3">
                        <a href="https://maps.app.goo.gl/JXjAZG1Nzf3do1LA8" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2.5 rounded-2xl bg-[#fe0002] px-6 py-3.5 text-xs sm:text-sm font-black text-white hover:bg-red-700 shadow-lg shadow-red-600/25 transition transform hover:-translate-y-0.5">
                            <svg class="size-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                            <span>{{ match($locale) { 'it' => 'Apri su Google Maps (GPS)', 'en' => 'Open in Google Maps (GPS)', default => 'فتح الموقع في خرائط Google (الاتجاهات)' } }}</span>
                        </a>

                        <div class="grid grid-cols-2 gap-2.5">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode('مرحباً، أود معرفة أقرب موعد لزيارة مقر أكاديمية INTOK') }}" target="_blank" class="flex items-center justify-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2.5 text-xs font-black text-emerald-800 hover:bg-emerald-100 transition">
                                <span>واتساب مباشر</span>
                            </a>
                            <a href="tel:{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}" class="flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs font-black text-slate-800 hover:bg-slate-100 transition" dir="ltr">
                                <span>{{ data_get($siteSettings ?? [], 'contact_phone', '+201008238323') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Map Container (7 cols) -->
                <div class="lg:col-span-7 rounded-3xl overflow-hidden border-2 border-slate-200 bg-white shadow-xl relative min-h-[420px] sm:min-h-[480px] reveal-right group">
                    
                    <!-- Embedded Google Maps -->
                    <iframe
                        src="https://maps.google.com/maps?q=30.0700542,31.2042554&hl={{ $locale }}&z=17&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0; min-height: 480px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="INTOK Academy Google Maps"
                        class="w-full h-full object-cover">
                    </iframe>

                    <!-- Top Map Overlay Badge -->
                    <div class="absolute top-4 start-4 z-10 pointer-events-none">
                        <div class="inline-flex items-center gap-2 rounded-2xl bg-slate-950/85 backdrop-blur-md px-4 py-2 text-xs font-black text-white shadow-xl border border-white/20">
                            <span class="size-2 rounded-full bg-[#fe0002] animate-ping"></span>
                            <span>📍 INTOK Academy Campus</span>
                        </div>
                    </div>

                    <!-- Bottom Floating Click-To-Open Pill -->
                    <div class="absolute bottom-4 inset-x-4 z-10 sm:inset-x-auto sm:end-4 pointer-events-auto">
                        <a href="https://maps.app.goo.gl/JXjAZG1Nzf3do1LA8" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200 px-5 py-2.5 text-xs font-black text-slate-900 shadow-xl hover:bg-[#fe0002] hover:text-white transition">
                            <svg class="size-4 text-red-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>{{ match($locale) { 'it' => 'Naviga con l\'app Google Maps', 'en' => 'Navigate in Google Maps App', default => 'تشغيل الاتجاهات في تطبيق خرائط Google' } }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Partners Image Modal (Lightbox) -->
    <div id="partner-lightbox-modal" class="fixed inset-0 z-50 hidden bg-black/85 backdrop-blur-md flex items-center justify-center p-4 sm:p-6" onclick="closePartnerModal(event)">
        <div class="relative max-w-5xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl p-4 sm:p-6 flex flex-col" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200">
                <h4 id="partner-modal-title" class="text-sm sm:text-base font-black text-slate-900"></h4>
                <button type="button" onclick="closePartnerModal()" class="size-8 rounded-full bg-slate-100 hover:bg-red-50 hover:text-red-600 flex items-center justify-center font-bold text-slate-600 transition cursor-pointer">
                    ✕
                </button>
            </div>
            <div class="overflow-auto max-h-[75vh] flex items-center justify-center rounded-2xl bg-slate-50 p-2">
                <img id="partner-modal-img" src="" alt="Partner Image" class="max-w-full h-auto object-contain rounded-xl">
            </div>
        </div>
    </div>

    <script>
        function openPartnerModal(src, title) {
            const modal = document.getElementById('partner-lightbox-modal');
            const img = document.getElementById('partner-modal-img');
            const tEl = document.getElementById('partner-modal-title');
            if (modal && img && tEl) {
                img.src = src;
                tEl.textContent = title;
                modal.classList.remove('hidden');
            }
        }
        function closePartnerModal() {
            const modal = document.getElementById('partner-lightbox-modal');
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tabBtns = document.querySelectorAll('.partner-tab-btn');
            const panelEgypt = document.getElementById('panel-partners-egypt');
            const panelIntl = document.getElementById('panel-partners-intl');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.dataset.target;
                    tabBtns.forEach(b => {
                        b.classList.remove('active-partner-tab', 'text-slate-900');
                        b.classList.add('text-slate-600');
                    });
                    btn.classList.add('active-partner-tab', 'text-slate-900');
                    btn.classList.remove('text-slate-600');

                    if (target === 'partners-egypt') {
                        panelEgypt?.classList.remove('hidden');
                        panelIntl?.classList.add('hidden');
                    } else {
                        panelEgypt?.classList.add('hidden');
                        panelIntl?.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
    <style>
        .active-partner-tab {
            background-color: #fe0002 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(254, 0, 2, 0.25);
        }
    </style>

    <!-- ==========================================================
         TESTIMONIALS SECTION
         ========================================================== -->
    @if($testimonials->isNotEmpty())
        <section class="relative bg-intok-section py-24 border-b border-slate-200/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-14 reveal-up">
                    <div>
                        <span class="inline-block rounded-full bg-amber-50 border border-amber-200 px-4 py-1 text-xs font-black text-amber-800">
                            قصص نجاح واقعية
                        </span>
                        <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-5xl">
                            {{ __('site.testimonials_title') }}
                        </h2>
                    </div>
                    <a href="{{ route('testimonials', ['locale'=>$locale]) }}" class="inline-flex items-center gap-2 text-sm font-black text-[#fe0002] hover:text-red-700 transition">
                        <span>شاهد كل القصص والتجارب</span>
                        <span aria-hidden="true">&larr;</span>
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($testimonials as $testimonial)
                        <article class="card-poster-white p-6 flex flex-col justify-between bg-white border border-slate-200 reveal-up stagger-{{ $loop->iteration }}">
                            <div>
                                <div class="flex items-center gap-3">
                                    @if($testimonial->photo_path)
                                        <img src="{{ asset('storage/'.$testimonial->photo_path) }}" alt="{{ $testimonial->name[app()->getLocale()] ?? '' }}" loading="lazy" class="size-14 rounded-2xl object-cover border border-slate-200">
                                    @else
                                        <div class="size-14 rounded-2xl bg-red-50 text-[#fe0002] border border-red-200 grid place-items-center text-lg font-black shadow-xs">
                                            {{ mb_substr($testimonial->name[$locale] ?? $testimonial->name['en'] ?? 'T', 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-base font-black text-[#c27803]">{{ $testimonial->name[$locale] ?? $testimonial->name['en'] ?? '' }}</h3>
                                        <p class="text-xs font-bold text-[#fe0002]">{{ $testimonial->destination[$locale] ?? 'طالب مبتعث' }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-1 text-[#c27803]" aria-label="{{ $testimonial->rating }} من 5">
                                    @for($i = 0; $i < $testimonial->rating; $i++)
                                        <svg class="size-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>

                                <blockquote class="mt-4 text-xs leading-relaxed text-slate-600 font-medium">
                                    “{{ $testimonial->quote[$locale] ?? $testimonial->quote['en'] ?? '' }}”
                                </blockquote>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- ==========================================================
         CALL TO ACTION BANNER (SIGNATURE INTOK RED LUXURY CARD)
         ========================================================== -->
    <section class="relative mx-auto max-w-7xl px-4 py-16 sm:py-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border-2 border-red-400/40 bg-gradient-to-br from-[#fe0002] via-[#e60002] to-[#b30001] p-8 sm:p-14 shadow-2xl shadow-red-600/30 text-white reveal-scale">
            <!-- Ambient Internal Glows -->
            <div class="pointer-events-none absolute -top-20 -end-20 size-72 rounded-full bg-white/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -start-20 size-72 rounded-full bg-amber-300/15 blur-3xl"></div>

            <div class="relative z-10 flex flex-col items-center justify-between gap-8 text-center md:flex-row md:text-start">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/20 border border-white/40 px-4 py-1 text-xs font-black text-white backdrop-blur-md shadow-xs">
                        {{ data_get($siteSettings ?? [], 'cta_badge.'.$locale, match($locale) { 'it' => 'Inizia il tuo futuro oggi', 'en' => 'Start Your Future Today', default => 'ابدأ مستقبلك اليوم' }) }}
                    </span>
                    @php
                        $rawCtaTitle = data_get($siteSettings ?? [], 'cta_title.'.$locale);
                        $ctaTitle = ($rawCtaTitle && !str_contains($rawCtaTitle, 'إيطاليا'))
                            ? $rawCtaTitle
                            : match($locale) {
                                'it' => 'Pronto a compiere il tuo prossimo passo con INTOK?',
                                'en' => 'Ready to Take Your Next Step with INTOK?',
                                default => 'جاهز تبدأ خطوتك الجاية مع INTOK؟',
                            };

                        $rawCtaSub = data_get($siteSettings ?? [], 'cta_subtitle.'.$locale);
                        $ctaSub = ($rawCtaSub && !str_contains($rawCtaSub, 'إيطاليا'))
                            ? $rawCtaSub
                            : match($locale) {
                                'it' => 'Che il tuo obiettivo sia imparare una lingua, sviluppare competenze professionali, qualificarti per studiare in Europa o completare le tue pratiche accademiche, il team INTOK è pronto ad aiutarti a iniziare.',
                                'en' => 'Whether your goal is learning a language, developing career skills, qualifying to study in Europe, or completing academic procedures, the INTOK team is ready to guide your start.',
                                default => 'سواء هدفك تتعلم لغة، تطور مهاراتك المهنية، تتأهل للدراسة في أوروبا أو تستكمل إجراءاتك الأكاديمية، فريق INTOK جاهز يساعدك تبدأ.',
                            };
                    @endphp
                    <h2 class="mt-4 text-2xl font-black text-white sm:text-4xl drop-shadow-sm leading-tight">
                        {{ $ctaTitle }}
                    </h2>
                    <p class="mt-3 text-sm leading-relaxed text-red-50/95 font-medium">
                        {{ $ctaSub }}
                    </p>
                    
                    <!-- Official Social Links -->
                    <div class="mt-5 flex flex-wrap items-center gap-3 justify-center md:justify-start">
                        <a href="https://www.instagram.com/intokacademy" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-black/20 border border-white/30 px-3.5 py-1 text-xs font-bold text-white hover:bg-white hover:text-[#fe0002] transition">
                            <span>Instagram: @intokacademy</span>
                        </a>
                        <a href="https://tiktok.com/@intokacademy" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-black/20 border border-white/30 px-3.5 py-1 text-xs font-bold text-white hover:bg-white hover:text-[#fe0002] transition">
                            <span>TikTok: @intokacademy</span>
                        </a>
                    </div>
                </div>
                
                <div class="shrink-0 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="rounded-full bg-white px-8 py-4 text-center text-sm font-black text-[#fe0002] shadow-xl hover:bg-amber-50 hover:scale-105 transition transform flex items-center justify-center gap-2">
                        <span>{{ data_get($siteSettings ?? [], 'cta_btn_primary.'.$locale, 'احجز استشارتك الآن') }}</span>
                        <span>&larr;</span>
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" target="_blank" class="rounded-full border-2 border-white/70 bg-white/10 px-6 py-4 text-center text-sm font-black text-white backdrop-blur-md transition hover:bg-white hover:text-[#fe0002] flex items-center justify-center gap-2">
                        <span>{{ data_get($siteSettings ?? [], 'cta_btn_secondary.'.$locale, 'واتساب مباشر') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         ACTIVE JAVASCRIPT ENGINE (60FPS CONSTELLATION & MASCOT TILT)
         ========================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. ACTIVE 60FPS CONSTELLATION CANVAS (Desktop Only for Maximum Performance)
            const canvas = document.getElementById('hero-interactive-canvas');
            if (canvas && window.innerWidth >= 1024) {
                const ctx = canvas.getContext('2d');
                let width = canvas.width = canvas.parentElement.offsetWidth;
                let height = canvas.height = canvas.parentElement.offsetHeight;

                window.addEventListener('resize', () => {
                    if (canvas && canvas.parentElement) {
                        width = canvas.width = canvas.parentElement.offsetWidth;
                        height = canvas.height = canvas.parentElement.offsetHeight;
                    }
                });

                const particleCount = Math.min(Math.floor(width / 15), 80);
                const particles = [];
                // Clean subtle tones: Red (#dc2626), Warm Amber (#f59e0b), Slate (#94a3b8)
                const colors = ['rgba(220, 38, 38, ', 'rgba(245, 158, 11, ', 'rgba(148, 163, 184, '];

                for (let i = 0; i < particleCount; i++) {
                    particles.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        vx: (Math.random() - 0.5) * 0.85,
                        vy: (Math.random() - 0.5) * 0.85,
                        radius: Math.random() * 2.2 + 1,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        baseAlpha: Math.random() * 0.4 + 0.25
                    });
                }

                let mouse = { x: null, y: null, maxDist: 140 };

                window.addEventListener('mousemove', (e) => {
                    const rect = canvas.getBoundingClientRect();
                    mouse.x = e.clientX - rect.left;
                    mouse.y = e.clientY - rect.top;
                });

                window.addEventListener('mouseleave', () => {
                    mouse.x = null;
                    mouse.y = null;
                });

                function render() {
                    ctx.clearRect(0, 0, width, height);

                    for (let i = 0; i < particles.length; i++) {
                        const p = particles[i];

                        p.x += p.vx;
                        p.y += p.vy;

                        if (p.x < 0 || p.x > width) p.vx *= -1;
                        if (p.y < 0 || p.y > height) p.vy *= -1;

                        if (mouse.x !== null && mouse.y !== null) {
                            const dx = mouse.x - p.x;
                            const dy = mouse.y - p.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);
                            if (dist < mouse.maxDist) {
                                const force = (mouse.maxDist - dist) / mouse.maxDist;
                                p.x += (dx / dist) * force * 1.2;
                                p.y += (dy / dist) * force * 1.2;

                                ctx.strokeStyle = `rgba(220, 38, 38, ${0.4 * force})`;
                                ctx.lineWidth = 1;
                                ctx.beginPath();
                                ctx.moveTo(p.x, p.y);
                                ctx.lineTo(mouse.x, mouse.y);
                                ctx.stroke();
                            }
                        }

                        ctx.fillStyle = p.color + p.baseAlpha + ')';
                        ctx.beginPath();
                        ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                        ctx.fill();

                        for (let j = i + 1; j < particles.length; j++) {
                            const p2 = particles[j];
                            const dx = p.x - p2.x;
                            const dy = p.y - p2.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);

                            if (dist < 105) {
                                const alpha = (1 - dist / 105) * 0.25;
                                ctx.strokeStyle = `rgba(203, 213, 225, ${alpha})`;
                                ctx.lineWidth = 0.75;
                                ctx.beginPath();
                                ctx.moveTo(p.x, p.y);
                                ctx.lineTo(p2.x, p2.y);
                                ctx.stroke();
                            }
                        }
                    }

                    requestAnimationFrame(render);
                }

                render();
            }

            // 2. CINEMATIC HERO ACADEMIC STAGE ENGINE
            const heroStageData = {!! json_encode($heroScenes, JSON_UNESCAPED_UNICODE) !!};

            let heroSceneIdx = 0;
            let heroCycleTimer = null;
            const heroImg = document.getElementById('hero-stage-img');
            const heroBadgeText = document.getElementById('hero-stage-badge-text');
            const heroTitle = document.getElementById('hero-stage-title');
            const heroDesc = document.getElementById('hero-stage-desc');
            const heroStat = document.getElementById('hero-stage-stat');
            const heroProgressBar = document.getElementById('hero-stage-progress');
            const heroTabs = document.querySelectorAll('.hero-stage-tab');
            const heroStageCard = document.getElementById('hero-academic-stage');

            function applyHeroScene(idx) {
                if (!heroImg || !heroStageData[idx]) return;
                heroSceneIdx = idx;

                heroTabs.forEach((tab, tIdx) => {
                    if (tIdx === idx) tab.classList.add('active-hero-tab');
                    else tab.classList.remove('active-hero-tab');
                });

                heroImg.style.opacity = '0.35';
                if (heroTitle) heroTitle.style.opacity = '0';
                if (heroDesc) heroDesc.style.opacity = '0';

                setTimeout(() => {
                    const item = heroStageData[idx];
                    heroImg.src = item.image;
                    if (heroBadgeText) heroBadgeText.innerText = item.badge;
                    if (heroTitle) heroTitle.innerText = item.title;
                    if (heroDesc) heroDesc.innerText = item.desc;
                    if (heroStat) heroStat.innerText = item.stat;

                    heroImg.style.opacity = '1';
                    if (heroTitle) heroTitle.style.opacity = '1';
                    if (heroDesc) heroDesc.style.opacity = '1';
                }, 200);

                if (heroProgressBar) {
                    heroProgressBar.style.transition = 'none';
                    heroProgressBar.style.width = '0%';
                    setTimeout(() => {
                        heroProgressBar.style.transition = 'width 4.8s linear';
                        heroProgressBar.style.width = '100%';
                    }, 50);
                }
            }

            function startHeroCycle() {
                stopHeroCycle();
                applyHeroScene(heroSceneIdx);
                heroCycleTimer = setInterval(() => {
                    heroSceneIdx = (heroSceneIdx + 1) % heroStageData.length;
                    applyHeroScene(heroSceneIdx);
                }, 5000);
            }

            function stopHeroCycle() {
                if (heroCycleTimer) clearInterval(heroCycleTimer);
            }

            heroTabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    const idx = parseInt(tab.getAttribute('data-scene'), 10);
                    applyHeroScene(idx);
                    startHeroCycle();
                });
            });

            if (heroStageCard) {
                heroStageCard.addEventListener('mouseenter', stopHeroCycle);
                heroStageCard.addEventListener('mouseleave', startHeroCycle);

                if (window.innerWidth >= 1024) {
                    heroStageCard.addEventListener('mousemove', (e) => {
                        const rect = heroStageCard.getBoundingClientRect();
                        const x = e.clientX - rect.left - rect.width / 2;
                        const y = e.clientY - rect.top - rect.height / 2;
                        const rotateX = -(y / (rect.height / 2)) * 6;
                        const rotateY = (x / (rect.width / 2)) * 6;
                        heroStageCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                    });

                    heroStageCard.addEventListener('mouseleave', () => {
                        heroStageCard.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
                    });
                }
            }

            startHeroCycle();

            // 3. SHATTER / SLICE DISINTEGRATION SLIDER ENGINE
            const slidesData = {!! json_encode($liveSlides, JSON_UNESCAPED_UNICODE) !!};

            let currentSlideIndex = 0;
            let isShattering = false;
            let shatterInterval = null;
            const SLIDE_PAUSE = 4800;

            const baseLayer = document.getElementById('shatter-base-layer');
            const slicesStage = document.getElementById('shatter-slices-stage');
            const screenBox = document.getElementById('shatter-screen');
            const progressFill = document.getElementById('shatter-progress-fill');
            const badgeEl = document.getElementById('shatter-slide-badge');
            const titleEl = document.getElementById('shatter-slide-title');
            const descEl = document.getElementById('shatter-slide-desc');
            const counterEl = document.getElementById('shatter-counter');
            const dotsBar = document.getElementById('shatter-dots-bar');
            const prevBtn = document.getElementById('shatter-prev-btn');
            const nextBtn = document.getElementById('shatter-next-btn');

            function initShatterSlider() {
                if (!screenBox || !baseLayer) return;

                baseLayer.style.backgroundImage = `url('${slidesData[0].image}')`;

                if (dotsBar) {
                    dotsBar.innerHTML = '';
                    slidesData.forEach((_, idx) => {
                        const dot = document.createElement('button');
                        dot.setAttribute('aria-label', `الانتقال للصورة ${idx + 1}`);
                        dot.className = `h-2.5 rounded-full transition-all duration-300 cursor-pointer ${idx === 0 ? 'bg-[#fe0002] w-8' : 'bg-slate-300 hover:bg-slate-400 w-2.5'}`;
                        dot.addEventListener('click', () => {
                            if (!isShattering && idx !== currentSlideIndex) {
                                goToShatterSlide(idx);
                            }
                        });
                        dotsBar.appendChild(dot);
                    });
                }

                startShatterTimer();
            }

            function updateSlideCaptions(index) {
                const data = slidesData[index];
                if (badgeEl) badgeEl.innerText = data.badge;
                if (titleEl) {
                    titleEl.style.opacity = '0';
                    setTimeout(() => {
                        titleEl.innerText = data.title;
                        titleEl.style.opacity = '1';
                    }, 180);
                }
                if (descEl) {
                    descEl.style.opacity = '0';
                    setTimeout(() => {
                        descEl.innerText = data.desc;
                        descEl.style.opacity = '1';
                    }, 180);
                }
                if (counterEl) {
                    counterEl.innerText = `0${index + 1} / 0${slidesData.length}`;
                }

                if (dotsBar) {
                    const dots = dotsBar.querySelectorAll('button');
                    dots.forEach((d, i) => {
                        if (i === index) {
                            d.className = 'h-2.5 rounded-full transition-all duration-300 bg-[#fe0002] w-8';
                        } else {
                            d.className = 'h-2.5 rounded-full transition-all duration-300 bg-slate-300 hover:bg-slate-400 w-2.5';
                        }
                    });
                }
            }

            function executeShatterTransition(fromIndex, toIndex) {
                if (isShattering) return;
                isShattering = true;

                const fromImg = slidesData[fromIndex].image;
                const toImg = slidesData[toIndex].image;

                const width = screenBox.offsetWidth;
                const height = screenBox.offsetHeight;
                const stripCount = 10;
                const stripWidth = width / stripCount;

                slicesStage.innerHTML = '';

                // Generate vertical strips covering the exact picture coordinates
                for (let i = 0; i < stripCount; i++) {
                    const strip = document.createElement('div');
                    strip.className = 'shatter-strip';
                    strip.style.left = `${i * stripWidth}px`;
                    strip.style.width = `${stripWidth + 1}px`;
                    strip.style.height = `${height}px`;
                    strip.style.backgroundImage = `url('${fromImg}')`;
                    strip.style.backgroundSize = `${width}px ${height}px`;
                    strip.style.backgroundPosition = `-${i * stripWidth}px 0px`;
                    strip.style.transitionDelay = `${i * 35}ms`;
                    slicesStage.appendChild(strip);
                }

                // Place target next image underneath
                baseLayer.style.backgroundImage = `url('${toImg}')`;
                baseLayer.style.transform = 'scale(1.04)';
                setTimeout(() => {
                    baseLayer.style.transform = 'scale(1)';
                }, 40);

                updateSlideCaptions(toIndex);

                // Disintegrate & shatter the strips
                requestAnimationFrame(() => {
                    const strips = slicesStage.querySelectorAll('.shatter-strip');
                    strips.forEach((strip, i) => {
                        if (i % 2 === 0) {
                            strip.classList.add('shattered-even');
                        } else {
                            strip.classList.add('shattered-odd');
                        }
                    });
                });

                // Reset stage after animation completes
                setTimeout(() => {
                    slicesStage.innerHTML = '';
                    currentSlideIndex = toIndex;
                    isShattering = false;
                    startShatterTimer();
                }, 850);
            }

            function goToShatterSlide(targetIndex) {
                clearInterval(shatterInterval);
                resetShatterProgress();
                executeShatterTransition(currentSlideIndex, targetIndex);
            }

            function nextShatterSlide() {
                const nextIdx = (currentSlideIndex + 1) % slidesData.length;
                goToShatterSlide(nextIdx);
            }

            function prevShatterSlide() {
                const prevIdx = (currentSlideIndex - 1 + slidesData.length) % slidesData.length;
                goToShatterSlide(prevIdx);
            }

            function startShatterTimer() {
                clearInterval(shatterInterval);
                resetShatterProgress();

                if (progressFill) {
                    progressFill.style.transition = 'none';
                    progressFill.style.width = '0%';
                    setTimeout(() => {
                        progressFill.style.transition = `width ${SLIDE_PAUSE}ms linear`;
                        progressFill.style.width = '100%';
                    }, 40);
                }

                shatterInterval = setInterval(() => {
                    nextShatterSlide();
                }, SLIDE_PAUSE);
            }

            function resetShatterProgress() {
                if (progressFill) {
                    progressFill.style.transition = 'none';
                    progressFill.style.width = '0%';
                }
            }

            if (prevBtn) prevBtn.addEventListener('click', prevShatterSlide);
            if (nextBtn) nextBtn.addEventListener('click', nextShatterSlide);

            if (screenBox) {
                screenBox.addEventListener('mouseenter', () => {
                    clearInterval(shatterInterval);
                    if (progressFill) progressFill.style.transition = 'none';
                });
                screenBox.addEventListener('mouseleave', () => {
                    startShatterTimer();
                });
            }

            initShatterSlider();

            // 4. INTERACTIVE SPLIT TRACK STAGE ENGINE
            const trackRailBtns = document.querySelectorAll('.track-rail-btn');
            const serviceFilterTabs = document.querySelectorAll('.service-filter-tab');
            const mainStagePanel = document.getElementById('service-main-stage');

            const stageBadge = document.getElementById('stage-badge');
            const stageCatName = document.getElementById('stage-cat-name');
            const stageCatIcon = document.getElementById('stage-cat-icon');
            const stageBigIcon = document.getElementById('stage-big-icon');
            const stageTitle = document.getElementById('stage-title');
            const stageLevel = document.getElementById('stage-level');
            const stageDesc = document.getElementById('stage-desc');
            const stagePointsContainer = document.getElementById('stage-points-container');
            const stageDuration = document.getElementById('stage-duration');
            const stageMode = document.getElementById('stage-mode');
            const stageTarget = document.getElementById('stage-target');
            const stageWhatsappBtn = document.getElementById('stage-whatsapp-btn');
            const stageCtaBtn = document.getElementById('stage-cta-btn');
            const stageDetailsBtn = document.getElementById('stage-details-btn');
            const stageTrackCounter = document.getElementById('stage-track-counter');
            const stagePrevBtn = document.getElementById('stage-prev-btn');
            const stageNextBtn = document.getElementById('stage-next-btn');

            function getVisibleTrackBtns() {
                return Array.from(trackRailBtns).filter(btn => btn.style.display !== 'none');
            }

            function updateStage(trackData, activeIndex, totalCount) {
                if (!mainStagePanel) return;

                mainStagePanel.classList.remove('track-stage-anim');
                void mainStagePanel.offsetWidth; // trigger reflow
                mainStagePanel.classList.add('track-stage-anim');

                if (stageTrackCounter && typeof activeIndex === 'number' && totalCount) {
                    stageTrackCounter.innerText = `${activeIndex + 1} / ${totalCount}`;
                }

                if (stageBadge) {
                    stageBadge.className = `inline-flex items-center rounded-full border px-3 py-1 text-xs font-black ${trackData.badge_class || ''}`;
                    stageBadge.innerText = trackData.badge;
                }
                if (stageCatName) stageCatName.innerText = trackData.category_label;
                if (stageCatIcon) stageCatIcon.innerHTML = trackData.icon;
                if (stageBigIcon) stageBigIcon.innerHTML = trackData.icon;
                if (stageTitle) stageTitle.innerText = trackData.title;
                if (stageLevel) stageLevel.innerText = trackData.level;
                if (stageDesc) stageDesc.innerText = trackData.full_desc || trackData.summary;
                if (stageDuration) stageDuration.innerText = trackData.duration;
                if (stageMode) stageMode.innerText = trackData.mode;
                if (stageTarget) {
                    stageTarget.innerText = trackData.target;
                    stageTarget.title = trackData.target;
                }

                if (stagePointsContainer && Array.isArray(trackData.points)) {
                    stagePointsContainer.innerHTML = '';
                    trackData.points.forEach(pt => {
                        const box = document.createElement('div');
                        box.className = 'flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 hover:bg-slate-50 transition min-w-0';
                        box.innerHTML = `<div class="size-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5" style="width: 20px; height: 20px; min-width: 20px;"><svg class="size-3" width="12" height="12" style="width: 12px; height: 12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><span class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug break-words flex-1">${pt}</span>`;
                        stagePointsContainer.appendChild(box);
                    });
                }

                if (stageWhatsappBtn) {
                    const waPrefix = {!! json_encode($locale === 'it' ? 'Ciao, vorrei richiedere informazioni e iscrivermi a: ' : ($locale === 'en' ? 'Hello, I would like to inquire about and enroll in: ' : 'مرحباً، أود الاستفسار والتسجيل في برنامج: ')) !!};
                    const msg = encodeURIComponent(trackData.whatsapp_message || `${waPrefix}${trackData.title}`);
                    stageWhatsappBtn.href = `https://wa.me/201008238323?text=${msg}`;
                }
                if (stageCtaBtn) {
                    stageCtaBtn.href = `{{ route('consultation.create', ['locale' => app()->getLocale()]) }}?track=${encodeURIComponent(trackData.id || '')}`;
                }
                if (stageDetailsBtn && trackData.slug) {
                    stageDetailsBtn.href = `/{{ app()->getLocale() }}/services/${encodeURIComponent(trackData.slug)}`;
                }
            }

            trackRailBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    trackRailBtns.forEach(b => b.classList.remove('active-track'));
                    btn.classList.add('active-track');

                    try {
                        const data = JSON.parse(btn.getAttribute('data-track-data'));
                        const visibleBtns = getVisibleTrackBtns();
                        const activeIdx = visibleBtns.indexOf(btn);
                        updateStage(data, activeIdx >= 0 ? activeIdx : 0, visibleBtns.length || trackRailBtns.length);

                        // Scroll active pill into view smoothly in the horizontal strip
                        btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    } catch (e) {
                        console.error('Invalid track data', e);
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

            // Filter Tabs Handling (if present)
            if (serviceFilterTabs && serviceFilterTabs.length) {
                serviceFilterTabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        serviceFilterTabs.forEach(t => t.classList.remove('active-service-tab'));
                        tab.classList.add('active-service-tab');

                        const filter = tab.getAttribute('data-filter');
                        let firstVisible = null;

                        trackRailBtns.forEach(btn => {
                            const cat = btn.getAttribute('data-category');
                            if (filter === 'all' || cat === filter) {
                                btn.style.display = 'flex';
                                if (!firstVisible) firstVisible = btn;
                            } else {
                                btn.style.display = 'none';
                            }
                        });

                        // Activate first visible in this category
                        if (firstVisible) {
                            firstVisible.click();
                        }
                    });
                });
            }
        });
    </script>
@endsection
