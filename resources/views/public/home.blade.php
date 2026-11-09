@extends('public.layouts.app')

@section('title', __('site.nav_home'))
@section('meta_description', __('site.hero_text'))
@php
    $locale = app()->getLocale();
    $defaultRobotQuotes = [
        '"الدبلوم الفني ليس نهاية المطاف.. شهادتك بوابتك الرسمية للدراسة في إيطاليا."',
        '"مستقبلك يبدأ من هنا.. خطوة مدروسة تحول طموحك إلى واقع أوروبي."',
        '"منحة DSU تغطي مصروفاتك بالكامل مع سكن جامعي مجاني وبدل سنوي 8,000 يورو."',
        '"تدريب الكول سنتر واللغات في INTOK يفتح لك أبواب العمل بكبرى الشركات العالمية."',
        '"ترجمة معتمدة رسمياً وموثقة للسفارة الإيطالية بأعلى معايير الدقة الدبلوماسية."'
    ];
    $robotQuotesList = data_get($siteSettings ?? [], 'robot_quotes') ?: $defaultRobotQuotes;
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
                <div class="lg:col-span-7 text-start reveal-left">
                    
                    <!-- Top Dynamic Badge -->
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-red-200 bg-white/90 px-4 py-2 text-xs font-black text-red-600 backdrop-blur-md shadow-xs">
                        <span class="relative flex size-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex size-2.5 rounded-full bg-red-600"></span>
                        </span>
                        <span>{{ data_get($siteSettings ?? [], 'hero_badge.'.$locale, 'مستقبلك يبدأ هنا: مسارك المعتمد نحو الدراسة والعمل في أوروبا') }}</span>
                    </div>

                    <!-- Main Punchy Headline -->
                    <h1 class="mt-6 text-3xl font-black leading-[1.2] tracking-tight sm:text-5xl lg:text-6xl text-[#c27803]">
                        {!! nl2br(e(data_get($siteSettings ?? [], 'hero_title.'.$locale, "مستقبلك أكبر من حدود بلدك! \nالدراسة في إيطاليا واحتراف اللغات"))) !!}
                    </h1>

                    <!-- Empowering Subtitle -->
                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg font-medium">
                        {{ data_get($siteSettings ?? [], 'hero_text.'.$locale, 'معاك ثانوية أو دبلوم فني (صنايع، تجارة، زراعة)؟ بوابتك مفتوحة لاستكمال دراستك في إيطاليا، والحصول على منح DSU الشاملة (8,000 يورو + سكن مجاني)، والعمل قانونياً باليورو، مع أقوى برامج تدريب الكول سنتر، والترجمة المعتمدة، ودورات اللغات.') }}
                    </p>

                    <!-- Primary CTAs -->
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary flex items-center gap-3 px-8 py-4 text-sm font-black shadow-lg">
                            <span>{{ data_get($siteSettings ?? [], 'hero_cta.'.$locale, 'احجز استشارتك الأكاديمية وابدأ الآن') }}</span>
                        </a>

                        <a href="#services-section" class="flex items-center gap-2.5 rounded-full border-2 border-slate-200 bg-white px-6 py-4 text-sm font-black text-slate-700 transition hover:border-slate-400 hover:text-red-600 shadow-xs">
                            <span>{{ data_get($siteSettings ?? [], 'hero_secondary_cta.'.$locale, 'استكشف الـ 7 مجالات والخدمات') }}</span>
                            <span class="text-[#fe0002]">↓</span>
                        </a>
                    </div>

                    <!-- Trust Metrics -->
                    <div class="mt-10 grid grid-cols-3 gap-4 border-t border-slate-200 pt-6 max-w-lg text-start">
                        <div>
                            <p class="text-2xl font-black text-[#c27803] sm:text-3xl">{{ data_get($siteSettings ?? [], 'hero_stat_1_val', '+1,500') }}</p>
                            <p class="text-xs font-bold text-red-600 mt-1">{{ data_get($siteSettings ?? [], 'hero_stat_1_lbl.'.$locale, 'طالب تم قبولهم') }}</p>
                        </div>
                        <div class="border-s border-slate-200 ps-4">
                            <p class="text-2xl font-black text-[#c27803] sm:text-3xl">{{ data_get($siteSettings ?? [], 'hero_stat_2_val', '99.4%') }}</p>
                            <p class="text-xs font-bold text-slate-600 mt-1">{{ data_get($siteSettings ?? [], 'hero_stat_2_lbl.'.$locale, 'نسبة نجاح الملفات') }}</p>
                        </div>
                        <div class="border-s border-slate-200 ps-4">
                            <p class="text-2xl font-black text-[#c27803] sm:text-3xl">{{ data_get($siteSettings ?? [], 'hero_stat_3_val', '8,000€') }}</p>
                            <p class="text-xs font-bold text-red-600 mt-1">{{ data_get($siteSettings ?? [], 'hero_stat_3_lbl.'.$locale, 'منحة سنوية + سكن') }}</p>
                        </div>
                    </div>

                    <!-- Official Accreditation Guarantee Bar -->
                    <div class="mt-6 flex flex-wrap items-center gap-2.5 text-xs font-bold text-slate-700">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-emerald-800 shadow-2xs">
                            <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>شراكات رسمية معتمدة في إيطاليا</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-amber-900 shadow-2xs">
                            <span>توثيق قنصلي وترجمة معتمدة 100%</span>
                        </span>
                    </div>
                </div>

                <!-- Right Column: Cinematic Italian Academic Gateway Stage (Luxury 3D Showcase) -->
                <div class="lg:col-span-5 relative flex flex-col items-center justify-center pt-8 lg:pt-0 reveal-right" id="hero-stage-column">
                    
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
                                    src="{{ asset('assets/images/schools/san-giorgio.jpg') }}"
                                    alt="الدراسة في إيطاليا مع INTOK ACADEMY"
                                    class="size-full object-cover transition-all duration-700 ease-out group-hover:scale-105">

                                <!-- Film Vignette & Shadow Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-black/20 pointer-events-none"></div>

                                <!-- Top Badge Ribbon on Image -->
                                <div class="absolute top-3.5 inset-x-3.5 z-20 flex items-center justify-between gap-2">
                                    <span id="hero-stage-badge" class="inline-flex items-center gap-1.5 rounded-full bg-black/60 backdrop-blur-md border border-white/20 px-3 py-1 text-[11px] font-black text-amber-300 shadow-md">
                                        <span class="size-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span id="hero-stage-badge-text">عاصمة الدراسة والصناعة • ميلانو</span>
                                    </span>
                                    
                                    <span class="rounded-full bg-emerald-500/90 backdrop-blur-xs px-2.5 py-0.5 text-[10px] font-black text-white shadow-xs">
                                        متاح التقديم
                                    </span>
                                </div>

                                <!-- Center/Bottom Captions on Image -->
                                <div class="absolute bottom-3 inset-x-3.5 z-20 text-start text-white">
                                    <h3 id="hero-stage-title" class="text-lg sm:text-xl font-black text-white leading-tight drop-shadow-md transition-opacity duration-300">
                                        جامعات ومدارس ميلانو الحكومية
                                    </h3>
                                    <p id="hero-stage-desc" class="mt-1 text-xs text-slate-200 font-medium line-clamp-2 leading-relaxed transition-opacity duration-300">
                                        استكمال دراستك في أعرق الصروح التعليمية مع منحة DSU الشاملة (8,000 يورو + سكن مجاني) وتأشيرة دراسية رسمية.
                                    </p>

                                    <!-- Bottom Fast CTA inside card -->
                                    <div class="mt-3.5 flex items-center justify-between gap-2 pt-2.5 border-t border-white/15">
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-amber-300">
                                            <span id="hero-stage-stat">8,000€ بدل سنوي + سكن مجاني</span>
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
                                <button type="button" class="hero-stage-tab active-hero-tab" data-scene="0">
                                    <span class="block text-xs font-black truncate py-1">ميلانو</span>
                                </button>
                                <button type="button" class="hero-stage-tab" data-scene="1">
                                    <span class="block text-xs font-black truncate py-1">روما</span>
                                </button>
                                <button type="button" class="hero-stage-tab" data-scene="2">
                                    <span class="block text-xs font-black truncate py-1">قاعات إنتوك</span>
                                </button>
                                <button type="button" class="hero-stage-tab" data-scene="3">
                                    <span class="block text-xs font-black truncate py-1">الكول سنتر</span>
                                </button>
                            </div>

                        </div>

                        <!-- FLOATING LUXURY 3D BADGES (Layered over the card) -->
                        
                        <!-- Top-End Floating Badge: DSU Scholarship -->
                        <div class="pointer-events-none absolute -top-5 -end-3 sm:-end-5 z-30 flex items-center gap-2.5 rounded-2xl border-2 border-emerald-400/80 bg-white/95 px-3 py-1.5 sm:px-3.5 sm:py-2 text-slate-900 shadow-xl backdrop-blur-md animate-float-drift-1">
                            <span class="grid size-8 sm:size-9 shrink-0 place-items-center rounded-xl bg-emerald-100 text-emerald-700 text-xs font-black">
                                DSU
                            </span>
                            <div class="text-start">
                                <span class="text-[11px] font-black text-emerald-800 block leading-tight">منحة DSU الحكومية</span>
                                <span class="text-[9px] sm:text-[10px] font-bold text-slate-600 block">8,000€ + سكن معفى 100%</span>
                            </div>
                        </div>

                        <!-- Bottom-Start Floating Badge: Official Italian Visa -->
                        <div class="pointer-events-none absolute -bottom-5 -start-3 sm:-start-5 z-30 flex items-center gap-2.5 rounded-2xl border-2 border-red-300 bg-white/95 px-3 py-1.5 sm:px-3.5 sm:py-2 text-slate-900 shadow-xl backdrop-blur-md animate-float-drift-2">
                            <span class="grid size-8 sm:size-9 shrink-0 place-items-center rounded-xl bg-red-100 text-[#fe0002] text-xs font-black">
                                VISA
                            </span>
                            <div class="text-start">
                                <span class="text-[11px] font-black text-[#fe0002] block leading-tight">تأشيرة رسمية معتمدة</span>
                                <span class="text-[9px] sm:text-[10px] font-bold text-slate-600 block">نسبة نجاح الملفات 99.4%</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         OFFICIAL 7 CORE SERVICES & SPECIALIZATIONS (USER PROVIDED)
         ========================================================== -->
    <section id="services-section" class="relative bg-intok-section py-16 sm:py-24 border-b border-slate-200/80 w-full max-w-full overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full min-w-0 max-w-full">
            <div class="text-center max-w-3xl mx-auto mb-10 lg:mb-14 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-red-700 shadow-xs">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>{{ data_get($siteSettings ?? [], 'services_badge.'.$locale, 'برامج وتدريب معتمد دولياً') }}</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ data_get($siteSettings ?? [], 'services_title.'.$locale, 'خدمات وتدريب INTOK ACADEMY') }}
                </h2>
                <p class="mt-4 text-base text-slate-600 font-medium leading-relaxed">
                    {{ data_get($siteSettings ?? [], 'services_subtitle.'.$locale, 'منظومة تدريب احترافية معتمدة تؤهلك لسوق العمل الدولي وكبرى الشركات العالمية، مع خدمات الترجمة الرسمية الموثقة للسفارات وبوابتك لاستكمال الدراسة في إيطاليا.') }}
                </p>
            </div>

            @php
                $trackItems = [
                    [
                        'id' => 'call-center',
                        'title' => 'تدريب الكول سنتر الاحترافي',
                        'category' => 'career',
                        'category_label' => 'تأهيل لسوق العمل والكول سنتر',
                        'badge' => 'الأكثر طلباً',
                        'badge_class' => 'bg-red-50 text-[#fe0002] border-red-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>',
                        'level' => 'تأهيل وظيفي مباشر لكبرى الشركات',
                        'duration' => 'مكثف (4 - 6 أسابيع)',
                        'mode' => 'قاعات مجهزة + أونلاين تفاعلي',
                        'target' => 'خريجو المؤهلات والباحثون عن دخل مميز بالعملات الأجنبية',
                        'salary' => '15,000 - 30,000+ ج.م شهرياً',
                        'summary' => 'برنامج تدريبي يؤهلك للعمل في الكول سنتر باحتراف، مع تطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات بثقة.',
                        'points' => [
                            'محاكاة حقيقية لمقابلات كبرى الشركات متعددة الجنسيات (Vodafone UK, Concentrix, TP)',
                            'تدريب عملي تفاعلي على الشاشات الذكية والصوتيات وحل مشكلات العملاء باحترافية',
                            'تأهيل للعمل برواتب مجزية بالعملات الأجنبية مع متابعة شخصية حتى اجتياز المقابلة',
                            'إتقان اللهجة والأسلوب المهني المناسب للحملات الدولية'
                        ],
                        'full_desc' => 'برنامج تدريبي يؤهلك للعمل في الكول سنتر باحتراف، مع تطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات بثقة. يشمل تدريباً عملياً مكثفاً على مهارات التحدث باللغات الأجنبية، إدارة المكالمات، وتجاوز أصعب مواقف خدمة العملاء بنجاح.'
                    ],
                    [
                        'id' => 'italy-dsu',
                        'title' => 'الدراسة في إيطاليا & منح DSU الشاملة',
                        'category' => 'italy',
                        'category_label' => 'الدراسة في إيطاليا والمنح',
                        'badge' => 'منحة 8,000€ + سكن مجاني',
                        'badge_class' => 'bg-amber-50 text-amber-900 border-amber-300',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>',
                        'level' => 'ثانوية عامة + دبلومات فنية (صنايع / تجارة / زراعة)',
                        'duration' => 'التقديم متاح للموسم القادم',
                        'mode' => 'إشراف متكامل من الألف للياء',
                        'target' => 'حملة الدبلومات الفنية والثانوية والجامعيين',
                        'salary' => 'عمل قانوني 20 ساعة/أسبوع باليورو',
                        'summary' => 'بوابتك المعتمدة لاستكمال دراستك في أعرق الجامعات الإيطالية والحصول على منحة DSU الشاملة وتصريح عمل رسمي.',
                        'points' => [
                            'قبول جامعي ومدرسي معتمد لحملة الدبلومات الفنية والثانوية العامة والأزهرية',
                            'تجهيز كامل لملف منحة DSU الحكومية (8,000 يورو سنوياً + سكن مجاني معفى)',
                            'إنهاء ترجمة وتصديق كافة المستندات لدى السفارة الإيطالية والجهات الرسمية',
                            'استقبال بالمطار وتسليم السكن واستخراج الإقامة والحساب البنكي بإيطاليا'
                        ],
                        'full_desc' => 'برنامج متكامل لتأهيل الطلاب وحملة الدبلومات الفنية (صنايع، تجارة، زراعة) والثانوية العامة والأزهرية لاستكمال دراستهم في إيطاليا، مع الحصول على منحة DSU الحكومية التي تمنحك 8,000 يورو سنوياً معفاة، وسكن جامعي مجاني، وتصريح عمل رسمي باليورو وفق القوانين الإيطالية.'
                    ],
                    [
                        'id' => 'translation',
                        'title' => 'احتراف الترجمة',
                        'category' => 'translation',
                        'category_label' => 'الترجمة والاعتماد',
                        'badge' => 'تأهيل للعمل الحر',
                        'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>',
                        'level' => 'من المبتدئ حتى الاحتراف والعمل الحر',
                        'duration' => 'ورش عمل ومشاريع تطبيقية',
                        'mode' => 'مشاريع عملية حقيقية',
                        'target' => 'خريجو كليات اللغات والآداب والمترجمون المستقلون',
                        'salary' => 'عائد مميز بالدولار واليورو عبر منصات الفريلانس',
                        'summary' => 'برنامج تدريبي لتعلم الترجمة باحتراف، مع تطبيقات عملية على النصوص المختلفة وتأهيلك للعمل في المجال بثقة.',
                        'points' => [
                            'تدريب تطبيقي على الترجمة التحريرية والفورية في المجالات القانونية والطبية والتقنية',
                            'إتقان أدوات الترجمة بمساعدة الحاسوب (CAT Tools) ومعايير الجودة العالمية',
                            'تأهيل مباشر لدخول منصات العمل الحر (Freelancing) ووكالات الترجمة الدولية',
                            'بناء بورتفوليو مهني وسيرة ذاتية قوية تجذب العملاء والشركات'
                        ],
                        'full_desc' => 'برنامج تدريبي لتعلم الترجمة باحتراف، مع تطبيقات عملية على النصوص المختلفة وتأهيلك للعمل في المجال بثقة. يشمل التعامل مع الوثائق الرسمية والتقنية وبناء سيرة ذاتية وبورتفوليو قوي يجذب العملاء الدوليين.'
                    ],
                    [
                        'id' => 'certified-translation',
                        'title' => 'ترجمة معتمدة احترافية',
                        'category' => 'translation',
                        'category_label' => 'الترجمة والاعتماد',
                        'badge' => 'معتمدة رسمياً للسفارات',
                        'badge_class' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                        'level' => 'توثيق وتصديق قانوني وقنصلي',
                        'duration' => 'تسليم سريع (24-48 ساعة)',
                        'mode' => 'معتمدة ومختومة رسمياً',
                        'target' => 'المسافرون للعمل والدراسة والشركات',
                        'salary' => 'قبول رسمي 100% دون أي مخاطرة بالرفض',
                        'summary' => 'خدمة ترجمة معتمدة لجميع المستندات بدقة عالية وسرعة تنفيذ، مع توثيق رسمي معترف به للجهات الحكومية والسفارات.',
                        'points' => [
                            'ترجمة معتمدة وموثقة لجميع المستندات الشخصية، شهادات التخرج، وإعلانات القيمة',
                            'معترف بها رسمياً لدى السفارة الإيطالية وكافة السفارات والجهات الحكومية',
                            'دقة لغوية وقانونية متناهية مع خيارات تسليم فوري للملفات المستعجلة',
                            'إنهاء التصديقات والمعاملات الحكومية اللازمة لسفرك'
                        ],
                        'full_desc' => 'خدمة ترجمة معتمدة لجميع المستندات بدقة عالية وسرعة تنفيذ، مع توثيق رسمي معترف به للجهات الحكومية والسفارات. تشمل ترجمة الأوراق الدراسية وشهادات الميلاد وعقود العمل والملفات القانونية.'
                    ],
                    [
                        'id' => 'ielts-toefl',
                        'title' => 'التأهيل للاختبارات الدولية',
                        'category' => 'languages',
                        'category_label' => 'اللغات والاختبارات',
                        'badge' => 'ضمان اجتياز الاختبار',
                        'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>',
                        'level' => 'إعداد معتمد رسمي (IELTS / TOEFL / CILS / CELI)',
                        'duration' => 'خطط مكثفة بحسب المستوى',
                        'mode' => 'مجموعات صغيرة + متابعة فردية',
                        'target' => 'المتقدمون للمنح والجامعات والسفر بالخارج',
                        'salary' => 'تحقيق السكور المطلوب للقبول الجامعي والهجرة',
                        'summary' => 'برامج تدريبية متخصصة لإعدادك لاجتياز الاختبارات الدولية مثل IELTS وTOEFL، مع تدريب عملي على جميع المهارات.',
                        'points' => [
                            'استراتيجيات متقدمة لاجتياز اختبارات IELTS & TOEFL واختبارات الإيطالي (CILS/CELI)',
                            'تدريب مكثف على مهارات التحدث، الاستماع، القراءة، والكتابة الأكاديمية',
                            'اختبارات تجريبية تحاكي الاختبار الحقيقي بنسبة 100% مع تقييم دقيق لنقاط القوة',
                            'متابعة دورية لتطوير جوانب القصور وضمان السكور المطلوب'
                        ],
                        'full_desc' => 'برامج تدريبية متخصصة لإعدادك لاجتياز الاختبارات الدولية مثل IELTS وTOEFL، مع تدريب عملي على جميع المهارات ومراجعات مستمرة تضمن لك تحقيق الدرجة المطلوبة في وقت قياسي.'
                    ],
                    [
                        'id' => 'tot-instructors',
                        'title' => 'إعداد محاضري اللغات',
                        'category' => 'languages',
                        'category_label' => 'اللغات وتأهيل المحاضرين',
                        'badge' => 'برنامج مدرب معتمد (TOT)',
                        'badge_class' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                        'level' => 'دبلومة مهنية متقدمة في تدريس اللغات',
                        'duration' => 'تدريب تدريسي تطبيقي مكثف',
                        'mode' => 'محاكاة تدريس حي بقاعات ذكية',
                        'target' => 'المعلمون والمدربون وخريجو اللغات والتربية',
                        'salary' => 'عقود عمل بمدارس دولية وأكاديميات كبرى',
                        'summary' => 'برنامج متخصص لإعداد مدربي اللغات بمهارات التدريس والتواصل، مع تطبيق عملي يؤهلك للعمل بثقة.',
                        'points' => [
                            'أحدث استراتيجيات التدريس التفاعلي وتقنيات إدارة القاعات والمناهج الذكية',
                            'تطوير مهارات الإلقاء والشرح الإبداعي وبناء الأنشطة التعليمية الحديثة',
                            'تطبيقات تدريس حية ومباشرة تؤهلك للتعاقد مع كبرى الأكاديميات والمدارس الدولية',
                            'شهادة مدرب معتمد تؤهلك لتقديم الكورسات التدريبية باحتراف'
                        ],
                        'full_desc' => 'برنامج متخصص لإعداد مدربي اللغات بمهارات التدريس والتواصل، مع تطبيق عملي يؤهلك للعمل بثقة. يركز على علم التدريس الحديث وإدارة سلوك المتعلمين واستخدام الأدوات الرقمية في الشرح.'
                    ],
                    [
                        'id' => 'proofreading',
                        'title' => 'التدقيق اللغوي الاحترافي',
                        'category' => 'translation',
                        'category_label' => 'الترجمة والتدقيق',
                        'badge' => 'سلامة لغوية 100%',
                        'badge_class' => 'bg-teal-50 text-teal-700 border-teal-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
                        'level' => 'مراجعة أكاديمية وأسلوبية دقيقة',
                        'duration' => 'مرن وسريع مع الحفاظ على الدقة',
                        'mode' => 'سرية تامة ومطابقة للمعايير',
                        'target' => 'الباحثون، الأكاديميون، والمؤلفون والشركات',
                        'salary' => 'اعتماد للأبحاث والرسائل العلمية للنشر الدولي',
                        'summary' => 'مراجعة لغوية دقيقة للنصوص مع تصحيح الأخطاء النحوية والإملائية وتحسين الصياغة لتظهر بشكل احترافي وواضح.',
                        'points' => [
                            'فحص دقيق لكافة الأخطاء النحوية والإملائية والأسلوبية وضبط علامات الترقيم',
                            'تحسين الصياغة البلاغية مع الحفاظ على روح النص والمعنى الأصلي للكاتب',
                            'مراجعة شاملة لرسائل الماجستير والدكتوراة، السير الذاتية، والمحتوى التسويقي',
                            'تقرير تدقيق تفصيلي بالتعديلات والتحسينات المقترحة'
                        ],
                        'full_desc' => 'مراجعة لغوية دقيقة للنصوص مع تصحيح الأخطاء النحوية والإملائية وتحسين الصياغة لتظهر بشكل احترافي وواضح. تشمل التدقيق الإملائي والنحوي والأسلوبي للأبحاث العلمية والكتب والمقالات.'
                    ],
                    [
                        'id' => 'language-courses',
                        'title' => 'دورات اللغات الاحترافية',
                        'category' => 'languages',
                        'category_label' => 'اللغات والاختبارات',
                        'badge' => 'من الصفر حتى الطلاقة',
                        'badge_class' => 'bg-rose-50 text-rose-700 border-rose-200',
                        'icon' => '<svg class="size-5 sm:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
                        'level' => 'إيطالي - إنجليزي - ألماني (مستويات A1 حتى C2)',
                        'duration' => 'مستويات تدريجية تفاعلية',
                        'mode' => 'تركيز 80% على المحادثة والاستماع',
                        'target' => 'المبتدئون وراغبو السفر والعمل بالخارج',
                        'salary' => 'طلاقة محادثة وثقة تامة في التحدث مع الأجانب',
                        'summary' => 'تعلم اللغات الأجنبية بطريقة حديثة وسهلة، من الصفر للاحتراف مع متابعة مستمرة لتحقيق الطلاقة بسرعة.',
                        'points' => [
                            'منهجية حديثة تركز على الطلاقة والمحادثة الحية وكسر حاجز الخوف من النطق',
                            'محادثات واقعية مع مدربين متخصصين تحاكي الحياة اليومية والعملية في أوروبا',
                            'متابعة دورية وتقييم مستمر لتحقيق المستوى المطلوب للقبول الجامعي وسوق العمل',
                            'تطبيق عملي من خلال مواقف وسيناريوهات تفاعلية يومية'
                        ],
                        'full_desc' => 'تعلم اللغات الأجنبية بطريقة حديثة وسهلة، من الصفر للاحتراف مع متابعة مستمرة لتحقيق الطلاقة بسرعة. دورات عملية في الإيطالية والإنجليزية والألمانية تمنحك الثقة الكاملة في التحدث والتواصل.'
                    ],
                ];

                $initialTrack = $trackItems[0];
            @endphp

            <!-- ==========================================================
                 INNOVATIVE INTERACTIVE SPLIT SHOWCASE (CONSOLED EXPERIENCE)
                 ========================================================== -->
            <div class="grid gap-6 lg:gap-8 lg:grid-cols-12 items-start w-full min-w-0 max-w-full" id="services-interactive-showcase">
                
                <!-- Left Column: The Interactive Track Rail (Selector) -->
                <div class="w-full min-w-0 max-w-full lg:col-span-5 xl:col-span-4 space-y-2 reveal-left" id="track-rail-container">
                    <div class="mb-2 px-1 flex items-center justify-between text-xs font-black text-slate-500 uppercase tracking-wider">
                        <span class="flex items-center gap-1.5">
                            <span>المسارات المعتمدة:</span>
                            <span class="text-[10px] text-slate-400 font-normal lg:hidden">(اسحب لاختيار المسار ↔)</span>
                        </span>
                        <span class="text-red-600 font-mono text-xs font-black">8 مسارات</span>
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
                                <svg class="size-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>معتمد رسمياً في INTOK</span>
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
                                <span>أبرز مخرجات ومميزات هذا المسار:</span>
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
                                    <span class="block text-[10px] text-slate-500 font-bold">المدة والجدول</span>
                                    <span id="stage-duration" class="font-black text-slate-900 block truncate">{{ $initialTrack['duration'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 min-w-0 border-t sm:border-t-0 sm:border-r sm:pr-3 border-slate-200/80 pt-2 sm:pt-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-amber-600 shadow-2xs font-bold text-xs">🏛</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">نظام الحضور</span>
                                    <span id="stage-mode" class="font-black text-slate-900 block truncate">{{ $initialTrack['mode'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 min-w-0 border-t sm:border-t-0 sm:border-r sm:pr-3 border-slate-200/80 pt-2 sm:pt-0">
                                <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-white border border-slate-200 text-blue-600 shadow-2xs font-bold text-xs">🎯</span>
                                <div class="min-w-0">
                                    <span class="block text-[10px] text-slate-500 font-bold">الفئة المستهدفة</span>
                                    <span id="stage-target" class="font-black text-slate-900 block truncate" title="{{ $initialTrack['target'] }}">{{ $initialTrack['target'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2 w-full min-w-0">
                            <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 flex-1">
                                <a id="stage-cta-btn" href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary w-full sm:w-auto px-6 py-3.5 text-center text-xs sm:text-sm font-black shadow-md flex items-center justify-center gap-2">
                                    <span>احجز مقعدك في هذا المسار</span>
                                    <span>←</span>
                                </a>
                                <a id="stage-whatsapp-btn" href="https://wa.me/201008238323?text={{ urlencode('مرحباً، أود الاستفسار والتسجيل في برنامج: ' . $initialTrack['title']) }}" target="_blank" class="w-full sm:w-auto px-5 py-3.5 rounded-full border-2 border-emerald-500 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white font-black text-xs sm:text-sm transition shadow-xs flex items-center justify-center gap-2">
                                    <svg class="size-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    <span>واتساب مباشر (24/7)</span>
                                </a>
                            </div>
                            <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="text-xs font-bold text-slate-500 hover:text-red-600 transition flex items-center justify-center gap-1 shrink-0 py-2">
                                <span>جميع الخدمات والمسارات</span>
                                <span>&larr;</span>
                            </a>
                        </div>

                        <!-- Mobile Quick Switcher Bar (Visible on < lg) -->
                        <div class="lg:hidden flex items-center justify-between pt-3 mt-4 border-t border-slate-100 text-xs font-bold text-slate-500 w-full min-w-0">
                            <button type="button" id="stage-prev-btn" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition active:scale-95 text-xs font-black">
                                <span>← المسار السابق</span>
                            </button>
                            <span id="stage-track-counter" class="text-xs font-mono text-slate-500 font-bold">1 / 8</span>
                            <button type="button" id="stage-next-btn" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition active:scale-95 text-xs font-black">
                                <span>المسار التالي →</span>
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
                    <span>{{ data_get($siteSettings ?? [], 'live_slider_badge.'.$locale, 'نبض التدريب والمحاضرات الحية في الأكاديمية') }}</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ data_get($siteSettings ?? [], 'live_slider_title.'.$locale, 'شاهد تجربة التعليم الواقعية في INTOK ACADEMY') }}
                </h2>
                <p class="mt-3 text-base text-slate-600 font-medium">
                    {{ data_get($siteSettings ?? [], 'live_slider_subtitle.'.$locale, 'لقطات حية من داخل قاعاتنا: تدريب الكول سنتر والمحادثة على الشاشات الذكية، ومحاضرات اللغة الإيطالية والترجمة المعتمدة.') }}
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
                                تدريب الكول سنتر والمحادثة المباشرة
                            </span>
                            <h3 id="shatter-slide-title" class="mt-3 text-xl sm:text-3xl font-black text-white tracking-tight drop-shadow-md transition-opacity duration-300">
                                How to Be a Confident Speaker - محاكاة المقابلات الدولية والطلاقة
                            </h3>
                            <p id="shatter-slide-desc" class="mt-2 text-xs sm:text-sm text-slate-200 line-clamp-2 font-medium leading-relaxed drop-shadow transition-opacity duration-300">
                                تدريب تفاعلي على الشاشات الذكية لتأهيل المتدربين لخدمة العملاء واجتياز مقابلات شركات الكول سنتر متعددة الجنسيات بثقة.
                            </p>
                        </div>

                        <!-- Right: Quick Action & Counter -->
                        <div class="flex items-center gap-4 shrink-0">
                            <span id="shatter-counter" class="text-sm font-black text-white font-mono tracking-widest bg-black/40 px-3 py-1.5 rounded-xl border border-white/20">
                                01 / 03
                            </span>
                            <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="rounded-full bg-white px-5 py-2.5 text-xs font-black text-[#fe0002] shadow-lg transition hover:bg-amber-100 hover:scale-105">
                                انضم للدفعة القادمة
                            </a>
                        </div>
                    </div>

                    <!-- Slide Progress Bar (5s filling) -->
                    <div class="absolute bottom-0 inset-x-0 h-1.5 bg-white/20 z-40">
                        <div id="shatter-progress-fill" class="h-full bg-[#fe0002] w-0"></div>
                    </div>

                    <!-- Left / Right Nav Arrows -->
                    <button type="button" id="shatter-prev-btn" aria-label="الصورة السابقة" class="absolute start-4 top-1/2 -translate-y-1/2 z-40 size-11 rounded-full bg-black/40 border border-white/20 text-white flex items-center justify-center text-xl font-bold backdrop-blur-md transition hover:bg-[#fe0002] hover:scale-110 shadow-lg cursor-pointer">
                        ‹
                    </button>
                    <button type="button" id="shatter-next-btn" aria-label="الصورة التالية" class="absolute end-4 top-1/2 -translate-y-1/2 z-40 size-11 rounded-full bg-black/40 border border-white/20 text-white flex items-center justify-center text-xl font-bold backdrop-blur-md transition hover:bg-[#fe0002] hover:scale-110 shadow-lg cursor-pointer">
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
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-700 mb-1.5">{{ data_get($siteSettings ?? [], 'finder_step1_label.'.$locale, '1. مسارك التعليمي الحالي') }}</label>
                    <select id="finder-track" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <option value="diploma">دبلوم فني (صنايع / تجارة / زراعة)</option>
                        <option value="highschool">ثانوية عامة / لغات / أزهرية</option>
                        <option value="grad">خريج جامعي (ماجستير / عمل باليورو)</option>
                        <option value="languages">باحث عن تدريب كول سنتر ولغات</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-700 mb-1.5">{{ data_get($siteSettings ?? [], 'finder_step2_label.'.$locale, '2. هدفك المنشود') }}</label>
                    <select id="finder-goal" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <option value="italy-study">دراسة جامعية بإيطاليا + منحة DSU</option>
                        <option value="callcenter">العمل في الكول سنتر الدولي</option>
                        <option value="translation">احتراف وترجمة معتمدة للسفارات</option>
                        <option value="ielts">اجتياز اختبارات IELTS & TOEFL</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-700 mb-1.5">{{ data_get($siteSettings ?? [], 'finder_step3_label.'.$locale, '3. موسم الالتحاق') }}</label>
                    <select id="finder-intake" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        <option value="fast">أقرب دفعة تدريبية / تقديم متاح</option>
                        <option value="fall-2026">الفصل الدراسي الأول (أكتوبر 2026)</option>
                        <option value="spring-2027">الفصل الدراسي الثاني (فبراير 2027)</option>
                    </select>
                </div>

                <div class="sm:col-span-2 lg:col-span-1 pt-1 sm:pt-0">
                    <label class="hidden lg:block text-[11px] font-bold text-transparent mb-1.5">إجراء</label>
                    <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary flex w-full items-center justify-center gap-2 py-3 text-xs font-black shadow-xs">
                        <span>{{ data_get($siteSettings ?? [], 'finder_btn_text.'.$locale, 'فحص شروط القبول والمنحة') }}</span>
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
                    <span>{{ data_get($siteSettings ?? [], 'why_badge.'.$locale, 'معايير الثقة والريادة الدولية') }}</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
                    {{ data_get($siteSettings ?? [], 'why_title.'.$locale, 'لماذا تختار أكاديمية إنتوك؟') }}
                </h2>
                <p class="mt-4 text-base text-slate-600 font-medium leading-relaxed">
                    {{ data_get($siteSettings ?? [], 'why_subtitle.'.$locale, 'منظومة متكاملة لا تكتفي بتقديم الكورسات أو الترجمة، بل تصنع معك مستقبلاً حقيقياً بالدراسة في إيطاليا والعمل في كبرى الشركات العالمية بأعلى عائد.') }}
                </p>
            </div>

            @php
                $whyPillars = [
                    [
                        'id' => 'dsu',
                        'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>',
                        'nav_title' => 'منحة DSU والسكن',
                        'nav_sub' => '8,000€ + سكن مجاني',
                        'badge' => 'منحة إقليمية حكومية',
                        'badge_color' => 'bg-red-50 text-[#fe0002] border-red-200',
                        'title' => data_get($siteSettings ?? [], 'why_bento_dsu_title.'.$locale, 'أعلى نسبة قبول لمنح DSU الحكومية الإيطالية'),
                        'desc' => data_get($siteSettings ?? [], 'why_bento_dsu_desc.'.$locale, 'نضمن لك حساب مؤشر ISEE بدقة هندسية وقانونية لضمان استيفاء شروط المنحة الإقليمية وسكن جامعي معفى تماماً، مع فتح الباب لحملة الدبلومات الفنية (صنايع / تجارة / زراعة) والثانوية العامة والجامعيين.'),
                        'stat_val' => '8,000€',
                        'stat_unit' => 'سنوياً',
                        'stat_label' => 'بدل نقدي مباشر لحساب الطالب',
                        'stat_sub' => 'إعفاء 100% من المصروفات + سكن مجاني',
                        'points' => [
                            'حساب دقيق لمؤشر ISEE Parificato وفق المعايير الرسمية للمنحة الإقليمية',
                            'إعفاء كامل 100% من الرسوم والمصروفات الدراسية الجامعية في إيطاليا',
                            'تأمين سكن جامعي مجاني ومجهز طوال فترة سنوات دراستك',
                            'وجبات غذائية مدعومة بمطاعم الجامعات الإيطالية يومياً',
                            'حق العمل القانوني للطلاب 20 ساعة أسبوعياً باليورو'
                        ],
                        'vs_traditional' => [
                            'traditional' => 'إهمال المنحة وتوريط الطالب بمصروفات دراسية باهظة بدون سكن أو دعم نقدي',
                            'intok' => 'ملف منحة متكامل بدقة 100% يضمن لك أعلى فرصة للحصول على الـ 8,000 يورو والسكن'
                        ],
                        'cta_text' => 'افحص فرصة حصولك على منحة DSU',
                        'cta_url' => route('consultation.create', ['locale' => $locale]),
                        'wa_msg' => 'مرحباً، أود الاستفسار عن تفاصيل منحة DSU الإيطالية وشروط القبول والسكن المجاني'
                    ],
                    [
                        'id' => 'callcenter',
                        'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>',
                        'nav_title' => 'الكول سنتر والتوظيف',
                        'nav_sub' => 'رواتب 15k - 30k+ ج.م',
                        'badge' => 'تأهيل وظيفي فوري',
                        'badge_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'title' => data_get($siteSettings ?? [], 'why_bento_callcenter_title.'.$locale, 'تأهيل وظيفي فوري لكبرى شركات الكول سنتر'),
                        'desc' => data_get($siteSettings ?? [], 'why_bento_callcenter_desc.'.$locale, 'تدريب تطبيقي على الشاشات الذكية ومحاكاة لمقابلات شركات متعددة الجنسيات (Vodafone UK, Concentrix, Teleperformance) يؤهلك للعمل المباشر.'),
                        'stat_val' => '15k - 30k+',
                        'stat_unit' => 'ج.م / شهرياً',
                        'stat_label' => 'متوسط الراتب لحديثي التخرج والخريجين',
                        'stat_sub' => 'فرص عمل فوري بكبرى الشركات الدولية',
                        'points' => [
                            'تدريب عملي ومحاكاة لمكالمات وأنظمة خدمة العملاء والدعم الفني الحقيقية',
                            'محاكاة لأسئلة واختبارات الـ HR والـ Operations في الشركات متعددة الجنسيات',
                            'إتقان اللهجة ونبرة الصوت المناسبة لمختلف أسواق العمل الدولية',
                            'ورش مكثفة لاجتياز المقابلات الشخصية بنجاح من المقابلة الأولى',
                            'ترشيح مباشر وتوصية للتوظيف لدى شبكة شركائنا بعد التخرج'
                        ],
                        'vs_traditional' => [
                            'traditional' => 'كورسات نظرية عامة بدون شاشات تفاعلية أو محاكاة حقيقية وبلا أي فرص توظيف',
                            'intok' => 'محاكاة واقعية 100% تؤهلك لاجتياز مقابلات الشركات العالمية فور التخرج'
                        ],
                        'cta_text' => 'سجل في تدريب الكول سنتر المباشر',
                        'cta_url' => route('consultation.create', ['locale' => $locale]),
                        'wa_msg' => 'مرحباً، أود الاستفسار عن كورس تدريب الكول سنتر وفرص التوظيف المتاحة'
                    ],
                    [
                        'id' => 'translation',
                        'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                        'nav_title' => 'الترجمة المعتمدة',
                        'nav_sub' => 'معتمدة قنصلياً 100%',
                        'badge' => 'توثيق رسمي للسفارات',
                        'badge_color' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'title' => data_get($siteSettings ?? [], 'why_bento_trans_title.'.$locale, 'ترجمة معتمدة رسمياً وموثقة لجميع السفارات'),
                        'desc' => data_get($siteSettings ?? [], 'why_bento_trans_desc.'.$locale, 'ترجمة رسمية معترف بها أمام القنصلية الإيطالية وكافة السفارات الأوروبية، لشهادات التخرج، إعلانات القيمة، وعقود العمل دون مخاطرة بالرفض.'),
                        'stat_val' => '24 - 48h',
                        'stat_unit' => 'تسليم مستعجل',
                        'stat_label' => 'سرعة إنجاز وتوثيق الملفات الرسمية',
                        'stat_sub' => 'دقة قانونية متناهية بدون أخطاء ترفض ملفك',
                        'points' => [
                            'ترجمة معتمدة ومقبولة لدى القنصلية الإيطالية بالقاهرة والإسكندرية',
                            'ترجمة إعلان القيمة (Dichiarazione di Valore) وبيانات الدرجات والمقررات',
                            'إنهاء تصديقات الخارجية المصرية ونقابة المترجمين والغرفة التجارية',
                            'تدقيق لغوي وقانوني مزدوج لضمان خلو الأوراق من أي ثغرات قنصلية',
                            'توصيل فوري لجميع محافظات مصر مع إمكانية المعاينة الرقمية'
                        ],
                        'vs_traditional' => [
                            'traditional' => 'ترجمات غير معتمدة أو مليئة بالأخطاء تؤدي لرفض التأشيرة وإضاعة المواعيد',
                            'intok' => 'اعتماد قنصلي رسمي 100% يضمن قبول أوراقك في السفارة من المرة الأولى'
                        ],
                        'cta_text' => 'اطلب ترجمتك المعتمدة فوراً',
                        'cta_url' => route('contact', ['locale' => $locale]),
                        'wa_msg' => 'مرحباً، أود الاستفسار عن خدمة الترجمة المعتمدة للأوراق الرسمية وتصديقات السفارة'
                    ],
                    [
                        'id' => 'reception',
                        'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>',
                        'nav_title' => 'الاستقبال بإيطاليا',
                        'nav_sub' => 'ميلانو وروما وتسكين مباشر',
                        'badge' => 'مرافقة ميدانية بأوروبا',
                        'badge_color' => 'bg-red-50 text-[#fe0002] border-red-200',
                        'title' => data_get($siteSettings ?? [], 'why_bento_reception_title.'.$locale, 'استقبال في المطار وتسليم السكن بإيطاليا'),
                        'desc' => data_get($siteSettings ?? [], 'why_bento_reception_desc.'.$locale, 'رحلتك معنا لا تنتهي عند باب المطار؛ بل يستقبلك فريقنا الميداني في ميلانو وروما لتسليم السكن، واستخراج الإقامة والحساب البنكي.'),
                        'stat_val' => '100%',
                        'stat_unit' => 'أمان ورعاية',
                        'stat_label' => 'مرافقة ميدانية من لحظة الهبوط بالمطار',
                        'stat_sub' => 'فريق ميداني رسمي يتحدث العربية والإيطالية',
                        'points' => [
                            'استقبالك بالاسم في صالة الوصول بمطارات ميلانو (Malpensa) وروما (Fiumicino)',
                            'توصيلك مباشرة إلى مقر إقامتك وتسليمك مفاتيح السكن الجامعي أو الخاص',
                            'مرافقة لتقديم أوراق تصريح الإقامة (Permesso di Soggiorno) بالبريد والشرطة',
                            'استخراج الرقم الضريبي الإيطالي (Codice Fiscale) وشراء شريحة اتصال إيطالية',
                            'مساعدتك في فتح حساب بنكي إيطالي وتوجيهك لفرص العمل والأنشطة الطلابية'
                        ],
                        'vs_traditional' => [
                            'traditional' => 'ينتهي دور المكتب بمجرد السفر ويُترك الطالب وحيداً وتائهاً في المطار والغربة',
                            'intok' => 'فريقنا الميداني في إيطاليا يستقبلك ويلازمك حتى تستقر في سكنك وتنهي أوراقك'
                        ],
                        'cta_text' => 'احجز باقة الاستقبال والمرافقة بإيطاليا',
                        'cta_url' => route('consultation.create', ['locale' => $locale]),
                        'wa_msg' => 'مرحباً، أود الاستفسار عن خدمات الاستقبال في المطار والتسكين في إيطاليا'
                    ],
                    [
                        'id' => 'languages',
                        'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
                        'nav_title' => 'إتقان اللغات وCILS',
                        'nav_sub' => 'من الصفر حتى الطلاقة التامة',
                        'badge' => 'شهادات دولية معتمدة',
                        'badge_color' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'title' => data_get($siteSettings ?? [], 'why_bento_languages_title.'.$locale, 'إتقان اللغات من الصفر واجتياز CILS & IELTS'),
                        'desc' => data_get($siteSettings ?? [], 'why_bento_languages_desc.'.$locale, 'دورات مكثفة في الإيطالية والإنجليزية والألمانية تركز 80% على المحادثة والطلاقة الواقعية، وتؤهلك لاجتياز امتحانات السفارات والجامعات.'),
                        'stat_val' => '80%',
                        'stat_unit' => 'محادثة وتطبيق',
                        'stat_label' => 'نسبة التركيز على التحدث والطلاقة العملية',
                        'stat_sub' => 'كسر حاجز الخوف والحديث بطلاقة خلال أسابيع',
                        'points' => [
                            'مناهج أوروبية معتمدة ومطابقة للإطار المرجعي الأوروبي للغات (CEFR)',
                            'تدريب مكثف على نماذج اختبارات اللغة الإيطالية الرسمية (CILS, CELI, PLIDA)',
                            'دورات متخصصة لاجتياز اختبارات الآيلتس (IELTS) والتوفل (TOEFL) الدولية',
                            'محاضرون خبراء معتمدون وناطقون أصليون يتابعون مستواك يومياً',
                            'شهادات تخرج معتمدة توثق مستواك اللغوي وتؤهلك للجامعات وسوق العمل'
                        ],
                        'vs_traditional' => [
                            'traditional' => 'طرق تدريس قديمة تعتمد على الحفظ الصم دون إتاحة الفرصة لممارسة المحادثة',
                            'intok' => 'منهج تفاعلي يركز 80% على المحادثة المباشرة ويكسر حاجز الرهبة تماماً'
                        ],
                        'cta_text' => 'ابدأ كورس اللغة وتحديد المستوى',
                        'cta_url' => route('consultation.create', ['locale' => $locale]),
                        'wa_msg' => 'مرحباً، أود الاستفسار عن دورات اللغات (إيطالي / إنجليزي / ألماني) وتأهيل CILS'
                    ],
                    [
                        'id' => 'mentorship',
                        'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                        'nav_title' => 'الإرشاد والمتابعة 24/7',
                        'nav_sub' => 'مستشار أكاديمي شخصي مخصص',
                        'badge' => 'متابعة مستمرة ودقيقة',
                        'badge_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'title' => data_get($siteSettings ?? [], 'why_bento_mentorship_title.'.$locale, 'إرشاد شخصي 1-on-1 ومتابعة مستمرة'),
                        'desc' => data_get($siteSettings ?? [], 'why_bento_mentorship_desc.'.$locale, 'مستشار أكاديمي مخصص يدرس ملفك ويضع خطتك المناسبة، مع نظام تنبيهات لمواعيد المنح والتقديمات لضمان عدم فوات أي موعد رسمي.'),
                        'stat_val' => '24/7',
                        'stat_unit' => 'دعم متواصل',
                        'stat_label' => 'مستشارك الأكاديمي بجانبك طوال رحلتك',
                        'stat_sub' => 'متابعة دقيقة لكل خطوة وموعد تقديم رسمي',
                        'points' => [
                            'جلسة استشارة فردية 1-on-1 لتحليل مؤهلك (دبلوم فني، ثانوية، بكالوريوس) واختيار أفضل طريق',
                            'خطة زمنية مدروسة تضمن استيفاء كافة الأوراق والمواعيد قبل إغلاق باب التقديم',
                            'مراجعة وتدقيق شامل لملفك الدراسي لمنع أي خطأ قد يؤدي للرفض',
                            'تذكير دوري بمواعيد المقابلات والمنح والتصديقات خطوة بخطوة',
                            'دعم متواصل عبر الواتساب والمكالمات والاجتماعات الافتراضية طوال فترة التقديم'
                        ],
                        'vs_traditional' => [
                            'traditional' => 'إهمال استفسارات الطلاب والتأخر في الرد وضياع المواعيد الرسمية للمنح',
                            'intok' => 'مستشار أكاديمي ملازم لك يومياً ومتابعة دقيقة تضمن عدم تفويت أي فرصة'
                        ],
                        'cta_text' => 'احجز استشارتك الأكاديمية الآن',
                        'cta_url' => route('consultation.create', ['locale' => $locale]),
                        'wa_msg' => 'مرحباً، أود حجز جلسة استشارة أكاديمية شخصية 1-on-1 لتحديد مساري الأنسب'
                    ]
                ];
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
                                    <span>معيار تميز رسمي</span>
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
                                    <span>استفسار فوري عبر واتساب</span>
                                </a>
                            </div>

                        </div>

                        <!-- Right Column: Interactive Reality Check HUD (5 Cols) -->
                        <div class="lg:col-span-5 space-y-5">
                            
                            <!-- Stat Card with Big Number -->
                            <div class="rounded-3xl bg-gradient-to-br from-red-50/60 via-amber-50/40 to-white border-2 border-red-200 p-6 text-center shadow-md relative overflow-hidden">
                                <div class="relative z-10">
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-1">القيمة المحققة لك:</span>
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
                                        <span>مقارنة صريحة بالواقع</span>
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400">لماذا إنتوك أفضل؟</span>
                                </div>

                                <!-- The Traditional Downside -->
                                <div class="rounded-2xl bg-red-950/40 border border-red-800/40 p-3.5 flex items-start gap-3">
                                    <span class="grid size-6 shrink-0 place-items-center rounded-full bg-red-900/80 text-red-300 mt-0.5">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </span>
                                    <div>
                                        <span class="text-[11px] font-black text-red-400 block mb-0.5">الطرق والمكاتب التقليدية:</span>
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
                                        <span class="text-[11px] font-black text-emerald-400 block mb-0.5">معيار أكاديمية INTOK:</span>
                                        <p id="why-vs-intok" class="text-xs text-slate-200 font-semibold leading-snug">
                                            {{ $initialPillar['vs_traditional']['intok'] }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Trust Footer -->
                                <div class="pt-1 flex items-center justify-between text-[10px] font-bold text-slate-400">
                                    <span>اعتماد رسمي موثق</span>
                                    <span class="text-amber-400">نسبة رضا 99.4% (تقييم 5 من 5)</span>
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
                                    جدول المقارنة المباشر: فارق المعايير بين INTOK ACADEMY والمكاتب العادية
                                </h4>
                                <p class="text-xs font-medium text-slate-500">
                                    اضغط لاستعراض المقارنة التفصيلية الكاملة في 5 مجالات أساسية
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
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">1. القبول والدراسة في إيطاليا</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">وعود غير موثقة، نسب رفض عالية بالتأشيرة، عدم قبول الدبلومات الفنية.</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">قبول جامعي موثق، فتح الباب للدبلومات الفنية والثانوية، نسبة قبول استثنائية.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">2. منحة DSU والسكن المجاني</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">تجاهل المنحة تماماً وترك الطالب يدفع آلاف اليوروهات سنوياً بلا سكن.</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">حساب دقيق لـ ISEE يضمن إعفاء 100% من المصروفات وسكن مجاني وبدل 8,000€.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">3. التدريب وتوظيف الكول سنتر</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">دورات نظرية تقليدية بدون ممارسة أو شاشات تفاعلية وبلا أي متابعة توظيف.</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">تدريب عملي على شاشات تفاعلية ومحاكاة لمقابلات الشركات العالمية وتوصية وظيفية فورية.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">4. الترجمة وتصديقات السفارات</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">ترجمات غير معتمدة أو مليئة بالأخطاء تتسبب في تعليق أو رفض الملف بالقنصلية.</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">ترجمة معتمدة رسمياً ومقبولة أمام القنصلية الإيطالية وكافة السفارات مع إنهاء التصديقات.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-black text-slate-900 bg-slate-50/40">5. الاستقبال والتسكين بإيطاليا</td>
                                        <td class="p-4 text-slate-600 bg-red-50/20">ينتهي دور المكتب بمجرد سفر الطالب، وتركه تائهاً في البحث عن سكن وإقامة.</td>
                                        <td class="p-4 font-bold text-slate-900 bg-emerald-50/30">استقبال شخصي بالمطار في ميلانو وروما، تسليم السكن، ومرافقة لاستخراج الإقامة والبنك.</td>
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
                            'title' => data_get($siteSettings ?? [], 'roadmap_step1_title.'.$locale, '1. جلسة الاستشارة والتقييم'),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step1_desc.'.$locale, 'جلسة إرشاد شاملة مع مستشارك لتحديد البرنامج أو المسار الإيطالي المناسب لمؤهلك.'),
                            'dir' => 'reveal-left stagger-1',
                            'pct' => 25
                        ],
                        [
                            'num' => '02',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step2_title.'.$locale, '2. تجهيز الأوراق والتدريب'),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step2_desc.'.$locale, 'ترجمة وتصديق كافة الشهادات والأوراق الرسمية والبدء في التدريب اللغوي أو العملي.'),
                            'dir' => 'reveal-up stagger-2',
                            'pct' => 50
                        ],
                        [
                            'num' => '03',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step3_title.'.$locale, '3. التقديم للمنح والقبول'),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step3_desc.'.$locale, 'إرسال طلبات الالتحاق بالجامعات أو التقدم للمنح والوظائف ومتابعة النتائج خطوة بخطوة.'),
                            'dir' => 'reveal-up stagger-3',
                            'pct' => 75
                        ],
                        [
                            'num' => '04',
                            'icon' => '<svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>',
                            'title' => data_get($siteSettings ?? [], 'roadmap_step4_title.'.$locale, '4. السفر والاستقبال والمتابعة'),
                            'desc' => data_get($siteSettings ?? [], 'roadmap_step4_desc.'.$locale, 'استلام التأشيرة الدراسية، تأمين السكن، والاستقبال في المطار لبدء مستقبلك الجديد.'),
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
         CALL TO ACTION BANNER (EXECUTIVE CONTRAST CARD)
         ========================================================== -->
    <section class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-r from-slate-950 via-slate-900 to-stone-900 p-8 sm:p-14 shadow-2xl text-white reveal-scale">
            <div class="relative z-10 flex flex-col items-center justify-between gap-8 text-center md:flex-row md:text-start">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full bg-red-500/20 border border-red-500/40 px-4 py-1 text-xs font-black text-red-300">
                        {{ data_get($siteSettings ?? [], 'cta_badge.'.$locale, 'ابدأ مستقبلك اليوم') }}
                    </span>
                    <h2 class="mt-4 text-2xl font-black text-white sm:text-4xl">
                        {{ data_get($siteSettings ?? [], 'cta_title.'.$locale, 'جاهز لبدء رحلتك نحو إيطاليا وأرقى الوظائف الدولية؟') }}
                    </h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-300">
                        {{ data_get($siteSettings ?? [], 'cta_subtitle.'.$locale, 'تواصل معنا الآن أو تابعنا عبر منصاتنا الرسمية على إنستغرام وتيك توك، ودع فريق INTOK Academy يرسم معك طريق النجاح.') }}
                    </p>
                    
                    <!-- Official Social Links -->
                    <div class="mt-4 flex flex-wrap items-center gap-3 justify-center md:justify-start">
                        <a href="https://www.instagram.com/intokacademy" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-white/20 px-3.5 py-1 text-xs font-bold text-white hover:bg-[#fe0002] hover:text-white transition">
                            <span>Instagram: @intokacademy</span>
                        </a>
                        <a href="https://tiktok.com/@intokacademy" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-white/20 px-3.5 py-1 text-xs font-bold text-white hover:bg-[#fe0002] hover:text-white transition">
                            <span>TikTok: @intokacademy</span>
                        </a>
                    </div>
                </div>
                
                <div class="shrink-0 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('consultation.create', ['locale' => app()->getLocale()]) }}" class="btn-intok-primary px-8 py-4 text-center text-sm font-black shadow-xl">
                        {{ data_get($siteSettings ?? [], 'cta_btn_primary.'.$locale, 'احجز استشارتك الآن') }}
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}" target="_blank" class="rounded-full border-2 border-white/40 bg-white/10 px-6 py-4 text-center text-sm font-black text-white backdrop-blur-md transition hover:bg-white hover:text-slate-900">
                        {{ data_get($siteSettings ?? [], 'cta_btn_secondary.'.$locale, 'واتساب: 01008238323') }}
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
            // 1. ACTIVE 60FPS CONSTELLATION CANVAS
            const canvas = document.getElementById('hero-interactive-canvas');
            if (canvas) {
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
            const heroStageData = [
                {
                    image: "{{ asset('assets/images/schools/san-giorgio.jpg') }}",
                    badge: "عاصمة الدراسة والصناعة • ميلانو",
                    title: "جامعات ومدارس ميلانو الحكومية",
                    desc: "استكمال دراستك في أعرق الصروح التعليمية مع منحة DSU الشاملة (8,000 يورو + سكن مجاني) وتأشيرة دراسية رسمية.",
                    stat: "8,000€ بدل سنوي + سكن مجاني"
                },
                {
                    image: "{{ asset('assets/images/schools/galileo-galilei.jpg') }}",
                    badge: "التاريخ والأكاديمية • روما",
                    title: "دراسة البكالوريوس والماجستير بروما",
                    desc: "الالتحاق بأعرق الجامعات والمدارس الإيطالية مع تصريح عمل قانوني باليورو وتأشيرة شنغن رسمية.",
                    stat: "99.4% نسبة نجاح وقبول الملفات"
                },
                {
                    image: "{{ asset('assets/images/academy/italian-classroom-lecture.jpg') }}",
                    badge: "قاعات إنتوك الذكية • تدريب حي",
                    title: "تعليم الإيطالية واللغات المعتمدة",
                    desc: "محاضرات تفاعلية على السبورات الذكية لتأسيس النطق وتأهيلك لاجتياز اختبارات CILS و CELI ومقابلات السفارة.",
                    stat: "CILS / CELI معتمد رسمياً"
                },
                {
                    image: "{{ asset('assets/images/academy/live-speaker-training.jpg') }}",
                    badge: "كول سنتر وسوق العمل الدولي",
                    title: "محاكاة المقابلات والطلاقة باللغات",
                    desc: "تدريب تطبيقي مكثف يجعلك واثقاً من مهاراتك الصوتية والتواصلية لاقتناص وظائف كبرى الشركات العالمية فوراً.",
                    stat: "رواتب 15k - 30k+ ج.م"
                }
            ];

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
            const slidesData = [
                {
                    image: "{{ asset('assets/images/academy/live-speaker-training.jpg') }}",
                    badge: "تدريب الكول سنتر والمحادثة المباشرة",
                    title: "How to Be a Confident Speaker - محاكاة المقابلات والطلاقة",
                    desc: "تدريب تفاعلي على الشاشات الذكية لتطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات الدولية بثقة."
                },
                {
                    image: "{{ asset('assets/images/academy/italian-classroom-lecture.jpg') }}",
                    badge: "محاضرات اللغة الإيطالية والقبول الجامعي",
                    title: "شرح تفاعلي لقواعد ومحادثة اللغة الإيطالية (Grammatica Italiana)",
                    desc: "تأسيس المتدربين من الصفر وحتى الطلاقة والتأهيل لاختبارات السفارة والالتحاق بالجامعات الإيطالية مع نخبة من الأساتذة."
                },
                {
                    image: "{{ asset('assets/images/schools/galileo-galilei.jpg') }}",
                    badge: "بوابتك نحو إيطاليا وأوروبا",
                    title: "من قاعات INTOK إلى أعرق الصروح التعليمية في روما وميلانو",
                    desc: "رحلة متكاملة تؤهلك للحصول على منحة DSU الشاملة (8,000 يورو سنوياً + سكن مجاني) والإقامة القانونية والعمل باليورو."
                }
            ];

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
                        box.innerHTML = `<div class="size-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5"><svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><span class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug break-words flex-1">${pt}</span>`;
                        stagePointsContainer.appendChild(box);
                    });
                }

                if (stageWhatsappBtn) {
                    const msg = encodeURIComponent(`مرحباً، أود الاستفسار والتسجيل في برنامج: ${trackData.title}`);
                    stageWhatsappBtn.href = `https://wa.me/201008238323?text=${msg}`;
                }
                if (stageCtaBtn) {
                    stageCtaBtn.href = `{{ route('consultation.create', ['locale' => app()->getLocale()]) }}?track=${encodeURIComponent(trackData.id || '')}`;
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
