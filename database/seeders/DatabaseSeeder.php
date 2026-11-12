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

        // Ensure all official 10 core services exist with full metadata
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
