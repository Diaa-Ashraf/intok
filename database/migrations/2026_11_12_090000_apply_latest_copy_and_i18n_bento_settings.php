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
            // Live Slider Copy
            'live_slider_title' => [
                'ar' => 'شوف INTOK بتساعدك تطور مستقبلك إزاي',
                'en' => 'See How INTOK Helps You Build Your Future',
                'it' => 'Guarda come INTOK ti aiuta a costruire il tuo futuro'
            ],
            'live_slider_subtitle' => [
                'ar' => 'لقطات حقيقية من تدريباتنا، محاضراتنا، خدماتنا التعليمية وتجارب المتدربين داخل INTOK.',
                'en' => 'Real moments from our practical sessions, lectures, educational services, and student experiences at INTOK.',
                'it' => 'Momenti reali delle nostre lezioni pratiche, servizi didattici ed esperienze degli studenti in INTOK.'
            ],
            'live_slide_1_title' => [
                'ar' => 'اتعلم لغة تفتحلك فرص جديدة',
                'en' => 'Learn a Language Opening New Opportunities',
                'it' => 'Impara una lingua che apre nuove opportunità'
            ],
            'live_slide_1_desc' => [
                'ar' => 'تدريبات عملية لتطوير مهارات التحدث والتواصل بمختلف اللغات.',
                'en' => 'Practical training to build spoken conversational fluency in multiple foreign languages.',
                'it' => 'Esercitazioni pratiche per sviluppare conversazione e comunicazione in varie lingue.'
            ],
            'live_slide_2_title' => [
                'ar' => 'اتأهل لمستقبلك المهني',
                'en' => 'Qualify for Your Professional Career',
                'it' => 'Qualificati per la tua carriera lavorativa'
            ],
            'live_slide_2_desc' => [
                'ar' => 'تدريب عملي في الكول سنتر والترجمة وتطوير المهارات المطلوبة لسوق العمل.',
                'en' => 'Hands-on practical training in Call Center, certified translation, and in-demand skills.',
                'it' => 'Formazione pratica per call center, traduzione e competenze richieste dal mercato.'
            ],
            'live_slide_3_title' => [
                'ar' => 'جهّز خطوتك الأكاديمية بثقة',
                'en' => 'Prepare Your Academic Next Step Confidently',
                'it' => 'Prepara il tuo percorso accademico con fiducia'
            ],
            'live_slide_3_desc' => [
                'ar' => 'تأهيل للدراسة في أوروبا، وتجهيز ملفات التقديم والتدريب على الاختبارات الدولية.',
                'en' => 'Preparation for European university studies, application dossier auditing, and international exams coaching.',
                'it' => 'Orientamento per studiare in Europa, preparazione dossier e corsi per esami internazionali.'
            ],

            // Why Choose Us Copy
            'why_title' => [
                'ar' => 'ليه INTOK هي خطوتك الصح لمستقبلك؟',
                'en' => 'Why INTOK is the Right Step for Your Future?',
                'it' => 'Perché INTOK è il passo giusto per il tuo futuro?'
            ],
            'why_subtitle' => [
                'ar' => 'في INTOK بنجمع بين التعليم والتدريب والتأهيل المهني والخدمات الأكاديمية، علشان نساعدك تطور مهاراتك وتحقق أهدافك بخطوات واضحة ودعم متخصص.',
                'en' => 'At INTOK, we combine education, practical training, professional qualification, and academic services to help you build skills and achieve your goals with clear steps and expert support.',
                'it' => 'In INTOK uniamo formazione, istruzione, qualificazione professionale e servizi accademici per aiutarti a sviluppare competenze e raggiungere i tuoi traguardi con passi chiari e supporto dedicato.'
            ],

            // 6 Bento Cards
            'why_bento_services_nav_title' => ['ar' => 'خدمات متكاملة', 'en' => 'Integrated Services', 'it' => 'Servizi Integrati'],
            'why_bento_services_nav_sub' => ['ar' => '10 خدمات تعليمية ومهنية وأكاديمية', 'en' => '10 educational & vocational services', 'it' => '10 servizi educativi e professionali'],

            'why_bento_practical_nav_title' => ['ar' => 'تدريب عملي', 'en' => 'Practical Training', 'it' => 'Formazione Pratica'],
            'why_bento_practical_nav_sub' => ['ar' => 'تطبيقات وتدريبات تحاكي الواقع', 'en' => 'Real-world practice & simulations', 'it' => 'Esercitazioni e simulazioni reali'],

            'why_bento_trainers_nav_title' => ['ar' => 'مدربون متخصصون', 'en' => 'Expert Instructors', 'it' => 'Docenti Esperti'],
            'why_bento_trainers_nav_sub' => ['ar' => 'خبرات في مجالات التعليم والتدريب', 'en' => 'Real educational & training expertise', 'it' => 'Esperienza nell insegnamento e formazione'],

            'why_bento_support_nav_title' => ['ar' => 'متابعة مستمرة', 'en' => 'Continuous Follow-up', 'it' => 'Supporto Continuo'],
            'why_bento_support_nav_sub' => ['ar' => 'دعم ومتابعة خلال رحلتك', 'en' => 'Dedicated guidance along your path', 'it' => 'Assistenza costante lungo il percorso'],

            'why_bento_customized_nav_title' => ['ar' => 'حلول مخصصة', 'en' => 'Tailored Solutions', 'it' => 'Soluzioni Su Misura'],
            'why_bento_customized_nav_sub' => ['ar' => 'خدمات تناسب احتياجاتك وأهدافك', 'en' => 'Matching your needs and goals', 'it' => 'Adatte alle tue esigenze e traguardi'],

            'why_bento_future_nav_title' => ['ar' => 'تأهيل للمستقبل', 'en' => 'Future Readiness', 'it' => 'Preparazione al Futuro'],
            'why_bento_future_nav_sub' => ['ar' => 'تطوير مهاراتك الأكاديمية والمهنية', 'en' => 'Building your academic & career skills', 'it' => 'Sviluppo competenze accademiche e professionali'],
        ];

        foreach ($settingsToSync as $key => $val) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse
    }
};
