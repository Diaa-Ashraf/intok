<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceCatalogService
{
    public function __construct(private readonly ImageUploadService $images)
    {
    }

    public function paginateForAdmin(int $perPage = 20): LengthAwarePaginator
    {
        $this->ensureCoreServicesExist();

        return Service::query()
            ->select([
                'id',
                'slug',
                'slug_ar',
                'slug_en',
                'slug_it',
                'title',
                'summary',
                'badge',
                'category_label',
                'level',
                'duration',
                'mode',
                'salary_range',
                'icon',
                'image_path',
                'sort_order',
                'is_active',
                'created_at',
            ])
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function paginateActive(int $perPage = 12): LengthAwarePaginator
    {
        $this->ensureCoreServicesExist();

        return Service::query()
            ->select([
                'id',
                'slug',
                'slug_ar',
                'slug_en',
                'slug_it',
                'title',
                'summary',
                'badge',
                'category_label',
                'level',
                'duration',
                'mode',
                'target_audience',
                'salary_range',
                'whatsapp_message',
                'icon',
                'image_path',
                'sort_order',
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate($perPage);
    }

    public function findPublishedBySlug(string $locale, string $slug): ?Service
    {
        $this->ensureCoreServicesExist();

        $column = in_array($locale, ['ar', 'en', 'it'], true) ? 'slug_'.$locale : 'slug_ar';

        return Service::query()
            ->select([
                'id',
                'slug',
                'slug_ar',
                'slug_en',
                'slug_it',
                'title',
                'summary',
                'description',
                'badge',
                'category_label',
                'level',
                'duration',
                'mode',
                'target_audience',
                'salary_range',
                'whatsapp_message',
                'features',
                'requirements',
                'steps',
                'faqs',
                'seo_title',
                'seo_description',
                'icon',
                'image_path',
                'sort_order',
                'is_active',
            ])
            ->where('is_active', true)
            ->where(function ($query) use ($column, $slug) {
                $query->where($column, $slug)
                    ->orWhere('slug_ar', $slug)
                    ->orWhere('slug_en', $slug)
                    ->orWhere('slug_it', $slug);
            })
            ->first();
    }

    /**
     * Return all active services for the public site, ordered by sort_order.
     *
     * @return Collection<int, Service>
     */
    public function activeForLocale(string $locale): Collection
    {
        $this->ensureCoreServicesExist();

        return Service::query()
            ->select([
                'id',
                'slug',
                'slug_ar',
                'slug_en',
                'slug_it',
                'title',
                'summary',
                'description',
                'badge',
                'category_label',
                'level',
                'duration',
                'mode',
                'target_audience',
                'salary_range',
                'whatsapp_message',
                'features',
                'requirements',
                'steps',
                'faqs',
                'icon',
                'image_path',
                'sort_order',
                'is_active',
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Service
    {
        $image = $data['image'] ?? null;
        unset($data['image']);
        $data = $this->withLocalizedSlugColumns($data);
        $imagePath = $image instanceof \Illuminate\Http\UploadedFile ? $this->images->storeWebp($image, 'services', 1800, 1400) : null;
        if ($imagePath !== null) {
            $data['image_path'] = $imagePath;
        }

        try {
            $service = DB::transaction(fn (): Service => Service::query()->create($data));
            Cache::forget('site.sitemap');
            return $service;
        } catch (\Throwable $exception) {
            if ($imagePath !== null) {
                Storage::disk('public')->delete($imagePath);
            }
            throw $exception;
        }
    }

    /** @param array<string, mixed> $data */
    public function update(Service $service, array $data): Service
    {
        $image = $data['image'] ?? null;
        unset($data['image']);
        $data = $this->withLocalizedSlugColumns($data);
        $oldImagePath = $service->image_path;
        $newImagePath = $image instanceof \Illuminate\Http\UploadedFile ? $this->images->storeWebp($image, 'services', 1800, 1400) : null;
        if ($newImagePath !== null) {
            $data['image_path'] = $newImagePath;
        }

        try {
            $updated = DB::transaction(function () use ($service, $data): Service {
                $service->update($data);
                return $service->refresh();
            });
        } catch (\Throwable $exception) {
            if ($newImagePath !== null) {
                Storage::disk('public')->delete($newImagePath);
            }
            throw $exception;
        }

        if ($newImagePath !== null && $oldImagePath !== null) {
            Storage::disk('public')->delete($oldImagePath);
        }

        Cache::forget('site.sitemap');
        return $updated;
    }

    public function toggleActive(Service $service): bool
    {
        $service->update(['is_active' => !$service->is_active]);
        Cache::forget('site.sitemap');
        return (bool) $service->is_active;
    }

    public function delete(Service $service): void
    {
        $imagePath = $service->image_path;
        DB::transaction(fn (): bool => (bool) $service->delete());
        if ($imagePath !== null) {
            Storage::disk('public')->delete($imagePath);
        }
        Cache::forget('site.sitemap');
    }

    /**
     * Normalizes and enriches the multi-language data arrays before persistence.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function withLocalizedSlugColumns(array $data): array
    {
        // Features, Requirements, Steps
        foreach (['features', 'requirements', 'steps'] as $field) {
            foreach (['ar', 'en', 'it'] as $locale) {
                $data[$field][$locale] = $this->textLines($data[$field.'_text'][$locale] ?? '');
            }
            unset($data[$field.'_text']);
        }

        // FAQs
        foreach (['ar', 'en', 'it'] as $locale) {
            $data['faqs'][$locale] = $this->faqLines($data['faqs_text'][$locale] ?? '');
        }
        unset($data['faqs_text']);

        // Auto-fill missing English and Italian fields from Arabic if empty
        $localizedFields = [
            'title',
            'summary',
            'description',
            'badge',
            'category_label',
            'level',
            'duration',
            'mode',
            'target_audience',
            'salary_range',
            'whatsapp_message',
            'seo_title',
            'seo_description',
        ];

        foreach ($localizedFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $arVal = $data[$field]['ar'] ?? '';
                if (empty($data[$field]['en'])) {
                    $data[$field]['en'] = $arVal;
                }
                if (empty($data[$field]['it'])) {
                    $data[$field]['it'] = $arVal;
                }
            }
        }

        // Slug columns
        $slugAr = $data['slug']['ar'] ?? Str::slug($data['title']['ar'] ?? 'service', '-', null);
        $slugEn = $data['slug']['en'] ?? Str::slug($data['title']['en'] ?? $slugAr);
        $slugIt = $data['slug']['it'] ?? Str::slug($data['title']['it'] ?? $slugEn);

        $data['slug_ar'] = $slugAr;
        $data['slug_en'] = !empty($slugEn) ? $slugEn : 'service-'.time();
        $data['slug_it'] = !empty($slugIt) ? $slugIt : $data['slug_en'];
        $data['slug'] = [
            'ar' => $data['slug_ar'],
            'en' => $data['slug_en'],
            'it' => $data['slug_it'],
        ];

        return $data;
    }

    /** @return list<string> */
    private function textLines(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/u', trim($value)) ?: []), static fn (string $line): bool => $line !== ''));
    }

    /** @return list<array{question: string, answer: string}> */
    private function faqLines(string $value): array
    {
        $faqs = [];
        foreach ($this->textLines($value) as $line) {
            $parts = explode('|', $line, 2);
            if (count($parts) === 2 && trim($parts[0]) !== '' && trim($parts[1]) !== '') {
                $faqs[] = ['question' => trim($parts[0]), 'answer' => trim($parts[1])];
            }
        }
        return $faqs;
    }

    /**
     * Ensures all 8 official INTOK core services exist in the database with rich metadata.
     */
    public function ensureCoreServicesExist(): void
    {
        $coreServices = array (
  0 => 
  array (
    'sort_order' => 1,
    'icon' => 'documents',
    'slug_ar' => 'certified-translation',
    'slug_en' => 'certified-translation',
    'slug_it' => 'traduzione-giurata',
    'title' => 
    array (
      'ar' => 'خدمة الترجمة المعتمدة',
      'en' => 'Certified Translation Service',
      'it' => 'Servizio di Traduzione Asseverata',
    ),
    'summary' => 
    array (
      'ar' => 'نقدم خدمات ترجمة معتمدة للمستندات والوثائق الرسمية بمختلف اللغات، من خلال متخصصين يحرصون على الدقة اللغوية والالتزام بمتطلبات الجهات المقدَّم إليها المستند.',
      'en' => 'Official certified translation services for legal and academic documents across multiple languages with strict compliance to embassy standards.',
      'it' => 'Servizi di traduzione asseverata e giurata per documenti ufficiali e accademici in varie lingue secondo le norme consolari.',
    ),
    'description' => 
    array (
      'ar' => 'نقدم خدمات ترجمة معتمدة للمستندات والوثائق الرسمية بمختلف اللغات، من خلال متخصصين يحرصون على الدقة اللغوية والالتزام بمتطلبات الجهات المقدَّم إليها المستند. نراعي أعلى معايير الدقة للشهادات الجامعية، إعلانات القيمة، السجلات التجارية، وعقود العمل.',
      'en' => 'We provide certified translation for official, academic, and corporate documents across multiple languages, ensuring accuracy and official embassy compliance.',
      'it' => 'Forniamo traduzioni giurate e conformi agli standard internazionali per documenti di studio, certificati di stato civile e contratti.',
    ),
    'badge' => 
    array (
      'ar' => 'معتمدة رسمياً وموثقة',
      'en' => 'Officially Certified & Stamped',
      'it' => 'Ufficialmente Asseverata',
    ),
    'category_label' => 
    array (
      'ar' => 'الترجمة والاعتماد',
      'en' => 'Translation & Certification',
      'it' => 'Traduzione & Asseverazione',
    ),
    'level' => 
    array (
      'ar' => 'توثيق وتصديق قانوني وقنصلي',
      'en' => 'Legal and Consular Authentication',
      'it' => 'Autenticazione Legale e Consolare',
    ),
    'duration' => 
    array (
      'ar' => 'تسليم فوري (24-48 ساعة)',
      'en' => 'Fast turnaround (24-48 hrs)',
      'it' => 'Consegna rapida (24-48h)',
    ),
    'mode' => 
    array (
      'ar' => 'أونلاين أو بمقر الأكاديمية',
      'en' => 'Online or Academy Office',
      'it' => 'Online o presso l accademia',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والخريجون والأفراد والشركات',
      'en' => 'Students, graduates, individuals, and corporate clients',
      'it' => 'Studenti, laureati, privati e aziende',
    ),
    'salary_range' => 
    array (
      'ar' => 'دقة قانونية متناهية 100%',
      'en' => '100% Diplomatic Acceptance',
      'it' => 'Precisione legale al 100%',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن خدمة الترجمة المعتمدة للمستندات',
      'en' => 'Hello, I want to inquire about certified translation services',
      'it' => 'Vorrei informazioni sulla traduzione asseverata dei documenti',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'ترجمة المستندات والوثائق الرسمية والأكاديمية والشخصية',
        1 => 'مراجعة دقيقة للمحتوى والتواريخ والأسماء والمصطلحات',
        2 => 'تجهيز الترجمات وفق متطلبات الجهة المستقبلة والسفارات',
        3 => 'ترجمة من وإلى عدة لغات حية (إيطالي، إنجليزي، ألماني، فرنسي، عربي)',
      ),
      'en' => 
      array (
        0 => 'Official translation of academic, personal, and corporate files',
        1 => 'Meticulous review of names, dates, and specialized terminology',
        2 => 'Full compliance with embassy and ministerial requirements',
        3 => 'Multi-language translation (English, Italian, German, French, Arabic)',
      ),
      'it' => 
      array (
        0 => 'Traduzione di certificati di studio, documenti personali e societari',
        1 => 'Revisione accurata di dati anagrafici e terminologia tecnica',
        2 => 'Conformità alle disposizioni di ambasciate e ministeri',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'صورة واضحة من المستند الأصلي',
        1 => 'تحديد اللغة المطلوبة للترجمة',
        2 => 'تحديد الجهة التي سيُقدم إليها المستند',
        3 => 'توضيح الموعد المطلوب للاستلام',
      ),
      'en' => 
      array (
        0 => 'Clear digital copy of the original document',
        1 => 'Specifying source and target languages',
        2 => 'Destination embassy or authority name',
        3 => 'Desired deadline',
      ),
      'it' => 
      array (
        0 => 'Copia leggibile del documento originale',
        1 => 'Indicazione delle lingue di traduzione',
        2 => 'Ente o ambasciata di destinazione',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'إرسال المستندات وتحديد اللغة',
        1 => 'مراجعة المستند وتحديد التكلفة والمدة',
        2 => 'تنفيذ الترجمة والمراجعة اللغوية والقانونية',
        3 => 'تسليم النسخة النهائية المعتمدة',
      ),
      'en' => 
      array (
        0 => 'Document submission and language selection',
        1 => 'Document audit and cost estimation',
        2 => 'Translation execution and dual proofreading',
        3 => 'Official certified delivery',
      ),
      'it' => 
      array (
        0 => 'Invio file e selezione lingue',
        1 => 'Valutazione e preventivo',
        2 => 'Traduzione e revisione',
        3 => 'Consegna ufficiale',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل الترجمة معتمدة ومقبولة لدى السفارات؟',
          'answer' => 'نعم، ترجمتنا معتمدة رسمياً ومختومة وتفي بكافة المعايير والشروط القنصلية والدبلوماسية.',
        ),
        1 => 
        array (
          'question' => 'ما اللغات المتاحة للترجمة في الأكاديمية؟',
          'answer' => 'نوفر ترجمة معتمدة للغات الإيطالية، الإنجليزية، الألمانية، الفرنسية، الإسبانية، والعربية.',
        ),
        2 => 
        array (
          'question' => 'هل يمكن استلام النسخ المترجمة إلكترونياً وبالمقر؟',
          'answer' => 'نعم، نوفر استلاماً إلكترونياً عالي الدقة (PDF معتمد) بالإضافة للنسخ الورقية المطبوعة والمختومة بمقر الأكاديمية أو عبر الشحن.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Is the translation recognized by embassies?',
          'answer' => 'Yes, our certified translations are officially stamped and accepted by embassies and official authorities.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Le traduzioni sono riconosciute dai consolati?',
          'answer' => 'Sì, le traduzioni sono asseverate e timbrate secondo gli standard consolari.',
        ),
      ),
    ),
  ),
  1 => 
  array (
    'sort_order' => 2,
    'icon' => 'language',
    'slug_ar' => 'language-courses',
    'slug_en' => 'language-courses',
    'slug_it' => 'corsi-di-lingua',
    'title' => 
    array (
      'ar' => 'دورات وكورسات اللغات',
      'en' => 'Language Courses & Programs',
      'it' => 'Corsi e Formazione Linguistica',
    ),
    'summary' => 
    array (
      'ar' => 'برامج تعليمية متخصصة لتعلم اللغات الأجنبية من المستوى المبتدئ حتى المستويات المتقدمة، مع التركيز على تطوير مهارات التحدث والاستماع والقراءة والكتابة للاستخدام الأكاديمي والمهني.',
      'en' => 'Comprehensive language training from beginner to advanced levels, focusing on live conversational fluency for study abroad and career excellence.',
      'it' => 'Percorsi formativi per l apprendimento delle lingue straniere dal livello base a quello avanzato con metodo interattivo.',
    ),
    'description' => 
    array (
      'ar' => 'برامج تعليمية متخصصة لتعلم اللغات الأجنبية (الإيطالية، الإنجليزية، الألمانية) من المستوى المبتدئ حتى المتقدم، مع التركيز على تطوير مهارات التحدث والاستماع والقراءة والكتابة للاستخدام الأكاديمي والمهني اليومي، بإشراف محاضرين وخبراء معتمدين.',
      'en' => 'Tailored courses in Italian, English, and German focusing on active conversation, grammar mastery, and career readiness.',
      'it' => 'Corsi intensivi di italiano, inglese e tedesco incentrati sulla conversazione e preparazione per studio e lavoro.',
    ),
    'badge' => 
    array (
      'ar' => 'من الصفر حتى الطلاقة',
      'en' => 'Zero to Full Fluency',
      'it' => 'Da Zero alla Padronanza',
    ),
    'category_label' => 
    array (
      'ar' => 'اللغات الأجنبية',
      'en' => 'Foreign Languages',
      'it' => 'Lingue Straniere',
    ),
    'level' => 
    array (
      'ar' => 'إيطالي - إنجليزي - ألماني (مستويات A1 حتى C2)',
      'en' => 'Italian, English, German (A1 to C2)',
      'it' => 'Italiano, Inglese, Tedesco (A1 - C2)',
    ),
    'duration' => 
    array (
      'ar' => 'مكثف وعادي حسب المستوى',
      'en' => 'Flexible and intensive schedules',
      'it' => 'Orari flessibili e intensivi',
    ),
    'mode' => 
    array (
      'ar' => 'حضوري بقاعات ذكية + أونلاين',
      'en' => 'Smart Classroom + Interactive Online',
      'it' => 'In aula multimediale + online',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والخريجون والباحثون عن تطوير مهاراتهم اللغوية',
      'en' => 'Students, graduates, and professionals seeking language mastery',
      'it' => 'Studenti e professionisti',
    ),
    'salary_range' => 
    array (
      'ar' => 'تطوير حقيقي للمحادثة 80%',
      'en' => '80% Live Conversation Focus',
      'it' => 'Focus conversazione attiva',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن كورسات اللغات وتحديد المستوى المتاح',
      'en' => 'Hello, I want to inquire about language courses and placement tests',
      'it' => 'Vorrei informazioni sui corsi di lingua e test di livello',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'مستويات تعليمية متدرجة تناسب مختلف المتعلمين والقدرات',
        1 => 'تدريب عملي تفاعلي يركز على المحادثة وكسر حاجز الخوف',
        2 => 'متابعة وتقييم دوري مستمر لمستوى المتدرب',
        3 => 'تحديد المستوى قبل بدء الدراسة لضمان الانضمام للمجموعة الأنسب',
      ),
      'en' => 
      array (
        0 => 'Structured learning paths for all proficiency tiers',
        1 => 'Interactive live dialogue sessions building real-world fluency',
        2 => 'Continuous progress assessment and personal feedback',
        3 => 'Free initial placement evaluation',
      ),
      'it' => 
      array (
        0 => 'Percorsi progressivi per ogni livello',
        1 => 'Laboratori di conversazione interattiva',
        2 => 'Monitoraggio continuo dei progressi',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد اللغة المراد تعلمها',
        1 => 'تحديد المستوى الحالي إن وجد عبر اختبار تحديد المستوى',
        2 => 'الالتزام بحضور المحاضرات والتطبيقات',
      ),
      'en' => 
      array (
        0 => 'Selecting target language',
        1 => 'Completing initial placement assessment',
        2 => 'Commitment to interactive sessions',
      ),
      'it' => 
      array (
        0 => 'Scelta della lingua',
        1 => 'Test di livello iniziale',
        2 => 'Presenza e partecipazione attiva',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'اختيار اللغة المناسبة',
        1 => 'إجراء اختبار تحديد المستوى',
        2 => 'اختيار المجموعة والجدول الزمني المفضل',
        3 => 'بدء الدراسة والتقييم المستمر',
      ),
      'en' => 
      array (
        0 => 'Language selection',
        1 => 'Placement test',
        2 => 'Schedule and cohort selection',
        3 => 'Course commencement & milestones',
      ),
      'it' => 
      array (
        0 => 'Scelta lingua',
        1 => 'Test di livello',
        2 => 'Scelta orario',
        3 => 'Inizio corso',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يمكنني البدء في تعلم اللغة من الصفر؟',
          'answer' => 'نعم بالتأكيد، نبدأ معك من الصفر التام بحروف النطق والقواعد الأساسية حتى الطلاقة الكاملة.',
        ),
        1 => 
        array (
          'question' => 'هل الكورسات أونلاين أم حضورية بالمقر؟',
          'answer' => 'نوفر الخيارين: قاعات ذكية مجهزة بمقر الأكاديمية، أو محاضرات أونلاين تفاعلية مباشرة مع المحاضر.',
        ),
        2 => 
        array (
          'question' => 'هل يحصل المتدرب على شهادة معتمدة بعد انتهاء الكورس؟',
          'answer' => 'نعم، يحصل المتدرب على شهادة إتمام معتمدة توثق عدد الساعات والمستوى اللغوي المحقق.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Can I start from total beginner level?',
          'answer' => 'Yes, our foundation tiers start from absolute zero.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'È possibile iniziare da zero?',
          'answer' => 'Certamente, i corsi base partono dall alfabeto e dalle nozioni elementari.',
        ),
      ),
    ),
  ),
  2 => 
  array (
    'sort_order' => 3,
    'icon' => 'academic-cap',
    'slug_ar' => 'europe-study-training',
    'slug_en' => 'europe-study-training',
    'slug_it' => 'orientamento-studi-europa',
    'title' => 
    array (
      'ar' => 'التأهيل والتدريب للدراسة في أوروبا',
      'en' => 'Study in Europe Qualification & Prep',
      'it' => 'Orientamento e Formazione per Studiare in Europa',
    ),
    'summary' => 
    array (
      'ar' => 'برنامج متكامل لمساعدة الطلاب على الاستعداد للتقديم في الجامعات الأوروبية، بداية من اختيار الدولة والجامعة والتخصص المناسب، مرورًا بالتعرف على متطلبات القبول وتجهيز ومراجعة ملف التقديم ومتابعة إجراءاته.',
      'en' => 'Comprehensive guidance helping students prepare for European universities: destination matching, degree selection, paperwork auditing, and scholarship preparation.',
      'it' => 'Programma completo per orientare gli studenti verso le università europee, scelta della facoltà, preparazione fascicolo e ammissione.',
    ),
    'description' => 
    array (
      'ar' => 'برنامج متكامل لمساعدة الطلاب على الاستعداد للتقديم في الجامعات الأوروبية، بداية من اختيار الدولة والجامعة والتخصص المناسب، مرورًا بالتعرف على متطلبات القبول وتجهيز ومراجعة ملف التقديم ومتابعة إجراءاته. نفتح آفاقاً حقيقية لطلاب الثانوية والدبلومات الفنية والجامعيين للدراسة في أكثر من 10 دول أوروبية.',
      'en' => 'Full roadmap for students aiming to join European universities across 10+ nations, with guidance on requirements, applications, and scholarship criteria.',
      'it' => 'Guida strategica per l ammissione universitaria in Europa in oltre 10 paesi, valutazione dei titoli di studio e supporto completo.',
    ),
    'badge' => 
    array (
      'ar' => 'أكثر من 10 دول أوروبية',
      'en' => '10+ European Countries',
      'it' => '10+ Paesi Europei',
    ),
    'category_label' => 
    array (
      'ar' => 'الدراسة بالخارج',
      'en' => 'Study Abroad',
      'it' => 'Studio all Estero',
    ),
    'level' => 
    array (
      'ar' => 'ثانوية عامة + دبلومات فنية + جامعيون',
      'en' => 'High School, Technical Diplomas & Degrees',
      'it' => 'Scuola Superiore, Istituti Tecnici e Lauree',
    ),
    'duration' => 
    array (
      'ar' => 'حسب مواعيد التقديم بالدولة المستهدفة',
      'en' => 'Aligned with intake deadlines',
      'it' => 'In base ai bandi accademici',
    ),
    'mode' => 
    array (
      'ar' => 'جلسات استشارية أونلاين وحضورية',
      'en' => 'Advisory sessions online and in-person',
      'it' => 'Sessioni di orientamento online e in presenza',
    ),
    'target_audience' => 
    array (
      'ar' => 'طلاب الثانوية العامة والدبلومات والطلاب الراغبون في استكمال تعليمهم الجامعي بالخارج',
      'en' => 'High school and technical diploma holders and university aspirants',
      'it' => 'Diplomati, maturandi e laureati',
    ),
    'salary_range' => 
    array (
      'ar' => 'تأهيل أكاديمي موجه ومنظم',
      'en' => 'Structured Academic Pathway',
      'it' => 'Percorso accademico strutturato',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود استشارة حول التأهيل والتدريب للدراسة في الجامعات الأوروبية',
      'en' => 'Hello, I want to inquire about qualification for studying in European universities',
      'it' => 'Vorrei una consulenza per la preparazione agli studi in Europa',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التعرف على الجامعات والتخصصات المناسبة بمختلف الدول الأوروبية',
        1 => 'التأهيل لمتطلبات وإجراءات التقديم وشروط القبول',
        2 => 'تجهيز ومراجعة ملفات التقديم واستيفاء كافة الأوراق الرسمية',
        3 => 'التعريف بالمنح والفرص التعليمية المتاحة وفق شروط كل جهة',
      ),
      'en' => 
      array (
        0 => 'Exploration of universities and majors across European destinations',
        1 => 'Readiness audit for application procedures and deadlines',
        2 => 'Document preparation and file review eliminating errors',
        3 => 'Guidance on available scholarship frameworks and criteria',
      ),
      'it' => 
      array (
        0 => 'Valutazione di facoltà e atenei europei adatti al profilo',
        1 => 'Orientamento su scadenze e requisiti di ammissione',
        2 => 'Revisione e preparazione del fascicolo di candidatura',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'المؤهل الدراسي أو آخر شهادة دراسية',
        1 => 'بيان الدرجات',
        2 => 'جواز سفر سارٍ',
        3 => 'تحديد التخصص والدولة المفضلة',
        4 => 'أي مستندات إضافية تطلبها المؤسسة التعليمية',
      ),
      'en' => 
      array (
        0 => 'Graduation certificate or latest diploma',
        1 => 'Academic transcripts',
        2 => 'Valid passport',
        3 => 'Preferred study destination & major',
      ),
      'it' => 
      array (
        0 => 'Diploma o certificato di studio',
        1 => 'Certificato degli esami sostenuti',
        2 => 'Passaporto valido',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تقييم الحالة والمؤهل الدراسي',
        1 => 'تحديد الدولة والتخصص والجامعات المناسبة',
        2 => 'تجهيز المستندات والأوراق المطلوبة',
        3 => 'متابعة التقديم وإجراءات القبول والخطوات التالية',
      ),
      'en' => 
      array (
        0 => 'Profile and credentials evaluation',
        1 => 'Country and program matching',
        2 => 'Paperwork assembly & certification',
        3 => 'Application submission and tracking',
      ),
      'it' => 
      array (
        0 => 'Valutazione del profilo',
        1 => 'Selezione atenei e paesi',
        2 => 'Preparazione documenti',
        3 => 'Monitoraggio esiti',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يحق لحملة الدبلومات الفنية التقديم؟',
          'answer' => 'نعم، نوجه طلاب الدبلومات الفنية إلى الجامعات والمؤسسات الأوروبية التي تقبل مساراتهم التعليمية وتمنحهم فرصاً متكافئة.',
        ),
        1 => 
        array (
          'question' => 'ما هي أبرز الدول الأوروبية المتاحة؟',
          'answer' => 'نوفر التوجيه لأكثر من 10 دول أوروبية مثل إيطاليا، ألمانيا، فرنسا، إسبانيا، المجر، بولندا وغيرها.',
        ),
        2 => 
        array (
          'question' => 'هل تختلف متطلبات وشروط التقديم من جامعة لأخرى؟',
          'answer' => 'نعم بكل تأكيد، ولذلك نقوم بمراجعة متطلبات كل جامعة بدقة مع مستشارك الأكاديمي لضمان استيفاء كافة الشروط.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Can technical diploma graduates apply?',
          'answer' => 'Yes, we guide technical diploma holders to matching European institutions.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'I diplomati di istituti tecnici possono partecipare?',
          'answer' => 'Sì, forniamo orientamento specifico verso le università europee compatibili.',
        ),
      ),
    ),
  ),
  3 => 
  array (
    'sort_order' => 4,
    'icon' => 'presentation',
    'slug_ar' => 'call-center-qualification',
    'slug_en' => 'call-center-qualification',
    'slug_it' => 'formazione-call-center',
    'title' => 
    array (
      'ar' => 'التأهيل للعمل في الكول سنتر',
      'en' => 'Call Center Career Qualification',
      'it' => 'Qualificazione Lavorativa Call Center',
    ),
    'summary' => 
    array (
      'ar' => 'برنامج تدريبي عملي لإعداد وتأهيل المتدربين للعمل في مجال خدمة العملاء ومراكز الاتصال، من خلال تطوير مهارات التواصل والتعامل مع العملاء وحل المشكلات والتدريب على محاكاة بيئة العمل الحقيقية.',
      'en' => 'Practical training program qualifying candidates for customer care and multinational call centers through live call simulations and HR interview prep.',
      'it' => 'Percorso pratico di qualificazione per lavorare nei call center e customer service internazionali con simulazioni reali.',
    ),
    'description' => 
    array (
      'ar' => 'برنامج تدريبي عملي لإعداد وتأهيل المتدربين للعمل في مجال خدمة العملاء ومراكز الاتصال، من خلال تطوير مهارات التواصل والتعامل مع العملاء وحل المشكلات والتدريب على محاكاة بيئة العمل الحقيقية على الشاشات التفاعلية.',
      'en' => 'Hands-on training preparing job seekers for international call centers with real-life scenario handling, communication finesse, and interview rehearsals.',
      'it' => 'Addestramento pratico per superare le selezioni e lavorare con successo nei call center internazionali.',
    ),
    'badge' => 
    array (
      'ar' => 'تأهيل لسوق العمل فوراً',
      'en' => 'Direct Career Readiness',
      'it' => 'Inserimento nel Lavoro',
    ),
    'category_label' => 
    array (
      'ar' => 'التدريب المهني',
      'en' => 'Vocational Training',
      'it' => 'Formazione Professionale',
    ),
    'level' => 
    array (
      'ar' => 'جميع المؤهلات العليا والمتوسطة',
      'en' => 'All Education Levels',
      'it' => 'Tutti i titoli di studio',
    ),
    'duration' => 
    array (
      'ar' => 'مكثف (3 - 4 أسابيع)',
      'en' => 'Intensive (3-4 weeks)',
      'it' => 'Intensivo (3-4 settimane)',
    ),
    'mode' => 
    array (
      'ar' => 'تدريب حضوري وعملي تفاعلي',
      'en' => 'In-person hands-on workshop',
      'it' => 'In presenza con simulazioni',
    ),
    'target_audience' => 
    array (
      'ar' => 'الباحثون عن فرص عمل في مجال خدمة العملاء والكول سنتر الدولي',
      'en' => 'Job seekers targeting international call centers and customer support',
      'it' => 'Candidati per il settore customer service',
    ),
    'salary_range' => 
    array (
      'ar' => 'رواتب مجزية بالشركات الدولية',
      'en' => 'Competitive Multinational Salaries',
      'it' => 'Retribuzioni competitive',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن كورس التأهيل للعمل في الكول سنتر',
      'en' => 'Hello, I want to inquire about call center training and employment prep',
      'it' => 'Vorrei informazioni sul corso di formazione per call center',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'تطوير مهارات التواصل وخدمة العملاء والذكاء العاطفي المهني',
        1 => 'التدريب على المحادثات والمواقف العملية وأنظمة التذاكر والمكالمات',
        2 => 'محاكاة مقابلات العمل الحقيقية مع مديري الموارد البشرية والعمليات',
        3 => 'إتقان نبرة الصوت والمصطلحات الإنجليزية والأجنبية المستخدمة مهنياً',
      ),
      'en' => 
      array (
        0 => 'Professional customer service communications and conflict resolution',
        1 => 'Live call, ticketing, and troubleshooting simulations',
        2 => 'Mock HR and Operations interviews replicating multinational hiring',
        3 => 'Phonetic and accent refinement for foreign accounts',
      ),
      'it' => 
      array (
        0 => 'Tecniche di comunicazione professionale e gestione clienti',
        1 => 'Simulazioni di chiamate e scenari lavorativi reali',
        2 => 'Preparazione mirata ai colloqui di selezione',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'مستوى مناسب من اللغة حسب المسار المختار',
        1 => 'الالتزام بحضور التدريب العملي',
        2 => 'الرغبة في العمل بمجال خدمة العملاء',
      ),
      'en' => 
      array (
        0 => 'Adequate language level for target account',
        1 => 'Attendance commitment',
        2 => 'Aspiration for customer service career',
      ),
      'it' => 
      array (
        0 => 'Conoscenza linguistica idonea',
        1 => 'Presenza al corso',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تقييم المستوى اللغوي والتواصلي',
        1 => 'تحديد المسار واللغة التدريبية',
        2 => 'حضور التدريب العملي والمحاكاة التفاعلية',
        3 => 'التدريب على مقابلات العمل والاستعداد للتوظيف',
      ),
      'en' => 
      array (
        0 => 'Language & soft skills audit',
        1 => 'Account track assignment',
        2 => 'Interactive simulation sessions',
        3 => 'Mock interviews & hiring preparation',
      ),
      'it' => 
      array (
        0 => 'Valutazione iniziale',
        1 => 'Assegnazione percorso',
        2 => 'Simulazioni pratiche',
        3 => 'Preparazione ai colloqui',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يشترط وجود خبرة سابقة في الكول سنتر؟',
          'answer' => 'لا يشترط أي خبرة سابقة؛ فالبرنامج مصمم لتأسيسك وتأهيلك عملياً من البداية.',
        ),
        1 => 
        array (
          'question' => 'ما اللغات المتاحة للتدريب؟',
          'answer' => 'نوفر تدريباً لحسابات اللغة الإنجليزية، الألمانية، الإيطالية، والفرنسية.',
        ),
        2 => 
        array (
          'question' => 'هل يتم تدريبنا على أسئلة المقابلات الشخصية؟',
          'answer' => 'نعم، نخصص ورشاً مكثفة لمحاكاة مقابلات الـ HR والـ Operations لاجتيازها بثقة تامة.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Is prior call center experience required?',
          'answer' => 'No experience is required; we build your capabilities from scratch.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Serve esperienza pregressa?',
          'answer' => 'No, il corso parte dalle basi pratiche.',
        ),
      ),
    ),
  ),
  4 => 
  array (
    'sort_order' => 5,
    'icon' => 'edit',
    'slug_ar' => 'professional-translation-training',
    'slug_en' => 'professional-translation-training',
    'slug_it' => 'formazione-traduzione-professionale',
    'title' => 
    array (
      'ar' => 'التأهيل لاحتراف الترجمة',
      'en' => 'Professional Translation Qualification',
      'it' => 'Qualificazione per Traduttori Professionisti',
    ),
    'summary' => 
    array (
      'ar' => 'برنامج متخصص لتأهيل المهتمين بمجال الترجمة وتحويل مهاراتهم اللغوية إلى مهارات ترجمة احترافية، من خلال التدريب على قواعد الترجمة وأساليب الصياغة والتعامل مع النصوص المختلفة.',
      'en' => 'Specialized career training transforming language knowledge into high-demand professional translation and editing skills.',
      'it' => 'Corso professionale per trasformare le competenze linguistiche in abilità concrete di traduzione e revisione.',
    ),
    'description' => 
    array (
      'ar' => 'برنامج متخصص لتأهيل المهتمين بمجال الترجمة وتحويل مهاراتهم اللغوية إلى مهارات ترجمة احترافية، من خلال التدريب على قواعد الترجمة وأساليب الصياغة والتعامل مع النصوص القانونية، الأكاديمية، والتجارية المختلفة.',
      'en' => 'Master translation theory, CAT tools, legal and business document translation, and terminology management.',
      'it' => 'Formazione specialistica per operare come traduttore professionista su testi giuridici, tecnici e commerciali.',
    ),
    'badge' => 
    array (
      'ar' => 'احتراف مهني معتمد',
      'en' => 'Professional Career Track',
      'it' => 'Percorso Professionale',
    ),
    'category_label' => 
    array (
      'ar' => 'الترجمة الاحترافية',
      'en' => 'Professional Translation',
      'it' => 'Traduzione Professionale',
    ),
    'level' => 
    array (
      'ar' => 'خريجو وطلاب كليات اللغات والترجمة والمهتمون',
      'en' => 'Language & Translation Graduates & Students',
      'it' => 'Studenti e laureati in lingue e traduzione',
    ),
    'duration' => 
    array (
      'ar' => 'حسب المستوى والمسار التدريبي',
      'en' => 'Tailored by training module',
      'it' => 'In base al modulo formativo',
    ),
    'mode' => 
    array (
      'ar' => 'حضوري أو أونلاين حسب البرنامج',
      'en' => 'In-person or Online Interactive',
      'it' => 'In presenza oppure online',
    ),
    'target_audience' => 
    array (
      'ar' => 'خريجو اللغات والترجمة والمهتمون بالعمل في مجال الترجمة الحرة والمؤسسية',
      'en' => 'Language graduates and aspiring translators seeking freelance or agency careers',
      'it' => 'Aspiranti traduttori e laureati',
    ),
    'salary_range' => 
    array (
      'ar' => 'مهارات مطلوبة بالعمل الحر والشركات',
      'en' => 'High Freelance & Agency Demand',
      'it' => 'Sbocchi freelance e aziendali',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن كورس التأهيل لاحتراف الترجمة',
      'en' => 'Hello, I want to inquire about professional translation qualification training',
      'it' => 'Vorrei informazioni sul corso di formazione alla traduzione professionale',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التدريب على أساسيات وتقنيات ومناهج الترجمة الاحترافية',
        1 => 'تطبيق عملي على أنواع مختلفة من النصوص (قانونية، طبية، أكاديمية، عامة)',
        2 => 'تطوير مهارات المراجعة والتحرير اللغوي وإدارة قواميس المصطلحات',
        3 => 'التدريب على أدوات الترجمة الحديثة والمشروعات التطبيقية الحقيقية',
      ),
      'en' => 
      array (
        0 => 'In-depth training on translation fundamentals and methodology',
        1 => 'Practical workshops covering legal, technical, and academic texts',
        2 => 'Editorial proofreading, formatting, and terminology consistency',
        3 => 'Hands-on experience with real client project samples',
      ),
      'it' => 
      array (
        0 => 'Fondamenti e metodologie di traduzione professionale',
        1 => 'Esercitazioni pratiche su testi giuridici, tecnici e commerciali',
        2 => 'Revisione redazionale e gestione glossari',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'إجادة مناسبة للغة المراد التخصص فيها',
        1 => 'اجتياز تقييم المستوى عند الحاجة',
        2 => 'الالتزام بالتدريبات والتطبيقات العملية',
      ),
      'en' => 
      array (
        0 => 'Good command of source and target languages',
        1 => 'Initial evaluation test',
        2 => 'Dedication to practical assignments',
      ),
      'it' => 
      array (
        0 => 'Buona padronanza linguistica',
        1 => 'Test di ingresso',
        2 => 'Impegno pratico',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تقييم المستوى اللغوي الأولي',
        1 => 'تحديد المسار التخصصي للترجمة',
        2 => 'دراسة المهارات الأساسية والمتخصصة',
        3 => 'تنفيذ تدريبات ومشروعات عملية وتقييم نهائي',
      ),
      'en' => 
      array (
        0 => 'Placement assessment',
        1 => 'Specialization selection',
        2 => 'Methodology & workshop sessions',
        3 => 'Live project execution & certification',
      ),
      'it' => 
      array (
        0 => 'Valutazione iniziale',
        1 => 'Scelta specializzazione',
        2 => 'Lezioni ed esercitazioni',
        3 => 'Progetto finale',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يؤهلني البرنامج للعمل كمترجم حر أو بشركات الترجمة؟',
          'answer' => 'نعم، يركز البرنامج على التطبيق العملي وبناء معرض أعمال حقيقي يؤهلك للعمل المباشر.',
        ),
        1 => 
        array (
          'question' => 'ما أنواع النصوص التي يتم التدريب عليها؟',
          'answer' => 'ندربك على الوثائق القانونية، الشهادات الرسمية، النصوص الأكاديمية، والترجمات التجارية.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Does this program prepare me for freelance translation?',
          'answer' => 'Yes, practical projects equip you for both freelance and corporate translation roles.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Il corso abilita alla professione di traduttore?',
          'answer' => 'Fornisce tutte le competenze pratiche per operare come freelance o in agenzia.',
        ),
      ),
    ),
  ),
  5 => 
  array (
    'sort_order' => 6,
    'icon' => 'book-open',
    'slug_ar' => 'academic-exams-preparation',
    'slug_en' => 'academic-exams-preparation',
    'slug_it' => 'preparazione-esami-ammissione',
    'title' => 
    array (
      'ar' => 'التأهيل لاجتياز الاختبارات الدولية للدراسة',
      'en' => 'International Academic Exam Preparation',
      'it' => 'Preparazione Esami di Ammissione Internazionali',
    ),
    'summary' => 
    array (
      'ar' => 'برامج تدريبية متخصصة لإعداد الطلاب لاجتياز اختبارات القبول والتقييم المطلوبة من بعض الجامعات، من خلال شرح طبيعة الاختبارات والتدريب على نماذج الأسئلة وإدارة الوقت ورفع مستوى الاستعداد.',
      'en' => 'Targeted training helping students master university admission and entrance exams through simulated tests, time management, and problem solving.',
      'it' => 'Corsi mirati per superare i test di ammissione universitaria internazionali con simulazioni ed esercitazioni guidate.',
    ),
    'description' => 
    array (
      'ar' => 'برامج تدريبية متخصصة لإعداد الطلاب لاجتياز اختبارات القبول والتقييم المطلوبة من بعض الجامعات، من خلال شرح طبيعة الاختبارات والتدريب على نماذج الأسئلة وإدارة الوقت ورفع مستوى الاستعداد والدرجات.',
      'en' => 'Preparation for international college entrance tests with comprehensive problem-solving techniques and live test simulations.',
      'it' => 'Preparazione metodologica ai test di ingresso e di valutazione accademica richiesti dagli atenei internazionali.',
    ),
    'badge' => 
    array (
      'ar' => 'جاهزية تامة للاختبار',
      'en' => 'High-Score Exam Readiness',
      'it' => 'Preparazione Mirata',
    ),
    'category_label' => 
    array (
      'ar' => 'الاختبارات الأكاديمية',
      'en' => 'Academic Entrance Tests',
      'it' => 'Test Accademici',
    ),
    'level' => 
    array (
      'ar' => 'طلاب الثانوية والجامعات المتقدمون للاختبارات الدولية',
      'en' => 'High School & University Applicants',
      'it' => 'Maturandi e candidati universitari',
    ),
    'duration' => 
    array (
      'ar' => 'حسب نوع الاختبار وتاريخ انعقاده',
      'en' => 'Structured to test intake date',
      'it' => 'In funzione della data d esame',
    ),
    'mode' => 
    array (
      'ar' => 'مجموعات تدريبية ومتابعة فردية',
      'en' => 'Group classes & one-on-one coaching',
      'it' => 'Gruppi di studio e tutoraggio individuale',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب الراغبون في التقديم للجامعات التي تشترط اختبارات قبول وتقييم',
      'en' => 'Students applying to institutions mandating standardized entrance exams',
      'it' => 'Studenti che affrontano prove di ingresso',
    ),
    'salary_range' => 
    array (
      'ar' => 'رفع فرص القبول الأكاديمي',
      'en' => 'Maximizing Admission Probabilities',
      'it' => 'Massimizzazione del punteggio',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن برامج التأهيل لاختبارات القبول الجامعي الدولية',
      'en' => 'Hello, I want to inquire about international academic exam preparation',
      'it' => 'Vorrei informazioni sulla preparazione agli esami di ammissione',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التعرف على نظام الاختبار وأقسامه واستراتيجيات الحل السريع',
        1 => 'التدريب على نماذج وأسئلة امتحانات سابقة مطابقة للمعايير',
        2 => 'تقييم المستوى الدوري وتحديد نقاط التحسين لكل طالب',
        3 => 'خطة تدريب واستعداد مخصصة تناسب موعد الاختبار المستهدف',
      ),
      'en' => 
      array (
        0 => 'Detailed breakdown of exam structure and scoring rubrics',
        1 => 'Extensive practice with past papers and simulated question banks',
        2 => 'Periodic diagnostic testing and personalized performance review',
        3 => 'Tailored study schedule maximizing time management',
      ),
      'it' => 
      array (
        0 => 'Analisi della struttura del test e strategie di risposta',
        1 => 'Esercitazioni su prove d esame ufficiali precedenti',
        2 => 'Valutazioni diagnostiche periodiche',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد الجامعة أو التخصص المستهدف',
        1 => 'معرفة الاختبار المطلوب إن وجد',
        2 => 'الالتزام بالتدريبات والاختبارات التجريبية',
      ),
      'en' => 
      array (
        0 => 'Target institution & major specification',
        1 => 'Identifying required exam name',
        2 => 'Commitment to mock tests',
      ),
      'it' => 
      array (
        0 => 'Ateneo di interesse',
        1 => 'Nome della prova richiesta',
        2 => 'Partecipazione alle simulazioni',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد الاختبار والدرجة المطلوبة',
        1 => 'إجراء اختبار تقييمي أولي',
        2 => 'وضع خطة تدريب مكثفة',
        3 => 'التدريب على النماذج والمحاكاة قبل موعد الاختبار',
      ),
      'en' => 
      array (
        0 => 'Target score identification',
        1 => 'Diagnostic test',
        2 => 'Intensive coaching plan',
        3 => 'Mock testing & final review',
      ),
      'it' => 
      array (
        0 => 'Individuazione prova',
        1 => 'Test diagnostico',
        2 => 'Piano di studio',
        3 => 'Simulazione finale',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يشمل البرنامج اختبارات تجريبية تحاكي الوقت الفعلي؟',
          'answer' => 'نعم، ننفذ اختبارات تجريبية مطابقة في التوقيت وشروط الامتحان لكسر التوتر.',
        ),
        1 => 
        array (
          'question' => 'كم تستغرق فترة الاستعداد للاختبار؟',
          'answer' => 'تتراوح بين 4 إلى 8 أسابيع حسب المستوى المبدئي للطالب ونوع الاختبار.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Do you provide timed mock tests?',
          'answer' => 'Yes, full mock exams with strict timing are integral to the training.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Sono previste simulazioni a tempo?',
          'answer' => 'Sì, prove simulate con cronometro e condizioni d esame.',
        ),
      ),
    ),
  ),
  6 => 
  array (
    'sort_order' => 7,
    'icon' => 'certificate',
    'slug_ar' => 'language-certifications-prep',
    'slug_en' => 'language-certifications-prep',
    'slug_it' => 'certificazioni-linguistiche-internazionali',
    'title' => 
    array (
      'ar' => 'التأهيل لاجتياز اختبارات شهادات اللغة الدولية',
      'en' => 'International Language Certificates Preparation',
      'it' => 'Preparazione alle Certificazioni Linguistiche Internazionali',
    ),
    'summary' => 
    array (
      'ar' => 'تدريب متخصص لإعداد المتعلمين لاجتياز اختبارات وشهادات قياس مستوى اللغة الأجنبية، من خلال التدريب على أقسام الاختبار وتطوير المهارات اللغوية المطلوبة والتعامل مع نماذج الأسئلة.',
      'en' => 'Specialized training for globally recognized language credentials: IELTS, TOEFL, CILS, CELI, and PLIDA with proven high-score methodologies.',
      'it' => 'Preparazione mirata per certificazioni di lingua ufficiali: IELTS, TOEFL, CILS, CELI e PLIDA con docenti esperti.',
    ),
    'description' => 
    array (
      'ar' => 'تدريب متخصص لإعداد المتعلمين لاجتياز اختبارات وشهادات قياس مستوى اللغة الأجنبية (IELTS – TOEFL – CILS – CELI وغيرها)، من خلال التدريب على أقسام الاختبار وتطوير مهارات التحدث والاستماع والقراءة والكتابة والتعامل مع نماذج الأسئلة بدرجات مرتفعة.',
      'en' => 'Comprehensive preparation for IELTS, TOEFL, CILS, CELI, and PLIDA required for university admission, immigration, and multinational employment.',
      'it' => 'Corsi di preparazione specifica per esami linguistici ufficiali con simulazioni e correzioni personalizzate.',
    ),
    'badge' => 
    array (
      'ar' => 'IELTS • TOEFL • CILS',
      'en' => 'IELTS • TOEFL • CILS',
      'it' => 'IELTS • TOEFL • CILS',
    ),
    'category_label' => 
    array (
      'ar' => 'شهادات اللغة الدولية',
      'en' => 'Language Certifications',
      'it' => 'Certificazioni Ufficiali',
    ),
    'level' => 
    array (
      'ar' => 'من المستوى المتوسط حتى المتقدم (B1 إلى C2)',
      'en' => 'Intermediate to Advanced (B1 to C2)',
      'it' => 'Intermedio e avanzato (B1 - C2)',
    ),
    'duration' => 
    array (
      'ar' => 'دورات مكثفة (4 - 8 أسابيع)',
      'en' => 'Intensive courses (4-8 weeks)',
      'it' => 'Moduli intensivi (4-8 settimane)',
    ),
    'mode' => 
    array (
      'ar' => 'حضوري أو أونلاين',
      'en' => 'In-person or Online Interactive',
      'it' => 'In aula o online',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والباحثون عن شهادات لغة معتمدة لأغراض الدراسة بالخارج أو العمل',
      'en' => 'Candidates seeking verified language credentials for study visas or careers',
      'it' => 'Studenti e professionisti che necessitano di attestazione ufficiale',
    ),
    'salary_range' => 
    array (
      'ar' => 'تحقيق السكور المطلوب',
      'en' => 'Target Score Attainment',
      'it' => 'Obiettivo punteggio garantito',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن كورس التأهيل لاختبارات شهادات اللغة الدولية (IELTS/TOEFL/CILS)',
      'en' => 'Hello, I want to inquire about language certification preparation (IELTS/TOEFL/CILS)',
      'it' => 'Vorrei informazioni sulla preparazione alle certificazioni CILS / IELTS / TOEFL',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التدريب المتخصص على اختبارات الآيلتس (IELTS) والتوفل (TOEFL)',
        1 => 'التدريب على امتحانات اللغة الإيطالية الرسمية (CILS, CELI, PLIDA)',
        2 => 'تطوير مهارات القراءة والاستماع والكتابة والمحادثة وفق معايير التصحيح الدولية',
        3 => 'اختبارات تجريبية دورية وتقييم دقيق يحدد درجاتك المتوقعة',
      ),
      'en' => 
      array (
        0 => 'Targeted modules for IELTS Academic & General and TOEFL iBT',
        1 => 'Specialized preparation for Italian CILS, CELI, and PLIDA certificates',
        2 => 'Skill building across all four exam papers: Reading, Listening, Writing, Speaking',
        3 => 'Diagnostic mock exams with certified rubric grading',
      ),
      'it' => 
      array (
        0 => 'Preparazione specialistica per IELTS e TOEFL',
        1 => 'Corsi specifici per CILS, CELI e PLIDA (livelli B1, B2, C1)',
        2 => 'Simulazioni con criteri di correzione ufficiali',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد الشهادة والدرجة المستهدفة',
        1 => 'تقييم المستوى اللغوي الحالي',
        2 => 'الالتزام بالخطة التدريبية والتكليفات',
      ),
      'en' => 
      array (
        0 => 'Target credential & required band score',
        1 => 'Placement evaluation',
        2 => 'Coursework commitment',
      ),
      'it' => 
      array (
        0 => 'Tipo di certificazione e livello richiesto',
        1 => 'Test di ingresso',
        2 => 'Partecipazione alle lezioni',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد الشهادة والدرجة المطلوبة',
        1 => 'إجراء تقييم للمستوى وتحديد الفجوات',
        2 => 'وضع خطة الاستعداد والتدريب على أقسام الاختبار',
        3 => 'إجراء اختبارات تجريبية وتقييم الجاهزية',
      ),
      'en' => 
      array (
        0 => 'Goal setting & benchmark score definition',
        1 => 'Skills gap diagnosis',
        2 => 'Sectional tactics training',
        3 => 'Full-length timed mock tests',
      ),
      'it' => 
      array (
        0 => 'Definizione obiettivo',
        1 => 'Diagnosi livello',
        2 => 'Addestramento sui moduli',
        3 => 'Simulazione completa',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'ما الشهادات المتاحة للتدريب في الأكاديمية؟',
          'answer' => 'نوفر تدريباً شاملاً لاختبارات IELTS, TOEFL, CILS, CELI, و PLIDA.',
        ),
        1 => 
        array (
          'question' => 'هل يساعدني الكورس في الحصول على السكور المطلوب للمنحة أو الفيزا؟',
          'answer' => 'نعم، يركز التدريب بشكل دقيق على معايير توزيع الدرجات والتعامل مع فخاخ الأسئلة.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Which certifications do you cover?',
          'answer' => 'We cover IELTS, TOEFL, CILS, CELI, and PLIDA.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Quali certificazioni sono trattate?',
          'answer' => 'Prepariamo agli esami CILS, CELI, PLIDA, IELTS e TOEFL.',
        ),
      ),
    ),
  ),
  7 => 
  array (
    'sort_order' => 8,
    'icon' => 'academic-cap',
    'slug_ar' => 'university-school-admission',
    'slug_en' => 'university-school-admission',
    'slug_it' => 'ammissioni-scuola-universita',
    'title' => 
    array (
      'ar' => 'خدمة الحصول على قبول جامعي وثانوي',
      'en' => 'University & School Admission Service',
      'it' => 'Servizio Ammissioni Universitarie e Scolastiche',
    ),
    'summary' => 
    array (
      'ar' => 'نساعد الطلاب وأولياء الأمور في التعرف على فرص القبول بالجامعات والمدارس المناسبة، واختيار المؤسسة التعليمية وفق المؤهلات والمتطلبات، مع تجهيز ومراجعة المستندات ومتابعة إجراءات التقديم.',
      'en' => 'Assisting students and parents in securing admissions at top European secondary schools and universities, tailored to credentials and aspirations.',
      'it' => 'Supporto completo a studenti e famiglie per l ammissione a scuole e atenei europei di prestigio.',
    ),
    'description' => 
    array (
      'ar' => 'نساعد الطلاب وأولياء الأمور في التعرف على فرص القبول بالجامعات والمدارس المناسبة بالخارج، واختيار المؤسسة التعليمية وفق المؤهلات والمتطلبات، مع تجهيز ومراجعة المستندات ومتابعة إجراءات التقديم حتى صدور قرار القبول الرسمي.',
      'en' => 'End-to-end guidance for higher education and secondary school placements abroad, reviewing eligibility and managing application submissions.',
      'it' => 'Assistenza personalizzata nella selezione di istituti e corsi accademici, verifica requisiti e inoltro domande di iscrizione.',
    ),
    'badge' => 
    array (
      'ar' => 'قبول جامعي ومدرسي معتمد',
      'en' => 'Certified Academic Placement',
      'it' => 'Ammissione Accreditata',
    ),
    'category_label' => 
    array (
      'ar' => 'القبول الأكاديمي',
      'en' => 'Academic Admissions',
      'it' => 'Ammissioni Accademiche',
    ),
    'level' => 
    array (
      'ar' => 'ثانوي عام وفني + بكالوريوس + ماجستير',
      'en' => 'High School, Bachelor & Master Levels',
      'it' => 'Scuole superiori, lauree triennali e magistrali',
    ),
    'duration' => 
    array (
      'ar' => 'حسب المؤسسة التعليمية ومواعيد التقديم',
      'en' => 'According to academic deadlines',
      'it' => 'In base ai bandi d iscrizione',
    ),
    'mode' => 
    array (
      'ar' => 'متابعة واستشارات أونلاين وحضورية',
      'en' => 'Advisory & file tracking online and in-person',
      'it' => 'Consulenza online e di persona',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب وأولياء الأمور الراغبون في التقديم للمؤسسات التعليمية المرموقة بالخارج',
      'en' => 'Students and parents seeking official study admissions abroad',
      'it' => 'Studenti e genitori interessati agli studi esteri',
    ),
    'salary_range' => 
    array (
      'ar' => 'توجيه دقيق ومطابقة للشروط',
      'en' => 'Precise Eligibility Matching',
      'it' => 'Verifica puntuale dei requisiti',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن خدمة الحصول على قبول جامعي أو ثانوي بالخارج',
      'en' => 'Hello, I want to inquire about university and secondary school admission assistance',
      'it' => 'Vorrei informazioni sul servizio di ammissione a scuole e università',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'البحث عن المؤسسات والمدارس والجامعات المناسبة لمؤهلك',
        1 => 'مراجعة شروط القبول والتخصصات والمواعيد النهائية بدقة',
        2 => 'تجهيز ومراجعة مستندات وملفات التقديم الرسمية',
        3 => 'متابعة الطلب مع المؤسسة التعليمية حتى استلام خطاب القبول',
      ),
      'en' => 
      array (
        0 => 'Comprehensive search matching qualifications with accredited institutions',
        1 => 'Detailed review of admission prerequisites, course catalogs, and deadlines',
        2 => 'Assembly, review, and submission of the complete application portfolio',
        3 => 'Direct follow-up with admissions offices until official decisions are issued',
      ),
      'it' => 
      array (
        0 => 'Ricerca delle istituzioni formative più adatte alle aspirazioni',
        1 => 'Controllo rigoroso dei criteri di ammissione e documentazione',
        2 => 'Inoltro pratiche e interfaccia diretta con le segreterie universitarie',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'آخر مؤهل دراسي تم الحصول عليه',
        1 => 'بيان الدرجات الموثق',
        2 => 'جواز سفر أو إثبات هوية سارٍ',
        3 => 'تحديد المرحلة الدراسية والتخصص المطلوب',
        4 => 'أي مستندات إضافية تطلبها المؤسسة التعليمية',
      ),
      'en' => 
      array (
        0 => 'Latest academic qualification certificate',
        1 => 'Official transcripts',
        2 => 'Valid passport',
        3 => 'Chosen specialization & study level',
      ),
      'it' => 
      array (
        0 => 'Titolo di studio conseguito',
        1 => 'Certificato degli esami',
        2 => 'Passaporto valido',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'مراجعة المؤهل الدراسي والأهداف',
        1 => 'تحديد المؤسسات التعليمية المناسبة',
        2 => 'تجهيز وترجمة ملف التقديم',
        3 => 'تقديم الطلب ومتابعته حتى استلام الرد الرسمي',
      ),
      'en' => 
      array (
        0 => 'Academic background evaluation',
        1 => 'Shortlisting programs & institutions',
        2 => 'File compilation & translation',
        3 => 'Submission & admission tracking',
      ),
      'it' => 
      array (
        0 => 'Esame profilo',
        1 => 'Selezione istituti',
        2 => 'Preparazione fascicolo',
        3 => 'Presentazione domanda ed esito',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل الخدمة مخصصة للجامعات فقط؟',
          'answer' => 'لا، نقدم الخدمة لمرحلة الثانوية والمدارس المتخصصة، بالإضافة لمراحل البكالوريوس والماجستير والدكتوراه.',
        ),
        1 => 
        array (
          'question' => 'هل يمكن التقديم لأكثر من جامعة؟',
          'answer' => 'نعم، يمكن التقديم على عدة رغبات لزيادة فرص القبول وضمان أفضل خيار للطالب.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Is this service only for universities?',
          'answer' => 'No, we assist with secondary schools, undergraduate, and postgraduate programs.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Il servizio è solo per l università?',
          'answer' => 'No, supportiamo anche iscrizioni a scuole superiori e master.',
        ),
      ),
    ),
  ),
  8 => 
  array (
    'sort_order' => 9,
    'icon' => 'edit',
    'slug_ar' => 'proofreading-services',
    'slug_en' => 'proofreading-services',
    'slug_it' => 'correzione-bozze-revisione',
    'title' => 
    array (
      'ar' => 'خدمة التدقيق اللغوي',
      'en' => 'Professional Proofreading & Editing',
      'it' => 'Correzione Bozze e Revisione Linguistica',
    ),
    'summary' => 
    array (
      'ar' => 'خدمات مراجعة وتدقيق لغوي للنصوص والمستندات الأكاديمية والمهنية، بهدف تحسين جودة الكتابة وتصحيح الأخطاء اللغوية والإملائية والنحوية مع الحفاظ على المعنى الأصلي للنص.',
      'en' => 'Academic and corporate proofreading services ensuring linguistic accuracy, correct grammar, punctuation, and academic tone while preserving original meaning.',
      'it' => 'Servizio professionale di revisione e correzione per testi accademici, tesi, saggi e documenti aziendali.',
    ),
    'description' => 
    array (
      'ar' => 'خدمات مراجعة وتدقيق لغوي للنصوص والمستندات الأكاديمية والمهنية، بهدف تحسين جودة الكتابة وتصحيح الأخطاء اللغوية والإملائية والنحوية وعلامات الترقيم، مع الحفاظ على المعنى الأصلي للنص وسلاسة القراءة.',
      'en' => 'High-level language review for research papers, theses, corporate publications, and official declarations in Arabic, English, Italian, and other languages.',
      'it' => 'Revisione linguistica approfondita per tesi universitarie, ricerche scientifiche e documentazione commerciale.',
    ),
    'badge' => 
    array (
      'ar' => 'دقة لغوية متناهية',
      'en' => 'Zero-Error Editing',
      'it' => 'Massima Precisione',
    ),
    'category_label' => 
    array (
      'ar' => 'التدقيق والتحرير',
      'en' => 'Proofreading & Editing',
      'it' => 'Revisione Testi',
    ),
    'level' => 
    array (
      'ar' => 'أبحاث أكاديمية + وثائق قانونية ورسمية + شركات',
      'en' => 'Academic, Legal, and Corporate Texts',
      'it' => 'Testi accademici, legali e aziendali',
    ),
    'duration' => 
    array (
      'ar' => 'حسب حجم النص وطبيعة المستند',
      'en' => 'Turnaround based on word count',
      'it' => 'In base alla lunghezza del testo',
    ),
    'mode' => 
    array (
      'ar' => 'أونلاين مع تسليم إلكتروني سريع',
      'en' => '100% Digital Delivery',
      'it' => 'Consegna digitale rapida',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والباحثون والأكاديميون والشركات والكتّاب',
      'en' => 'Researchers, academics, university students, and corporate teams',
      'it' => 'Ricercatori, studenti, docenti e imprese',
    ),
    'salary_range' => 
    array (
      'ar' => 'أسلوب أكاديمي وصياغة متقنة',
      'en' => 'Polished Academic & Business Style',
      'it' => 'Stile impeccabile',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن خدمة التدقيق اللغوي للأبحاث أو المستندات',
      'en' => 'Hello, I want to inquire about professional proofreading and editing',
      'it' => 'Vorrei informazioni sul servizio di correzione bozze e revisione',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'مراجعة وتصحيح الأخطاء الإملائية والنحوية والصرفية',
        1 => 'تحسين الصياغة والأسلوب اللغوي والتراكيب مع الحفاظ على الفكرة',
        2 => 'ضبط علامات الترقيم وتوحيد المصطلحات والتنسيق العام',
        3 => 'مراجعة الأبحاث العلمية ورسائل الماجستير والدكتوراه والمستندات الرسمية',
      ),
      'en' => 
      array (
        0 => 'Thorough correction of orthography, grammar, syntax, and punctuation',
        1 => 'Enhancement of vocabulary precision and academic readability',
        2 => 'Consistent terminology, citation format, and typographic alignment',
        3 => 'Specialized audit for theses, dissertations, and research publications',
      ),
      'it' => 
      array (
        0 => 'Correzione di errori ortografici, grammaticali e di punteggiatura',
        1 => 'Miglioramento della fluidità stilistica e del registro linguistico',
        2 => 'Uniformazione della terminologia e formattazione accademica',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'إرسال الملف المراد تدقيقه بصيغة قابلة للتعديل',
        1 => 'تحديد لغة النص والمجال التخصصي',
        2 => 'تحديد نوع التدقيق المطلوب والموعد النهائي',
      ),
      'en' => 
      array (
        0 => 'Editable digital file (Word/Docs)',
        1 => 'Specifying language and academic field',
        2 => 'Deadline and formatting guidelines',
      ),
      'it' => 
      array (
        0 => 'File modificabile',
        1 => 'Indicazione della materia e lingua',
        2 => 'Termine di consegna desiderato',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'استلام الملف ومراجعته وتحديد عدد الكلمات',
        1 => 'تحديد نطاق التدقيق والتكلفة والمدة',
        2 => 'تنفيذ التدقيق اللغوي عبر مدقق متخصص',
        3 => 'تسليم الملف منقحاً مع توضيح التعديلات المنفذة',
      ),
      'en' => 
      array (
        0 => 'File intake and word count audit',
        1 => 'Scope & timeline agreement',
        2 => 'Expert linguistic proofreading',
        3 => 'Clean delivery with track-changes option',
      ),
      'it' => 
      array (
        0 => 'Ricezione file e conteggio parole',
        1 => 'Preventivo e tempi',
        2 => 'Revisione da parte di un correttore esperto',
        3 => 'Consegna finale',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يتم التدقيق باللغات العربية والإنجليزية والإيطالية؟',
          'answer' => 'نعم، لدينا مدققون لغويون متخصصون وأصحاب لغة أصليون لمختلف اللغات الحية.',
        ),
        1 => 
        array (
          'question' => 'هل تشمل الخدمة إعادة الصياغة وتحسين الأسلوب؟',
          'answer' => 'نعم، نحسن الصياغة ونضبط الأسلوب الأكاديمي مع الحفاظ التام على أفكار الكاتب الأصلية.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Do you edit in Arabic, English, and Italian?',
          'answer' => 'Yes, our native-level proofreaders handle Arabic, English, Italian, and other languages.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Fornite revisioni in italiano, inglese e arabo?',
          'answer' => 'Sì, ci avvaliamo di revisori madrelingua specializzati.',
        ),
      ),
    ),
  ),
  9 => 
  array (
    'sort_order' => 10,
    'icon' => 'calendar',
    'slug_ar' => 'embassy-appointments-booking',
    'slug_en' => 'embassy-appointments-booking',
    'slug_it' => 'prenotazione-appuntamenti-consolari',
    'title' => 
    array (
      'ar' => 'خدمة حجز مواعيد السفارات والقنصليات',
      'en' => 'Embassy & Consulate Appointment Assistance',
      'it' => 'Assistenza Prenotazione Appuntamenti Consolari',
    ),
    'summary' => 
    array (
      'ar' => 'نقدم المساعدة في إجراءات حجز مواعيد السفارات والقنصليات وفق الأنظمة والمتطلبات المتاحة لكل جهة، مع توضيح خطوات الحجز والمعلومات اللازمة لإتمام الطلب.',
      'en' => 'Guidance and assistance with embassy and consular appointment scheduling systems, clarifying prerequisites and appointment requirements.',
      'it' => 'Assistenza nelle procedure di prenotazione appuntamenti presso ambasciate e consolati secondo i canali ufficiali.',
    ),
    'description' => 
    array (
      'ar' => 'نقدم المساعدة في إجراءات حجز مواعيد السفارات والقنصليات وفق الأنظمة والمتطلبات المتاحة لكل جهة، مع توضيح خطوات الحجز والمعلومات اللازمة لإتمام الطلب بدقة وتفادي أي أخطاء في البيانات. تنويه: الخدمة خاصة بالمساعدة في حجز المواعيد الرسمية، ولا تشمل إصدار التأشيرات أو ضمان الحصول عليها.',
      'en' => 'We assist travelers and students in navigating official embassy and consular appointment booking portals, avoiding data entry discrepancies and delays.',
      'it' => 'Supporto tecnico e informativo per la registrazione e prenotazione degli appuntamenti sui portali consolari ufficiali.',
    ),
    'badge' => 
    array (
      'ar' => 'تنسيق ومتابعة رسمية',
      'en' => 'Official Booking Guidance',
      'it' => 'Supporto Ufficiale',
    ),
    'category_label' => 
    array (
      'ar' => 'الخدمات القنصلية',
      'en' => 'Consular Services',
      'it' => 'Servizi Consolari',
    ),
    'level' => 
    array (
      'ar' => 'مواعيد التأشيرات الدراسية والعمل والسياحة والتصديقات',
      'en' => 'Study, Work, Tourist & Legalization Appointments',
      'it' => 'Visti studio, lavoro e legalizzazioni',
    ),
    'duration' => 
    array (
      'ar' => 'حسب توافر المواعيد ونظام كل جهة',
      'en' => 'Dependent on official portal availability',
      'it' => 'In base alla disponibilità degli enti',
    ),
    'mode' => 
    array (
      'ar' => 'متابعة أونلاين',
      'en' => 'Online Assistance',
      'it' => 'Assistenza online',
    ),
    'target_audience' => 
    array (
      'ar' => 'الأفراد والطلاب والمسافرون الذين يحتاجون لحجز مواعيد بالسفارات والقنصليات',
      'en' => 'Students, individuals, and business travelers needing embassy appointment slots',
      'it' => 'Richiedenti visto e cittadini che necessitano di servizi consolari',
    ),
    'salary_range' => 
    array (
      'ar' => 'توجيه دقيق لإجراءات الموعد',
      'en' => 'Precise Procedural Guidance',
      'it' => 'Orientamento accurato',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود المساعدة في إجراءات حجز موعد سفارة أو قنصلية',
      'en' => 'Hello, I need assistance with embassy appointment booking procedures',
      'it' => 'Vorrei assistenza per prenotare un appuntamento consolare',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'المساعدة في تحديد جهة الحجز ونوع الموعد المناسب لغرض سفرك',
        1 => 'متابعة أنظمة المواعيد المتاحة والقنوات الرسمية لكل سفارة',
        2 => 'إدخال وتدقيق البيانات المطلوبة للحجز بدقة لتفادي أي رفض',
        3 => 'توضيح متطلبات الموعد وقائمة الأوراق المطلوب إحضارها للمقابلة',
      ),
      'en' => 
      array (
        0 => 'Identification of appropriate consular jurisdiction and appointment type',
        1 => 'Real-time tracking of official scheduling portals and requirements',
        2 => 'Accurate data profile entry preventing typographical mistakes',
        3 => 'Checklist of documents and instructions for in-person appointment day',
      ),
      'it' => 
      array (
        0 => 'Individuazione della tipologia di appuntamento corretta',
        1 => 'Monitoraggio dei portali istituzionali',
        2 => 'Compilazione e verifica dei dati anagrafici',
        3 => 'Elenco documenti e istruzioni per il giorno dell appuntamento',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد الدولة والسفارة أو القنصلية المستهدفة',
        1 => 'تحديد نوع الموعد المطلوب (دراسة، سياحة، عمل، تصديقات)',
        2 => 'بيانات جواز السفر ساري المفعول',
        3 => 'البيانات الشخصية المطلوبة للحجز',
      ),
      'en' => 
      array (
        0 => 'Target country and specific embassy / consulate',
        1 => 'Appointment category',
        2 => 'Valid passport particulars',
        3 => 'Applicant contact information',
      ),
      'it' => 
      array (
        0 => 'Ambasciata o consolato di interesse',
        1 => 'Tipo di visto o servizio richiesto',
        2 => 'Dati del passaporto',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد السفارة ونوع الموعد المطلوب',
        1 => 'مراجعة وتدقيق البيانات المطلوبة',
        2 => 'متابعة نظام الحجز وتنفيذ الإجراءات الرسمية المتاحة',
        3 => 'تسليم تفاصيل الموعد المؤكد وإرشادات الحضور',
      ),
      'en' => 
      array (
        0 => 'Jurisdiction & appointment classification',
        1 => 'Data and document verification',
        2 => 'Booking execution through official portal',
        3 => 'Delivery of appointment confirmation and preparation instructions',
      ),
      'it' => 
      array (
        0 => 'Scelta consolato',
        1 => 'Controllo dati',
        2 => 'Prenotazione',
        3 => 'Consegna ricevuta e istruzioni',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل تشمل الخدمة إصدار التأشيرة أو ضمان الحصول عليها؟',
          'answer' => 'تنويه مهم: الخدمة خاصة بالمساعدة في إجراءات حجز المواعيد الرسمية، وقرار منح التأشيرة هو اختصاص سيادي حصري للقنصلية المختصة.',
        ),
        1 => 
        array (
          'question' => 'ماذا يحدث إذا لم تكن هناك مواعيد متاحة حالياً؟',
          'answer' => 'نتابع نظام الحجز بانتظام ونبلغك فور توفر فترات أو مواعيد جديدة وفق نظام السفارة.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Does this service guarantee visa issuance?',
          'answer' => 'No. We assist strictly with booking procedures; visa decisions remain the sole discretion of the respective embassy.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Il servizio garantisce il rilascio del visto?',
          'answer' => 'No, l assistenza riguarda esclusivamente la prenotazione dell appuntamento; la decisione sul visto spetta unicamente all autorità consolare.',
        ),
      ),
    ),
  ),
);

        foreach ($coreServices as $item) {
            $existing = Service::query()->where('slug_ar', $item['slug_ar'])->first();
            if ($existing) {
                // Update missing metadata columns if empty
                $updates = [];
                foreach (['badge', 'category_label', 'level', 'duration', 'mode', 'target_audience', 'salary_range', 'whatsapp_message'] as $field) {
                    if (empty($existing->{$field})) {
                        $updates[$field] = $item[$field];
                    }
                }
                if (!empty($updates)) {
                    $existing->update($updates);
                }
            } else {
                Service::query()->create($item + [
                    'slug' => [
                        'ar' => $item['slug_ar'],
                        'en' => $item['slug_en'],
                        'it' => $item['slug_it'],
                    ],
                    'seo_title' => [
                        'ar' => $item['title']['ar'].' | أكاديمية INTOK',
                        'en' => $item['title']['en'].' | INTOK Academy',
                        'it' => $item['title']['it'].' | INTOK Academy',
                    ],
                    'seo_description' => $item['summary'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
