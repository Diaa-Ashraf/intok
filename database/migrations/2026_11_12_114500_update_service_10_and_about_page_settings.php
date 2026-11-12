<?php

use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update Service 10: حجز مواعيد السفارات والقنصليات
        $service10 = Service::query()
            ->where('slug_ar', 'embassy-appointments')
            ->orWhere('slug_en', 'embassy-appointments')
            ->first();

        if ($service10) {
            $service10->update([
                'title' => [
                    'ar' => 'حجز مواعيد السفارات والقنصليات',
                    'en' => 'Embassy & Consulate Appointments',
                    'it' => 'Prenotazione Appuntamenti Consolari',
                ],
                'headline' => [
                    'ar' => 'احجز موعدك بالسفارة أو القنصلية بسهولة',
                    'en' => 'Book Your Embassy or Consulate Appointment Easily',
                    'it' => 'Prenota Facilmente il Tuo Appuntamento in Ambasciata o Consolato',
                ],
                'summary' => [
                    'ar' => 'بنساعدك في متابعة إجراءات حجز المواعيد بالسفارات والقنصليات وفق النظام المتاح والبيانات المطلوبة، مع توضيح خطوات الحجز والمستندات اللازمة حسب الجهة.',
                    'en' => 'We assist you in managing embassy and consulate appointment booking procedures per available systems and required information, with clear steps and document guidance.',
                    'it' => 'Ti assistiamo nelle procedure di prenotazione appuntamenti presso ambasciate e consolati secondo i sistemi disponibili e i dati richiesti, indicando chiaramente i passaggi necessari.',
                ],
                'description' => [
                    'ar' => "بنساعدك في متابعة إجراءات حجز المواعيد بالسفارات والقنصليات وفق النظام المتاح والبيانات المطلوبة، مع توضيح خطوات الحجز والمستندات اللازمة حسب الجهة.\n\n⚠️ مهم: الخدمة هنا خاصة بحجز المواعيد فقط، وليست إصدار تأشيرات أو ضمان الحصول عليها.",
                    'en' => "We assist you in managing embassy and consulate appointment booking procedures in accordance with available systems and required information, clearly explaining booking steps and needed documents per authority.\n\n⚠️ Important Notice: This service covers appointment booking and procedural support only; it does not issue visas or guarantee visa approval.",
                    'it' => "Ti assistiamo nelle procedure di prenotazione appuntamenti presso ambasciate e consolati secondo i sistemi disponibili e i dati richiesti, chiarendo i passaggi e i documenti necessari per ogni ente.\n\n⚠️ Nota importante: Il servizio è limitato all'assistenza per la prenotazione degli appuntamenti; non rilascia visti né garantisce l'esito della domanda.",
                ],
                'features' => [
                    'ar' => [
                        'المساعدة في تحديد جهة الحجز المناسبة.',
                        'متابعة أنظمة المواعيد المتاحة.',
                        'إدخال البيانات المطلوبة للحجز.',
                        'توضيح متطلبات الموعد.',
                        'مراجعة بيانات الحجز قبل التأكيد.',
                        'إرشادك بشأن الخطوات التالية.',
                    ],
                    'en' => [
                        'Assistance in determining the appropriate booking entity and jurisdiction.',
                        'Continuous monitoring of available booking systems and slots.',
                        'Accurate entry of required personal and passport details.',
                        'Clear explanation of appointment requirements and checklists.',
                        'Reviewing and verifying booking information prior to final confirmation.',
                        'Guidance on preparation and subsequent steps following confirmation.',
                    ],
                    'it' => [
                        'Assistenza nell\'individuazione del consolato e del portale competente.',
                        'Monitoraggio costante dei sistemi e delle disponibilità di appuntamenti.',
                        'Inserimento accurato di dati anagrafici e del passaporto.',
                        'Chiarimento dettagliato dei requisiti e dei documenti per l\'appuntamento.',
                        'Verifica rigorosa delle informazioni prima della conferma finale.',
                        'Indicazioni chiare sui passi successivi e sulle modalità di presentazione.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'تحديد الدولة والسفارة أو القنصلية.',
                        'تحديد نوع الموعد المطلوب.',
                        'بيانات جواز السفر.',
                        'البيانات الشخصية المطلوبة.',
                        'أي مستندات تشترطها جهة الحجز.',
                    ],
                    'en' => [
                        'Specifying the country and target embassy or consulate.',
                        'Specifying the exact type of appointment needed.',
                        'Valid passport details.',
                        'Required personal information.',
                        'Any specific documentation mandated by the consular authority.',
                    ],
                    'it' => [
                        'Indicazione del paese e dell\'ambasciata o consolato di riferimento.',
                        'Tipologia specifica dell\'appuntamento richiesto.',
                        'Dati del passaporto in corso di validità.',
                        'Dati anagrafici e di contatto richiesti.',
                        'Eventuali documenti specifici richiesti dall\'ente consolare.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'تحديد السفارة ونوع الموعد.',
                        'مراجعة البيانات المطلوبة.',
                        'متابعة نظام الحجز والمواعيد المتاحة.',
                        'تنفيذ الحجز وفق الإجراءات المتاحة.',
                        'تسليم تفاصيل الموعد وإرشادات الحضور.',
                    ],
                    'en' => [
                        'Determining the embassy/consulate and appointment category.',
                        'Reviewing and preparing all required information.',
                        'Tracking the official appointment system for open slots.',
                        'Executing the booking in compliance with available procedures.',
                        'Delivering confirmed appointment details along with attendance guidance.',
                    ],
                    'it' => [
                        'Individuazione dell\'ambasciata/consolato e della categoria di appuntamento.',
                        'Verifica accurata dei dati e dei documenti richiesti.',
                        'Monitoraggio del sistema ufficiale di prenotazione per slot disponibili.',
                        'Esecuzione della prenotazione secondo le procedure previste.',
                        'Consegna della conferma dell\'appuntamento con istruzioni per il colloquio.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        [
                            'question' => 'هل يمكن حجز مواعيد لجميع السفارات؟',
                            'answer' => 'نساعد في حجز المواعيد للسفارات والقنصليات التي تتيح نظام حجز إلكتروني أو آليات تقديم معلنة، وفق المتاح والممكن نظامياً.',
                            'q' => 'هل يمكن حجز مواعيد لجميع السفارات؟',
                            'a' => 'نساعد في حجز المواعيد للسفارات والقنصليات التي تتيح نظام حجز إلكتروني أو آليات تقديم معلنة، وفق المتاح والممكن نظامياً.',
                        ],
                        [
                            'question' => 'هل يوجد موعد مضمون في تاريخ محدد؟',
                            'answer' => 'المواعيد ترتبط بالأنظمة الرسمية المتاحة لدى السفارة أو مركز التأشيرات المعني، ونقوم بمتابعة وحجز أقرب موعد متاح ومناسب لبياناتك.',
                            'q' => 'هل يوجد موعد مضمون في تاريخ محدد؟',
                            'a' => 'المواعيد ترتبط بالأنظمة الرسمية المتاحة لدى السفارة أو مركز التأشيرات المعني، ونقوم بمتابعة وحجز أقرب موعد متاح ومناسب لبياناتك.',
                        ],
                        [
                            'question' => 'هل تشمل الخدمة تجهيز ملف التأشيرة؟',
                            'answer' => 'هذه الخدمة تركز بشكل أساسي على حجز الموعد وتأكيده، وإذا كنت بحاجة إلى ترجمة معتمدة أو تدقيق للمستندات نوفر ذلك كخدمات تكميلية متخصصة.',
                            'q' => 'هل تشمل الخدمة تجهيز ملف التأشيرة؟',
                            'a' => 'هذه الخدمة تركز بشكل أساسي على حجز الموعد وتأكيده، وإذا كنت بحاجة إلى ترجمة معتمدة أو تدقيق للمستندات نوفر ذلك كخدمات تكميلية متخصصة.',
                        ],
                        [
                            'question' => 'ما البيانات المطلوبة للحجز؟',
                            'answer' => 'بيانات جواز السفر ساري المفعول، والبيانات الشخصية المطابقة للمستندات الرسمية، ونوع التأشيرة أو المعاملة المطلوبة.',
                            'q' => 'ما البيانات المطلوبة للحجز؟',
                            'a' => 'بيانات جواز السفر ساري المفعول، والبيانات الشخصية المطابقة للمستندات الرسمية، ونوع التأشيرة أو المعاملة المطلوبة.',
                        ],
                        [
                            'question' => 'ماذا يحدث إذا لم توجد مواعيد متاحة؟',
                            'answer' => 'نقوم بالمتابعة الدورية لنظام المواعيد الرسمي لاقتناص أي فتح لمواعيد جديدة أو مقاعد ملغاة فور توفرها.',
                            'q' => 'ماذا يحدث إذا لم توجد مواعيد متاحة؟',
                            'a' => 'نقوم بالمتابعة الدورية لنظام المواعيد الرسمي لاقتناص أي فتح لمواعيد جديدة أو مقاعد ملغاة فور توفرها.',
                        ],
                    ],
                    'en' => [
                        [
                            'question' => 'Can appointments be booked for all embassies?',
                            'answer' => 'We assist with embassies and consulates that maintain online booking portals or announced procedures, subject to official availability.',
                            'q' => 'Can appointments be booked for all embassies?',
                            'a' => 'We assist with embassies and consulates that maintain online booking portals or announced procedures, subject to official availability.',
                        ],
                        [
                            'question' => 'Is a specific appointment date guaranteed?',
                            'answer' => 'Appointments depend on the official scheduling systems of embassies and visa processing centers. We monitor and book the earliest suitable slot.',
                            'q' => 'Is a specific appointment date guaranteed?',
                            'a' => 'Appointments depend on the official scheduling systems of embassies and visa processing centers. We monitor and book the earliest suitable slot.',
                        ],
                        [
                            'question' => 'Does this service include preparing the complete visa file?',
                            'answer' => 'This service specifically focuses on booking and confirming your consular appointment. Translation and document checking are available as complementary services.',
                            'q' => 'Does this service include preparing the complete visa file?',
                            'a' => 'This service specifically focuses on booking and confirming your consular appointment. Translation and document checking are available as complementary services.',
                        ],
                        [
                            'question' => 'What information is needed to book?',
                            'answer' => 'A valid passport, personal details matching official records, and the exact type of visa or consular transaction requested.',
                            'q' => 'What information is needed to book?',
                            'a' => 'A valid passport, personal details matching official records, and the exact type of visa or consular transaction requested.',
                        ],
                        [
                            'question' => 'What happens if no slots are currently available?',
                            'answer' => 'We regularly monitor the official booking platforms to secure newly opened slots or cancellations as soon as they become available.',
                            'q' => 'What happens if no slots are currently available?',
                            'a' => 'We regularly monitor the official booking platforms to secure newly opened slots or cancellations as soon as they become available.',
                        ],
                    ],
                    'it' => [
                        [
                            'question' => 'È possibile prenotare appuntamenti per tutte le ambasciate?',
                            'answer' => 'Offriamo assistenza per consolati e ambasciate dotati di piattaforme telematiche o canali ufficiali comunicati, secondo disponibilità.',
                            'q' => 'È possibile prenotare appuntamenti per tutte le ambasciate?',
                            'a' => 'Offriamo assistenza per consolati e ambasciate dotati di piattaforme telematiche o canali ufficiali comunicati, secondo disponibilità.',
                        ],
                        [
                            'question' => 'È garantita una data specifica?',
                            'answer' => 'Le date dipendono esclusivamente dalla disponibilità dei portali ufficiali e dei centri visti autorizzati. Monitoriamo per prenotare il primo slot utile.',
                            'q' => 'È garantita una data specifica?',
                            'a' => 'Le date dipendono esclusivamente dalla disponibilità dei portali ufficiali e dei centri visti autorizzati. Monitoriamo per prenotare il primo slot utile.',
                        ],
                        [
                            'question' => 'Il servizio include la preparazione del fascicolo di visto?',
                            'answer' => 'Il servizio è dedicato alla prenotazione e conferma dell\'appuntamento. Qualora servano traduzioni giurate o revisione documentale, forniamo servizi dedicati.',
                            'q' => 'Il servizio include la preparazione del fascicolo di visto?',
                            'a' => 'Il servizio è dedicato alla prenotazione e conferma dell\'appuntamento. Qualora servano traduzioni giurate o revisione documentale, forniamo servizi dedicati.',
                        ],
                        [
                            'question' => 'Quali dati sono necessari per la prenotazione?',
                            'answer' => 'Passaporto in corso di validità, dati anagrafici corrispondenti ai documenti ufficiali e tipologia esatta della pratica.',
                            'q' => 'Quali dati sono necessari per la prenotazione?',
                            'a' => 'Passaporto in corso di validità, dati anagrafici corrispondenti ai documenti ufficiali e tipologia esatta della pratica.',
                        ],
                        [
                            'question' => 'Cosa accade se non ci sono date disponibili?',
                            'answer' => 'Effettuiamo controlli frequenti sui sistemi ufficiali per cogliere aperture di nuovi calendari o disdette tempestivamente.',
                            'q' => 'Cosa accade se non ci sono date disponibili?',
                            'a' => 'Effettuiamo controlli frequenti sui sistemi ufficiali per cogliere aperture di nuovi calendari o disdette tempestivamente.',
                        ],
                    ],
                ],
            ]);
        }

        // 2. Add / Update Dynamic Site Settings for About Us page
        $aboutSettings = [
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

        foreach ($aboutSettings as $key => $val) {
            SiteSetting::query()->updateOrCreate(['key' => $key], ['value' => $val]);
        }

        Cache::forget('site.settings');
        Cache::forget('site.services.active');
        Cache::forget('site.sitemap');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Cache::forget('site.settings');
        Cache::forget('site.services.active');
        Cache::forget('site.sitemap');
    }
};
