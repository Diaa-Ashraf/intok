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

        // 3. Clear cache
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

