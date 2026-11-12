@extends('public.layouts.app')

@php
    $locale = $locale ?? app()->getLocale();
    $pageTitle = $page->title[$locale] ?? $page->title['en'] ?? __('site.nav_about');
@endphp

@section('title', $page->seo_title[$locale] ?? $pageTitle)
@section('meta_description', $page->seo_description[$locale] ?? 'تعرف على INTOK ACADEMY: بوابتك للتعلم والتطور وبناء مستقبلك الأكاديمي والمهني.')

@section('content')
@php
    $locale = $locale ?? app()->getLocale();
@endphp
    <!-- ==========================================================
         1. HERO SECTION
         ========================================================== -->
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 sm:py-24 text-slate-900 border-b border-slate-100">
        <div class="animate-aurora-1 pointer-events-none absolute -top-24 start-10 -z-10 size-[32rem] rounded-full bg-red-500/10 blur-[110px]"></div>
        <div class="animate-aurora-2 pointer-events-none absolute top-1/4 end-10 -z-10 size-[30rem] rounded-full bg-amber-500/10 blur-[100px]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
            <div class="max-w-3xl reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white/90 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>INTOK ACADEMY • Connecting You to the World</span>
                </span>

                <h1 class="mt-5 text-3xl font-black leading-tight text-[#c27803] sm:text-5xl lg:text-6xl tracking-tight">
                    {{ data_get($siteSettings ?? [], 'about_hero_title.'.$locale, match($locale) {
                        'it' => 'INTOK ACADEMY – Ti apriamo nuove porte per apprendere e crescere',
                        'en' => 'INTOK ACADEMY – Opening New Doors to Learning & Growth',
                        default => 'INTOK ACADEMY – بنفتحلك أبواب جديدة للتعلم والتطور',
                    }) }}
                </h1>

                <p class="mt-4 text-base sm:text-lg leading-relaxed text-slate-700 font-medium">
                    {{ data_get($siteSettings ?? [], 'about_hero_p1.'.$locale, match($locale) {
                        'it' => 'Siamo un\'accademia specializzata in istruzione, formazione e qualificazione accademica e professionale: ti aiutiamo a sviluppare competenze, ampliare le tue opportunità e compiere passi ponderati verso il tuo futuro.',
                        'en' => 'We are an academy specialized in education, practical training, and academic & career qualification, helping you build high-demand skills, expand horizons, and take well-planned steps toward your future.',
                        default => 'إحنا أكاديمية متخصصة في التعليم والتدريب والتأهيل الأكاديمي والمهني، بنساعدك تطور مهاراتك، توسّع فرصك، وتاخد خطوات مدروسة نحو مستقبلك.',
                    }) }}
                </p>

                <p class="mt-2 text-sm sm:text-base leading-relaxed text-slate-600">
                    {{ data_get($siteSettings ?? [], 'about_hero_p2.'.$locale, match($locale) {
                        'it' => 'Dall\'apprendimento linguistico e traduzioni asseverate alla formazione professionale, servizi accademici e studi all\'estero: offriamo soluzioni variegate su misura per le tue ambizioni.',
                        'en' => 'From language learning and certified translation to career training, academic services, and studying abroad: we offer tailored solutions matching your ambitions.',
                        default => 'من تعلم اللغات والترجمة المعتمدة، إلى التدريب المهني والخدمات الأكاديمية والدراسة بالخارج؛ بنقدم حلول متنوعة تناسب طموحاتك واحتياجاتك.',
                    }) }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('services.index', ['locale' => $locale]) }}" class="btn-intok-primary px-7 py-3.5 text-xs sm:text-sm font-black shadow-md">
                        <span>{{ match($locale) { 'it' => 'Scopri i nostri servizi', 'en' => 'Explore Our Services', default => 'اكتشف خدماتنا' } }}</span>
                    </a>
                    <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 rounded-full border-2 border-slate-300 bg-white px-6 py-3.5 text-xs sm:text-sm font-black text-slate-700 hover:border-[#fe0002] hover:text-[#fe0002] transition shadow-xs">
                        <span>{{ match($locale) { 'it' => 'Prenota la tua consulenza', 'en' => 'Book Your Consultation', default => 'احجز استشارتك' } }}</span>
                        <span>&larr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         2. OUR STORY
         ========================================================== -->
    <section class="relative bg-white py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 items-center">
                <div class="lg:col-span-6 reveal-up">
                    <span class="text-xs font-black uppercase tracking-wider text-[#fe0002] block mb-2">{{ data_get($siteSettings ?? [], 'about_story_badge.'.$locale, match($locale) {
                        'it' => 'La Nostra Storia – Il Viaggio di INTOK',
                        'en' => 'Our Story – The Journey of INTOK',
                        default => 'قصتنا – حكاية INTOK',
                    }) }}</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-[#c27803] leading-tight">
                        {{ data_get($siteSettings ?? [], 'about_story_title.'.$locale, match($locale) {
                            'it' => 'Siamo partiti da un\'idea... per aprirti opportunità più grandi',
                            'en' => 'Started with an idea... to unlock greater opportunities for you',
                            default => 'بدأنا بفكرة.. وهدفنا نفتحلك فرص أكبر',
                        }) }}
                    </h2>
                    <p class="mt-4 text-sm sm:text-base leading-relaxed text-slate-700 font-medium">
                        {{ data_get($siteSettings ?? [], 'about_story_p1.'.$locale, match($locale) {
                            'it' => 'INTOK ACADEMY è nata con una visione chiara: la vera istruzione non è solo nozioni teoriche, ma un\'esperienza integrata che ti permette di crescere e prepararti a opportunità migliori.',
                            'en' => 'INTOK ACADEMY was established with a clear vision: genuine education is not mere information, but an integrated experience that helps you evolve and prepare for prime opportunities.',
                            default => 'اتأسست INTOK ACADEMY برؤية واضحة: إن التعليم الحقيقي مش مجرد معلومات بتتعلمها، لكنه تجربة متكاملة تساعدك تطور نفسك وتستعد لفرص أفضل.',
                        }) }}
                    </p>
                    <p class="mt-3 text-sm sm:text-base leading-relaxed text-slate-600">
                        {{ data_get($siteSettings ?? [], 'about_story_p2.'.$locale, match($locale) {
                            'it' => 'Da qui abbiamo iniziato a offrire un ventaglio di servizi educativi, linguistici e accademici, puntando sull\'applicazione practical, sul tutoraggio continuo e sull\'aiutare ciascuna persona a individuare la strada ideale per i propri obiettivi.',
                            'en' => 'Hence we began providing educational, vocational, and academic services with deep focus on hands-on application, constant follow-up, and tailoring pathways for each individual.',
                            default => 'ومن هنا بدأنا نقدم مجموعة متنوعة من الخدمات التعليمية والتدريبية والأكاديمية، مع الاهتمام بالتطبيق العملي، والمتابعة، ومساعدة كل شخص يحدد الطريق المناسب لأهدافه.',
                        }) }}
                    </p>
                    <p class="mt-3 text-sm sm:text-base leading-relaxed text-slate-600">
                        {{ data_get($siteSettings ?? [], 'about_story_p3.'.$locale, match($locale) {
                            'it' => 'Crediamo che ogni persona abbia un\'ambizione unica, ed è per questo che ci impegniamo a offrirle il supporto e i servizi necessari per compiere il prossimo passo con fiducia.',
                            'en' => 'We believe every individual possesses a unique ambition, and we strive to provide the specialized support that allows them to take the next leap confidently.',
                            default => 'بنؤمن إن لكل شخص طموح مختلف، وعشان كده بنسعى نوفرله الدعم والخدمات اللي تساعده ياخد خطوته الجاية بثقة.',
                        }) }}
                    </p>
                </div>
                <div class="lg:col-span-6 reveal-scale">
                    <div class="relative overflow-hidden rounded-3xl border-2 border-slate-200 shadow-xl bg-slate-900 group">
                        <img src="{{ asset('assets/images/academy/italian-classroom-lecture.jpg') }}" alt="حكاية INTOK" class="w-full h-[360px] object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-6 inset-x-6 text-white text-start">
                            <span class="rounded-full bg-[#fe0002] px-3 py-1 text-xs font-black">#انتوك_اسلوب_حياه</span>
                            <h4 class="mt-2 text-lg font-black">تعليم • تدريب • تأهيل دولي</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         3. VISION, MISSION & VALUES
         ========================================================== -->
    <section class="relative bg-intok-section py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    منظومة القيم والمبادئ
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    رؤيتنا ورسالتنا وقيمنا
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Vision -->
                <div class="card-poster-white p-6 sm:p-8 bg-white border border-slate-200 shadow-sm reveal-up flex flex-col justify-between">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-amber-50 text-amber-700 border border-amber-200 text-xl font-black mb-5">
                            👁️
                        </span>
                        <h3 class="text-xl font-black text-slate-900">{{ match($locale) { 'it' => 'La Nostra Visione', 'en' => 'Our Vision', default => 'رؤيتنا' } }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600 font-medium">
                            {{ data_get($siteSettings ?? [], 'about_vision_desc.'.$locale, match($locale) {
                                'it' => 'Essere un\'istituzione leader nelle soluzioni educative, formative e accademiche, contribuendo a una generazione dotata di competenze e competitività a livello locale e internazionale.',
                                'en' => 'To be a pioneering institution in educational, training, and academic solutions, contributing to a generation equipped with knowledge, skills, and competitive capability locally and globally.',
                                default => 'أن نكون من المؤسسات الرائدة في تقديم الحلول التعليمية والتدريبية والأكاديمية، وأن نساهم في بناء جيل يمتلك المعرفة والمهارات والقدرة على المنافسة محليًا ودوليًا.',
                            }) }}
                        </p>
                    </div>
                </div>

                <!-- Mission -->
                <div class="card-poster-white p-6 sm:p-8 bg-white border border-slate-200 shadow-sm reveal-up flex flex-col justify-between">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-red-50 text-[#fe0002] border border-red-200 text-xl font-black mb-5">
                            🎯
                        </span>
                        <h3 class="text-xl font-black text-slate-900">{{ match($locale) { 'it' => 'La Nostra Missione', 'en' => 'Our Mission', default => 'رسالتنا' } }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600 font-medium">
                            {{ data_get($siteSettings ?? [], 'about_mission_desc.'.$locale, match($locale) {
                                'it' => 'Fornire servizi educativi e formativi integrati che uniscono conoscenza teorica e pratica applicata, facilitando l\'accesso alle opportunità accademiche e professionali con guida esperta.',
                                'en' => 'Delivering integrated educational and training services bridging knowledge and hands-on practice, facilitating access to academic and professional pathways through dedicated guidance and specialized solutions.',
                                default => 'تقديم خدمات تعليمية وتدريبية متكاملة تجمع بين المعرفة والتطبيق العملي، وتسهيل وصول الأفراد إلى الفرص الأكاديمية والمهنية من خلال التوجيه والمتابعة والحلول المتخصصة.',
                            }) }}
                        </p>
                    </div>
                </div>

                <!-- Values -->
                <div class="card-poster-white p-6 sm:p-8 bg-white border border-slate-200 shadow-sm sm:col-span-2 lg:col-span-1 reveal-up flex flex-col justify-between">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xl font-black mb-5">
                            ⭐
                        </span>
                        <h3 class="text-xl font-black text-slate-900">{{ match($locale) { 'it' => 'I Nostri Valori', 'en' => 'Our Values', default => 'قيمنا' } }}</h3>
                        <ul class="mt-3 space-y-2 text-xs sm:text-sm text-slate-700 font-medium">
                            <li class="flex items-center gap-2">
                                <span class="size-1.5 rounded-full bg-[#fe0002]"></span>
                                <span>{{ match($locale) { 'it' => 'Qualità e professionalità nell\'erogazione dei servizi.', 'en' => 'Quality and professionalism in service delivery.', default => 'الجودة والاحترافية في تقديم الخدمات.' } }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="size-1.5 rounded-full bg-[#fe0002]"></span>
                                <span>{{ match($locale) { 'it' => 'Trasparenza e affidabilità nei rapporti.', 'en' => 'Credibility and transparency in all dealings.', default => 'المصداقية والشفافية في التعامل.' } }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="size-1.5 rounded-full bg-[#fe0002]"></span>
                                <span>{{ match($locale) { 'it' => 'Cura dell\'esperienza di ogni studente e corsista.', 'en' => 'Dedicated care for every student and trainee journey.', default => 'الاهتمام بتجربة كل طالب ومتدرب.' } }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="size-1.5 rounded-full bg-[#fe0002]"></span>
                                <span>{{ match($locale) { 'it' => 'Sviluppo costante e allineamento con i bisogni del mercato del lavoro.', 'en' => 'Continuous development aligned with job market demands.', default => 'التطوير المستمر ومواكبة احتياجات سوق العمل.' } }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="size-1.5 rounded-full bg-[#fe0002]"></span>
                                <span>{{ match($locale) { 'it' => 'Impegno e follow-up in ogni singola fase.', 'en' => 'Commitment and guidance at every single step.', default => 'الالتزام والمتابعة في كل خطوة.' } }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         4. OUR SERVICES (6 CORE DOMAINS)
         ========================================================== -->
    <section class="relative bg-white py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    {{ data_get($siteSettings ?? [], 'about_services_badge.'.$locale, match($locale) {
                        'it' => 'I Nostri Servizi – Come Ti Aiutiamo',
                        'en' => 'Our Services – How We Help You',
                        default => 'خدماتنا – بنساعدك في إيه؟',
                    }) }}
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    {{ data_get($siteSettings ?? [], 'about_services_title.'.$locale, match($locale) {
                        'it' => 'Ambiti Molteplici.. Unico Obiettivo: Sviluppare il Tuo Futuro',
                        'en' => 'Multiple Domains.. One Goal: Advance Your Future',
                        default => 'مجالات متعددة.. وهدف واحد: تطور مستقبلك',
                    }) }}
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $aboutAreas = [
                        [
                            'title' => match($locale) {
                                'it' => 'Qualificazione per Studiare in Europa',
                                'en' => 'Qualification to Study in Europe',
                                default => 'التأهيل للدراسة في اوربا',
                            },
                            'desc' => match($locale) {
                                'it' => 'Ti aiutiamo a esplorare opportunità formative in oltre 10 paesi europei, scegliere ateneo e corso ideale, e preparare fascicoli di ammissione.',
                                'en' => 'We help you explore educational opportunities across 10+ European countries, select universities and majors, and prepare application files.',
                                default => 'نساعدك في استكشاف الفرص التعليمية في أكثر من 10 دول أوروبية، واختيار الجامعة والتخصص المناسب، وتجهيز ملفات التقديم ومتابعة إجراءات القبول.',
                            }
                        ],
                        [
                            'title' => match($locale) {
                                'it' => 'Apprendimento delle Lingue',
                                'en' => 'Language Learning',
                                default => 'تعلم اللغات',
                            },
                            'desc' => match($locale) {
                                'it' => 'Corsi di lingue straniere a vari livelli per sviluppare competenze comunicative e aprire orizzonti accademici e di carriera.',
                                'en' => 'Language programs at multiple levels to boost communication skills and unlock new academic and professional horizons.',
                                default => 'برامج تعليمية في اللغات بمستويات مختلفة، تساعدك تطور مهارات التواصل وتفتح لنفسك فرص أكاديمية ومهنية جديدة.',
                            }
                        ],
                        [
                            'title' => match($locale) {
                                'it' => 'Traduzione Asseverata e Revisione Linguistica',
                                'en' => 'Certified Translation & Proofreading',
                                default => 'الترجمة المعتمدة والتدقيق اللغوي',
                            },
                            'desc' => match($locale) {
                                'it' => 'Traduzioni giurate e revisione di documenti accademici, ufficiali e professionali secondo i requisiti delle autorità competenti.',
                                'en' => 'Certified translation and proofreading for academic, official, and corporate documents aligned with recipient authority rules.',
                                default => 'خدمات ترجمة وتدقيق للمستندات والوثائق الأكاديمية والرسمية والمهنية، وفق متطلبات الجهة المطلوب تقديم المستندات إليها.',
                            }
                        ],
                        [
                            'title' => match($locale) {
                                'it' => 'Formazione e Qualificazione Professionale (Call Center & Guida Turistica)',
                                'en' => 'Career Training & Qualification (Call Center & Tour Guiding)',
                                default => 'التدريب والتأهيل المهني (منها الكول سنتر والإرشاد السياحي)',
                            },
                            'desc' => match($locale) {
                                'it' => 'Programmi pratici in settori ad alta domanda come call center e turismo, mirati allo sviluppo di competenze richieste dal mercato.',
                                'en' => 'Practical training programs in fields like multinational call centers and tour guiding, preparing you for real job market requirements.',
                                default => 'برامج تدريبية عملية في مجالات مختلفة، منها الكول سنتر والإرشاد السياحي، بهدف تنمية المهارات والاستعداد لمتطلبات سوق العمل.',
                            }
                        ],
                        [
                            'title' => match($locale) {
                                'it' => 'Servizi Accademici e Internazionali',
                                'en' => 'Academic & International Services',
                                default => 'الخدمات الأكاديمية والدولية',
                            },
                            'desc' => match($locale) {
                                'it' => 'Supporto nelle ammissioni universitarie, prenotazione test internazionali, visti e domande per borse di studio post-laurea.',
                                'en' => 'Assistance with university applications, international exam bookings, consular appointments, and postgraduate scholarship submissions.',
                                default => 'مساعدة في إجراءات التقديم للجامعات، وحجز الاختبارات الدولية، ومواعيد السفارات، والتقديم للدراسات العليا والمنح وفق شروط كل جهة.',
                            }
                        ],
                        [
                            'title' => match($locale) {
                                'it' => 'Preparazione per Esami Internazionali',
                                'en' => 'Preparation for International Exams',
                                default => 'التأهيل للاختبارات الدولية',
                            },
                            'desc' => match($locale) {
                                'it' => 'Corsi intensivi per superare con successo certificazioni linguistiche ed esami di ammissione universitari.',
                                'en' => 'Preparatory programs helping students achieve top scores in official international language and entrance examinations.',
                                default => 'برامج تحضيرية تساعد الطلاب على الاستعداد للاختبارات الدولية والأكاديمية، من خلال التدريب والتوجيه حسب طبيعة كل اختبار.',
                            }
                        ],
                    ];
                @endphp
                @foreach($aboutAreas as $idx => $area)
                    <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-xs reveal-up">
                        <span class="text-xs font-mono font-black text-[#fe0002]">0{{ $idx + 1 }}</span>
                        <h3 class="mt-2 text-base font-black text-slate-900">{{ $area['title'] }}</h3>
                        <p class="mt-2 text-xs sm:text-sm leading-relaxed text-slate-600 font-medium">{{ $area['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==========================================================
         5. WHY CHOOSE INTOK ACADEMY?
         ========================================================== -->
    <section class="relative bg-intok-section py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    {{ data_get($siteSettings ?? [], 'about_why_badge.'.$locale, match($locale) {
                        'it' => 'Perché Scegliere INTOK ACADEMY?',
                        'en' => 'Why Choose INTOK ACADEMY?',
                        default => 'لماذا تختار INTOK ACADEMY؟',
                    }) }}
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    {{ data_get($siteSettings ?? [], 'about_why_title.'.$locale, match($locale) {
                        'it' => 'Molto più di un servizio.. Ci prendiamo cura del tuo percorso dall\'inizio alla fine',
                        'en' => 'More than just a service.. We genuinely care for your journey from start to finish',
                        default => 'مش بنقدم خدمة وخلاص.. بنهتم برحلتك من البداية',
                    }) }}
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $whyPoints = [
                        [
                            'title' => match($locale) { 'it' => 'Varietà di Servizi', 'en' => 'Comprehensive Services', default => 'تنوع الخدمات' },
                            'desc' => match($locale) { 'it' => 'Una gamma completa di soluzioni formative, educative e accademiche in un unico luogo.', 'en' => 'A diverse suite of educational, training, and academic solutions under one roof.', default => 'مجموعة من الحلول التعليمية والتدريبية والأكاديمية في مكان واحد.' }
                        ],
                        [
                            'title' => match($locale) { 'it' => 'Orientamento Personalizzato', 'en' => 'Tailored Guidance', default => 'التوجيه المناسب' },
                            'desc' => match($locale) { 'it' => 'Ti aiutiamo a comprendere le tue opzioni e a definire il passo più adatto ai tuoi obiettivi.', 'en' => 'We help you assess your options and define the most suitable step towards your goal.', default => 'بنساعدك تفهم اختياراتك وتحدد الخطوة الأنسب لهدفك.' }
                        ],
                        [
                            'title' => match($locale) { 'it' => 'Follow-up Continuo', 'en' => 'Continuous Follow-up', default => 'متابعة مستمرة' },
                            'desc' => match($locale) { 'it' => 'Seguiamo con costanza i tuoi passi e rispondiamo prontamente a ogni tuo quesito.', 'en' => 'We closely monitor your journey and address every inquiry thoroughly.', default => 'بنهتم بمتابعة خطواتك والإجابة عن استفساراتك.' }
                        ],
                        [
                            'title' => match($locale) { 'it' => 'Applicazione Pratica', 'en' => 'Hands-on Application', default => 'التطبيق العملي' },
                            'desc' => match($locale) { 'it' => 'Ci concentriamo su competenze reali e prassi concrete da cui puoi trarre massimo beneficio.', 'en' => 'We focus on high-yield skills and direct practical knowledge you can leverage immediately.', default => 'بنركز على المهارات والخبرات اللي تقدر تستفيد منها.' }
                        ],
                        [
                            'title' => match($locale) { 'it' => 'Team Specializzato', 'en' => 'Specialized Experts', default => 'فريق متخصص' },
                            'desc' => match($locale) { 'it' => 'Docenti e consulenti con solida esperienza nei campi dell\'istruzione, formazione e servizi accademici.', 'en' => 'A team operating across education, vocational training, and academic advisory.', default => 'فريق يعمل في مجالات التعليم والتدريب والخدمات الأكاديمية.' }
                        ],
                        [
                            'title' => match($locale) { 'it' => 'Trasparenza delle Procedure', 'en' => 'Transparent Procedures', default => 'وضوح الإجراءات' },
                            'desc' => match($locale) { 'it' => 'Chiariamo requisiti, fasi operative e costi prima dell\'avvio di qualsiasi servizio.', 'en' => 'We provide complete clarity on requirements, roadmap steps, and costs before initiating any service.', default => 'بنوضح المتطلبات والخطوات والتكاليف قبل بدء الخدمة.' }
                        ],
                    ];
                @endphp
                @foreach($whyPoints as $p)
                    <div class="card-poster-white p-6 bg-white border border-slate-200 rounded-2xl shadow-sm reveal-up">
                        <div class="size-2 rounded-full bg-[#fe0002] mb-3"></div>
                        <h3 class="text-base font-black text-slate-900">{{ $p['title'] }}</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">{{ $p['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==========================================================
         6. SUCCESS PARTNERS
         ========================================================== -->
    <section class="relative bg-white py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    {{ data_get($siteSettings ?? [], 'about_partners_badge.'.$locale, match($locale) {
                        'it' => 'Partner del Successo',
                        'en' => 'Success Partners',
                        default => 'شركاء النجاح',
                    }) }}
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    {{ data_get($siteSettings ?? [], 'about_partners_title.'.$locale, match($locale) {
                        'it' => 'Insieme Raggiungiamo Opportunità Più Grandi',
                        'en' => 'Together We Reach Greater Horizons',
                        default => 'مع بعض بنقدر نوصل لفرص أكبر',
                    }) }}
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-700 font-medium leading-relaxed">
                    {{ data_get($siteSettings ?? [], 'about_partners_p1.'.$locale, match($locale) {
                        'it' => 'Siamo orgogliosi delle relazioni di cooperazione con gli enti e le istituzioni che contribuiscono a sviluppare i nostri servizi e ampliare le opportunità formative e professionali per i nostri clienti.',
                        'en' => 'We take pride in our cooperation with organizations and institutions that contribute to developing our services and expanding learning and training opportunities for our clients.',
                        default => 'نفخر بعلاقات التعاون مع الجهات والمؤسسات التي تساهم في تطوير خدماتنا وتوسيع فرص التعلم والتدريب لعملائنا.',
                    }) }}
                </p>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    {{ data_get($siteSettings ?? [], 'about_partners_p2.'.$locale, match($locale) {
                        'it' => 'Attraverso i nostri partner, puntiamo a scambiare competenze, rafforzare la cooperazione e offrire esperienze sempre più integrate.',
                        'en' => 'Through our partners, we strive to exchange expertise, strengthen cooperation, and provide more comprehensive integrated experiences.',
                        default => 'من خلال شركائنا، نسعى لتبادل الخبرات، وتعزيز التعاون، وتقديم تجارب أكثر تكاملًا.',
                    }) }}
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Inside Egypt -->
                <div class="card-poster-white p-6 sm:p-8 bg-slate-50 border border-slate-200 rounded-3xl shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🇪🇬</span>
                            <span>{{ match($locale) { 'it' => 'Partner del Successo in Egitto', 'en' => 'Success Partners Inside Egypt', default => 'شركاء النجاح داخل مصر' } }}</span>
                        </h3>
                        <button type="button" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-egypt.jpg') }}', 'شركاء النجاح داخل مصر')" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white hover:bg-[#fe0002] hover:text-white text-slate-700 text-xs font-black transition cursor-pointer shadow-2xs border border-slate-200">
                            <span>{{ match($locale) { 'it' => 'Ingrandisci', 'en' => 'Enlarge', default => 'تكبير الصورة' } }}</span>
                            <span>🔍</span>
                        </button>
                    </div>
                    <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 p-2 cursor-pointer group" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-egypt.jpg') }}', 'شركاء النجاح داخل مصر')">
                        <img src="{{ asset('assets/images/partners/partners-egypt.jpg') }}" alt="شركاء النجاح داخل مصر" class="w-full h-auto object-contain rounded-xl group-hover:scale-105 transition duration-500">
                    </div>
                </div>

                <!-- Outside Egypt -->
                <div class="card-poster-white p-6 sm:p-8 bg-slate-50 border border-slate-200 rounded-3xl shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🇪🇺</span>
                            <span>{{ match($locale) { 'it' => 'Partner del Successo Fuori dall\'Egitto (Università Europee)', 'en' => 'Success Partners Outside Egypt (European Universities)', default => 'شركاء النجاح خارج مصر (الجامعات الأوروبية)' } }}</span>
                        </h3>
                        <button type="button" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-international.jpg') }}', 'شركاء النجاح خارج مصر (الجامعات الأوروبية)')" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white hover:bg-[#fe0002] hover:text-white text-slate-700 text-xs font-black transition cursor-pointer shadow-2xs border border-slate-200">
                            <span>{{ match($locale) { 'it' => 'Ingrandisci', 'en' => 'Enlarge', default => 'تكبير الصورة' } }}</span>
                            <span>🔍</span>
                        </button>
                    </div>
                    <div class="overflow-hidden rounded-2xl bg-white border border-slate-200 p-2 cursor-pointer group" onclick="openPartnerModal('{{ asset('assets/images/partners/partners-international.jpg') }}', 'شركاء النجاح خارج مصر (الجامعات الأوروبية)')">
                        <img src="{{ asset('assets/images/partners/partners-international.jpg') }}" alt="شركاء النجاح خارج مصر" class="w-full h-auto object-contain rounded-xl group-hover:scale-105 transition duration-500">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         7. COOPERATION PROTOCOLS
         ========================================================== -->
    <section class="relative bg-intok-section py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    {{ data_get($siteSettings ?? [], 'about_protocols_badge.'.$locale, match($locale) {
                        'it' => 'Protocolli di Cooperazione',
                        'en' => 'Cooperation Protocols',
                        default => 'بروتوكولات التعاون',
                    }) }}
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    {{ data_get($siteSettings ?? [], 'about_protocols_title.'.$locale, match($locale) {
                        'it' => 'Cooperazione Istituzionale.. Passi Verso un Futuro Migliore',
                        'en' => 'Institutional Cooperation.. Steps Toward a Brighter Future',
                        default => 'تعاون مؤسسي.. وخطوات نحو مستقبل أفضل',
                    }) }}
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-700 font-medium leading-relaxed">
                    {{ data_get($siteSettings ?? [], 'about_protocols_desc.'.$locale, match($locale) {
                        'it' => 'Ci impegniamo a costruire relazioni istituzionali solide attraverso protocolli e accordi ufficiali con enti e istituti diversi, con l\'obiettivo di scambiare competenze e sviluppare programmi e servizi educativi e formativi.',
                        'en' => 'We are dedicated to building institutional partnerships through official protocols and agreements with diverse bodies and institutions, exchanging expertise and advancing academic and training programs.',
                        default => 'نحرص على بناء علاقات تعاون مؤسسية من خلال بروتوكولات واتفاقيات رسمية مع جهات ومؤسسات مختلفة، بهدف تبادل الخبرات وتطوير البرامج والخدمات التعليمية والتدريبية.',
                    }) }}
                </p>
            </div>

            <!-- Protocols Grid: Protocol / Entity / Signature Date / Key Goals -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $protocols = [
                        [
                            'badge' => 'أكاديمي ودولي',
                            'title' => 'بروتوكول التأهيل والقبول الجامعي الأوروبي',
                            'entity' => 'أعرق الجامعات الإيطالية والأوروبية المعتمدة (Bologna, Sapienza, Milan)',
                            'date' => 'معتمد ومجدد سنوياً (2024 - 2026)',
                            'goals' => 'تسهيل مراجعة المؤهلات، التحضير لاختبارات القبول الدولية، وتأهيل الطلاب للمنح الإقليمية DSU والسكن الجامعي.',
                            'icon' => '🏛️'
                        ],
                        [
                            'badge' => 'تأهيل وتوظيف',
                            'title' => 'اتفاقية التدريب والتوظيف بالكول سنتر الدولي',
                            'entity' => 'كبرى شركات مراكز الاتصال والخدمات الدولية (Teleperformance, Concentrix, EID)',
                            'date' => 'شراكة مستمرة 2024 - 2026',
                            'goals' => 'محاكاة بيئات العمل الحقيقية، تدريب المتحدثين باللغات الأجنبية، وترشيح الكوادر للمقابلات المباشرة.',
                            'icon' => '🎧'
                        ],
                        [
                            'badge' => 'ترجمة وتصديقات',
                            'title' => 'بروتوكول الاعتماد والترجمة المعتمدة والتصديقات',
                            'entity' => 'المدرسة العربية للترجمة وجمعيات الترجمة الرسمية',
                            'date' => 'سارٍ وموثق رسمياً',
                            'goals' => 'ضمان الدقة اللغوية، اعتماد صياغات الوثائق الرسمية لدى السفارات والقنصليات، وتدريب المترجمين الواعدين.',
                            'icon' => '📜'
                        ],
                        [
                            'badge' => 'تعليم ولغات',
                            'title' => 'بروتوكول التطوير اللغوي مع المدارس الدولية',
                            'entity' => 'المدارس والمؤسسات التعليمية والتربوية الدولية (International Modern School, DeutschPath)',
                            'date' => 'معتمد وموثق',
                            'goals' => 'تطوير المناهج اللغوية، تأهيل الطلاب لشهادات اللغة الدولية (CILS, CELI, IELTS)، وتوجيههم الأكاديمي المبكر.',
                            'icon' => '🌍'
                        ],
                        [
                            'badge' => 'خدمات دبلوماسية',
                            'title' => 'بروتوكول التنسيق ومتابعة مواعيد السفارات والقنصليات',
                            'entity' => 'مراكز تقديم التأشيرات وأنظمة الحجز المعتمدة',
                            'date' => 'خدمة متابعة مستمرة',
                            'goals' => 'توضيح متطلبات التأشيرات والمواعيد، متابعة فتح الحجوزات الرسمية، وتسهيل إجراءات حضور المقابلات.',
                            'icon' => '🛂'
                        ],
                        [
                            'badge' => 'تدريب عملي',
                            'title' => 'بروتوكول الشراكة مع قطاعات السياحة والأعمال',
                            'entity' => 'شركات السياحة والمؤسسات التجارية الرائدة',
                            'date' => 'تفعيل ميداني متواصل',
                            'goals' => 'تأهيل خريجي اللغات لقطاعات الإرشاد السياحي والتسويق الدولي وتوفير فرص تدريب واقعية.',
                            'icon' => '💼'
                        ]
                    ];
                @endphp
                @foreach($protocols as $p)
                    <div class="card-poster-white p-6 bg-white border border-slate-200 rounded-2xl shadow-sm reveal-up flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-2xl">{{ $p['icon'] }}</span>
                                <span class="rounded-full bg-red-50 text-[#fe0002] border border-red-200 px-2.5 py-0.5 text-[11px] font-black">{{ $p['badge'] }}</span>
                            </div>
                            <h3 class="text-base font-black text-slate-900 leading-snug">{{ $p['title'] }}</h3>
                            <div class="mt-3 space-y-1.5 text-xs text-slate-600">
                                <p><span class="font-bold text-slate-800">اسم الجهة:</span> {{ $p['entity'] }}</p>
                                <p><span class="font-bold text-slate-800">تاريخ التوقيع / السريان:</span> <span class="font-mono text-emerald-700 font-bold">{{ $p['date'] }}</span></p>
                            </div>
                            <div class="mt-3 pt-3 border-t border-slate-100">
                                <span class="block text-[11px] font-black text-[#c27803] mb-1">أبرز أهداف التعاون:</span>
                                <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ $p['goals'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==========================================================
         8. TEAM MEMBERS
         ========================================================== -->
    <section class="relative bg-white py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    فريق INTOK
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    وراء كل تجربة ناجحة.. فريق بيشتغل بشغف
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-700 font-medium leading-relaxed">
                    في INTOK بنؤمن إن جودة الخدمة بتبدأ من جودة الفريق اللي بيقدمها.
                </p>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    عشان كده بنهتم بتطوير فريق العمل، وتبادل الخبرات، والتعاون بين التخصصات المختلفة لتقديم تجربة احترافية لكل طالب ومتدرب وعميل.
                </p>
            </div>

            @if(isset($teamMembers) && $teamMembers->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($teamMembers as $member)
                        @php
                            $mName = is_array($member->name) ? data_get($member->name, $locale, data_get($member->name, 'ar', '')) : $member->name;
                            $mRole = is_array($member->role) ? data_get($member->role, $locale, data_get($member->role, 'ar', '')) : $member->role;
                            $mBio = is_array($member->bio) ? data_get($member->bio, $locale, data_get($member->bio, 'ar', '')) : $member->bio;
                        @endphp
                        <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm text-center reveal-up">
                            <div class="size-24 mx-auto rounded-full overflow-hidden bg-white border-2 border-red-200 mb-4 shadow-xs">
                                <img src="{{ $member->avatar_url ?? asset('assets/images/intok-logo.jpg') }}" alt="{{ $mName }}" class="size-full object-cover">
                            </div>
                            <h3 class="text-base font-black text-slate-900">{{ $mName }}</h3>
                            <p class="text-xs font-bold text-[#fe0002] mt-1">{{ $mRole }}</p>
                            @if($mBio)
                                <p class="mt-3 text-xs leading-relaxed text-slate-600 font-medium">{{ $mBio }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- ==========================================================
         9. LIVE INSIDE INTOK
         ========================================================== -->
    <section class="relative bg-intok-section py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-red-50 border border-red-200 px-4 py-1 text-xs font-black text-[#fe0002]">
                    من داخل INTOK
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    مش مجرد كلام.. شوف تجربتنا على أرض الواقع
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-700 font-medium leading-relaxed">
                    اكتشف جانبًا من أنشطتنا التعليمية والتدريبية، وشاهد لقطات من المحاضرات والتدريبات والفعاليات والتجارب الحقيقية داخل الأكاديمية.
                </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 h-64 group shadow-sm relative">
                    <img src="{{ asset('assets/images/academy/italian-classroom-lecture.jpg') }}" alt="محاضرات تفاعلية" class="size-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-3 inset-x-3 text-white text-xs font-bold bg-black/60 backdrop-blur-xs p-2 rounded-xl">محاضرات لغوية وتدريبات تفاعلية</div>
                </div>
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 h-64 group shadow-sm relative">
                    <img src="{{ asset('assets/images/academy/live-speaker-training.jpg') }}" alt="تدريب حي" class="size-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-3 inset-x-3 text-white text-xs font-bold bg-black/60 backdrop-blur-xs p-2 rounded-xl">محاكاة عملية لكول سنتر ومقابلات العمل</div>
                </div>
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 h-64 group shadow-sm relative">
                    <img src="{{ asset('assets/images/schools/galileo-galilei.jpg') }}" alt="صروح تعليمية أوروبية" class="size-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute bottom-3 inset-x-3 text-white text-xs font-bold bg-black/60 backdrop-blur-xs p-2 rounded-xl">تأهيل للدراسة بالجامعات الأوروبية</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         10. CLIENT EXPERIENCES & STORIES
         ========================================================== -->
    <section class="relative bg-white py-16 sm:py-24 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                <span class="inline-block rounded-full bg-amber-50 border border-amber-200 px-4 py-1 text-xs font-black text-amber-800">
                    تجارب وقصص عملائنا
                </span>
                <h2 class="mt-3 text-3xl font-black text-[#c27803] sm:text-4xl">
                    كل رحلة ليها حكاية.. وإحنا بنفتخر نكون جزء منها
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-700 font-medium leading-relaxed">
                    بنعتز بثقة الطلاب والمتدربين والعملاء اللي اختاروا INTOK في رحلتهم التعليمية والمهنية.
                </p>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    شاهد تجاربهم وآراءهم، وتعرف على رحلاتهم مع خدماتنا.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm reveal-up flex flex-col justify-between">
                    <p class="text-xs sm:text-sm leading-relaxed text-slate-700 italic font-medium">"{{ match($locale) { 'it' => 'INTOK mi ha supportato nella preparazione della domanda per l\'università europea con precisione in ogni passaggio.', 'en' => 'INTOK helped me prepare my application for European university admission with meticulous tracking at every step.', default => 'أكاديمية INTOK ساعدتني في تجهيز أوراقي والتقديم للجامعات الأوروبية، والمتابعة كانت دقيقة جداً في كل مرحلة.' } }}"</p>
                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs font-bold text-slate-800">
                        <span>{{ match($locale) { 'it' => 'Ahmed M.', 'en' => 'Ahmed M.', default => 'أحمد م.' } }}</span>
                        <span class="text-[#fe0002]">{{ match($locale) { 'it' => 'Studi in Europa', 'en' => 'Study in Europe', default => 'دراسة بأوروبا' } }}</span>
                    </div>
                </div>
                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm reveal-up flex flex-col justify-between">
                    <p class="text-xs sm:text-sm leading-relaxed text-slate-700 italic font-medium">"{{ match($locale) { 'it' => 'Il corso pratico di Call Center e conversazione ha trasformato le mie competenze permettendomi di superare il colloquio subito.', 'en' => 'The hands-on Call Center and conversation training completely transformed my skills, enabling me to pass the interview immediately.', default => 'تدريب الكول سنتر والمحادثة على الشاشات الذكية غير مستواي تماماً وخلاني أعدي الإنترفيو في أول أسبوع بعد التدريب.' } }}"</p>
                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs font-bold text-slate-800">
                        <span>{{ match($locale) { 'it' => 'Sara A.', 'en' => 'Sara A.', default => 'سارة ع.' } }}</span>
                        <span class="text-emerald-600">{{ match($locale) { 'it' => 'Call Center Internazionale', 'en' => 'International Call Center', default => 'كول سنتر دولي' } }}</span>
                    </div>
                </div>
                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm reveal-up flex flex-col justify-between">
                    <p class="text-xs sm:text-sm leading-relaxed text-slate-700 italic font-medium">"{{ match($locale) { 'it' => 'La traduzione giurata è stata consegnata nei tempi previsti con piena conformità consolare, eccellente professionalità.', 'en' => 'The certified translation was delivered on time with full consular acceptance, excellent professionalism and speed.', default => 'الترجمة المعتمدة اتسلمت في نفس اليوم وموثقة بدون أي ملاحظات من السفارة، احترافية وسرعة ممتازة.' } }}"</p>
                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs font-bold text-slate-800">
                        <span>{{ match($locale) { 'it' => 'Mahmoud Kh.', 'en' => 'Mahmoud Kh.', default => 'محمود خ.' } }}</span>
                        <span class="text-amber-700">{{ match($locale) { 'it' => 'Traduzione Giurata', 'en' => 'Certified Translation', default => 'ترجمة معتمدة' } }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         11. FINAL CTA SECTION
         ========================================================== -->
    <section class="relative mx-auto max-w-7xl px-4 py-16 sm:py-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border-2 border-red-400/40 bg-gradient-to-br from-[#fe0002] via-[#e60002] to-[#b30001] p-8 sm:p-14 shadow-2xl shadow-red-600/30 text-white text-center md:text-start flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <span class="inline-block rounded-full bg-white/20 border border-white/40 px-4 py-1 text-xs font-black text-white backdrop-blur-md mb-3">
                    #انتوك_اسلوب_حياه
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                    مستقبلك بيبدأ بخطوة.. وإحنا هنا نساعدك تاخدها
                </h2>
                <p class="mt-3 text-sm text-red-50 font-medium leading-relaxed">
                    سواء هدفك تتعلم لغة جديدة، تطور مهاراتك، تبدأ تدريب مهني، تحصل على ترجمة معتمدة، أو تستكشف فرص الدراسة بالخارج؛ فريق INTOK جاهز يساعدك تعرف الطريق المناسب.
                </p>
                <p class="mt-2 text-xs font-mono font-bold text-amber-200">
                    INTOK ACADEMY – Connecting You to the World
                </p>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="rounded-full bg-white px-8 py-4 text-center text-sm font-black text-[#fe0002] shadow-xl hover:bg-amber-50 hover:scale-105 transition transform">
                    احجز استشارتك الآن
                </a>
                <a href="https://wa.me/201008238323" target="_blank" class="rounded-full border-2 border-white/70 bg-white/10 px-6 py-4 text-center text-sm font-black text-white backdrop-blur-md transition hover:bg-white hover:text-[#fe0002]">
                    تواصل معنا عبر واتساب
                </a>
            </div>
        </div>
    </section>
                    احجز استشارتك الآن
                </a>
                <a href="https://wa.me/201008238323" target="_blank" class="rounded-full border-2 border-white/70 bg-white/10 px-6 py-4 text-center text-sm font-black text-white backdrop-blur-md transition hover:bg-white hover:text-[#fe0002]">
                    تواصل معنا عبر واتساب
                </a>
            </div>
        </div>
    </section>

    <!-- Partners Image Modal (Lightbox) -->
    <div id="partner-lightbox-modal" class="fixed inset-0 z-50 hidden bg-black/85 backdrop-blur-md flex items-center justify-center p-4 sm:p-6" onclick="closePartnerModal(event)">
        <div class="relative max-w-5xl w-full bg-white rounded-3xl p-4 sm:p-6 shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200">
                <h4 id="partner-modal-title" class="text-sm sm:text-base font-black text-slate-900"></h4>
                <button type="button" onclick="closePartnerModal()" class="size-8 rounded-full bg-slate-100 hover:bg-red-50 hover:text-red-600 flex items-center justify-center font-bold text-slate-600 transition cursor-pointer">
                    &times;
                </button>
            </div>
            <div class="max-h-[80vh] overflow-auto flex items-center justify-center p-2 bg-slate-50 rounded-2xl border border-slate-100">
                <img id="partner-modal-img" src="" alt="Partner Image" class="max-w-full h-auto object-contain rounded-xl">
            </div>
        </div>
    </div>

    <script>
        function openPartnerModal(src, title) {
            const modal = document.getElementById('partner-lightbox-modal');
            const img = document.getElementById('partner-modal-img');
            const tEl = document.getElementById('partner-modal-title');
            if (modal && img) {
                img.src = src;
                if (tEl) tEl.textContent = title;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closePartnerModal() {
            const modal = document.getElementById('partner-lightbox-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    </script>
@endsection
