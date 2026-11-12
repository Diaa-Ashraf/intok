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
                'headline',
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
                'headline',
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
                'headline',
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
                'headline',
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
        if (Service::query()->where('is_active', true)->count() >= 10) {
            return;
        }

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
      'ar' => 'الترجمة المعتمدة',
      'en' => 'Certified Translation',
      'it' => 'Traduzione Asseverata',
    ),
    'summary' => 
    array (
      'ar' => 'نقدم خدمات ترجمة معتمدة للمستندات والوثائق الرسمية بمختلف اللغات، من خلال متخصصين يحرصون على الدقة اللغوية والالتزام بمتطلبات الجهات المقدَّم إليها المستند.',
      'en' => 'Certified translation services for official and academic documents across multiple languages with strict adherence to destination authority requirements.',
      'it' => 'Servizi di traduzione asseverata e giurata per documenti ufficiali e accademici in varie lingue secondo le norme degli enti riceventi.',
    ),
    'description' => 
    array (
      'ar' => 'نقدم خدمات ترجمة معتمدة للمستندات والوثائق الرسمية بمختلف اللغات، من خلال متخصصين يحرصون على الدقة اللغوية والالتزام بمتطلبات الجهات المقدَّم إليها المستند.',
      'en' => 'We provide certified translation for official, academic, and corporate documents across multiple languages, ensuring linguistic accuracy and compliance with destination authorities.',
      'it' => 'Forniamo traduzioni giurate e conformi agli standard internazionali per documenti di studio, certificati e atti ufficiali.',
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
      'ar' => 'تسليم فوري حسب الطلب',
      'en' => 'Immediate delivery upon request',
      'it' => 'Consegna immediata su richiesta',
    ),
    'mode' => 
    array (
      'ar' => 'أونلاين أو من خلال مقر الأكاديمية حسب طبيعة الطلب',
      'en' => 'Online or at Academy headquarters',
      'it' => 'Online o presso la sede dell accademia',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والخريجون والأفراد والشركات',
      'en' => 'Students, graduates, individuals, and corporate clients',
      'it' => 'Studenti, laureati, privati e aziende',
    ),
    'salary_range' => 
    array (
      'ar' => 'دقة لغوية وقانونية 100%',
      'en' => '100% Accuracy',
      'it' => 'Accuratezza al 100%',
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
        0 => 'ترجمة المستندات والوثائق الرسمية.',
        1 => 'مراجعة دقيقة للمحتوى والمصطلحات.',
        2 => 'تجهيز الترجمات وفق متطلبات الجهة المستقبلة.',
      ),
      'en' => 
      array (
        0 => 'Official translation of academic, personal, and corporate files.',
        1 => 'Meticulous review of content and terminology.',
        2 => 'Preparing translations per receiving authority requirements.',
      ),
      'it' => 
      array (
        0 => 'Traduzione di certificati di studio e documenti ufficiali.',
        1 => 'Revisione accurata del contenuto e della terminologia.',
        2 => 'Predisposizione traduzioni secondo i requisiti dell ente ricevente.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'صورة واضحة من المستند الأصلي',
        1 => 'تحديد اللغة المطلوبة للترجمة',
        2 => 'تحديد الجهة التي سيُقدم إليها المستند',
      ),
      'en' => 
      array (
        0 => 'Clear copy of original document',
        1 => 'Specify target language',
        2 => 'Specify receiving authority',
      ),
      'it' => 
      array (
        0 => 'Copia chiara del documento originale',
        1 => 'Indicazione della lingua desiderata',
        2 => 'Ente di destinazione del documento',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'إرسال صورة المستند عبر الموقع أو الواتساب',
        1 => 'فحص المستند وتحديد التكلفة والموعد',
        2 => 'الترجمة والتدقيق والاعتماد الرسمي',
        3 => 'استلام النسخة المعتمدة ورقياً أو إلكترونياً',
      ),
      'en' => 
      array (
        0 => 'Send document digital copy via website or WhatsApp',
        1 => 'Review, quotation, and timeline confirmation',
        2 => 'Translation, proofreading, and official certification',
        3 => 'Delivery in digital or stamped physical copy',
      ),
      'it' => 
      array (
        0 => 'Invio della copia del documento',
        1 => 'Verifica del preventivo e tempi di consegna',
        2 => 'Traduzione, asseverazione e timbratura',
        3 => 'Ritiro o spedizione della copia conforme',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل الترجمة معتمدة لدى السفارات؟',
          'answer' => 'نعم، ترجمتنا معتمدة رسمياً ومطابقة لمعايير السفارات والقنصليات والجهات الحكومية.',
        ),
        1 => 
        array (
          'question' => 'ما هي المدة المطلوبة لاستلام المستند؟',
          'answer' => 'تسليم فوري حسب الطلب، ونوفر خدمة الاستلام العاجل في نفس اليوم.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Is the translation embassy accredited?',
          'answer' => 'Yes, our certified translations comply with embassies, consulates, and official ministries.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Le traduzioni sono riconosciute dalle ambasciate?',
          'answer' => 'Sì, le nostre traduzioni asseverate sono conformi alle richieste consolari e ministeriali.',
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
    'slug_it' => 'corsi-lingue',
    'title' => 
    array (
      'ar' => 'دورات وكورسات اللغات',
      'en' => 'Language Courses & Programs',
      'it' => 'Corsi e Formazione Linguistica',
    ),
    'summary' => 
    array (
      'ar' => 'برامج تعليمية متخصصة لتعلم اللغات الأجنبية من المستوى المبتدئ حتى المستويات المتقدمة، مع التركيز على تطوير مهارات التحدث والاستماع والقراءة والكتابة للاستخدام الأكاديمي والمهني.',
      'en' => 'Specialized educational programs for learning foreign languages from beginner to advanced levels, focusing on speaking, listening, reading, and writing.',
      'it' => 'Programmi educativi per l apprendimento delle lingue straniere dal livello base all avanzato, con focus su conversazione, ascolto, lettura e scrittura.',
    ),
    'description' => 
    array (
      'ar' => 'برامج تعليمية متخصصة لتعلم اللغات الأجنبية من المستوى المبتدئ حتى المستويات المتقدمة، مع التركيز على تطوير مهارات التحدث والاستماع والقراءة والكتابة للاستخدام الأكاديمي والمهني.',
      'en' => 'Comprehensive foreign language training from beginner to advanced levels, developing conversational and communicative competence for academic and professional environments.',
      'it' => 'Corsi di lingua intensivi e flessibili pensati per scopi accademici e di inserimento professionale nel mercato europeo e globale.',
    ),
    'badge' => 
    array (
      'ar' => 'من الصفر للاحتراف',
      'en' => 'Beginner to Advanced',
      'it' => 'Da zero a fluente',
    ),
    'category_label' => 
    array (
      'ar' => 'تعليم اللغات والترجمة',
      'en' => 'Language Learning',
      'it' => 'Formazione Linguistica',
    ),
    'level' => 
    array (
      'ar' => 'من المستوى المبتدئ حتى المتقدم',
      'en' => 'Beginner to Advanced (A1 - C2)',
      'it' => 'Dal livello base all avanzato (A1 - C2)',
    ),
    'duration' => 
    array (
      'ar' => 'تختلف حسب اللغة والمستوى',
      'en' => 'Varies by language and level',
      'it' => 'Varia in base a lingua e livello',
    ),
    'mode' => 
    array (
      'ar' => 'مجموعات حضورية وأونلاين حسب البرنامج',
      'en' => 'In-person groups & interactive online',
      'it' => 'In aula e online interattivo',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والخريجون والباحثون عن تطوير مهاراتهم اللغوية',
      'en' => 'Students, graduates, and professionals seeking language mastery',
      'it' => 'Studenti, laureati e professionisti in cerca di sviluppo linguistico',
    ),
    'salary_range' => 
    array (
      'ar' => 'تطوير لغوي شامل',
      'en' => 'Full Linguistic Mastery',
      'it' => 'Competenza linguistica completa',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار والتسجيل في دورات وكورسات اللغات',
      'en' => 'Hello, I want to inquire about language courses and training',
      'it' => 'Vorrei informazioni sui corsi di formazione linguistica',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'مستويات تعليمية تناسب مختلف المتعلمين.',
        1 => 'تدريب عملي على المحادثة والتواصل.',
        2 => 'متابعة وتقييم مستمر لمستوى المتدرب.',
      ),
      'en' => 
      array (
        0 => 'Educational levels tailored to different learners.',
        1 => 'Practical conversational and communication training.',
        2 => 'Continuous tracking and assessment of student progress.',
      ),
      'it' => 
      array (
        0 => 'Livelli di apprendimento adatti a diversi profili.',
        1 => 'Esercitazioni pratiche di conversazione e comunicazione.',
        2 => 'Monitoraggio e valutazione continua del livello.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد المستوى عبر اختبار تمهيدي مجاني',
        1 => 'الالتزام بحضور المحاضرات والتطبيقات العملية',
      ),
      'en' => 
      array (
        0 => 'Placement assessment',
        1 => 'Commitment to active participation',
      ),
      'it' => 
      array (
        0 => 'Test di posizionamento iniziale',
        1 => 'Impegno a seguire le esercitazioni',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد اللغة والمستوى المطلوب',
        1 => 'اختيار الموعد ونظام الحضور (حضوري/أونلاين)',
        2 => 'بدء التدريب العملي والتفاعل مع المدربين',
        3 => 'اجتياز التقييم واستلام شهادة إتمام المستوى',
      ),
      'en' => 
      array (
        0 => 'Select language and level',
        1 => 'Choose schedule and attendance format',
        2 => 'Interactive lectures and speaking practice',
        3 => 'Level exam and certificate issuance',
      ),
      'it' => 
      array (
        0 => 'Scelta di lingua e livello',
        1 => 'Definizione di calendario e modalità',
        2 => 'Frequenza lezioni e conversazione',
        3 => 'Verifica finale e rilascio attestato',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'ما هي اللغات المتاحة للدراسة؟',
          'answer' => 'نوفر دورات في الإيطالية، الإنجليزية، الألمانية، الفرنسية، وغيرها من اللغات.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Which languages are offered?',
          'answer' => 'We offer Italian, English, German, French, and other world languages.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Quali lingue sono disponibili?',
          'answer' => 'Offriamo corsi di italiano, inglese, tedesco, francese e altre lingue.',
        ),
      ),
    ),
  ),
  2 => 
  array (
    'sort_order' => 3,
    'icon' => 'academic-cap',
    'slug_ar' => 'study-in-europe-prep',
    'slug_en' => 'study-in-europe-prep',
    'slug_it' => 'orientamento-studio-europa',
    'title' => 
    array (
      'ar' => 'التأهيل للدراسة في أوروبا',
      'en' => 'Study in Europe Qualification',
      'it' => 'Orientamento agli Studi in Europa',
    ),
    'summary' => 
    array (
      'ar' => 'برنامج متكامل لمساعدة الطلاب على الاستعداد للتقديم في الجامعات الأوروبية، بداية من اختيار الدولة والجامعة والتخصص المناسب، مرورًا بالتعرف على متطلبات القبول وتجهيز ومراجعة ملف التقديم ومتابعة إجراءاته.',
      'en' => 'Comprehensive guidance program preparing students to apply to European universities: choosing countries, universities, majors, reviewing files, and tracking applications.',
      'it' => 'Programma completo per prepararsi alla candidatura nelle università europee: scelta di ateneo, corso, requisiti e monitoraggio pratiche.',
    ),
    'description' => 
    array (
      'ar' => 'برنامج متكامل لمساعدة الطلاب على الاستعداد للتقديم في الجامعات الأوروبية، بداية من اختيار الدولة والجامعة والتخصص المناسب، مرورًا بالتعرف على متطلبات القبول وتجهيز ومراجعة ملف التقديم ومتابعة إجراءاته.',
      'en' => 'A complete roadmap for higher education in Europe: university matching, prerequisite assessment, official file preparation, and admission tracking.',
      'it' => 'Assistenza e orientamento passo dopo passo per accedere all istruzione universitaria in Europa con pieno rispetto dei requisiti legali.',
    ),
    'badge' => 
    array (
      'ar' => '10+ دول أوروبية',
      'en' => '10+ European Destinations',
      'it' => '10+ Paesi Europei',
    ),
    'category_label' => 
    array (
      'ar' => 'التأهيل للدراسة والجامعات',
      'en' => 'Study Abroad & University Prep',
      'it' => 'Orientamento Universitario',
    ),
    'level' => 
    array (
      'ar' => 'طلاب الثانوية العامة والدبلومات والخريجون',
      'en' => 'High school, technical diplomas, and graduates',
      'it' => 'Diplomati, istituti tecnici e laureati',
    ),
    'duration' => 
    array (
      'ar' => 'حسب الدولة والجامعة والتخصص ومتطلبات التقديم',
      'en' => 'According to country, university, and application deadlines',
      'it' => 'In base al paese, ateneo e scadenze di bando',
    ),
    'mode' => 
    array (
      'ar' => 'جلسات استشارية أونلاين وحضورية',
      'en' => 'Advisory sessions online and in person',
      'it' => 'Consulenze individuali online e in presenza',
    ),
    'target_audience' => 
    array (
      'ar' => 'طلاب الثانوية العامة والدبلومات والطلاب الراغبون في استكمال تعليمهم الجامعي',
      'en' => 'High school students, diploma holders, and candidates pursuing university degrees',
      'it' => 'Studenti di scuola superiore, istituti tecnici e candidati universitari',
    ),
    'salary_range' => 
    array (
      'ar' => 'تأهيل أكاديمي موجه',
      'en' => 'Guided Academic Pathway',
      'it' => 'Percorso accademico guidato',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار والتسجيل في برنامج التأهيل للدراسة في أوروبا',
      'en' => 'Hello, I want to inquire about qualifying to study in European universities',
      'it' => 'Vorrei informazioni sui percorsi per studiare in Europa',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التعرف على الجامعات والتخصصات المناسبة.',
        1 => 'التأهيل لمتطلبات وإجراءات التقديم.',
        2 => 'تجهيز ومراجعة الملفات ومتابعة إجراءات القبول.',
      ),
      'en' => 
      array (
        0 => 'Identifying suitable universities and academic majors.',
        1 => 'Qualification for admission prerequisites and steps.',
        2 => 'Preparing, auditing files, and following application workflows.',
      ),
      'it' => 
      array (
        0 => 'Orientamento su università e corsi più indicati.',
        1 => 'Preparazione ai requisiti e all iter di ammissione.',
        2 => 'Revisione del fascicolo e monitoraggio delle pratiche.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'شهادة المؤهل الدراسي الحالي (ثانوية عامة / دبلوم / بكالوريوس)',
        1 => 'بيان درجات مفصل بالمواد',
        2 => 'جواز سفر ساري',
      ),
      'en' => 
      array (
        0 => 'Educational degree or diploma transcript',
        1 => 'Valid passport',
      ),
      'it' => 
      array (
        0 => 'Titolo di studio o diploma con pagelle',
        1 => 'Passaporto in corso di validità',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'جلسة استشارية وتحديد الدولة والجامعة والمسار المناسب',
        1 => 'فحص وتجهيز الأوراق والترجمة المعتمدة والتصديقات',
        2 => 'التقديم الرسمي ومتابعة إجراءات القبول والمنح',
        3 => 'تأهيل التأشيرة والاستعداد للسفر والاندماج',
      ),
      'en' => 
      array (
        0 => 'Consultation session to identify country, university, and major',
        1 => 'Document preparation, certified translation, and legalizations',
        2 => 'Official application submission and admission tracking',
        3 => 'Visa guidance and pre-departure orientation',
      ),
      'it' => 
      array (
        0 => 'Consulenza preliminare per definire paese, ateneo e corso',
        1 => 'Preparazione fascicolo, traduzioni giurate e legalizzazioni',
        2 => 'Invio della candidatura e monitoraggio',
        3 => 'Orientamento visti e preparazione alla partenza',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يمكن لحملة الدبلومات الفنية التقديم؟',
          'answer' => 'نعم، نوفر مسارات مخصصة لحملة الدبلومات الفنية والثانوية العامة بالجامعات الأوروبية.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Can technical diploma holders apply?',
          'answer' => 'Yes, we have dedicated pathways for technical diploma holders in European universities.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'I diplomati di istituti tecnici possono candidarsi?',
          'answer' => 'Sì, offriamo percorsi specifici per diplomati di istituti tecnici e scuole superiori.',
        ),
      ),
    ),
  ),
  3 => 
  array (
    'sort_order' => 4,
    'icon' => 'presentation',
    'slug_ar' => 'call-center-career',
    'slug_en' => 'call-center-career',
    'slug_it' => 'carriera-call-center',
    'title' => 
    array (
      'ar' => 'التأهيل للعمل في الكول سنتر',
      'en' => 'Call Center Career Qualification',
      'it' => 'Qualificazione Lavorativa Call Center',
    ),
    'summary' => 
    array (
      'ar' => 'برنامج تدريبي عملي لإعداد وتأهيل المتدربين للعمل في مجال خدمة العملاء ومراكز الاتصال، من خلال تطوير مهارات التواصل والتعامل مع العملاء وحل المشكلات والتدريب على محاكاة بيئة العمل الحقيقية.',
      'en' => 'Practical training program qualifying participants for customer service and call center careers by developing communication skills, problem solving, and workplace simulations.',
      'it' => 'Percorso pratico per preparare i partecipanti al lavoro nel customer service e contact center internazionali con simulazioni reali.',
    ),
    'description' => 
    array (
      'ar' => 'برنامج تدريبي عملي لإعداد وتأهيل المتدربين للعمل في مجال خدمة العملاء ومراكز الاتصال، من خلال تطوير مهارات التواصل والتعامل مع العملاء وحل المشكلات والتدريب على محاكاة بيئة العمل الحقيقية.',
      'en' => 'Hands-on practical training designed to qualify candidates for multinational call centers with intensive voice and situational customer service training.',
      'it' => 'Formazione professionale e simulazioni pratiche per superare con successo i colloqui nei principali contact center multinazionali.',
    ),
    'badge' => 
    array (
      'ar' => 'الأكثر طلباً للتوظيف',
      'en' => 'High Employability',
      'it' => 'Alta Richiesta di Mercato',
    ),
    'category_label' => 
    array (
      'ar' => 'تأهيل لسوق العمل والكول سنتر',
      'en' => 'Career & Customer Service',
      'it' => 'Formazione Professionale & Call Center',
    ),
    'level' => 
    array (
      'ar' => 'تأهيل وظيفي مباشر لكبرى الشركات',
      'en' => 'Direct career entry level',
      'it' => 'Accesso professionale diretto',
    ),
    'duration' => 
    array (
      'ar' => 'حسب البرنامج التدريبي',
      'en' => 'According to selected training track',
      'it' => 'In base al percorso formativo scelto',
    ),
    'mode' => 
    array (
      'ar' => 'تدريب حضوري وعملي',
      'en' => 'In-person practical training',
      'it' => 'In presenza con esercitazioni pratiche',
    ),
    'target_audience' => 
    array (
      'ar' => 'الباحثون عن فرص عمل في مجال خدمة العملاء والكول سنتر',
      'en' => 'Job seekers targeting international call center and customer experience positions',
      'it' => 'Chi cerca impiego nel customer service e call center internazionali',
    ),
    'salary_range' => 
    array (
      'ar' => 'رواتب مجزية 15,000 - 30,000+ ج.م',
      'en' => '15k - 30k+ EGP monthly',
      'it' => 'Stipendi competitivi',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار والتسجيل في برنامج التأهيل للعمل في الكول سنتر',
      'en' => 'Hello, I want to inquire about professional call center training',
      'it' => 'Vorrei informazioni sulla qualificazione per call center',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'تطوير مهارات التواصل وخدمة العملاء.',
        1 => 'التدريب على المحادثات والمواقف العملية.',
        2 => 'محاكاة مقابلات العمل والتعامل مع العملاء.',
      ),
      'en' => 
      array (
        0 => 'Developing communication and customer service skills.',
        1 => 'Live conversation drills and situational conflict handling.',
        2 => 'Job interview simulations and customer handling scenarios.',
      ),
      'it' => 
      array (
        0 => 'Sviluppo di capacità comunicative e customer care.',
        1 => 'Esercitazioni pratiche su chiamate e gestione situazioni complesse.',
        2 => 'Simulazioni di colloquio e scenari lavorativi reali.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'مستوى تمهيدي في إحدى اللغات الأجنبية (إيطالي أو إنجليزي أو ألماني)',
        1 => 'الرغبة في التدريب العملي واكتساب مهارات التوظيف',
      ),
      'en' => 
      array (
        0 => 'Basic command of a target language (Italian, English, or German)',
        1 => 'Commitment to practical speaking exercises',
      ),
      'it' => 
      array (
        0 => 'Conoscenza di base di una lingua straniera (italiano, inglese o tedesco)',
        1 => 'Motivazione e disponibilità a sessioni simulate',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تقييم اللغة والنطق والمقابلة المبدئية',
        1 => 'ورش العمل الصوتية والتدريب على برامج الكول سنتر',
        2 => 'محاكاة المقابلات الشخصية لكبرى الشركات (Vodafone UK, Concentrix, TP)',
        3 => 'الترشيح للمقابلات الوظيفية المباشرة',
      ),
      'en' => 
      array (
        0 => 'Language and pronunciation assessment',
        1 => 'Voice workshops and CRM handling practice',
        2 => 'Mock interviews with multinational standards',
        3 => 'Direct referral to hiring interviews',
      ),
      'it' => 
      array (
        0 => 'Valutazione linguistica e fonetica iniziale',
        1 => 'Workshop pratici su software e gestione chiamate',
        2 => 'Simulazioni di colloquio per multinazionali',
        3 => 'Presentazione per colloqui lavorativi diretti',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يساعد البرنامج في الحصول على وظيفة؟',
          'answer' => 'نعم، يشمل البرنامج محاكاة حقيقية لمقابلات كبرى الشركات وتأهيلك المباشر لاجتيازها.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Does this program assist in job placement?',
          'answer' => 'Yes, it provides realistic interview simulations tailored to multinational hiring benchmarks.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Il corso favorisce l assunzione?',
          'answer' => 'Sì, include simulazioni mirate sui processi di selezione delle principali aziende.',
        ),
      ),
    ),
  ),
  4 => 
  array (
    'sort_order' => 5,
    'icon' => 'translation',
    'slug_ar' => 'professional-translation',
    'slug_en' => 'professional-translation',
    'slug_it' => 'professione-traduttore',
    'title' => 
    array (
      'ar' => 'التأهيل لاحتراف الترجمة',
      'en' => 'Professional Translation Qualification',
      'it' => 'Qualificazione per Traduttori Professionisti',
    ),
    'summary' => 
    array (
      'ar' => 'برنامج متخصص لتأهيل المهتمين بمجال الترجمة وتحويل مهاراتهم اللغوية إلى مهارات ترجمة احترافية، من خلال التدريب على قواعد الترجمة وأساليب الصياغة والتعامل مع النصوص المختلفة.',
      'en' => 'Specialized program transforming linguistic talent into professional translation skills via translation principles, syntax conventions, and textual handling.',
      'it' => 'Programma specialistico per trasformare le competenze linguistiche in professionalità di traduzione con metodi e strumenti del settore.',
    ),
    'description' => 
    array (
      'ar' => 'برنامج متخصص لتأهيل المهتمين بمجال الترجمة وتحويل مهاراتهم اللغوية إلى مهارات ترجمة احترافية، من خلال التدريب على قواعد الترجمة وأساليب الصياغة والتعامل مع النصوص المختلفة.',
      'en' => 'Comprehensive vocational track preparing translators for freelance platforms, agencies, and international enterprises with practical translation workshops.',
      'it' => 'Formazione su terminologia specialistica, revisione testi e standard di traduzione per il mercato libero professionale e aziendale.',
    ),
    'badge' => 
    array (
      'ar' => 'تأهيل لسوق العمل الحر',
      'en' => 'Freelance & Agency Ready',
      'it' => 'Pronto per il mercato freelance',
    ),
    'category_label' => 
    array (
      'ar' => 'التدريب المهني المتخصص',
      'en' => 'Professional Translation Career',
      'it' => 'Traduzione Professionale',
    ),
    'level' => 
    array (
      'ar' => 'تأهيل احترافي وتطبيقي',
      'en' => 'Intermediate to professional',
      'it' => 'Intermedio e professionale',
    ),
    'duration' => 
    array (
      'ar' => 'حسب المستوى والمسار التدريبي',
      'en' => 'According to track and level',
      'it' => 'In base al livello e al percorso',
    ),
    'mode' => 
    array (
      'ar' => 'حضوري أو أونلاين حسب البرنامج',
      'en' => 'In-person or online per track',
      'it' => 'In presenza o online',
    ),
    'target_audience' => 
    array (
      'ar' => 'خريجو اللغات والترجمة والمهتمون بالعمل في مجال الترجمة',
      'en' => 'Language & translation graduates and aspiring translators',
      'it' => 'Laureati in lingue, traduttori e appassionati del settore',
    ),
    'salary_range' => 
    array (
      'ar' => 'عائد مالي بالعمل الحر والشركات',
      'en' => 'Freelance & Agency Income',
      'it' => 'Opportunità freelance retribuite',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار والتسجيل في برنامج التأهيل لاحتراف الترجمة',
      'en' => 'Hello, I want to inquire about professional translation career training',
      'it' => 'Vorrei informazioni sulla qualificazione per traduttori',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التدريب على أساسيات وتقنيات الترجمة.',
        1 => 'تطبيق عملي على أنواع مختلفة من النصوص.',
        2 => 'تطوير مهارات المراجعة والتحرير اللغوي.',
      ),
      'en' => 
      array (
        0 => 'Training on translation fundamentals and techniques.',
        1 => 'Practical application across diverse document types.',
        2 => 'Developing proofreading and linguistic editing skills.',
      ),
      'it' => 
      array (
        0 => 'Formazione su tecniche e fondamenti di traduzione.',
        1 => 'Applicazione pratica su diverse tipologie testuali.',
        2 => 'Sviluppo di competenze di revisione ed editing linguistico.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'إجادة جيدة للغة المصدر واللغة الهدف (B2 فأعلى)',
        1 => 'الاهتمام بالدقة اللغوية والصياغة القانونية والأكاديمية',
      ),
      'en' => 
      array (
        0 => 'B2 or higher proficiency in source and target languages',
        1 => 'Dedication to linguistic and legal precision',
      ),
      'it' => 
      array (
        0 => 'Competenza linguistica B2 o superiore',
        1 => 'Attenzione alla precisione terminologica e sintattica',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تقييم المستوى اللغوي وتحديد المسار التخصصي',
        1 => 'ورش عمل تطبيقية على النصوص القانونية والأكاديمية والتجارية',
        2 => 'التدريب على أدوات الترجمة والتدقيق ومصادر المصطلحات',
        3 => 'تسليم مشاريع تخرج وتقييم نهائي معتمد',
      ),
      'en' => 
      array (
        0 => 'Language proficiency check and track selection',
        1 => 'Workshops on legal, academic, and business texts',
        2 => 'Training on CAT tools and terminology databases',
        3 => 'Graduation project review and certification',
      ),
      'it' => 
      array (
        0 => 'Valutazione del livello e scelta del percorso',
        1 => 'Esercitazioni pratiche su testi giuridici e commerciali',
        2 => 'Utilizzo di strumenti CAT e banche dati terminologiche',
        3 => 'Progetto finale e rilascio attestato',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يشمل التدريب العمل على برامج الترجمة؟',
          'answer' => 'نعم، يشمل أدوات المساعدة في الترجمة والتدقيق وإدارة المصطلحات.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Does training cover CAT tools?',
          'answer' => 'Yes, it includes hands-on practice with translation memory and terminology management tools.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Si utilizzano strumenti informatici per traduttori?',
          'answer' => 'Sì, è previsto l uso di memorie di traduzione e banche terminologiche.',
        ),
      ),
    ),
  ),
  5 => 
  array (
    'sort_order' => 6,
    'icon' => 'edit',
    'slug_ar' => 'academic-exams-prep',
    'slug_en' => 'academic-exams-prep',
    'slug_it' => 'esami-ammissione-universitaria',
    'title' => 
    array (
      'ar' => 'التأهيل لاختبارات القبول الجامعي',
      'en' => 'University Admission Exams Prep',
      'it' => 'Preparazione Esami di Ammissione',
    ),
    'summary' => 
    array (
      'ar' => 'برامج تدريبية متخصصة لإعداد الطلاب لاجتياز اختبارات القبول والتقييم المطلوبة من بعض الجامعات، من خلال شرح طبيعة الاختبارات والتدريب على نماذج الأسئلة وإدارة الوقت ورفع مستوى الاستعداد.',
      'en' => 'Targeted prep courses for university entrance and assessment exams with question analysis, test strategy, and timing management.',
      'it' => 'Corsi mirati per superare i test di ingresso universitari internazionali con simulazioni e strategie di gestione del tempo.',
    ),
    'description' => 
    array (
      'ar' => 'برامج تدريبية متخصصة لإعداد الطلاب لاجتياز اختبارات القبول والتقييم المطلوبة من بعض الجامعات، من خلال شرح طبيعة الاختبارات والتدريب على نماذج الأسئلة وإدارة الوقت ورفع مستوى الاستعداد.',
      'en' => 'Focused preparation for international university entrance assessments (including TOLC, SAT, IMAT, and tailored university entrance exams) with mock tests.',
      'it' => 'Preparazione specialistica per i test di ammissione delle università europee con simulazioni realistiche ed esercizi pratici.',
    ),
    'badge' => 
    array (
      'ar' => 'استعداد عالي للقبول',
      'en' => 'Exam Readiness',
      'it' => 'Alta Preparazione',
    ),
    'category_label' => 
    array (
      'ar' => 'الاختبارات الدولية والقبول',
      'en' => 'Academic Entrance Tests',
      'it' => 'Test di Ammissione Universitaria',
    ),
    'level' => 
    array (
      'ar' => 'تجهيز لاختبارات القبول والتقييم',
      'en' => 'Entrance exam readiness',
      'it' => 'Preparazione test d ingresso',
    ),
    'duration' => 
    array (
      'ar' => 'حسب نوع الاختبار ومستوى الطالب',
      'en' => 'According to test type and student level',
      'it' => 'In base al tipo di test e livello iniziale',
    ),
    'mode' => 
    array (
      'ar' => 'مجموعات تدريبية ومتابعة فردية حسب البرنامج',
      'en' => 'Training groups and 1-on-1 coaching',
      'it' => 'Gruppi di studio e tutoraggio individuale',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب الراغبون في التقديم للجامعات التي تشترط اختبارات قبول',
      'en' => 'Students applying to universities that mandate entrance tests',
      'it' => 'Studenti che intendono iscriversi a corsi con test di ammissione',
    ),
    'salary_range' => 
    array (
      'ar' => 'اجتياز مؤكد للاختبار',
      'en' => 'High Success Rate',
      'it' => 'Alto tasso di superamento',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار والتسجيل في برنامج التأهيل لاختبارات القبول الجامعي',
      'en' => 'Hello, I want to inquire about university entrance exam preparation',
      'it' => 'Vorrei informazioni sulla preparazione agli esami di ammissione',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التعرف على نظام الاختبار وأقسامه.',
        1 => 'التدريب على نماذج وأسئلة مشابهة.',
        2 => 'تقييم المستوى وتحديد نقاط التحسين.',
      ),
      'en' => 
      array (
        0 => 'In-depth breakdown of exam sections and format.',
        1 => 'Practicing with authentic simulated exam questions.',
        2 => 'Continuous diagnostics and identifying areas for improvement.',
      ),
      'it' => 
      array (
        0 => 'Analisi dettagliata della struttura del test.',
        1 => 'Esercitazioni su prove d esame ufficiali e simulate.',
        2 => 'Valutazione continua e potenziamento dei punti deboli.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد الجامعة والتخصص المستهدف',
        1 => 'معرفة متطلبات ونوع الاختبار المطلوب',
      ),
      'en' => 
      array (
        0 => 'Specifying target university and major',
        1 => 'Identifying required entrance exam format',
      ),
      'it' => 
      array (
        0 => 'Ateneo e corso di laurea prescelto',
        1 => 'Tipologia di test richiesta dal bando',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تحليل هيكل الاختبار المطلوب ونقاط الدرجات',
        1 => 'شرح استراتيجيات الحل السريع والتعامل مع الأسئلة',
        2 => 'اختبارات تجريبية دورية لقياس التقدم وضبط الوقت',
        3 => 'مراجعة شاملة ليلة الامتحان لضمان أعلى درجات الاستعداد',
      ),
      'en' => 
      array (
        0 => 'Breakdown of exam scoring and section weights',
        1 => 'Speed-solving strategies and time management',
        2 => 'Timed mock exams tracking progress',
        3 => 'Final review to ensure peak readiness',
      ),
      'it' => 
      array (
        0 => 'Analisi del sistema di punteggio del test',
        1 => 'Strategie di risoluzione rapida e gestione del tempo',
        2 => 'Simulazioni a tempo periodiche',
        3 => 'Revisione finale e consigli strategici',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'ما هي الاختبارات التي يتم التدريب عليها؟',
          'answer' => 'نوفر تدريباً لاختبارات القبول بالجامعات الأوروبية مثل TOLC، SAT، IMAT، وغيرها حسب التخصص.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Which exams are covered?',
          'answer' => 'We cover TOLC, SAT, IMAT, and other institutional entrance assessments.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Quali test sono trattati nel corso?',
          'answer' => 'Prepariamo a TOLC, SAT, IMAT e prove di ammissione specifiche.',
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
      'ar' => 'التأهيل لاختبارات شهادات اللغة الدولية',
      'en' => 'International Language Certifications',
      'it' => 'Certificazioni Linguistiche Internazionali',
    ),
    'summary' => 
    array (
      'ar' => 'تدريب متخصص لإعداد المتعلمين لاجتياز اختبارات وشهادات قياس مستوى اللغة الأجنبية، من خلال التدريب على أقسام الاختبار وتطوير المهارات اللغوية المطلوبة والتعامل مع نماذج الأسئلة.',
      'en' => 'Specialized training preparing learners to pass international language proficiency exams (IELTS, TOEFL, CILS, CELI) with structured practice.',
      'it' => 'Preparazione intensiva per il conseguimento di certificazioni linguistiche internazionali riconosciute (IELTS, TOEFL, CILS, CELI).',
    ),
    'description' => 
    array (
      'ar' => 'تدريب متخصص لإعداد المتعلمين لاجتياز اختبارات وشهادات قياس مستوى اللغة الأجنبية، من خلال التدريب على أقسام الاختبار وتطوير المهارات اللغوية المطلوبة والتعامل مع نماذج الأسئلة. (الاختبارات المستهدفة: IELTS – TOEFL – CILS – CELI وغيرها حسب البرامج المتاحة).',
      'en' => 'Comprehensive exam prep covering all 4 core components (Listening, Reading, Writing, Speaking) for IELTS, TOEFL, CILS, and CELI with simulated testing.',
      'it' => 'Corso completo per superare brillantemente le certificazioni richieste da atenei ed enti per studio e lavoro in Europa.',
    ),
    'badge' => 
    array (
      'ar' => 'IELTS • TOEFL • CILS • CELI',
      'en' => 'Global Certifications',
      'it' => 'Certificati Riconosciuti',
    ),
    'category_label' => 
    array (
      'ar' => 'الشهادات الدولية المعتمدة',
      'en' => 'International Certifications',
      'it' => 'Certificazioni Ufficiali',
    ),
    'level' => 
    array (
      'ar' => 'تحضير للاختبارات الرسمية الدولية',
      'en' => 'All CEFR levels (B1, B2, C1, C2)',
      'it' => 'Tutti i livelli QCER (B1, B2, C1, C2)',
    ),
    'duration' => 
    array (
      'ar' => 'حسب الاختبار والمستوى',
      'en' => 'According to test and target level',
      'it' => 'In base al tipo di certificazione e livello',
    ),
    'mode' => 
    array (
      'ar' => 'حضوري أو أونلاين',
      'en' => 'In person or online',
      'it' => 'In presenza o online',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والباحثون عن شهادات لغة لأغراض الدراسة أو العمل',
      'en' => 'Candidates seeking recognized language credentials for academic or career goals',
      'it' => 'Studenti e professionisti che necessitano di una certificazione ufficiale',
    ),
    'salary_range' => 
    array (
      'ar' => 'اعتماد دولي رسمي',
      'en' => 'Officially Accredited',
      'it' => 'Riconoscimento ufficiale',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار والتسجيل في برنامج التأهيل لاختبارات شهادات اللغة الدولية',
      'en' => 'Hello, I want to inquire about international language certificate preparation',
      'it' => 'Vorrei informazioni sulla preparazione per le certificazioni linguistiche',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'التدريب على أقسام الاختبارات المختلفة.',
        1 => 'تطوير مهارات الاستماع والقراءة والكتابة والتحدث.',
        2 => 'اختبارات تجريبية وتقييم مستوى المتدرب.',
        3 => 'تغطية اختبارات: IELTS – TOEFL – CILS – CELI وغيرها.',
      ),
      'en' => 
      array (
        0 => 'Targeted practice across all exam sections.',
        1 => 'Enhancing listening, reading, writing, and speaking skills.',
        2 => 'Full mock exams with performance reviews.',
        3 => 'Covers IELTS, TOEFL, CILS, CELI and more.',
      ),
      'it' => 
      array (
        0 => 'Esercitazioni mirate su ciascuna parte dell esame.',
        1 => 'Potenziamento di ascolto, lettura, scrittura e conversazione.',
        2 => 'Prove simulate e feedback personalizzato.',
        3 => 'Include IELTS, TOEFL, CILS, CELI e altri.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'تحديد نوع الاختبار المطلوب والدرجة المستهدفة',
        1 => 'مستوى لغوي مقارب للدرجة المستهدفة',
      ),
      'en' => 
      array (
        0 => 'Specifying target test and required score',
        1 => 'Baseline proficiency in the language',
      ),
      'it' => 
      array (
        0 => 'Scelta della certificazione e del punteggio obiettivo',
        1 => 'Livello linguistico di partenza congruo',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'اختبار تشخيصي أولي لتحديد نقاط القوة والضعف',
        1 => 'التدريب على كل قسم من أقسام الاختبار الأربعة',
        2 => 'جلسات تدريب صوتية فردية لمحادثة الامتحان',
        3 => 'اختبارات محاكاة كاملة تحت ظروف الامتحان الحقيقي',
      ),
      'en' => 
      array (
        0 => 'Diagnostic assessment identifying gaps',
        1 => 'Section-by-section drills across 4 skills',
        2 => 'Individual speaking practice sessions',
        3 => 'Full timed mock tests replicating exam environment',
      ),
      'it' => 
      array (
        0 => 'Test diagnostico di ingresso',
        1 => 'Esercitazioni strutturate sulle 4 abilità',
        2 => 'Sessioni individuali di conversazione per l orale',
        3 => 'Simulazioni complete di esame',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'ما هي مدة صلاحية شهادات اللغة الدولية؟',
          'answer' => 'تختلف حسب الجهة؛ فمعظم شهادات الإيطالية CILS وCELI دائمة الصلاحية، بينما IELTS وTOEFL مدتها سنتان.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'How long are language certificates valid?',
          'answer' => 'Most Italian certificates (CILS, CELI) have permanent validity, whereas IELTS and TOEFL are valid for 2 years.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Quanto durano le certificazioni?',
          'answer' => 'Le certificazioni CILS e CELI non hanno scadenza, mentre IELTS e TOEFL sono valide 2 anni.',
        ),
      ),
    ),
  ),
  7 => 
  array (
    'sort_order' => 8,
    'icon' => 'book-open',
    'slug_ar' => 'university-admissions',
    'slug_en' => 'university-admissions',
    'slug_it' => 'ammissioni-universitarie',
    'title' => 
    array (
      'ar' => 'القبول الجامعي والثانوي',
      'en' => 'University & School Admissions',
      'it' => 'Ammissioni Universitarie e Scolastiche',
    ),
    'summary' => 
    array (
      'ar' => 'نساعد الطلاب وأولياء الأمور في التعرف على فرص القبول بالجامعات والمدارس المناسبة، واختيار المؤسسة التعليمية وفق المؤهلات والمتطلبات، مع تجهيز ومراجعة المستندات ومتابعة إجراءات التقديم.',
      'en' => 'Assisting students and parents in discovering admission opportunities at suitable universities and schools, document preparation, and application tracking.',
      'it' => 'Supporto completo per studenti e famiglie nella scelta di scuole e atenei europei, preparazione documenti e gestione candidature.',
    ),
    'description' => 
    array (
      'ar' => 'نساعد الطلاب وأولياء الأمور في التعرف على فرص القبول بالجامعات والمدارس المناسبة، واختيار المؤسسة التعليمية وفق المؤهلات والمتطلبات، مع تجهيز ومراجعة المستندات ومتابعة إجراءات التقديم.',
      'en' => 'End-to-end guidance securing official university and high school admissions in Europe, ensuring full dossier compliance with admission boards.',
      'it' => 'Dall individuazione del percorso più adatto fino alla lettera di accettazione formale da parte degli istituti europei.',
    ),
    'badge' => 
    array (
      'ar' => 'مدارس وجامعات أوروبية',
      'en' => 'European Institutions',
      'it' => 'Istituti Europei',
    ),
    'category_label' => 
    array (
      'ar' => 'القبول والتسجيل الأكاديمي',
      'en' => 'Academic Admissions',
      'it' => 'Ammissioni & Iscrizioni',
    ),
    'level' => 
    array (
      'ar' => 'متابعة شاملة حتى إصدار القبول',
      'en' => 'Comprehensive tracking until admission',
      'it' => 'Assistenza completa fino all ammissione',
    ),
    'duration' => 
    array (
      'ar' => 'حسب المؤسسة التعليمية ومواعيد التقديم',
      'en' => 'Varies by educational institution and intake windows',
      'it' => 'In base all istituto e alle sessioni di ammissione',
    ),
    'mode' => 
    array (
      'ar' => 'متابعة واستشارات أونلاين وحضورية',
      'en' => 'Online consultations & in-person support',
      'it' => 'Consulenza online e supporto in presenza',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب وأولياء الأمور الراغبون في التقديم للمؤسسات التعليمية',
      'en' => 'Students and parents aiming to apply to prestigious European institutions',
      'it' => 'Studenti e famiglie che intendono candidarsi presso istituti europei',
    ),
    'salary_range' => 
    array (
      'ar' => 'قبول رسمي معتمد',
      'en' => 'Official Admission Letter',
      'it' => 'Lettera di ammissione ufficiale',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن خدمة القبول الجامعي والثانوي',
      'en' => 'Hello, I want to inquire about university and school admissions services',
      'it' => 'Vorrei informazioni sul servizio di ammissione universitaria e scolastica',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'البحث عن المؤسسات التعليمية المناسبة.',
        1 => 'مراجعة شروط ومتطلبات القبول.',
        2 => 'تجهيز ومتابعة ملفات التقديم.',
      ),
      'en' => 
      array (
        0 => 'Researching matching educational institutions.',
        1 => 'Reviewing specific admission rules and criteria.',
        2 => 'Dossier compilation and application tracking.',
      ),
      'it' => 
      array (
        0 => 'Ricerca degli istituti di istruzione più adatti.',
        1 => 'Verifica dei requisiti di ammissione specifici.',
        2 => 'Preparazione e gestione della candidatura.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'أوراق المؤهل الحالي مصدقة ومترجمة',
        1 => 'السيرة الذاتية وخطاب الدافع',
        2 => 'شهادة إجادة اللغة إن وُجدت',
      ),
      'en' => 
      array (
        0 => 'Translated and legalized academic certificates',
        1 => 'Curriculum Vitae and motivation letter',
        2 => 'Language proficiency proof if required',
      ),
      'it' => 
      array (
        0 => 'Certificati di studio tradotti e legalizzati',
        1 => 'Curriculum vitae e lettera motivazionale',
        2 => 'Certificato di lingua se richiesto',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'مراجعة الملف الأكاديمي واختيار الجامعات أو المدارس',
        1 => 'كتابة وتنسيق خطابات الدافع والسيرة الذاتية',
        2 => 'تقديم الملفات عبر البوابات الأكاديمية الرسمية',
        3 => 'استلام خطاب القبول الرسمي ومتابعة استكمال الإجراءات',
      ),
      'en' => 
      array (
        0 => 'Academic audit and institution selection',
        1 => 'Drafting CV and personal motivation statement',
        2 => 'Official portal submission and tracking',
        3 => 'Receiving admission letter and follow-up',
      ),
      'it' => 
      array (
        0 => 'Valutazione del profilo e selezione istituti',
        1 => 'Redazione CV e lettera di motivazione',
        2 => 'Invio della domanda sui portali universitari',
        3 => 'Ricezione dell ammissione e supporto successivo',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل تساعدون في اختيار التخصص المناسب؟',
          'answer' => 'نعم، يقدم مستشارنا الأكاديمي توجيهاً كاملاً بناءً على خلفيتك الدراسية ورغباتك المستقبلية.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Do you help in major selection?',
          'answer' => 'Yes, our academic advisors guide you based on your past education and future goals.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Aiutate nella scelta del corso di studi?',
          'answer' => 'Sì, i nostri consulenti ti orientano sul piano di studi più adatto alle tue aspirazioni.',
        ),
      ),
    ),
  ),
  8 => 
  array (
    'sort_order' => 9,
    'icon' => 'edit',
    'slug_ar' => 'proofreading-editing',
    'slug_en' => 'proofreading-editing',
    'slug_it' => 'correzione-revisione-testi',
    'title' => 
    array (
      'ar' => 'التدقيق اللغوي',
      'en' => 'Professional Proofreading & Editing',
      'it' => 'Revisione e Correzione Bozze',
    ),
    'summary' => 
    array (
      'ar' => 'خدمات مراجعة وتدقيق لغوي للنصوص والمستندات الأكاديمية والمهنية، بهدف تحسين جودة الكتابة وتصحيح الأخطاء اللغوية والإملائية والنحوية مع الحفاظ على المعنى الأصلي للنص.',
      'en' => 'Proofreading and linguistic editing services for academic and professional documents, improving writing quality while preserving original meaning.',
      'it' => 'Servizi di correzione bozze e revisione linguistica per documenti accademici e aziendali, per uno stile impeccabile.',
    ),
    'description' => 
    array (
      'ar' => 'خدمات مراجعة وتدقيق لغوي للنصوص والمستندات الأكاديمية والمهنية، بهدف تحسين جودة الكتابة وتصحيح الأخطاء اللغوية والإملائية والنحوية مع الحفاظ على المعنى الأصلي للنص.',
      'en' => 'Professional linguistic editing for theses, research papers, resumes, and official correspondence ensuring grammatical purity and polished academic tone.',
      'it' => 'Revisione dettagliata di tesi, articoli scientifici, lettere motivazionali e testi professionali con precisione stilistica e grammaticale.',
    ),
    'badge' => 
    array (
      'ar' => 'مراجعة أكاديمية متخصصة',
      'en' => 'Academic Precision',
      'it' => 'Precisione Accademica',
    ),
    'category_label' => 
    array (
      'ar' => 'الخدمات اللغوية والأكاديمية',
      'en' => 'Editorial & Linguistic Services',
      'it' => 'Servizi Linguistici e di Redazione',
    ),
    'level' => 
    array (
      'ar' => 'تدقيق لغوي ونحوي وبلاغي متكامل',
      'en' => 'Complete grammar and syntax audit',
      'it' => 'Revisione ortografica e stilistica completa',
    ),
    'duration' => 
    array (
      'ar' => 'حسب حجم النص وطبيعة المستند',
      'en' => 'According to document length and complexity',
      'it' => 'In base al volume del testo e urgenza',
    ),
    'mode' => 
    array (
      'ar' => 'أونلاين',
      'en' => 'Online submission & delivery',
      'it' => 'Online',
    ),
    'target_audience' => 
    array (
      'ar' => 'الطلاب والباحثون والأكاديميون والشركات والكتّاب',
      'en' => 'Students, researchers, academics, corporations, and authors',
      'it' => 'Studenti, ricercatori, docenti, aziende e autori',
    ),
    'salary_range' => 
    array (
      'ar' => 'خلو تام من الأخطاء 100%',
      'en' => '100% Error-Free Guarantee',
      'it' => 'Testi impeccabili al 100%',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن خدمة التدقيق اللغوي للنصوص والمستندات',
      'en' => 'Hello, I want to inquire about professional proofreading services',
      'it' => 'Vorrei informazioni sui servizi di correzione e revisione bozze',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'تصحيح الأخطاء الإملائية والنحوية.',
        1 => 'تحسين الصياغة والأسلوب اللغوي.',
        2 => 'مراجعة النصوص والأبحاث والمستندات.',
      ),
      'en' => 
      array (
        0 => 'Fixing spelling, grammatical, and typographical errors.',
        1 => 'Refining phrasing, clarity, and linguistic style.',
        2 => 'Reviewing academic papers, theses, and business documents.',
      ),
      'it' => 
      array (
        0 => 'Correzione di errori ortografici e grammaticali.',
        1 => 'Miglioramento dello stile e della fluidità espressiva.',
        2 => 'Revisione di tesi, saggi, ricerche e documenti aziendali.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'إرسال النص بصيغة إلكترونية قابلة للتعديل (Word أو PDF)',
        1 => 'توضيح طبيعة النص وأي إرشادات تنسيق خاصة',
      ),
      'en' => 
      array (
        0 => 'Editable document file (Word or text format)',
        1 => 'Any specific stylistic guidelines',
      ),
      'it' => 
      array (
        0 => 'File modificabile (Word o formato testo)',
        1 => 'Eventuali linee guida redazionali specifiche',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'استلام النص وتحديد حجم الكلمات والموعد',
        1 => 'المراجعة اللغوية والتدقيق النحوي والإملائي',
        2 => 'تحسين جودة الصياغة والأسلوب',
        3 => 'تسليم النسخة المدققة مع تتبع التغييرات',
      ),
      'en' => 
      array (
        0 => 'Text review, word count, and delivery timeline',
        1 => 'Spelling and grammatical editing',
        2 => 'Style and clarity enhancement',
        3 => 'Final delivery with tracked changes',
      ),
      'it' => 
      array (
        0 => 'Conteggio parole e conferma tempi di consegna',
        1 => 'Correzione ortografica e grammaticale approfondita',
        2 => 'Raffinamento stilistico',
        3 => 'Consegna del testo revisionato con modifiche tracciate',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل يشمل التدقيق إعادة الصياغة؟',
          'answer' => 'نعم، نحرص على تحسين الصياغة والأسلوب مع الحفاظ التام على المعنى الأصلي للكاتب.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Does proofreading include rephrasing?',
          'answer' => 'Yes, we refine style and phrasing while preserving your intended meaning.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'La revisione include la riscrittura di frasi?',
          'answer' => 'Sì, miglioriamo la fluidità preservando fedelmente il significato originale.',
        ),
      ),
    ),
  ),
  9 => 
  array (
    'sort_order' => 10,
    'icon' => 'documents',
    'slug_ar' => 'embassy-appointments',
    'slug_en' => 'embassy-appointments',
    'slug_it' => 'appuntamenti-ambasciate-consolati',
    'title' => 
    array (
      'ar' => 'حجز مواعيد السفارات والقنصليات',
      'en' => 'Embassy & Consulate Appointments',
      'it' => 'Prenotazione Appuntamenti Consolari',
    ),
    'summary' => 
    array (
      'ar' => 'نقدم المساعدة في إجراءات حجز مواعيد السفارات والقنصليات وفق الأنظمة والمتطلبات المتاحة لكل جهة، مع توضيح خطوات الحجز والمعلومات اللازمة لإتمام الطلب.',
      'en' => 'Assistance with embassy and consulate booking procedures per available official platforms, clarifying required steps and documentation.',
      'it' => 'Assistenza nelle procedure di prenotazione appuntamenti presso ambasciate e consolati, con indicazione di requisiti e modulistica.',
    ),
    'description' => 
    array (
      'ar' => 'نقدم المساعدة في إجراءات حجز مواعيد السفارات والقنصليات وفق الأنظمة والمتطلبات المتاحة لكل جهة، مع توضيح خطوات الحجز والمعلومات اللازمة لإتمام الطلب. (تنويه: الخدمة خاصة بالمساعدة في حجز المواعيد، ولا تشمل إصدار التأشيرات أو ضمان الحصول عليها).',
      'en' => 'Guidance on booking consular appointments per official diplomatic portals, requirements explanation, and status tracking. (Note: Service covers booking assistance and does not guarantee or issue visas).',
      'it' => 'Supporto nell orientamento sui portali consolari per fissare appuntamenti, con chiarimenti documentali. (Avvertenza: il servizio riguarda l assistenza alla prenotazione e non garantisce il rilascio del visto).',
    ),
    'badge' => 
    array (
      'ar' => 'متابعة رسمية وفق المواعيد',
      'en' => 'Official Booking Assistance',
      'it' => 'Assistenza Ufficiale',
    ),
    'category_label' => 
    array (
      'ar' => 'المواعيد القنصلية والدبلوماسية',
      'en' => 'Consular & Diplomatic Appointments',
      'it' => 'Servizi Consolari & Appuntamenti',
    ),
    'level' => 
    array (
      'ar' => 'تنسيق ومتابعة مواعيد السفارات',
      'en' => 'Consular schedule monitoring',
      'it' => 'Monitoraggio calendari consolari',
    ),
    'duration' => 
    array (
      'ar' => 'حسب توافر المواعيد ونظام كل جهة',
      'en' => 'Depends on consular slot availability and system',
      'it' => 'In base alla disponibilità degli slot consolari',
    ),
    'mode' => 
    array (
      'ar' => 'أونلاين',
      'en' => 'Online',
      'it' => 'Online',
    ),
    'target_audience' => 
    array (
      'ar' => 'الأفراد الذين يحتاجون إلى حجز مواعيد لدى السفارات والقنصليات',
      'en' => 'Individuals requiring official appointments at embassies and consulates',
      'it' => 'Privati che necessitano di appuntamenti presso ambasciate e consolati',
    ),
    'salary_range' => 
    array (
      'ar' => 'متابعة مستمرة ودقيقة',
      'en' => 'Accurate Booking Follow-up',
      'it' => 'Monitoraggio accurato',
    ),
    'whatsapp_message' => 
    array (
      'ar' => 'مرحباً، أود الاستفسار عن خدمة حجز مواعيد السفارات والقنصليات',
      'en' => 'Hello, I want to inquire about embassy and consulate appointment assistance',
      'it' => 'Vorrei informazioni sull assistenza per appuntamenti consolari',
    ),
    'features' => 
    array (
      'ar' => 
      array (
        0 => 'المساعدة في إجراءات حجز المواعيد.',
        1 => 'توضيح متطلبات الحجز لكل جهة.',
        2 => 'متابعة حالة طلب الحجز وإبلاغ العميل بالمستجدات.',
        3 => 'تنويه: الخدمة للمساعدة في حجز المواعيد ولا تشمل إصدار التأشيرات أو ضمانها.',
      ),
      'en' => 
      array (
        0 => 'Assistance with appointment booking procedures.',
        1 => 'Clarifying specific booking requirements for each authority.',
        2 => 'Tracking appointment status and notifying clients of updates.',
        3 => 'Disclaimer: Service assists with booking only; no visa issuance is guaranteed.',
      ),
      'it' => 
      array (
        0 => 'Supporto nell iter di prenotazione appuntamenti.',
        1 => 'Chiarimento dei requisiti richiesti da ciascuna sede.',
        2 => 'Monitoraggio della richiesta e aggiornamenti al cliente.',
        3 => 'Avvertenza: il servizio assiste nella prenotazione e non rilascia visti.',
      ),
    ),
    'requirements' => 
    array (
      'ar' => 
      array (
        0 => 'بيانات جواز السفر ساري المفعول',
        1 => 'تحديد السفارة والغرض من الموعد (دراسة / عمل / سياحة)',
      ),
      'en' => 
      array (
        0 => 'Valid passport data',
        1 => 'Specified embassy and appointment reason',
      ),
      'it' => 
      array (
        0 => 'Dati del passaporto in corso di validità',
        1 => 'Sede consolare e motivazione della richiesta',
      ),
    ),
    'steps' => 
    array (
      'ar' => 
      array (
        0 => 'تسجيل بيانات جواز السفر والغرض من الموعد',
        1 => 'متابعة فتح المواعيد الرسمية على المنصات القنصلية',
        2 => 'إتمام حجز الموعد وتأكيد الحجز فور إتاحته',
        3 => 'إرسال إشعار الحجز وقائمة الأوراق المطلوبة للمقابلة',
      ),
      'en' => 
      array (
        0 => 'Register passport details and appointment purpose',
        1 => 'Monitoring official consular portal openings',
        2 => 'Securing appointment slot as soon as released',
        3 => 'Sending confirmation receipt and checklist for the visit',
      ),
      'it' => 
      array (
        0 => 'Registrazione dati anagrafici e scopo dell appuntamento',
        1 => 'Monitoraggio delle aperture sui portali ufficiali',
        2 => 'Conferma della prenotazione al momento dell apertura slot',
        3 => 'Invio ricevuta di conferma e promemoria documenti',
      ),
    ),
    'faqs' => 
    array (
      'ar' => 
      array (
        0 => 
        array (
          'question' => 'هل تضمنون الحصول على تأشيرة السفر؟',
          'answer' => 'الخدمة خاصة بالمساعدة في حجز المواعيد وتجهيز الملف، وقرار منح التأشيرة يرجع كلياً للقسم القنصلي بالسفارة.',
        ),
      ),
      'en' => 
      array (
        0 => 
        array (
          'question' => 'Do you guarantee visa issuance?',
          'answer' => 'No, our role is assisting in appointment scheduling and document preparation; visa decisions are solely made by the embassy.',
        ),
      ),
      'it' => 
      array (
        0 => 
        array (
          'question' => 'Il servizio garantisce il rilascio del visto?',
          'answer' => 'No, il servizio riguarda l assistenza tecnica alla prenotazione; la concessione del visto compete unicamente al consolato.',
        ),
      ),
    ),
  ),
);

        $validSlugs = collect($coreServices)->pluck('slug_ar')->all();

        // Deactivate legacy services not in the official 10 services
        Service::query()->whereNotIn('slug_ar', $validSlugs)->update(['is_active' => false]);

        foreach ($coreServices as $item) {
            $data = $item + [
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
            ];

            $existing = Service::query()->where('slug_ar', $item['slug_ar'])->first();
            if ($existing) {
                $updates = [];

                // Fill any missing multilingual translations while preserving existing customized titles
                $currentTitle = $existing->title ?? [];
                if (empty($currentTitle['it']) || empty($currentTitle['en']) || empty($currentTitle['ar'])) {
                    $updates['title'] = array_merge($data['title'], is_array($currentTitle) ? $currentTitle : []);
                }

                $currentBadge = $existing->badge ?? [];
                if (empty($currentBadge['it']) || empty($currentBadge['en'])) {
                    $updates['badge'] = array_merge($data['badge'], is_array($currentBadge) ? $currentBadge : []);
                }

                $currentCat = $existing->category_label ?? [];
                if (empty($currentCat['it']) || empty($currentCat['en'])) {
                    $updates['category_label'] = array_merge($data['category_label'], is_array($currentCat) ? $currentCat : []);
                }

                foreach (['level', 'duration', 'mode', 'target_audience', 'salary_range', 'whatsapp_message', 'features', 'requirements', 'steps', 'faqs'] as $field) {
                    if (empty($existing->{$field})) {
                        $updates[$field] = $item[$field];
                    }
                }

                if (!$existing->is_active) {
                    $updates['is_active'] = true;
                }

                if (!empty($updates)) {
                    $existing->update($updates);
                }
            } else {
                Service::query()->create($data);
            }
        }
    }
}
