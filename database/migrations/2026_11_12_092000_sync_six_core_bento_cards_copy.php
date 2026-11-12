<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settingsToSync = [
            // 6 Bento Cards Navigation Titles & Subtitles
            'why_bento_services_nav_title' => [
                'ar' => 'خدمات تعليمية ومهنية متكاملة',
                'en' => 'Integrated Services',
                'it' => 'Servizi Integrati'
            ],
            'why_bento_services_nav_sub' => [
                'ar' => '10 خدمات متنوعة تحت سقف واحد',
                'en' => '10 diverse services under one roof',
                'it' => '10 servizi diversi sotto lo stesso tetto'
            ],

            'why_bento_practical_nav_title' => [
                'ar' => 'تدريب عملي وتطبيق واقعي',
                'en' => 'Practical & Real Training',
                'it' => 'Formazione Pratica e Reale'
            ],
            'why_bento_practical_nav_sub' => [
                'ar' => 'تطبيقات وتدريبات تحاكي الواقع',
                'en' => 'Real-world practice & simulations',
                'it' => 'Esercitazioni e simulazioni reali'
            ],

            'why_bento_trainers_nav_title' => [
                'ar' => 'مدربون ومتخصصون في مجالاتهم',
                'en' => 'Expert Domain Specialists',
                'it' => 'Docenti e Specialisti Esperti'
            ],
            'why_bento_trainers_nav_sub' => [
                'ar' => 'خبرات في مجالات التعليم والتدريب',
                'en' => 'Real educational & training expertise',
                'it' => 'Esperienza nell insegnamento e formazione'
            ],

            'why_bento_support_nav_title' => [
                'ar' => 'متابعة ودعم مستمر',
                'en' => 'Continuous Support & Tracking',
                'it' => 'Supporto e Tutoraggio Continuo'
            ],
            'why_bento_support_nav_sub' => [
                'ar' => 'دعم ومتابعة خلال رحلتك',
                'en' => 'Dedicated guidance along your path',
                'it' => 'Assistenza costante lungo il percorso'
            ],

            'why_bento_customized_nav_title' => [
                'ar' => 'حلول تناسب أهدافك',
                'en' => 'Solutions Tailored to Your Goals',
                'it' => 'Soluzioni Adatte ai Tuoi Traguardi'
            ],
            'why_bento_customized_nav_sub' => [
                'ar' => 'خدمات تناسب احتياجاتك وأهدافك',
                'en' => 'Matching your needs and goals',
                'it' => 'Adatte alle tue esigenze e traguardi'
            ],

            'why_bento_future_nav_title' => [
                'ar' => 'تأهيل لمستقبلك الأكاديمي والمهني',
                'en' => 'Academic & Career Future Readiness',
                'it' => 'Preparazione al Futuro'
            ],
            'why_bento_future_nav_sub' => [
                'ar' => 'تطوير مهاراتك الأكاديمية والمهنية',
                'en' => 'Building your academic & career skills',
                'it' => 'Sviluppo competenze accademiche e professionali'
            ],

            // 6 Bento Cards Main Headlines
            'why_bento_services_title' => [
                'ar' => '01 – خدمات تعليمية ومهنية متكاملة',
                'en' => '01 – Integrated Educational & Vocational Services',
                'it' => '01 – Servizi Didattici e Professionali Integrati'
            ],
            'why_bento_services_desc' => [
                'ar' => 'في INTOK بنوفر مجموعة متنوعة من الخدمات التعليمية والمهنية والأكاديمية، علشان تلاقي كل اللي تحتاجه في مكان واحد.',
                'en' => 'At INTOK, we provide a diverse range of educational, vocational, and academic services so you find everything you need in one place with expert guidance.',
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
                'it' => 'Ogni persona ha un traguardo unico: selezioniamo il percorso ideale per il tuo profilo.'
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

            // Feature points
            'why_bento_services_points' => [
                'ar' => "10 خدمات متنوعة تحت سقف واحد.\nمسارات تعليمية وتدريبية متعددة.\nحلول تناسب أهدافك الأكاديمية والمهنية.\nخدمات للأفراد والطلاب والخريجين.",
                'en' => "10 diverse services under one roof.\nMultiple educational and vocational tracks.\nSolutions aligned with your academic & career goals.\nDedicated services for individuals, students, and graduates.",
                'it' => "10 servizi diversi sotto lo stesso tetto.\nMolteplici percorsi formativi e professionali.\nSoluzioni su misura per i tuoi traguardi.\nServizi per privati, studenti e laureati."
            ],
            'why_bento_practical_points' => [
                'ar' => "تدريبات عملية حسب طبيعة كل برنامج.\nمحاكاة لمواقف العمل الحقيقية.\nتطبيقات وتمارين تفاعلية.\nتقييم مستمر لمستوى المتدرب.",
                'en' => "Targeted practical sessions tailored to each program.\nRealistic simulation of actual workplace scenarios.\nInteractive exercises and continuous hands-on applications.\nContinuous assessment and progression tracking.",
                'it' => "Esercitazioni pratiche in base alla natura di ogni corso.\nSimulazione di reali situazioni lavorative.\nApplicazioni ed esercizi interattivi continui.\nValutazione e monitoraggio costante del livello."
            ],
            'why_bento_trainers_points' => [
                'ar' => "محتوى تدريبي متخصص.\nشرح وتطبيق وفق طبيعة المجال.\nمتابعة وتوجيه خلال التدريب.\nالاهتمام بتطوير مستوى المتدرب.",
                'en' => "Specialized curriculum designed to market standards.\nClear explanation and applied practice for each field.\nGuidance and personalized feedback during training.\nDedicated attention to raising each learner's proficiency.",
                'it' => "Contenuto formativo specialistico e aggiornato.\nSpiegazione e applicazione pratica mirata.\nAssistenza e orientamento durante il corso.\nAttenzione costante alla crescita del singolo studente."
            ],
            'why_bento_support_points' => [
                'ar' => "متابعة مراحل التدريب أو تقديم الخدمة.\nالرد على الاستفسارات.\nتوضيح الخطوات والمتطلبات.\nدعم مستمر حسب طبيعة كل خدمة.",
                'en' => "Tracking all training and service delivery stages.\nPrompt answers to all questions and inquiries.\nFull clarity on prerequisite steps and requirements.\nOngoing support tailored to the nature of each service.",
                'it' => "Monitoraggio attento di tutte le fasi del percorso.\nRisposte puntuali a qualsiasi domanda o dubbio.\nTotale chiarezza sui requisiti e passaggi necessari.\nAssistenza costante su misura per ogni tipologia di servizio."
            ],
            'why_bento_customized_points' => [
                'ar' => "فهم احتياجاتك قبل اختيار الخدمة.\nتوجيهك للمسار المناسب.\nتوضيح المتطلبات والتفاصيل.\nاقتراح خطوات واضحة للبدء.",
                'en' => "Understanding your background before selecting a track.\nGuiding you toward the optimal academic or career path.\nClarifying all requirements, timeline, and details.\nProposing clear, actionable steps to start right.",
                'it' => "Comprensione del profilo prima della scelta del corso.\nIndirizzamento verso la scelta più vantaggiosa per te.\nChiarezza totale su requisiti, tempistiche e dettagli.\nPassaggi chiari per iniziare senza incertezze."
            ],
            'why_bento_future_points' => [
                'ar' => "التأهيل للدراسة في أوروبا.\nالاستعداد للاختبارات الدولية.\nتطوير المهارات اللغوية والمهنية.\nالمساعدة في إجراءات القبول الأكاديمي.",
                'en' => "Preparation for studying in Europe.\nReadiness for international examinations.\nDevelopment of language and professional skills.\nAssistance throughout academic admission procedures.",
                'it' => "Orientamento e preparazione per studiare in Europa.\nPreparazione a esami e certificazioni internazionali.\nMiglioramento delle abilità linguistiche e professionali.\nSupporto nelle pratiche di ammissione accademica."
            ],

            // Added Values (stat_label)
            'why_bento_services_stat_label' => [
                'ar' => 'القيمة المضافة: تجربة متكاملة بدل البحث عن أكثر من جهة.',
                'en' => 'Added Value: An integrated experience saving you from scattered providers.',
                'it' => 'Valore Aggiunto: Un esperienza integrata evitando fornitori frammentati.'
            ],
            'why_bento_practical_stat_label' => [
                'ar' => 'القيمة المضافة: مهارات قابلة للتطبيق في الواقع.',
                'en' => 'Added Value: Immediately applicable real-world skills.',
                'it' => 'Valore Aggiunto: Competenze subito spendibili sul lavoro.'
            ],
            'why_bento_trainers_stat_label' => [
                'ar' => 'القيمة المضافة: تعلم على إيد متخصصين.',
                'en' => 'Added Value: Learn directly from seasoned practitioners.',
                'it' => 'Valore Aggiunto: Impara direttamente da professionisti esperti.'
            ],
            'why_bento_support_stat_label' => [
                'ar' => 'القيمة المضافة: مش بتكون لوحدك في رحلتك.',
                'en' => 'Added Value: You are never alone on your journey.',
                'it' => 'Valore Aggiunto: Non sarai mai solo lungo il percorso.'
            ],
            'why_bento_customized_stat_label' => [
                'ar' => 'القيمة المضافة: تبدأ من المكان المناسب لهدفك.',
                'en' => 'Added Value: Start right from the place fitting your goal.',
                'it' => 'Valore Aggiunto: Parti dal punto ideale per il tuo traguardo.'
            ],
            'why_bento_future_stat_label' => [
                'ar' => 'القيمة المضافة: خطوات واضحة ومدروسة نحو مستقبلك.',
                'en' => 'Added Value: Clear, well-studied steps toward your future.',
                'it' => 'Valore Aggiunto: Passi chiari e concreti verso il tuo futuro.'
            ],
        ];

        foreach ($settingsToSync as $key => $val) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }

        \Illuminate\Support\Facades\Cache::forget('site.settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive
    }
};
