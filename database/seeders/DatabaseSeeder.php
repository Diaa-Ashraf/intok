<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\TeamMember;
use App\Models\SitePage;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::findOrCreate('Admin', 'web');
        Role::findOrCreate('Editor', 'web');

        $adminUser = \App\Models\User::query()->firstOrCreate(
            ['email' => 'admin@intok.com'],
            [
                'name' => 'Admin INTOK',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]
        );
        $adminUser->assignRole($adminRole);

        $services = [
            [
                'slug' => ['ar' => 'تدريب-الكول-سنتر-الاحترافي', 'en' => 'professional-call-center-training', 'it' => 'formazione-call-center-professionale'],
                'title' => ['ar' => 'تدريب الكول سنتر الاحترافي', 'en' => 'Professional Call Center Training', 'it' => 'Formazione Call Center Professionale'],
                'summary' => [
                    'ar' => 'برنامج تدريبي يؤهلك للعمل في الكول سنتر باحتراف، مع تطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات بثقة.',
                    'en' => 'A training program qualifying you to work in call centers professionally, developing communication skills, customer service, and acing interviews.',
                    'it' => 'Un programma di formazione che ti qualifica a lavorare nei call center con professionalità e sicurezza.'
                ],
                'description' => [
                    'ar' => 'تدريب عملي مكثف على مهارات التحدث باللغات الأجنبية، إدارة المكالمات والعملاء، وحل المشكلات، مع جلسات محاكاة حقيقية لمقابلات كبرى شركات الكول سنتر العالمية في مصر والخليج وأوروبا.',
                    'en' => 'Intensive practical training in foreign language communication, call handling, customer service, with real interview simulations for top multinational call centers.',
                    'it' => 'Formazione intensiva sulle competenze linguistiche, gestione delle chiamate e simulazioni di colloqui per grandi aziende.'
                ],
                'icon' => 'headset',
                'sort_order' => 1
            ],
            [
                'slug' => ['ar' => 'احتراف-الترجمة', 'en' => 'translation-mastery', 'it' => 'maestria-nella-traduzione'],
                'title' => ['ar' => 'احتراف الترجمة', 'en' => 'Translation Mastery', 'it' => 'Maestria nella Traduzione'],
                'summary' => [
                    'ar' => 'برنامج تدريبي لتعلم الترجمة باحتراف، مع تطبيقات عملية على النصوص المختلفة وتأهيلك للعمل في المجال بثقة.',
                    'en' => 'A training program to master translation professionally, with practical exercises on varied texts to start working with confidence.',
                    'it' => 'Un programma pratico per apprendere la traduzione professionale su diversi testi e documenti.'
                ],
                'description' => [
                    'ar' => 'تطوير تقنيات الترجمة الفورية والتحريرية، استخدام أدوات الـ CAT Tools، والتعامل مع النصوص القانونية والطبية والأكاديمية لتكون جاهزاً لسوق العمل الحر والشركات الدولية.',
                    'en' => 'Develop interpretation and written translation skills, CAT tools mastery, and handle legal, medical, and academic texts for freelancing and agencies.',
                    'it' => 'Sviluppa tecniche di traduzione scritta e simultanea, strumenti CAT e gestione di testi legali e accademici.'
                ],
                'icon' => 'language',
                'sort_order' => 2
            ],
            [
                'slug' => ['ar' => 'التأهيل-للاختبارات-الدولية', 'en' => 'international-exam-preparation', 'it' => 'preparazione-esami-internazionali'],
                'title' => ['ar' => 'التأهيل للاختبارات الدولية', 'en' => 'International Exam Preparation', 'it' => 'Preparazione Esami Internazionali'],
                'summary' => [
                    'ar' => 'برامج تدريبية متخصصة لإعدادك لاجتياز الاختبارات الدولية مثل IELTS وTOEFL، مع تدريب عملي على جميع المهارات.',
                    'en' => 'Specialized training programs to prepare you for international exams such as IELTS and TOEFL with hands-on practice across all skills.',
                    'it' => 'Corsi mirati per superare esami internazionali come IELTS, TOEFL e certificazioni europee.'
                ],
                'description' => [
                    'ar' => 'خطط تدريب مخصصة لاجتياز اختبارات الآيلتس والتوفل واختبارات اللغة الإيطالية (CILS, CELI, PLIDA) المطلوبة للجامعات والمنح الإيطالية، مع نماذج امتحانات فعلية ومتابعة فردية.',
                    'en' => 'Tailored preparation for IELTS, TOEFL, and Italian exams (CILS, CELI) required for European admissions and scholarships.',
                    'it' => 'Preparazione intensiva per esami universitari e certificazioni linguistiche con test pratici.'
                ],
                'icon' => 'certificate',
                'sort_order' => 3
            ],
            [
                'slug' => ['ar' => 'ترجمة-معتمدة-احترافية', 'en' => 'certified-professional-translation', 'it' => 'traduzione-giurata-professionale'],
                'title' => ['ar' => 'ترجمة معتمدة احترافية', 'en' => 'Certified Professional Translation', 'it' => 'Traduzione Giurata Professionale'],
                'summary' => [
                    'ar' => 'خدمة ترجمة معتمدة لجميع المستندات بدقة عالية وسرعة تنفيذ، مع توثيق رسمي معترف به للجهات الحكومية والسفارات.',
                    'en' => 'Certified translation service for all documents with top accuracy, speed, and official recognition by embassies and government bodies.',
                    'it' => 'Servizio di traduzione asseverata per documenti ufficiali riconosciuto da ambasciate e consolati.'
                ],
                'description' => [
                    'ar' => 'ترجمة معتمدة وموثقة لملفات السفر والتأشيرة، شهادات الميلاد والزواج، إعلان القيمة (Dichiarazione di Valore)، الشهادات الأكاديمية والدرجات لتقديمها للسفارات الإيطالية والأوروبية.',
                    'en' => 'Certified translations of visa files, academic certificates, transcripts, and official declarations recognized by Italian and European embassies.',
                    'it' => 'Traduzioni certificate di certificati di studio, documenti di identità e pratiche per visti consolari.'
                ],
                'icon' => 'documents',
                'sort_order' => 4
            ],
            [
                'slug' => ['ar' => 'إعداد-محاضري-اللغات', 'en' => 'language-instructor-training', 'it' => 'formazione-docenti-di-lingua'],
                'title' => ['ar' => 'إعداد محاضري اللغات', 'en' => 'Language Instructor Training', 'it' => 'Formazione Docenti di Lingua'],
                'summary' => [
                    'ar' => 'برنامج متخصص لإعداد مدربي اللغات بمهارات التدريس والتواصل، مع تطبيق عملي يؤهلك للعمل بثقة.',
                    'en' => 'A specialized program preparing language instructors with teaching and pedagogical communication skills and hands-on teaching practice.',
                    'it' => 'Programma per formare docenti ed esperti di lingue con metodologie moderne e pratiche di insegnamento.'
                ],
                'description' => [
                    'ar' => 'تأهيل المعلمين والمدربين على أحدث طرق التدريس التفاعلي، إدارة القاعات التدريبية، تصميم المناهج، وتدريس اللغات للكبار والصغار باحترافية تامة.',
                    'en' => 'Equipping instructors with modern interactive teaching methodologies, curriculum design, classroom management, and online teaching.',
                    'it' => 'Metodologie didattiche avanzate, gestione dell aula e pianificazione dei corsi di lingua.'
                ],
                'icon' => 'presentation',
                'sort_order' => 5
            ],
            [
                'slug' => ['ar' => 'التدقيق-اللغوي-الاحترافي', 'en' => 'professional-proofreading', 'it' => 'correzione-di-bozze-professionale'],
                'title' => ['ar' => 'التدقيق اللغوي الاحترافي', 'en' => 'Professional Proofreading', 'it' => 'Correzione di Bozze Professionale'],
                'summary' => [
                    'ar' => 'مراجعة لغوية دقيقة للنصوص مع تصحيح الأخطاء النحوية والإملائية وتحسين الصياغة لتظهر بشكل احترافي وواضح.',
                    'en' => 'Meticulous linguistic review correcting grammatical and spelling mistakes while enhancing style for clear, professional output.',
                    'it' => 'Revisione linguistica accurata, correzione di errori grammaticali e ottimizzazione stilistica.'
                ],
                'description' => [
                    'ar' => 'تدقيق لغوي وبلاغي شامل للأبحاث والرسائل العلمية، رسائل الدافع (Motivation Letter)، والسير الذاتية (CV)، والمحتوى الإعلاني بجميع اللغات لضمان خلوها التام من الأخطاء.',
                    'en' => 'Comprehensive proofreading for academic papers, thesis, motivation letters, CVs, and advertising content across languages.',
                    'it' => 'Revisione approfondita di tesi, lettere motivazionali, curriculum e testi accademici.'
                ],
                'icon' => 'edit',
                'sort_order' => 6
            ],
            [
                'slug' => ['ar' => 'دورات-اللغات-الاحترافية', 'en' => 'professional-language-courses', 'it' => 'corsi-di-lingua-professionali'],
                'title' => ['ar' => 'دورات اللغات الاحترافية', 'en' => 'Professional Language Courses', 'it' => 'Corsi di Lingua Professionali'],
                'summary' => [
                    'ar' => 'تعلم اللغات الأجنبية بطريقة حديثة وسهلة، من الصفر للاحتراف مع متابعة مستمرة لتحقيق الطلاقة بسرعة.',
                    'en' => 'Learn foreign languages with modern, easy methods from beginner to professional level with continuous follow-up for quick fluency.',
                    'it' => 'Impara lingue straniere con metodi moderni e pratici, da zero a livello avanzato con rapida fluidità.'
                ],
                'description' => [
                    'ar' => 'كورسات متخصصة في اللغة الإيطالية والإنجليزية والألمانية، تركز على المحادثة والطلاقة العملية، ومصممة للطلاب الراغبين في السفر والعمل أو التقديم للجامعات الأوروبية.',
                    'en' => 'Specialized courses in Italian, English, and German focused on conversational fluency, tailored for study abroad and careers.',
                    'it' => 'Corsi di italiano, inglese e tedesco incentrati sulla conversazione e preparazione per studio e lavoro all estero.'
                ],
                'icon' => 'book-open',
                'sort_order' => 7
            ],
        ];

        // Ensure all official 8 core services exist with full metadata
        app(\App\Services\ServiceCatalogService::class)->ensureCoreServicesExist();

        // Contact info and comprehensive dynamic site settings
        $settings = [
            'contact_phone' => '+201008238323',
            'whatsapp_number' => '201008238323',
            'contact_email' => 'info@intokacademy.com',
            'site_name' => ['ar' => 'INTOK Academy', 'en' => 'INTOK Academy', 'it' => 'INTOK Academy'],
            'tagline' => [
                'ar' => 'Connecting You to the World | بوابتك نحو إتقان اللغات والدراسة في الدول الأوروبية',
                'en' => 'Connecting You to the World | Your Gateway to Languages & European Education',
                'it' => 'Connecting You to the World | La tua porta per le lingue e gli studi nei paesi europei'
            ],
            'social_links' => [
                'instagram' => 'https://www.instagram.com/intokacademy',
                'tiktok' => 'https://tiktok.com/@intokacademy',
                'facebook' => 'https://facebook.com/intokacademy',
            ],
            'google_maps_url' => 'https://maps.app.goo.gl/JXjAZG1Nzf3do1LA8',
            'google_maps_embed' => 'https://maps.google.com/maps?q=30.0700542,31.2042554&hl=ar&z=17&output=embed',
            'academy_address' => [
                'ar' => 'القاهرة / الجيزة - مقر أكاديمية وقاعات INTOK التدريبية',
                'en' => 'Cairo / Giza - INTOK Academy Headquarters & Campus',
                'it' => 'Il Cairo / Giza - Sede e Campus INTOK Academy'
            ],

            // Hero Section (Official Wording)
            'hero_badge' => [
                'ar' => 'شريكك الموثوق نحو النجاح • INTOK Academy',
                'en' => 'Your Trusted Partner to Success • INTOK Academy',
                'it' => 'Il tuo partner di fiducia per il successo • INTOK Academy'
            ],
            'hero_title' => [
                'ar' => "INTOK - بوابتك للتعلم والتطور وبناء مستقبلك",
                'en' => "INTOK - Your Gateway to Learning, Growth & Future Building",
                'it' => "INTOK - La tua porta per imparare, crescere e costruire il futuro"
            ],
            'hero_text' => [
                'ar' => 'من تعلم اللغات والترجمة المعتمدة، إلى التدريب المهني والخدمات الأكاديمية والدراسة في أكثر من 10 دول أوروبية. بنوفرلك المعرفة والتأهيل والدعم اللي يساعدك تخطّي خطوتك الجاية بثقة.',
                'en' => 'From language learning and certified translation to professional career training, academic services, and studying in 10+ European countries. We provide knowledge, qualification, and support to take your next step with confidence.',
                'it' => "Dall'apprendimento delle lingue e traduzioni asseverate alla formazione professionale, servizi accademici e studi in oltre 10 paesi europei. Ti offriamo conoscenza, qualificazione e supporto per compiere il tuo prossimo passo con sicurezza."
            ],
            'hero_cta' => [
                'ar' => 'ابدأ رحلتك مع INTOK',
                'en' => 'Start Your Journey with INTOK',
                'it' => 'Inizia il tuo percorso con INTOK'
            ],
            'hero_secondary_cta' => [
                'ar' => 'استكشف خدماتنا',
                'en' => 'Explore Our Services',
                'it' => 'Scopri i nostri servizi'
            ],
            'hero_stat_1_val' => '10+',
            'hero_stat_1_lbl' => [
                'ar' => 'دول أوروبية • وجهات دراسية متنوعة',
                'en' => 'European Countries • Diverse Destinations',
                'it' => 'Paesi Europei • Destinazioni Varie'
            ],
            'hero_stat_2_val' => '1,200+',
            'hero_stat_2_lbl' => [
                'ar' => 'طالب ومتدرب تم تأهيلهم بنجاح',
                'en' => 'Students & Trainees Successfully Qualified',
                'it' => 'Studenti e corsisti qualificati con successo'
            ],
            'hero_stat_3_val' => '100%',
            'hero_stat_3_lbl' => [
                'ar' => 'استكمال الملفات',
                'en' => 'File Completion',
                'it' => 'Completamento Fascicoli'
            ],
            'hero_stat_3_sub' => [
                'ar' => 'متابعة وتجهيز الملفات وفق المتطلبات',
                'en' => 'File tracking and preparation as required',
                'it' => 'Monitoraggio e preparazione secondo i requisiti'
            ],

            // Floating Badges on Hero Stage
            'hero_float_1_title' => [
                'ar' => 'تأهيل أكاديمي ومهني',
                'en' => 'Academic & Career Qualification',
                'it' => 'Qualificazione Accademica e Professionale'
            ],
            'hero_float_1_sub' => [
                'ar' => 'برامج تدريبية وفرص تعليمية متنوعة',
                'en' => 'Diverse training & study opportunities',
                'it' => 'Programmi e opportunità formative varie'
            ],
            'hero_float_2_title' => [
                'ar' => 'دعم وتجهيز الملفات',
                'en' => 'File Support & Preparation',
                'it' => 'Supporto e Preparazione Fascicoli'
            ],
            'hero_float_2_sub' => [
                'ar' => 'متابعة دقيقة وفق متطلبات كل جهة',
                'en' => 'Strict tracking tailored to each institution',
                'it' => 'Monitoraggio accurato secondo ogni ente'
            ],

            // 4 Interactive Hero Stage Scenes
            'hero_scene_1_tab' => ['ar' => 'التأهيل للدراسة', 'en' => 'Study Qualification', 'it' => 'Orientamento agli Studi'],
            'hero_scene_1_badge' => ['ar' => 'خطوتك الأولى نحو الدراسة في أوروبا', 'en' => 'Your First Step Toward Europe', 'it' => 'Il tuo primo passo verso l\'Europa'],
            'hero_scene_1_title' => ['ar' => 'خطوتك الأولى نحو الدراسة في أوروبا', 'en' => 'Your First Step Toward Studying in Europe', 'it' => 'Il tuo primo passo verso lo studio in Europa'],
            'hero_scene_1_desc' => [
                'ar' => 'فرص تعليمية في أكثر من 10 دول أوروبية، ومساعدتك في اختيار الجامعة والتخصص وتجهيز ملف التقديم.',
                'en' => 'Educational opportunities in 10+ European countries, helping you select universities and prepare applications.',
                'it' => 'Opportunità educative in oltre 10 paesi europei, assistenza nella scelta dell ateneo e preparazione del dossier.'
            ],
            'hero_scene_1_stat' => ['ar' => '10+ دول أوروبية', 'en' => '10+ European Countries', 'it' => '10+ Paesi Europei'],

            'hero_scene_2_tab' => ['ar' => 'اللغات والترجمة', 'en' => 'Languages & Translation', 'it' => 'Lingue e Traduzioni'],
            'hero_scene_2_badge' => ['ar' => '02 — اللغات والترجمة', 'en' => '02 — Languages & Translation', 'it' => '02 — Lingue e Traduzioni'],
            'hero_scene_2_title' => ['ar' => 'لغتك تفتحلك أبواب جديدة', 'en' => 'Your Language Opens New Doors', 'it' => 'La tua lingua apre nuove porte'],
            'hero_scene_2_desc' => [
                'ar' => 'تعلم اللغات الأجنبية مع برامج تدريبية متخصصة، وخدمات ترجمة معتمدة تساعدك في خطواتك الأكاديمية والمهنية.',
                'en' => 'Learn foreign languages through specialized training and certified translation assisting your career.',
                'it' => 'Apprendi le lingue con corsi dedicati e traduzioni giurate a supporto del tuo percorso.'
            ],
            'hero_scene_2_stat' => ['ar' => 'ترجمة معتمدة وشهادات دولية', 'en' => 'Certified Translation & Diplomas', 'it' => 'Traduzione giurata e certificazioni'],

            'hero_scene_3_tab' => ['ar' => 'التدريب المهني', 'en' => 'Career Training', 'it' => 'Formazione Professionale'],
            'hero_scene_3_badge' => ['ar' => '03 — التدريب والتأهيل المهني', 'en' => '03 — Vocational & Career Training', 'it' => '03 — Formazione e Qualificazione Professionale'],
            'hero_scene_3_title' => ['ar' => 'طوّر مهاراتك واستعد لسوق العمل', 'en' => 'Upgrade Skills & Prepare for the Market', 'it' => 'Sviluppa competenze per il lavoro'],
            'hero_scene_3_desc' => [
                'ar' => 'برامج تدريب عملية في الكول سنتر، ومجالات مختلفة تساعدك تكتسب مهارات مطلوبة.',
                'en' => 'Practical training programs in Call Center and diverse fields helping you acquire in-demand skills.',
                'it' => 'Programmi pratici in call center e settori vari per acquisire competenze richieste.'
            ],
            'hero_scene_3_stat' => ['ar' => 'محاكاة عملية وسوق عمل مباشر', 'en' => 'Practical Simulation & Direct Market', 'it' => 'Simulazione pratica e mercato diretto'],

            'hero_scene_4_tab' => ['ar' => 'الخدمات الأكاديمية', 'en' => 'Academic Services', 'it' => 'Servizi Accademici'],
            'hero_scene_4_badge' => ['ar' => '04 — الخدمات الأكاديمية والدولية', 'en' => '04 — Academic & International Services', 'it' => '04 — Servizi Accademici e Internazionali'],
            'hero_scene_4_title' => ['ar' => 'خلّي طموحك يوصل أبعد', 'en' => 'Take Your Ambitions Further', 'it' => 'Porta la tua ambizione più lontano'],
            'hero_scene_4_desc' => [
                'ar' => 'بنساعدك في إجراءات التقديم للجامعات، وحجز الاختبارات الدولية، ومواعيد السفارات، والتقديم للدراسات العليا والمنح.',
                'en' => 'Assisting with university applications, international exams, embassy bookings, graduate studies and scholarships.',
                'it' => 'Ti guidiamo nelle domande universitarie, prenotazione test internazionali, appuntamenti consolari e borse di studio.'
            ],
            'hero_scene_4_stat' => ['ar' => '100% تجهيز ومتابعة دقيقة', 'en' => '100% File Compliance & Guidance', 'it' => '100% Preparazione e supporto'],

            'robot_quotes' => [
                "\"INTOK بوابتك للتعلم والتطور وبناء مستقبلك بثقة!\"",
                "\"فرص تعليمية وتأهيل مهني في أكثر من 10 دول أوروبية!\"",
                "\"منظومة متكاملة من اللغات والترجمة المعتمدة وحتى التوظيف الدولي!\"",
                "\"تدريب الكول سنتر واللغات في INTOK يفتح لك أبواب كبرى الشركات الدولية!\"",
                "\"ترجمة معتمدة رسمياً وموثقة لجميع السفارات بأعلى دقة وسرعة!\""
            ],

            // Services Section (Official Wording)
            'services_badge' => [
                'ar' => '10 خدمات تعليمية ومهنية متكاملة',
                'en' => '10 Integrated Educational & Career Services',
                'it' => '10 Servizi educativi e professionali integrati'
            ],
            'services_title' => [
                'ar' => 'INTOK  خدمات تعليمية ومهنية متكاملة',
                'en' => 'INTOK - Integrated Educational & Professional Services',
                'it' => 'INTOK - Servizi educativi e professionali integrati'
            ],
            'services_subtitle' => [
                'ar' => 'بنقدم لك حلول تعليمية ومهنية متكاملة تبدأ من تعلم اللغات والترجمة المعتمدة، مرورًا بالتأهيل والتدريب المهني، وصولًا للدراسة بالخارج والخدمات الأكاديمية الدولية.',
                'en' => 'We offer integrated educational and professional solutions starting from language learning and certified translation, through vocational training, to studying abroad and international academic services.',
                'it' => "Offriamo soluzioni educative e professionali integrate che partono dall'apprendimento delle lingue e dalle traduzioni asseverate, passano per la formazione professionale fino agli studi all'estero e ai servizi accademici internazionali."
            ],

            // Live Slider Section
            'live_slider_badge' => [
                'ar' => 'نبض التدريب والمحاضرات الحية في الأكاديمية',
                'en' => 'Live Academy Training & Lectures',
                'it' => 'Formazione dal vivo in accademia'
            ],
            'live_slider_title' => [
                'ar' => 'شوف INTOK بتساعدك تطور مستقبلك إزاي',
                'en' => 'See How INTOK Helps You Build Your Future',
                'it' => 'Scopri come INTOK ti aiuta a costruire il tuo futuro'
            ],
            'live_slider_subtitle' => [
                'ar' => 'لقطات حقيقية من تدريباتنا، محاضراتنا، خدماتنا التعليمية وتجارب المتدربين داخل INTOK.',
                'en' => 'Real moments from our training, lectures, educational services, and student experiences inside INTOK.',
                'it' => 'Riprese reali dai nostri corsi, lezioni, servizi educativi ed esperienze concrete degli studenti in INTOK.'
            ],
            'live_slide_1_title' => [
                'ar' => 'اتعلم لغة تفتحلك فرص جديدة',
                'en' => 'Learn a language that opens new doors',
                'it' => 'Impara una lingua che apre nuove opportunità'
            ],
            'live_slide_1_desc' => [
                'ar' => 'تدريبات عملية لتطوير مهارات التحدث والتواصل بمختلف اللغات.',
                'en' => 'Hands-on practice to develop spoken communication and fluency across multiple languages.',
                'it' => 'Esercitazioni pratiche per sviluppare conversazione e comunicazione in diverse lingue straniere.'
            ],
            'live_slide_2_title' => [
                'ar' => 'اتأهل لمستقبلك المهني',
                'en' => 'Get qualified for your professional future',
                'it' => 'Qualificati per il tuo futuro professionale'
            ],
            'live_slide_2_desc' => [
                'ar' => 'تدريب عملي في الكول سنتر والترجمة وتطوير المهارات المطلوبة لسوق العمل.',
                'en' => 'Practical training in Call Center, translation, and high-demand skills for the modern job market.',
                'it' => 'Formazione pratica in call center, traduzione e abilità richieste dal mercato del lavoro.'
            ],
            'live_slide_3_title' => [
                'ar' => 'جهّز خطوتك الأكاديمية بثقة',
                'en' => 'Prepare your academic journey with confidence',
                'it' => 'Prepara il tuo percorso accademico con fiducia'
            ],
            'live_slide_3_desc' => [
                'ar' => 'تأهيل للدراسة في أوروبا، وتجهيز ملفات التقديم والتدريب على الاختبارات الدولية.',
                'en' => 'Qualification for studying in Europe, application preparation, and international test coaching.',
                'it' => 'Orientamento per studiare in Europa, preparazione dossier di candidatura e test internazionali.'
            ],

            // Finder Console
            'finder_title' => [
                'ar' => 'فحص شروط القبول والمنحة',
                'en' => 'Check Eligibility & Scholarships',
                'it' => 'Verifica idoneità e borse'
            ],
            'finder_step1_label' => [
                'ar' => '1. مسارك التعليمي الحالي',
                'en' => '1. Current Educational Track',
                'it' => '1. Percorso di studio attuale'
            ],
            'finder_step2_label' => [
                'ar' => '2. هدفك المنشود',
                'en' => '2. Desired Goal',
                'it' => '2. Obiettivo desiderato'
            ],
            'finder_step3_label' => [
                'ar' => '3. موسم الالتحاق',
                'en' => '3. Intake Season',
                'it' => '3. Stagione di ammissione'
            ],
            'finder_btn_text' => [
                'ar' => 'فحص شروط القبول والمنحة',
                'en' => 'Check Eligibility & Scholarship',
                'it' => 'Verifica requisiti e borsa'
            ],

            // Why Choose Us Section (Bento)
            'why_badge' => [
                'ar' => 'معايير الثقة والريادة الدولية',
                'en' => 'Standards of Trust & Global Leadership',
                'it' => 'Standard di fiducia e leadership'
            ],
            'why_title' => [
                'ar' => 'ليه INTOK هي خطوتك الصح لمستقبلك؟',
                'en' => 'Why INTOK is the Right Step for Your Future?',
                'it' => 'Perché INTOK è il passo giusto per il tuo futuro?'
            ],
            'why_subtitle' => [
                'ar' => 'في INTOK بنجمع بين التعليم والتدريب والتأهيل المهني والخدمات الأكاديمية، علشان نساعدك تطور مهاراتك وتحقق أهدافك بخطوات واضحة ودعم متخصص.',
                'en' => 'At INTOK, we combine education, practical training, professional qualification, and academic services to help you build skills and achieve your goals with clear steps and expert support.',
                'it' => 'In INTOK uniamo formazione, istruzione, qualificazione professionale e servizi accademici per aiutarti a sviluppare competenze e raggiungere i tuoi obiettivi con passi chiari e supporto dedicato.'
            ],
            'why_bento_services_nav_title' => ['ar' => 'خدمات تعليمية ومهنية متكاملة', 'en' => 'Integrated Services', 'it' => 'Servizi Integrati'],
            'why_bento_services_nav_sub' => ['ar' => '10 خدمات متنوعة تحت سقف واحد', 'en' => '10 diverse services under one roof', 'it' => '10 servizi diversi sotto lo stesso tetto'],
            'why_bento_practical_nav_title' => ['ar' => 'تدريب عملي وتطبيق واقعي', 'en' => 'Practical & Real Training', 'it' => 'Formazione Pratica e Reale'],
            'why_bento_practical_nav_sub' => ['ar' => 'تطبيقات وتدريبات تحاكي الواقع', 'en' => 'Real-world practice & simulations', 'it' => 'Esercitazioni e simulazioni reali'],
            'why_bento_trainers_nav_title' => ['ar' => 'مدربون ومتخصصون في مجالاتهم', 'en' => 'Expert Domain Specialists', 'it' => 'Docenti e Specialisti Esperti'],
            'why_bento_trainers_nav_sub' => ['ar' => 'خبرات في مجالات التعليم والتدريب', 'en' => 'Real educational & training expertise', 'it' => 'Esperienza nell insegnamento e formazione'],
            'why_bento_support_nav_title' => ['ar' => 'متابعة ودعم مستمر', 'en' => 'Continuous Support & Tracking', 'it' => 'Supporto e Tutoraggio Continuo'],
            'why_bento_support_nav_sub' => ['ar' => 'دعم ومتابعة خلال رحلتك', 'en' => 'Dedicated guidance along your path', 'it' => 'Assistenza costante lungo il percorso'],
            'why_bento_customized_nav_title' => ['ar' => 'حلول تناسب أهدافك', 'en' => 'Solutions Tailored to Your Goals', 'it' => 'Soluzioni Adatte ai Tuoi Traguardi'],
            'why_bento_customized_nav_sub' => ['ar' => 'خدمات تناسب احتياجاتك وأهدافك', 'en' => 'Matching your needs and goals', 'it' => 'Adatte alle tue esigenze e traguardi'],
            'why_bento_future_nav_title' => ['ar' => 'تأهيل لمستقبلك الأكاديمي والمهني', 'en' => 'Academic & Career Future Readiness', 'it' => 'Preparazione al Futuro'],
            'why_bento_future_nav_sub' => ['ar' => 'تطوير مهاراتك الأكاديمية والمهنية', 'en' => 'Building your academic & career skills', 'it' => 'Sviluppo competenze accademiche e professionali'],
            'why_bento_services_title' => [
                'ar' => '01 – خدمات تعليمية ومهنية متكاملة',
                'en' => '01 – Integrated Educational & Vocational Services',
                'it' => '01 – Servizi Didattici e Professionali Integrati'
            ],
            'why_bento_services_desc' => [
                'ar' => 'في INTOK بنوفر مجموعة متنوعة من الخدمات التعليمية والمهنية والأكاديمية، علشان تلاقي كل اللي تحتاجه في مكان واحد.',
                'en' => 'At INTOK, we provide a diverse range of educational, vocational, and academic services so you find everything in one place with expert guidance.',
                'it' => 'In INTOK offriamo una gamma completa di servizi didattici, professionali e accademici per trovare tutto in un unico posto con supporto esperto.'
            ],
            'why_bento_practical_title' => [
                'ar' => '02 – تدريب عملي وتطبيق واقعي',
                'en' => '02 – Hands-on Practical & Real-world Training',
                'it' => '02 – Formazione Pratica e Simulazione Reale'
            ],
            'why_bento_practical_desc' => [
                'ar' => 'مش بنكتفي بالمعلومات النظرية؛ بنهتم بالتطبيق العملي والتدريب على مواقف حقيقية تساعدك تفهم المجال وتطور مهاراتك.',
                'en' => 'We go beyond theoretical knowledge to deliver practical training and real workplace simulations.',
                'it' => 'Non ci limitiamo alla teoria: puntiamo su formazione pratica ed esercitazioni reali.'
            ],
            'why_bento_trainers_title' => [
                'ar' => '03 – مدربون ومتخصصون في مجالاتهم',
                'en' => '03 – Expert Instructors & Domain Specialists',
                'it' => '03 – Docenti e Specialisti del Settore'
            ],
            'why_bento_trainers_desc' => [
                'ar' => 'نتيح برامج تدريبية وتعليمية بإشراف متخصصين في مجالاتهم، مع التركيز على نقل الخبرة وتقديم محتوى يناسب احتياجات المتدربين.',
                'en' => 'Training under the guidance of certified field practitioners transferring real market insights.',
                'it' => 'Programmi di formazione guidati da specialisti del settore per trasferire competenze pratiche.'
            ],
            'why_bento_support_title' => [
                'ar' => '04 – متابعة ودعم مستمر',
                'en' => '04 – Continuous Follow-up & Dedicated Support',
                'it' => '04 – Supporto e Tutoraggio Continuo'
            ],
            'why_bento_support_desc' => [
                'ar' => 'رحلتك مع INTOK مش مجرد تسجيل في خدمة؛ بنهتم بمتابعة خطواتك وتقديم الدعم والإرشاد وفق طبيعة الخدمة اللي اخترتها.',
                'en' => 'Your journey with INTOK is an ongoing partnership with continuous follow-up and guidance until you succeed.',
                'it' => 'Il tuo percorso con INTOK include monitoraggio costante e assistenza continua fino al traguardo.'
            ],
            'why_bento_customized_title' => [
                'ar' => '05 – حلول تناسب أهدافك',
                'en' => '05 – Solutions Tailored to Your Goals',
                'it' => '05 – Soluzioni Su Misura per i Tuoi Obiettivi'
            ],
            'why_bento_customized_desc' => [
                'ar' => 'كل شخص عنده هدف مختلف، علشان كده بنساعدك تختار الخدمة أو المسار الأنسب لاحتياجاتك وإمكانياتك وخطتك المستقبلية.',
                'en' => 'Everyone has a unique goal; we help you select the exact track fitting your qualifications.',
                'it' => 'Ogni studente ha un obiettivo unico: selezioniamo il percorso ideale per il tuo profilo.'
            ],
            'why_bento_future_title' => [
                'ar' => '06 – تأهيل لمستقبلك الأكاديمي والمهني',
                'en' => '06 – Comprehensive Readiness for Academic & Career Future',
                'it' => '06 – Preparazione Completa per il Futuro Accademico e Professionale'
            ],
            'why_bento_future_desc' => [
                'ar' => 'بنساعدك تطور قدراتك وتستعد لخطوات جديدة في التعليم والعمل، من خلال برامج التأهيل والتدريب والخدمات الأكاديمية المتخصصة.',
                'en' => 'We empower you to upgrade skills and step confidently into international study and employment.',
                'it' => 'Ti aiutiamo a sviluppare competenze per accedere a studi internazionali e carriere di successo.'
            ],
            'why_bento_future_stat_label' => [
                'ar' => 'القيمة المضافة: خطوات أوضح نحو مستقبلك.',
                'en' => 'Added value: Clearer steps toward your future.',
                'it' => 'Valore aggiunto: Passi più chiari verso il tuo futuro.'
            ],

            // Roadmap Section
            'roadmap_badge' => [
                'ar' => 'خارطة طريق واضحة ومضمونة',
                'en' => 'Clear & Guaranteed Roadmap',
                'it' => 'Tabella di marcia chiara e garantita'
            ],
            'roadmap_title' => [
                'ar' => 'خطواتك مع INTOK من البداية حتى تحقيق هدفك',
                'en' => 'Your steps with INTOK from the beginning to achieving your goal',
                'it' => 'I tuoi passi con INTOK dall\'inizio al raggiungimento del tuo obiettivo'
            ],
            'roadmap_subtitle' => [
                'ar' => 'بنمشي معاك في خطوات واضحة ومنظمة، بداية من فهم احتياجك واختيار الخدمة المناسبة، لحد التأهيل والتجهيز والمتابعة.',
                'en' => 'We walk with you in clear, organized steps, from understanding your needs to training, preparation, and follow-up.',
                'it' => 'Ti accompagniamo passo dopo passo, dalla comprensione delle tue esigenze alla preparazione e al monitoraggio.'
            ],
            'roadmap_step1_title' => [
                'ar' => '01. الاستشارة وتحديد المسار',
                'en' => '01. Consultation & Pathway Mapping',
                'it' => '01. Consulenza e Definizione del Percorso'
            ],
            'roadmap_step1_desc' => [
                'ar' => 'بنفهم هدفك واحتياجاتك، ونساعدك تختار الخدمة أو البرنامج الأنسب ليك.',
                'en' => 'We understand your goals and needs, helping you choose the most suitable service or educational program.',
                'it' => 'Comprendiamo i tuoi obiettivi e le tue esigenze e ti guidiamo nella scelta del servizio o programma più adatto.'
            ],
            'roadmap_step2_title' => [
                'ar' => '02. التقييم والتجهيز',
                'en' => '02. Evaluation & Preparation',
                'it' => '02. Valutazione e Preparazione'
            ],
            'roadmap_step2_desc' => [
                'ar' => 'بنراجع مؤهلاتك ومستواك ومتطلباتك، ونحدد خطوات التأهيل والتجهيز المطلوبة.',
                'en' => 'We review your qualifications, current level, and requirements, defining the training and preparation roadmap.',
                'it' => 'Esaminiamo le tue qualifiche e il tuo livello, definendo i passaggi di formazione e preparazione richiesti.'
            ],
            'roadmap_step3_title' => [
                'ar' => '03. التدريب والتقديم',
                'en' => '03. Training & Application Submission',
                'it' => '03. Formazione e Presentazione Candidatura'
            ],
            'roadmap_step3_desc' => [
                'ar' => 'بنوفرلك التأهيل والتدريب اللازم، وبنساعدك في إجراءات التقديم والمتابعة حسب الخدمة.',
                'en' => 'We provide necessary training and support application procedures and follow-up according to each service.',
                'it' => 'Forniamo la formazione necessaria e ti assistiamo nelle procedure di domanda e monitoraggio in base al servizio.'
            ],
            'roadmap_step4_title' => [
                'ar' => '04. المتابعة واستكمال الإجراءات',
                'en' => '04. Follow-up & File Completion',
                'it' => '04. Monitoraggio e Completamento Pratiche'
            ],
            'roadmap_step4_desc' => [
                'ar' => 'بنتابع معاك الخطوات المطلوبة، ونساعدك تستكمل ملفك وتكون جاهز لخطوتك القادمة.',
                'en' => 'We monitor the required steps, helping you finalize your file and get fully ready for your upcoming leap.',
                'it' => 'Seguiamo con te tutti i passaggi, ti aiutiamo a completare il fascicolo per essere pronto al prossimo traguardo.'
            ],

            // Final CTA Banner
            'cta_badge' => [
                'ar' => 'ابدأ مستقبلك اليوم',
                'en' => 'Start Your Future Today',
                'it' => 'Inizia il tuo futuro oggi'
            ],
            'cta_title' => [
                'ar' => 'جاهز تبدأ خطوتك الجاية مع INTOK؟',
                'en' => 'Ready to Take Your Next Step with INTOK?',
                'it' => 'Pronto a compiere il tuo prossimo passo con INTOK?'
            ],
            'cta_subtitle' => [
                'ar' => 'سواء هدفك تتعلم لغة، تطور مهاراتك المهنية، تتأهل للدراسة في أوروبا أو تستكمل إجراءاتك الأكاديمية، فريق INTOK جاهز يساعدك تبدأ.',
                'en' => 'Whether your goal is learning a language, developing career skills, qualifying to study in Europe, or completing academic procedures, the INTOK team is ready to guide your start.',
                'it' => 'Che il tuo obiettivo sia imparare una lingua, sviluppare competenze professionali, qualificarti per studiare in Europa o completare le tue pratiche accademiche, il team INTOK è pronto ad aiutarti a iniziare.'
            ],
            'cta_btn_primary' => [
                'ar' => 'احجز استشارتك الآن',
                'en' => 'Book Your Consultation Now',
                'it' => 'Prenota la tua consulenza'
            ],
            'cta_btn_secondary' => [
                'ar' => 'واتساب مباشر',
                'en' => 'Direct WhatsApp',
                'it' => 'WhatsApp diretto'
            ],

            // About Us Page Dynamic Settings
            'about_hero_title' => [
                'ar' => 'INTOK ACADEMY – بنفتحلك أبواب جديدة للتعلم والتطور',
                'en' => 'INTOK ACADEMY – Opening New Doors to Learning & Growth',
                'it' => 'INTOK ACADEMY – Ti apriamo nuove porte per apprendere e crescere',
            ],
            'about_hero_p1' => [
                'ar' => 'إحنا أكاديمية متخصصة في التعليم والتدريب والتأهيل الأكاديمي والمهني، بنساعدك تطور مهاراتك، توسّع فرصك، وتاخد خطوات مدروسة نحو مستقبلك.',
                'en' => 'We are an academy specialized in education, practical training, and academic & career qualification, helping you build high-demand skills, expand horizons, and take well-planned steps toward your future.',
                'it' => 'Siamo un\'accademia specializzata in istruzione, formazione e qualificazione accademica e professionale: ti aiutiamo a sviluppare competenze, ampliare le tue opportunità e compiere passi ponderati verso il tuo futuro.',
            ],
            'about_hero_p2' => [
                'ar' => 'من تعلم اللغات والترجمة المعتمدة، إلى التدريب المهني والخدمات الأكاديمية والدراسة بالخارج؛ بنقدم حلول متنوعة تناسب طموحاتك واحتياجاتك.',
                'en' => 'From language learning and certified translation to career training, academic services, and studying abroad: we offer tailored solutions matching your ambitions.',
                'it' => 'Dall\'apprendimento linguistico e traduzioni asseverate alla formazione professionale, servizi accademici e studi all\'estero: offriamo soluzioni variegate su misura per le tue ambizioni.',
            ],
            'about_story_badge' => [
                'ar' => 'قصتنا – حكاية INTOK',
                'en' => 'Our Story – The Journey of INTOK',
                'it' => 'La Nostra Storia – Il Viaggio di INTOK',
            ],
            'about_story_title' => [
                'ar' => 'بدأنا بفكرة.. وهدفنا نفتحلك فرص أكبر',
                'en' => 'Started with an idea... to unlock greater opportunities for you',
                'it' => 'Siamo partiti da un\'idea... per aprirti opportunità più grandi',
            ],
            'about_story_p1' => [
                'ar' => 'اتأسست INTOK ACADEMY برؤية واضحة: إن التعليم الحقيقي مش مجرد معلومات بتتعلمها، لكنه تجربة متكاملة تساعدك تطور نفسك وتستعد لفرص أفضل.',
                'en' => 'INTOK ACADEMY was established with a clear vision: genuine education is not mere information, but an integrated experience that helps you evolve and prepare for prime opportunities.',
                'it' => 'INTOK ACADEMY è nata con una visione chiara: la vera istruzione non è solo nozioni teoriche, ma un\'esperienza integrata che ti permette di crescere e prepararti a opportunità migliori.',
            ],
            'about_story_p2' => [
                'ar' => 'ومن هنا بدأنا نقدم مجموعة متنوعة من الخدمات التعليمية والتدريبية والأكاديمية، مع الاهتمام بالتطبيق العملي، والمتابعة، ومساعدة كل شخص يحدد الطريق المناسب لأهدافه.',
                'en' => 'Hence we began providing educational, vocational, and academic services with deep focus on hands-on application, constant follow-up, and tailoring pathways for each individual.',
                'it' => 'Da qui abbiamo iniziato a offrire un ventaglio di servizi educativi, linguistici e accademici, puntando sull\'applicazione pratica, sul tutoraggio continuo e sull\'aiutare ciascuna persona a individuare la strada ideale per i propri obiettivi.',
            ],
            'about_story_p3' => [
                'ar' => 'بنؤمن إن لكل شخص طموح مختلف، وعشان كده بنسعى نوفرله الدعم والخدمات اللي تساعده ياخد خطوته الجاية بثقة.',
                'en' => 'We believe every individual possesses a unique ambition, and we strive to provide the specialized support that allows them to take the next leap confidently.',
                'it' => 'Crediamo che ogni persona abbia un\'ambizione unica, ed è per questo che ci impegniamo a offrirle il supporto e i servizi necessari per compiere il prossimo passo con fiducia.',
            ],
            'about_vision_desc' => [
                'ar' => 'أن نكون من المؤسسات الرائدة في تقديم الحلول التعليمية والتدريبية والأكاديمية، وأن نساهم في بناء جيل يمتلك المعرفة والمهارات والقدرة على المنافسة محليًا ودوليًا.',
                'en' => 'To be a pioneering institution in educational, training, and academic solutions, contributing to a generation equipped with knowledge, skills, and competitive capability locally and globally.',
                'it' => 'Essere un\'istituzione leader nelle soluzioni educative, formative e accademiche, contribuendo a una generazione dotata di competenze e competitività a livello locale e internazionale.',
            ],
            'about_mission_desc' => [
                'ar' => 'تقديم خدمات تعليمية وتدريبية متكاملة تجمع بين المعرفة والتطبيق العملي، وتسهيل وصول الأفراد إلى الفرص الأكاديمية والمهنية من خلال التوجيه والمتابعة والحلول المتخصصة.',
                'en' => 'Delivering integrated educational and training services bridging knowledge and hands-on practice, facilitating access to academic and professional pathways through dedicated guidance and specialized solutions.',
                'it' => 'Fornire servizi educativi e formativi integrati che uniscono conoscenza teorica e pratica applicata, facilitando l\'accesso alle opportunità accademiche e professionali con guida esperta.',
            ],
            'about_services_badge' => [
                'ar' => 'خدماتنا – بنساعدك في إيه؟',
                'en' => 'Our Services – How We Help You',
                'it' => 'I Nostri Servizi – Come Ti Aiutiamo',
            ],
            'about_services_title' => [
                'ar' => 'مجالات متعددة.. وهدف واحد: تطور مستقبلك',
                'en' => 'Multiple Domains.. One Goal: Advance Your Future',
                'it' => 'Ambiti Molteplici.. Unico Obiettivo: Sviluppare il Tuo Futuro',
            ],
            'about_why_badge' => [
                'ar' => 'لماذا تختار INTOK ACADEMY؟',
                'en' => 'Why Choose INTOK ACADEMY?',
                'it' => 'Perché Scegliere INTOK ACADEMY?',
            ],
            'about_why_title' => [
                'ar' => 'مش بنقدم خدمة وخلاص.. بنهتم برحلتك من البداية',
                'en' => 'More than just a service.. We genuinely care for your journey from start to finish',
                'it' => 'Molto più di un servizio.. Ci prendiamo cura del tuo percorso dall\'inizio alla fine',
            ],
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site.settings');

        // Team members: Seeded initial dynamic members
        if (TeamMember::count() === 0) {
            $members = [
                [
                    'name' => ['ar' => 'د. ماركو روسي', 'en' => 'Dr. Marco Rossi', 'it' => 'Dott. Marco Rossi'],
                    'role' => ['ar' => 'كبير محاضري اللغة الإيطالية والامتحانات الدولية', 'en' => 'Senior Italian Lecturer & International Exams Lead', 'it' => 'Docente Senior di Lingua Italiana ed Esami CILS/CELI'],
                    'bio' => ['ar' => 'خبير تدريس اللغة الإيطالية وتأهيل الطلاب لاجتياز اختبارات CILS وCELI والقبول بالجامعات الإيطالية مع خبرة تتجاوز 12 عاماً.', 'en' => 'Italian language expert preparing students for CILS and CELI exams and admissions to Italian universities with over 12 years of experience.', 'it' => 'Esperto di lingua italiana per la preparazione agli esami CILS e CELI e per l ammissione universitaria.'],
                    'photo_path' => null,
                    'social_links' => ['linkedin' => 'https://linkedin.com', 'instagram' => 'https://instagram.com/intokacademy'],
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'name' => ['ar' => 'أ. سارة المنشاوي', 'en' => 'Sarah El-Menshawy', 'it' => 'Sarah El-Menshawy'],
                    'role' => ['ar' => 'رئيسة قسم تدريب الكول سنتر وخدمة العملاء الدولية', 'en' => 'Head of Call Center Training & Customer Service', 'it' => 'Responsabile Formazione Call Center Internazionale'],
                    'bio' => ['ar' => 'مدربة محترفة متخصصة في تأهيل الكوادر لاجتياز مقابلات كبرى شركات الكول سنتر الدولية (Concentrix, TP, Vodafone) برواتب مجزية.', 'en' => 'Professional trainer qualifying candidates to ace interviews at top multinational call centers with competitive foreign-currency salaries.', 'it' => 'Formatrice professionista nella preparazione per colloqui di lavoro nei grandi call center internazionali.'],
                    'photo_path' => null,
                    'social_links' => ['linkedin' => 'https://linkedin.com', 'instagram' => 'https://instagram.com/intokacademy'],
                    'sort_order' => 2,
                    'is_active' => true,
                ],
                [
                    'name' => ['ar' => 'أ. أحمد خليل', 'en' => 'Ahmed Khalil', 'it' => 'Ahmed Khalil'],
                    'role' => ['ar' => 'مستشار المنح الحكومية والقبول الجامعي بالدول الأوروبية', 'en' => 'European University Admissions & Scholarship Consultant', 'it' => 'Consulente Ammissioni Universitarie e Borse di Studio Europee'],
                    'bio' => ['ar' => 'خبير حساب مؤشرات ISEE وملفات المنح الإقليمية DSU والسكن الجامعي وتأشيرات السفر لحملة الدبلومات الفنية والثانوية والجامعيين.', 'en' => 'Specialist in ISEE calculation, DSU regional scholarship applications, student housing, and visa files for high school and diploma holders.', 'it' => 'Specialista nel calcolo ISEE, pratiche per borse DSU e pratiche consolari per visti di studio.'],
                    'photo_path' => null,
                    'social_links' => ['linkedin' => 'https://linkedin.com', 'instagram' => 'https://instagram.com/intokacademy'],
                    'sort_order' => 3,
                    'is_active' => true,
                ],
                [
                    'name' => ['ar' => 'أ. فاليريا بيانكي', 'en' => 'Valeria Bianchi', 'it' => 'Valeria Bianchi'],
                    'role' => ['ar' => 'مديرة قسم الترجمة المعتمدة والتصديقات القنصلية', 'en' => 'Director of Certified Translation & Consular Legalization', 'it' => 'Direttrice Traduzioni Giurate e Legalizzazioni'],
                    'bio' => ['ar' => 'مترجمة معتمدة متخصصة في تجهيز إعلان القيمة (Dichiarazione di Valore) وتوثيق الشهادات والمستندات الرسمية المعتمدة لدى السفارات.', 'en' => 'Certified translator specializing in Declaration of Value files and official embassy document legalization across Italy and Europe.', 'it' => 'Traduttrice giurata specializzata in pratiche di Dichiarazione di Valore e legalizzazioni documentali.'],
                    'photo_path' => null,
                    'social_links' => ['linkedin' => 'https://linkedin.com', 'instagram' => 'https://instagram.com/intokacademy'],
                    'sort_order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($members as $m) {
                TeamMember::create($m);
            }
        }
    }
}
