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
                'ar' => 'Connecting You to the World | بوابتك نحو إتقان اللغات والدراسة في إيطاليا وأوروبا',
                'en' => 'Connecting You to the World | Your Gateway to Languages & European Education',
                'it' => 'Connecting You to the World | La tua porta per le lingue e gli studi in Italia'
            ],
            'social_links' => [
                'instagram' => 'https://www.instagram.com/intokacademy',
                'tiktok' => 'https://tiktok.com/@intokacademy',
                'facebook' => 'https://facebook.com/intokacademy',
            ],

            // Hero Section
            'hero_badge' => [
                'ar' => 'بوابتك المعتمدة نحو إيطاليا وسوق العمل الدولي',
                'en' => 'Your Accredited Gateway to Italy & Global Careers',
                'it' => 'La tua porta accreditata verso l Italia e il lavoro globale'
            ],
            'hero_title' => [
                'ar' => 'خطوتك الأولى نحو الدراسة في إيطاليا وسوق العمل الدولي',
                'en' => 'Your First Step to Study in Italy & Global Careers',
                'it' => 'Il tuo primo passo per studiare in Italy e lavorare nel mondo'
            ],
            'hero_text' => [
                'ar' => 'معاك ثانوية أو دبلوم فني (صنايع، تجارة، زراعة)؟ بوابتك مفتوحة لاستكمال دراستك في إيطاليا، والحصول على منح DSU الشاملة (8,000 يورو + سكن مجاني)، والعمل قانونياً باليورو، مع أقوى برامج تدريب الكول سنتر، والترجمة المعتمدة، ودورات اللغات.',
                'en' => 'High school or vocational diploma? Your gateway is open to study in Italy with DSU scholarships (8,000€ + free housing), and ace professional call center and translation training.',
                'it' => 'Diploma o istituto tecnico? La tua porta verso gli studi in Italia con borse DSU complete (8.000€ + alloggio gratuito) e formazione professionale.'
            ],
            'hero_cta' => [
                'ar' => 'ابدأ رحلتك واستشرنا مجاناً',
                'en' => 'Start Your Journey & Free Consult',
                'it' => 'Inizia il tuo viaggio con consulenza gratuita'
            ],
            'hero_secondary_cta' => [
                'ar' => 'استكشف الـ 7 مجالات والخدمات ↓',
                'en' => 'Explore 7 Programs & Services ↓',
                'it' => 'Esplora i 7 programmi e servizi ↓'
            ],
            'hero_stat_1_val' => '100%',
            'hero_stat_1_lbl' => [
                'ar' => 'نسبة نجاح استخراج التأشيرات والقبول',
                'en' => 'Visa and Admission Success Rate',
                'it' => 'Tasso di successo visti e ammissioni'
            ],
            'hero_stat_2_val' => '+1,200',
            'hero_stat_2_lbl' => [
                'ar' => 'طالب ومتدرب تم تأهيلهم بنجاح',
                'en' => 'Students & Trainees Successfully Qualified',
                'it' => 'Studenti e corsisti qualificati con successo'
            ],
            'hero_stat_3_val' => '8,000€',
            'hero_stat_3_lbl' => [
                'ar' => 'بدل سنوي وسكن مجاني بمنحة DSU',
                'en' => 'Annual Grant & Free Housing with DSU',
                'it' => 'Sussidio annuo e alloggio gratuito DSU'
            ],
            'robot_quotes' => [
                "\"مين قال إن الدبلوم آخر الطريق؟ شهادتك بداية لفرصة جديدة في إيطاليا!\"",
                "\"مجموعك القليل مش كارثة... لأن مستقبلك مش بيقف على رقم!\"",
                "\"منحة DSU تغطي مصروفاتك وسكن مجاني وبدل سنوي 8,000 يورو!\"",
                "\"تدريب الكول سنتر واللغات في INTOK يفتح لك أبواب كبرى الشركات الدولية!\"",
                "\"ترجمة معتمدة رسمياً وموثقة للسفارة الإيطالية بدون أي تعقيدات!\""
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
                'ar' => 'منظومة تدريب احترافية معتمدة تؤهلك لسوق العمل الدولي وكبرى الشركات العالمية، مع خدمات الترجمة الرسمية الموثقة للسفارات وبوابتك لاستكمال الدراسة في إيطاليا.',
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
                'ar' => 'منظومة متكاملة لا تكتفي بتقديم الكورسات أو الترجمة، بل تصنع معك مستقبلاً حقيقياً بالدراسة في إيطاليا والعمل في كبرى الشركات العالمية بأعلى عائد.',
                'en' => 'A comprehensive platform opening genuine European education pathways and high-paying multinational careers.',
                'it' => 'Una piattaforma completa che costruisce il tuo futuro in Italia e nelle grandi aziende.'
            ],
            'why_bento_dsu_title' => [
                'ar' => 'أعلى نسبة قبول لمنح DSU الحكومية الإيطالية',
                'en' => 'Highest Acceptance Rate for Italian DSU Scholarships',
                'it' => 'Il più alto tasso di ammissione per borse DSU'
            ],
            'why_bento_dsu_desc' => [
                'ar' => 'نضمن لك حساب مؤشر ISEE بدقة هندسية وقانونية لضمان استيفاء شروط المنحة الإقليمية وسكن جامعي معفى تماماً، مع فتح الباب لحملة الدبلومات الفنية (صنايع / تجارة / زراعة) والثانوية العامة والجامعيين.',
                'en' => 'We calculate ISEE indices with legal and numerical precision ensuring regional scholarship qualification and free accommodation for diploma and high school graduates.',
                'it' => 'Calcolo ISEE preciso per borse regionali e alloggio gratuito.'
            ],
            'why_bento_callcenter_title' => [
                'ar' => 'تأهيل وظيفي فوري لكبرى شركات الكول سنتر',
                'en' => 'Immediate Job Qualification for Multinational Call Centers',
                'it' => 'Qualificazione immediata per call center multinazionali'
            ],
            'why_bento_callcenter_desc' => [
                'ar' => 'تدريب تطبيقي على الشاشات الذكية ومحاكاة لمقابلات شركات متعددة الجنسيات (Vodafone UK, Concentrix, Teleperformance) يؤهلك للعمل المباشر برواتب تبدأ من 15k وتصل إلى 30k+ ج.م.',
                'en' => 'Hands-on training on smart screens and simulations for interviews at multinational companies.',
                'it' => 'Formazione pratica e simulazioni per colloqui con grandi aziende.'
            ],
            'why_bento_trans_title' => [
                'ar' => 'ترجمة معتمدة رسمياً وموثقة لجميع السفارات',
                'en' => 'Officially Certified Translation for All Embassies',
                'it' => 'Traduzione giurata ufficiale per tutte le ambasciate'
            ],
            'why_bento_trans_desc' => [
                'ar' => 'ترجمة رسمية معترف بها أمام القنصلية الإيطالية وكافة السفارات الأوروبية، لشهادات التخرج، إعلانات القيمة، وعقود العمل دون مخاطرة بالرفض.',
                'en' => 'Official certified translation recognized by the Italian consulate and European embassies with zero errors.',
                'it' => 'Traduzioni riconosciute dal consolato italiano e ambasciate europee.'
            ],
            'why_bento_reception_title' => [
                'ar' => 'استقبال في المطار وتسليم السكن بإيطاليا',
                'en' => 'Airport Reception & Housing Delivery in Italy',
                'it' => 'Accoglienza all aeroporto e consegna alloggio in Italia'
            ],
            'why_bento_reception_desc' => [
                'ar' => 'رحلتك معنا لا تنتهي عند باب المطار؛ بل يستقبلك فريقنا الميداني في ميلانو وروما لتسليم السكن، واستخراج الإقامة والحساب البنكي والعمل باليورو.',
                'en' => 'Our local team in Milan and Rome receives you at the airport, handles your residence permit, bank account, and housing.',
                'it' => 'Il nostro team sul posto ti accoglie all aeroporto e ti assiste per alloggio e permesso di soggiorno.'
            ],
            'why_bento_languages_title' => [
                'ar' => 'إتقان اللغات من الصفر واجتياز CILS & IELTS',
                'en' => 'Language Mastery from Scratch & Passing CILS/IELTS',
                'it' => 'Padronanza delle lingue e superamento esami CILS/IELTS'
            ],
            'why_bento_languages_desc' => [
                'ar' => 'دورات مكثفة في الإيطالية والإنجليزية والألمانية تركز 80% على المحادثة والطلاقة الواقعية، وتؤهلك لاجتياز امتحانات السفارات والجامعات.',
                'en' => 'Intensive language courses in Italian, English, and German focusing 80% on live conversation.',
                'it' => 'Corsi intensivi di italiano, inglese e tedesco incentrati sulla conversazione.'
            ],
            'why_bento_mentorship_title' => [
                'ar' => 'إرشاد شخصي 1-on-1 ومتابعة ذكية مستمرة',
                'en' => 'Personal 1-on-1 Mentorship & 24/7 Smart Tracking',
                'it' => 'Tutoraggio 1 a 1 e supporto continuo'
            ],
            'why_bento_mentorship_desc' => [
                'ar' => 'مستشار أكاديمي مخصص يدرس ملفك ويضع خطتك المناسبة، مع نظام تنبيهات ذكي لمواعيد المنح والتقديمات لضمان عدم فوات أي موعد رسمي.',
                'en' => 'A dedicated educational advisor assesses your file and builds your roadmap with real-time deadline tracking.',
                'it' => 'Un consulente dedicato esamina il tuo fascicolo e ti guida passo dopo passo.'
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
                'ar' => 'جلسة إرشاد شاملة مع مستشارك لتحديد البرنامج أو المسار الإيطالي المناسب لمؤهلك.',
                'en' => 'Comprehensive advisory session to select the ideal Italian or professional track for your profile.',
                'it' => 'Sessione di orientamento per scegliere il percorso adatto.'
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
                'ar' => 'التأشيرة والاستقبال بإيطاليا',
                'en' => 'Visa & Reception in Italy',
                'it' => 'Visto e accoglienza in Italia'
            ],
            'roadmap_step4_desc' => [
                'ar' => 'استلام التأشيرة الدراسية، تأمين السكن، والاستقبال في المطار لبدء مستقبلك الجديد.',
                'en' => 'Receiving your student visa, securing accommodation, and airport reception in Italy.',
                'it' => 'Rilascio visto, alloggio e accoglienza all arrivo.'
            ],

            // Final CTA Banner
            'cta_badge' => [
                'ar' => 'ابدأ مستقبلك اليوم',
                'en' => 'Start Your Future Today',
                'it' => 'Inizia il tuo futuro oggi'
            ],
            'cta_title' => [
                'ar' => 'جاهز لبدء رحلتك نحو إيطاليا وأرقى الوظائف الدولية؟',
                'en' => 'Ready to Start Your Journey to Italy & Top International Careers?',
                'it' => 'Pronto per iniziare il tuo percorso verso l Italia?'
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
                    'role' => ['ar' => 'مستشار المنح الحكومية والقبول الجامعي بإيطاليا', 'en' => 'Italian University Admissions & DSU Scholarship Consultant', 'it' => 'Consulente Ammissioni Universitarie e Borse DSU'],
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
