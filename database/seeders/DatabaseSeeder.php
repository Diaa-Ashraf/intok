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
                'ar' => 'تأهيل معتمد ودعم متكامل',
                'en' => 'Certified Qualification & Full Support',
                'it' => 'Qualificazione certificata e supporto completo'
            ],
            'robot_quotes' => [
                "\"INTOK بوابتك للتعلم والتطور وبناء مستقبلك بثقة!\"",
                "\"فرص تعليمية وتأهيل مهني في أكثر من 10 دول أوروبية!\"",
                "\"منظومة متكاملة من اللغات والترجمة المعتمدة وحتى التوظيف الدولي!\"",
                "\"تدريب الكول سنتر واللغات في INTOK يفتح لك أبواب كبرى الشركات الدولية!\"",
                "\"ترجمة معتمدة رسمياً وموثقة لجميع السفارات بأعلى دقة وسرعة!\""
            ],

            // Services Section
            'services_badge' => [
                'ar' => 'برامج وتدريب معتمد دولياً',
                'en' => 'Internationally Certified Programs',
                'it' => 'Programmi certificati a livello internazionale'
            ],
            'services_title' => [
                'ar' => 'خدمات وتدريب INTOK ACADEMY',
                'en' => 'Services & Training INTOK ACADEMY',
                'it' => 'Servizi e formazione INTOK ACADEMY'
            ],
            'services_subtitle' => [
                'ar' => 'منظومة تدريب احترافية معتمدة تؤهلك لسوق العمل الدولي وكبرى الشركات العالمية، مع خدمات الترجمة الرسمية الموثقة للسفارات وبوابتك لاستكمال الدراسة في الدول الأوروبية.',
                'en' => 'Comprehensive certified training qualifying you for multinational careers, certified translation, and European education.',
                'it' => 'Formazione professionale certificata per il lavoro e gli studi in Europa.'
            ],

            // Live Slider Section
            'live_slider_badge' => [
                'ar' => 'نبض التدريب والمحاضرات الحية في الأكاديمية',
                'en' => 'Live Academy Training & Lectures',
                'it' => 'Formazione dal vivo in accademia'
            ],
            'live_slider_title' => [
                'ar' => 'شاهد قاعاتنا وتدريباتنا التفاعلية',
                'en' => 'Explore Our Classrooms & Interactive Training',
                'it' => 'Esplora le nostre aule interattive'
            ],
            'live_slider_subtitle' => [
                'ar' => 'لقطات حية من داخل قاعاتنا: تدريب الكول سنتر والمحادثة على الشاشات الذكية، ومحاضرات اللغة الإيطالية والترجمة المعتمدة.',
                'en' => 'Live scenes from our smart classrooms: call center training, Italian lectures, and certified translation workshops.',
                'it' => 'Scatti dal vivo dalle nostre aule multimediali.'
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
                'ar' => 'لماذا تختار أكاديمية إنتوك؟',
                'en' => 'Why Choose INTOK Academy?',
                'it' => 'Perché scegliere INTOK Academy?'
            ],
            'why_subtitle' => [
                'ar' => 'منظومة متكاملة لا تكتفي بتقديم الكورسات أو الترجمة، بل تصنع معك مستقبلاً حقيقياً بالدراسة في الدول الأوروبية والعمل في كبرى الشركات العالمية بأعلى عائد.',
                'en' => 'A comprehensive platform opening genuine European education pathways and high-paying multinational careers.',
                'it' => 'Una piattaforma completa che costruisce il tuo futuro nei paesi europei e nelle grandi aziende.'
            ],
            'why_bento_services_title' => [
                'ar' => 'خدمات تعليمية ومهنية وأكاديمية متكاملة',
                'en' => 'Integrated Educational, Vocational & Academic Services',
                'it' => 'Servizi educativi, professionali e accademici integrati'
            ],
            'why_bento_services_desc' => [
                'ar' => 'في INTOK بنوفر مجموعة متنوعة من الخدمات التعليمية والمهنية والأكاديمية، علشان تلاقي كل اللي تحتاجه في مكان واحد وبدعم متخصص.',
                'en' => 'At INTOK we provide a diverse range of educational, vocational, and academic services so you find everything in one place with expert guidance.',
                'it' => 'In INTOK offriamo una gamma completa di servizi educativi, professionali e accademici con supporto esperto.'
            ],
            'why_bento_practical_title' => [
                'ar' => 'تدريب عملي وتطبيق واقعي يؤهلك لسوق العمل',
                'en' => 'Hands-on Practical Training & Real Workplace Simulation',
                'it' => 'Formazione pratica e simulazioni reali per il mercato del lavoro'
            ],
            'why_bento_practical_desc' => [
                'ar' => 'مش بنكتفي بالمعلومات النظرية؛ بنهتم بالتطبيق العملي والتدريب على مواقف حقيقية تساعدك تفهم المجال وتطور مهاراتك بكفاءة.',
                'en' => 'We go beyond theoretical knowledge to deliver practical training and real workplace simulations.',
                'it' => 'Non ci limitiamo alla teoria: puntiamo su formazione pratica ed esercitazioni reali.'
            ],
            'why_bento_trainers_title' => [
                'ar' => 'مدربون ومتخصصون ذوو خبرة ميدانية واسعة',
                'en' => 'Expert Instructors & Practitioners with Real-World Experience',
                'it' => 'Docenti e professionisti con ampia esperienza sul campo'
            ],
            'why_bento_trainers_desc' => [
                'ar' => 'نتيح برامج تدريبية وتعليمية بإشراف متخصصين في مجالاتهم، مع التركيز على نقل الخبرة وتقديم محتوى يناسب احتياجات المتدربين.',
                'en' => 'Training under the guidance of certified field practitioners transferring real market insights.',
                'it' => 'Programmi di formazione guidati da specialisti del settore per trasferire competenze pratiche.'
            ],
            'why_bento_support_title' => [
                'ar' => 'متابعة ودعم مستمر في كل خطوة من رحلتك',
                'en' => 'Continuous 24/7 Tracking & Step-by-Step Support',
                'it' => 'Tutoraggio continuo e assistenza passo dopo passo'
            ],
            'why_bento_support_desc' => [
                'ar' => 'رحلتك مع INTOK مش مجرد تسجيل في خدمة؛ بنهتم بمتابعة خطواتك وتقديم الدعم والإرشاد وفق طبيعة الخدمة اللي اخترتها حتى تحقق هدفك.',
                'en' => 'Your journey with INTOK is an ongoing partnership with continuous follow-up and guidance until you succeed.',
                'it' => 'Il tuo percorso con INTOK include monitoraggio costante e assistenza continua fino al traguardo.'
            ],
            'why_bento_customized_title' => [
                'ar' => 'حلول مخصصة تناسب أهدافك وإمكانياتك',
                'en' => 'Customized Solutions Tailored to Your Profile & Ambition',
                'it' => 'Soluzioni personalizzate per i tuoi obiettivi e potenzialità'
            ],
            'why_bento_customized_desc' => [
                'ar' => 'كل شخص عنده هدف مختلف، علشان كده بنساعدك تختار الخدمة أو المسار الأنسب لاحتياجاتك وإمكانياتك وخطتك المستقبلية.',
                'en' => 'Everyone has a unique goal; we help you select the exact track fitting your qualifications.',
                'it' => 'Ogni studente ha un obiettivo unico: selezioniamo il percorso ideale per il tuo profilo.'
            ],
            'why_bento_future_title' => [
                'ar' => 'تأهيل شامل لمستقبلك الأكاديمي والمهني',
                'en' => 'Comprehensive Readiness for Academic & International Careers',
                'it' => 'Preparazione completa per il tuo futuro accademico e lavorativo'
            ],
            'why_bento_future_desc' => [
                'ar' => 'بنساعدك تطور قدراتك وتستعد لخطوات جديدة في التعليم والعمل، من خلال برامج التأهيل والتدريب والخدمات الأكاديمية المتخصصة.',
                'en' => 'We empower you to upgrade skills and step confidently into international study and employment.',
                'it' => 'Ti aiutiamo a sviluppare competenze per accedere a studi internazionali e carriere di successo.'
            ],

            // Roadmap Section
            'roadmap_badge' => [
                'ar' => 'خارطة طريق واضحة ومضمونة',
                'en' => 'Clear & Guaranteed Roadmap',
                'it' => 'Tabella di marcia chiara e garantita'
            ],
            'roadmap_title' => [
                'ar' => 'خطوات التحاقك من البداية حتى الاستقرار',
                'en' => 'Your Path from Day One to Settlement',
                'it' => 'I passi dall inizio all insediamento'
            ],
            'roadmap_subtitle' => [
                'ar' => 'أربع مراحل مدروسة بعناية تحول طموحك بالدراسة والعمل الدولي إلى حقيقة مؤكدة.',
                'en' => 'Four well-planned stages turning your ambitions of European education and global careers into reality.',
                'it' => 'Quattro fasi per realizzare i tuoi obiettivi di studio e lavoro.'
            ],
            'roadmap_step1_title' => [
                'ar' => 'الاستشارة وتحديد المسار',
                'en' => 'Consultation & Track Selection',
                'it' => 'Consulenza e scelta percorso'
            ],
            'roadmap_step1_desc' => [
                'ar' => 'جلسة إرشاد شاملة مع مستشارك لتحديد البرنامج أو المسار الأكاديمي الأوروبي المناسب لمؤهلك.',
                'en' => 'Comprehensive advisory session to select the ideal European academic or professional track for your profile.',
                'it' => 'Sessione di orientamento per scegliere il percorso europeo adatto.'
            ],
            'roadmap_step2_title' => [
                'ar' => 'تجهيز الأوراق والتدريب',
                'en' => 'Document Preparation & Training',
                'it' => 'Preparazione documenti e formazione'
            ],
            'roadmap_step2_desc' => [
                'ar' => 'ترجمة وتصديق كافة الشهادات والأوراق الرسمية والبدء في التدريب اللغوي أو العملي.',
                'en' => 'Translating and legalizing all certificates while starting language or vocational training.',
                'it' => 'Traduzione e legalizzazione documenti con formazione linguistica.'
            ],
            'roadmap_step3_title' => [
                'ar' => 'التقديم للمنح والقبول',
                'en' => 'Applying for Scholarships & Admission',
                'it' => 'Candidatura per borse e ammissioni'
            ],
            'roadmap_step3_desc' => [
                'ar' => 'إرسال طلبات الالتحاق بالجامعات أو التقدم للمنح والوظائف ومتابعة النتائج خطوة بخطوة.',
                'en' => 'Submitting university applications and DSU scholarship files with close tracking.',
                'it' => 'Invio domande universitarie e monitoraggio borse di studio.'
            ],
            'roadmap_step4_title' => [
                'ar' => 'التأشيرة والاستقبال بالدول الأوروبية',
                'en' => 'Visa & Reception in European Countries',
                'it' => 'Visto e accoglienza nei Paesi Europei'
            ],
            'roadmap_step4_desc' => [
                'ar' => 'استلام التأشيرة الدراسية، تأمين السكن، والاستقبال في المطار لبدء مستقبلك الجديد.',
                'en' => 'Receiving your student visa, securing accommodation, and airport reception in Europe.',
                'it' => 'Rilascio visto, alloggio e accoglienza all arrivo.'
            ],

            // Final CTA Banner
            'cta_badge' => [
                'ar' => 'ابدأ مستقبلك اليوم',
                'en' => 'Start Your Future Today',
                'it' => 'Inizia il tuo futuro oggi'
            ],
            'cta_title' => [
                'ar' => 'جاهز لبدء رحلتك نحو الدول الأوروبية وأرقى الوظائف الدولية؟',
                'en' => 'Ready to Start Your Journey to European Countries & Top International Careers?',
                'it' => 'Pronto per iniziare il tuo percorso verso i Paesi Europei?'
            ],
            'cta_subtitle' => [
                'ar' => 'تواصل معنا الآن أو تابعنا عبر منصاتنا الرسمية على إنستغرام وتيك توك، ودع فريق INTOK Academy يرسم معك طريق النجاح.',
                'en' => 'Contact us now or follow our official social channels, and let INTOK Academy map your path to success.',
                'it' => 'Contattaci subito o seguici sui canali ufficiali.'
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
