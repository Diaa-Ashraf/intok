<?php

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
        $settings = [
            'why_bento_future_stat_label' => [
                'ar' => 'القيمة المضافة: خطوات أوضح نحو مستقبلك.',
                'en' => 'Added value: Clearer steps toward your future.',
                'it' => 'Valore aggiunto: Passi più chiari verso il tuo futuro.'
            ],
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
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }

        Cache::forget('site.settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Cache::forget('site.settings');
    }
};
