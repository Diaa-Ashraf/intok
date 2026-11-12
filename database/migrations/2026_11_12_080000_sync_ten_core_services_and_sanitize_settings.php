<?php

use App\Models\SiteSetting;
use App\Services\ServiceCatalogService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Sync official 10 services and deactivate legacy obsolete rows
        try {
            $catalog = app(ServiceCatalogService::class);
            $catalog->ensureCoreServicesExist();
        } catch (\Throwable $e) {
            // Fail safe
        }

        // 2. Sanitize any legacy strings in site_settings mentioning Italy/إيطاليا
        $ctaTitle = SiteSetting::query()->where('key', 'cta_title')->first();
        if ($ctaTitle) {
            $val = $ctaTitle->value;
            if (is_array($val)) {
                $val['ar'] = 'جاهز تبدأ خطوتك الجاية مع INTOK؟';
                $val['en'] = 'Ready to Take Your Next Step with INTOK?';
                $val['it'] = 'Pronto a compiere il tuo prossimo passo con INTOK?';
                $ctaTitle->update(['value' => $val]);
            }
        }

        $ctaSub = SiteSetting::query()->where('key', 'cta_subtitle')->first();
        if ($ctaSub) {
            $val = $ctaSub->value;
            if (is_array($val)) {
                $val['ar'] = 'سواء هدفك تتعلم لغة، تطور مهاراتك المهنية، تتأهل للدراسة في أوروبا أو تستكمل إجراءاتك الأكاديمية، فريق INTOK جاهز يساعدك تبدأ.';
                $val['en'] = 'Whether your goal is learning a language, developing career skills, qualifying to study in Europe, or completing academic procedures, the INTOK team is ready to guide your start.';
                $val['it'] = 'Che il tuo obiettivo sia imparare una lingua, sviluppare competenze professionali, qualificarti per studiare in Europa o completare le tue pratiche accademiche, il team INTOK è pronto ad aiutarti a iniziare.';
                $ctaSub->update(['value' => $val]);
            }
        }

        // 3. Update live slider title and subtitle
        SiteSetting::query()->updateOrCreate(['key' => 'live_slider_title'], [
            'value' => [
                'ar' => 'شوف INTOK بتساعدك تطور مستقبلك إزاي',
                'en' => 'See How INTOK Helps You Build Your Future',
                'it' => 'Scopri come INTOK ti aiuta a costruire il tuo futuro'
            ]
        ]);
        SiteSetting::query()->updateOrCreate(['key' => 'live_slider_subtitle'], [
            'value' => [
                'ar' => 'لقطات حقيقية من تدريباتنا، محاضراتنا، خدماتنا التعليمية وتجارب المتدربين داخل INTOK.',
                'en' => 'Real moments from our training, lectures, educational services, and student experiences inside INTOK.',
                'it' => 'Riprese reali dai nostri corsi, lezioni, servizi educativi ed esperienze concrete degli studenti in INTOK.'
            ]
        ]);

        // 4. Update why choose us title and subtitle
        SiteSetting::query()->updateOrCreate(['key' => 'why_title'], [
            'value' => [
                'ar' => 'ليه INTOK هي خطوتك الصح لمستقبلك؟',
                'en' => 'Why INTOK is the Right Step for Your Future?',
                'it' => 'Perché INTOK è il passo giusto per il tuo futuro?'
            ]
        ]);
        SiteSetting::query()->updateOrCreate(['key' => 'why_subtitle'], [
            'value' => [
                'ar' => 'في INTOK بنجمع بين التعليم والتدريب والتأهيل المهني والخدمات الأكاديمية، علشان نساعدك تطور مهاراتك وتحقق أهدافك بخطوات واضحة ودعم متخصص.',
                'en' => 'At INTOK, we combine education, practical training, professional qualification, and academic services to help you build skills and achieve your goals with clear steps and expert support.',
                'it' => 'In INTOK uniamo formazione, istruzione, qualificazione professionale e servizi accademici per aiutarti a sviluppare competenze e raggiungere i tuoi obiettivi con passi chiari e supporto dedicato.'
            ]
        ]);

        // 5. Update why bento 6 cards nav titles and subs
        $bentoUpdates = [
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
        foreach ($bentoUpdates as $k => $v) {
            SiteSetting::query()->updateOrCreate(['key' => $k], ['value' => $v]);
        }

        // 6. Clear cache
        Cache::forget('site.settings');
        Cache::forget('site.services.active');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op
    }
};

