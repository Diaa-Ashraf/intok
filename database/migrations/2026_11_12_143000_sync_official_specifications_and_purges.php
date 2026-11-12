<?php

use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Purge obsolete services and keep strictly the 10 official services
        $validSlugs = [
            'certified-translation',
            'language-courses',
            'study-in-europe',
            'call-center-qualification',
            'translation-qualification',
            'university-admission-exams',
            'international-language-certificates',
            'university-school-admission',
            'proofreading-service',
            'embassy-appointments',
        ];

        Service::query()->whereNotIn('slug_ar', $validSlugs)->delete();

        // Ensure service 1 duration is explicitly set to immediate delivery on demand
        Service::query()->where('slug_ar', 'certified-translation')->update([
            'duration' => [
                'ar' => 'تسليم فوري حسب الطلب والتنسيق',
                'en' => 'Immediate delivery upon request & coordination',
                'it' => 'Consegna immediata su richiesta e coordinamento',
            ],
        ]);

        // 2. Set realistic photos and titles for the 4 core team members
        $teamPhotos = [
            1 => 'assets/images/team/member-1.jpg',
            2 => 'assets/images/team/member-2.jpg',
            3 => 'assets/images/team/member-3.jpg',
            4 => 'assets/images/team/member-4.jpg',
        ];

        foreach (TeamMember::orderBy('sort_order')->get() as $member) {
            $member->update([
                'photo_path' => $teamPhotos[$member->sort_order] ?? 'assets/images/team/member-1.jpg',
                'is_active' => true,
            ]);
        }

        // 3. Sync official site settings exactly as requested
        $settings = [
            // Hero
            'hero_badge' => [
                'ar' => 'شريكك الموثوق نحو النجاح • INTOK Academy',
                'en' => 'Your Trusted Partner to Success • INTOK Academy',
                'it' => 'Il tuo partner di fiducia per il successo • INTOK Academy',
            ],
            'hero_title' => [
                'ar' => 'INTOK - بوابتك للتعلم والتطور وبناء مستقبلك',
                'en' => 'INTOK - Your Gateway to Learning, Growth & Future Building',
                'it' => 'INTOK - La tua porta per imparare, crescere e costruire il futuro',
            ],
            'hero_text' => [
                'ar' => 'من تعلم اللغات والترجمة المعتمدة، إلى التدريب المهني والخدمات الأكاديمية والدراسة في أكثر من 10 دول أوروبية. بنوفرلك المعرفة والتأهيل والدعم اللي يساعدك تخطّي خطوتك الجاية بثقة.',
                'en' => 'From language learning and certified translation to professional career training, academic services, and studying in 10+ European countries. We provide knowledge, qualification, and support to take your next step with confidence.',
                'it' => "Dall'apprendimento delle lingue e traduzioni asseverate alla formazione professionale, servizi accademici e studi in oltre 10 paesi europei. Ti offriamo conoscenza, qualificazione e supporto per compiere il tuo prossimo passo con sicurezza.",
            ],
            'hero_cta' => [
                'ar' => 'ابدأ رحلتك مع INTOK',
                'en' => 'Start Your Journey with INTOK',
                'it' => 'Inizia il tuo percorso con INTOK',
            ],
            'hero_secondary_cta' => [
                'ar' => 'استكشف خدماتنا',
                'en' => 'Explore Our Services',
                'it' => 'Scopri i nostri servizi',
            ],
            'hero_stat_1_val' => '10+',
            'hero_stat_1_lbl' => [
                'ar' => 'دول أوروبية • وجهات دراسية متنوعة',
                'en' => 'European Countries • Diverse Destinations',
                'it' => 'Paesi Europei • Destinazioni Varie',
            ],
            'hero_stat_2_val' => '1,200+',
            'hero_stat_2_lbl' => [
                'ar' => 'طالب ومتدرب تم تأهيلهم بنجاح',
                'en' => 'Students & Trainees Successfully Qualified',
                'it' => 'Studenti e corsisti qualificati con successo',
            ],
            'hero_stat_3_val' => '100%',
            'hero_stat_3_lbl' => [
                'ar' => 'استكمال الملفات',
                'en' => 'File Completion',
                'it' => 'Completamento Fascicoli',
            ],
            'hero_stat_3_sub' => [
                'ar' => 'متابعة وتجهيز الملفات وفق المتطلبات',
                'en' => 'File tracking and preparation as required',
                'it' => 'Monitoraggio e preparazione secondo i requisiti',
            ],

            // Services
            'services_badge' => [
                'ar' => '10 خدمات تعليمية ومهنية متكاملة',
                'en' => '10 Integrated Educational & Career Services',
                'it' => '10 Servizi Educativi e Professionali',
            ],
            'services_title' => [
                'ar' => 'INTOK  خدمات تعليمية ومهنية متكاملة',
                'en' => 'INTOK - Integrated Educational & Professional Services',
                'it' => 'INTOK - Servizi educativi e professionali integrati',
            ],
            'services_subtitle' => [
                'ar' => 'بنقدم لك حلول تعليمية ومهنية متكاملة تبدأ من تعلم اللغات والترجمة المعتمدة، مرورًا بالتأهيل والتدريب المهني، وصولًا للدراسة بالخارج والخدمات الأكاديمية الدولية.',
                'en' => 'We offer integrated educational and professional solutions starting from language learning and certified translation, through vocational training, to studying abroad and international academic services.',
                'it' => "Offriamo soluzioni educative e professionali integrate che partono dall'apprendimento delle lingue e dalle traduzioni asseverate, passano per la formazione professionale fino agli studi all'estero e ai servizi accademici internazionali.",
            ],

            // Live Slider
            'live_slider_title' => [
                'ar' => 'شوف INTOK بتساعدك تطور مستقبلك إزاي',
                'en' => 'See How INTOK Helps You Build Your Future',
                'it' => 'Guarda come INTOK ti aiuta a costruire il futuro',
            ],
            'live_slider_subtitle' => [
                'ar' => 'لقطات حقيقية من تدريباتنا، محاضراتنا، خدماتنا التعليمية وتجارب المتدربين داخل INTOK.',
                'en' => 'Real moments from our training, lectures, educational services, and student experiences at INTOK.',
                'it' => 'Momenti reali delle nostre formazioni, lezioni ed esperienze degli studenti presso INTOK.',
            ],

            // About Section 9: Live Inside INTOK
            'about_inside_badge' => [
                'ar' => 'من داخل INTOK',
                'en' => 'Inside INTOK',
                'it' => 'Dentro INTOK',
            ],
            'about_inside_title' => [
                'ar' => 'مش مجرد كلام.. شوف تجربتنا على أرض الواقع',
                'en' => 'More Than Just Words.. Experience Our Real Journey',
                'it' => 'Non Solo Parole.. Scopri la Nostra Esperienza sul Campo',
            ],
            'about_inside_desc' => [
                'ar' => 'اكتشف جانبًا من أنشطتنا التعليمية والتدريبية، وشاهد لقطات من المحاضرات والتدريبات والفعاليات والتجارب الحقيقية داخل الأكاديمية.',
                'en' => 'Discover our educational and training activities, interactive lectures, hands-on simulations, and real experiences inside the academy.',
                'it' => "Scopri le nostre attività educative e formative: lezioni interattive, simulazioni pratiche e momenti reali all'interno dell'accademia.",
            ],
            'about_inside_caption_1' => [
                'ar' => 'محاضرات لغوية وتدريبات تفاعلية',
                'en' => 'Interactive Language Lectures',
                'it' => 'Lezioni interattive di lingua',
            ],
            'about_inside_caption_2' => [
                'ar' => 'محاكاة عملية لكول سنتر ومقابلات العمل',
                'en' => 'Job Interviews & Call Center Simulations',
                'it' => 'Simulazioni di colloqui e call center',
            ],
            'about_inside_caption_3' => [
                'ar' => 'تأهيل للدراسة بالجامعات الأوروبية',
                'en' => 'Preparation for European Universities',
                'it' => 'Preparazione per università europee',
            ],
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('site.settings');
        Cache::forget('site.sitemap');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

