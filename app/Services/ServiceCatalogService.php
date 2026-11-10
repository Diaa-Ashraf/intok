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
        $coreServices = [
            [
                'slug_ar' => 'تدريب-الكول-سنتر-الاحترافي',
                'slug_en' => 'professional-call-center-training',
                'slug_it' => 'formazione-call-center-professionale',
                'title' => [
                    'ar' => 'تدريب الكول سنتر الاحترافي',
                    'en' => 'Professional Call Center Training',
                    'it' => 'Formazione Call Center Professionale',
                ],
                'summary' => [
                    'ar' => 'برنامج تدريبي يؤهلك للعمل في الكول سنتر باحتراف، مع تطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات بثقة.',
                    'en' => 'A training program qualifying you to work in call centers professionally, developing communication skills, customer service, and acing interviews.',
                    'it' => 'Un programma di formazione che ti qualifica a lavorare nei call center con professionalità e sicurezza.',
                ],
                'description' => [
                    'ar' => 'برنامج تدريبي يؤهلك للعمل في الكول سنتر باحتراف، مع تطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات بثقة. يشمل تدريباً عملياً مكثفاً على مهارات التحدث باللغات الأجنبية، إدارة المكالمات، وتجاوز أصعب مواقف خدمة العملاء بنجاح.',
                    'en' => 'Intensive practical training in foreign language communication, call handling, customer service, with real interview simulations for top multinational call centers.',
                    'it' => 'Formazione intensiva sulle competenze linguistiche, gestione delle chiamate e simulazioni di colloqui per grandi aziende.',
                ],
                'badge' => ['ar' => 'الأكثر طلباً', 'en' => 'Most Popular', 'it' => 'Più Richiesto'],
                'category_label' => ['ar' => 'تأهيل لسوق العمل والكول سنتر', 'en' => 'Career & Call Center', 'it' => 'Lavoro e Call Center'],
                'level' => ['ar' => 'تأهيل وظيفي مباشر لكبرى الشركات', 'en' => 'Direct Career Qualification', 'it' => 'Qualificazione Professionale Diretta'],
                'duration' => ['ar' => 'مكثف (4 - 6 أسابيع)', 'en' => 'Intensive (4-6 weeks)', 'it' => 'Intensivo (4-6 settimane)'],
                'mode' => ['ar' => 'قاعات مجهزة + أونلاين تفاعلي', 'en' => 'Equipped Classrooms + Live Online', 'it' => 'In Aula + Online Live'],
                'target_audience' => ['ar' => 'خريجو المؤهلات والباحثون عن دخل مميز بالعملات الأجنبية', 'en' => 'Graduates and seekers of foreign currency income', 'it' => 'Diplomati e laureati'],
                'salary_range' => ['ar' => '15,000 - 30,000+ ج.م شهرياً', 'en' => '15k - 30k+ EGP monthly', 'it' => 'Stipendio competitivo'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود الاستفسار والتسجيل في برنامج تدريب الكول سنتر الاحترافي', 'en' => 'Hello, I want to inquire about Call Center Training', 'it' => 'Vorrei informazioni sul corso Call Center'],
                'features' => [
                    'ar' => [
                        'محاكاة حقيقية لمقابلات كبرى الشركات متعددة الجنسيات (Vodafone UK, Concentrix, TP)',
                        'تدريب عملي تفاعلي على الشاشات الذكية والصوتيات وحل مشكلات العملاء باحترافية',
                        'تأهيل للعمل برواتب مجزية بالعملات الأجنبية مع متابعة شخصية حتى اجتياز المقابلة',
                        'إتقان اللهجة والأسلوب المهني المناسب للحملات الدولية',
                    ],
                    'en' => [
                        'Real interview simulations for multinational companies (Vodafone UK, Concentrix, TP)',
                        'Hands-on interactive training on smart screens and acoustics',
                        'Preparation for rewarding salaries with personal mentorship until passing the interview',
                        'Mastering accent and professional tone for international campaigns',
                    ],
                    'it' => [
                        'Simulazioni di colloquio reali per aziende multinazionali',
                        'Esercitazioni pratiche su schermi interattivi e fonetica',
                        'Preparazione a retribuzioni competitive con tutor dedicato',
                    ],
                ],
                'requirements' => [
                    'ar' => ['الرغبة الجادة في التعلم والتطوير', 'التزام بحضور الورش العملية والمحاكاة'],
                    'en' => ['Commitment to learn and develop', 'Attendance of workshops and simulations'],
                    'it' => ['Impegno e partecipazione attiva', 'Disponibilità per esercitazioni pratiche'],
                ],
                'steps' => [
                    'ar' => ['تحديد المستوى اللغوي والصوتي مجاناً', 'حضور ورش المحاكاة العملية المكثفة', 'التقديم المباشر للمقابلات الوظيفية والتعاقد'],
                    'en' => ['Free language assessment', 'Intensive practical simulation workshops', 'Direct application to job interviews'],
                    'it' => ['Valutazione del livello iniziale', 'Sessioni di simulazione intensiva', 'Colloquio diretto e assunzione'],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يشترط مؤهل معين للالتحاق؟', 'answer' => 'البرنامج متاح لجميع المؤهلات العليا والمتوسطة، الأهم هو الرغبة في التعلم واجتياز التقييم المبدئي.'],
                        ['question' => 'ما هي الرواتب المتوقعة بعد التخرج؟', 'answer' => 'تبدأ الرواتب من 15,000 ج.م وتصل لأكثر من 30,000 ج.م شهرياً حسب اللغة والشركة.'],
                    ],
                    'en' => [
                        ['question' => 'Are there specific qualifications required?', 'answer' => 'Open to all graduates; commitment and passing the initial assessment are key.'],
                    ],
                    'it' => [
                        ['question' => 'Quali sono i requisiti di ammissione?', 'answer' => 'Aperto a diplomati e laureati motivati.'],
                    ],
                ],
                'icon' => 'headset',
                'sort_order' => 1,
            ],
            [
                'slug_ar' => 'italy-study-dsu',
                'slug_en' => 'italy-study-dsu',
                'slug_it' => 'studiare-in-italia-borse-dsu',
                'title' => [
                    'ar' => 'الدراسة في الدول الأوروبية والمنح الشاملة',
                    'en' => 'Study in European Countries & Full Scholarships',
                    'it' => 'Studiare nei Paesi Europei & Borse di Studio Complete',
                ],
                'summary' => [
                    'ar' => 'بوابتك المعتمدة لاستكمال دراستك في أعرق الجامعات والمدارس الأوروبية والحصول على المنح الشاملة بقيمة تصل إلى 8,000€ سنوياً وسكن مجاني.',
                    'en' => 'Your certified gateway to study in prestigious European universities and secure full scholarships worth up to 8,000€/year plus free accommodation.',
                    'it' => 'Il tuo percorso per studiare nelle università europee e ottenere borse di studio complete con alloggio gratuito.',
                ],
                'description' => [
                    'ar' => 'برنامج متكامل لتأهيل الطلاب وحملة الدبلومات الفنية (صنايع، تجارة، زراعة) والثانوية العامة والأزهرية لاستكمال دراستهم في الدول الأوروبية، مع الحصول على المنح الحكومية والجامعية التي تمنحك حتى 8,000 يورو سنوياً، وسكن جامعي مجاني، وتصريح عمل رسمي باليورو وفق القوانين الأوروبية.',
                    'en' => 'Comprehensive guidance for students and technical diploma holders to study in European universities with full scholarships (up to 8,000€/year, free housing, legal work permit).',
                    'it' => 'Orientamento completo per diplomati e studenti per l immatricolazione universitaria nei paesi europei con borse di studio e alloggio.',
                ],
                'badge' => ['ar' => 'منحة 8,000€ + سكن مجاني', 'en' => '8,000€ Grant + Free Housing', 'it' => 'Borsa 8.000€ + Alloggio'],
                'category_label' => ['ar' => 'الدراسة في أوروبا والمنح', 'en' => 'Study in Europe & Grants', 'it' => 'Studio in Europa'],
                'level' => ['ar' => 'ثانوية عامة + دبلومات فنية (صنايع / تجارة / زراعة)', 'en' => 'High School & Technical Diplomas', 'it' => 'Scuola Superiore & Istituti Tecnici'],
                'duration' => ['ar' => 'التقديم متاح الآن للموسم القادم', 'en' => 'Applications open for next intake', 'it' => 'Iscrizioni aperte'],
                'mode' => ['ar' => 'إشراف متكامل من الألف للياء', 'en' => 'End-to-end full supervision', 'it' => 'Supervisione completa'],
                'target_audience' => ['ar' => 'حملة الدبلومات الفنية والثانوية والجامعيين', 'en' => 'Technical diploma and high school holders', 'it' => 'Studenti e diplomati'],
                'salary_range' => ['ar' => 'عمل قانوني 20 ساعة/أسبوع باليورو', 'en' => 'Legal work 20 hrs/week in Euros', 'it' => 'Lavoro legale part-time in Euro'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود فحص شروط القبول للدراسة في الدول الأوروبية والمنح الدراسية', 'en' => 'Hello, I want to check admission for European universities & scholarships', 'it' => 'Vorrei informazioni su borse di studio nei paesi europei'],
                'features' => [
                    'ar' => [
                        'قبول جامعي ومدرسي معتمد لحملة الدبلومات الفنية والثانوية العامة والأزهرية',
                        'تجهيز كامل لملف منحة DSU الحكومية (8,000 يورو سنوياً + سكن مجاني معفى)',
                        'إنهاء ترجمة وتصديق كافة المستندات لدى السفارة الإيطالية والجهات الرسمية',
                        'استقبال بالمطار وتسليم السكن واستخراج الإقامة والحساب البنكي بالدول الأوروبية',
                    ],
                    'en' => [
                        'Accredited admission for technical diplomas and high school graduates',
                        'Full preparation for the government DSU scholarship file (8,000€/year + free housing)',
                        'Certified translation and legalizations at European embassies',
                        'Airport reception, housing delivery, residence permit and bank account assistance',
                    ],
                    'it' => [
                        'Ammissione accreditata per istituti e università europee',
                        'Gestione completa del fascicolo borsa DSU (8.000€/anno + alloggio)',
                        'Traduzioni giurate e legalizzazioni consolari',
                        'Accoglienza e supporto per permesso di soggiorno e conto bancario',
                    ],
                ],
                'requirements' => [
                    'ar' => ['شهادة الثانوية العامة أو دبلوم فني (صنايع / تجارة / زراعة / فندقي)', 'جواز سفر سارٍ وشهادة الميلاد'],
                    'en' => ['High school certificate or technical diploma', 'Valid passport and birth certificate'],
                    'it' => ['Diploma di scuola superiore o istituto tecnico', 'Passaporto in corso di validità'],
                ],
                'steps' => [
                    'ar' => ['فحص الأوراق واختيار التخصص والجامعة المناسبة', 'تجهيز ملف منحة DSU والتصديقات والترجمة المعتمدة', 'استلام التأشيرة والاستقبال بميلانو أو روما وبدء الدراسة'],
                    'en' => ['Documents check and university selection', 'DSU file preparation and embassy legalization', 'Visa receipt and airport reception in Europe'],
                    'it' => ['Valutazione documenti e scelta università', 'Preparazione borsa DSU e legalizzazioni', 'Rilascio visto e accoglienza all arrivo'],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يحق لحملة الدبلومات الفنية التقديم؟', 'answer' => 'نعم وبشكل رسمي 100%! الجامعات الأوروبية تقبل الدبلومات الفنية بنظام 3 و5 سنوات للحصول على قبول جامعي مع المنح.'],
                        ['question' => 'ماذا تغطي منحة DSU الإيطالية؟', 'answer' => 'تغطي المنحة بدل إعاشة نقدي سنوي يصل إلى 8,000 يورو، سكن جامعي مجاني، وإعفاء كامل من المصروفات الدراسية.'],
                    ],
                    'en' => [
                        ['question' => 'Can technical diploma holders apply?', 'answer' => 'Yes, European universities officially accept 3 and 5-year technical diplomas with scholarships.'],
                    ],
                    'it' => [
                        ['question' => 'Cosa copre la borsa DSU?', 'answer' => 'Copre fino a 8.000€ all anno, alloggio gratuito ed esenzione dalle tasse universitarie.'],
                    ],
                ],
                'icon' => 'academic-cap',
                'sort_order' => 2,
            ],
            [
                'slug_ar' => 'احتراف-الترجمة',
                'slug_en' => 'translation-mastery',
                'slug_it' => 'maestria-nella-traduzione',
                'title' => [
                    'ar' => 'احتراف الترجمة',
                    'en' => 'Translation Mastery',
                    'it' => 'Maestria nella Traduzione',
                ],
                'summary' => [
                    'ar' => 'برنامج تدريبي لتعلم الترجمة باحتراف، مع تطبيقات عملية على النصوص المختلفة وتأهيلك للعمل في المجال بثقة.',
                    'en' => 'A training program to learn professional translation with hands-on practice across specialized texts.',
                    'it' => 'Programma per apprendere la traduzione professionale con esercitazioni pratiche.',
                ],
                'description' => [
                    'ar' => 'برنامج تدريبي لتعلم الترجمة باحتراف، مع تطبيقات عملية على النصوص المختلفة وتأهيلك للعمل في المجال بثقة. يشمل التعامل مع الوثائق الرسمية والتقنية وبناء سيرة ذاتية وبورتفوليو قوي يجذب العملاء الدوليين.',
                    'en' => 'Hands-on training in specialized, legal, and technical translation, preparing you for freelance markets and international translation agencies.',
                    'it' => 'Formazione su traduzione tecnica e giuridica con strumenti CAT avanzati.',
                ],
                'badge' => ['ar' => 'تأهيل للعمل الحر', 'en' => 'Freelance Ready', 'it' => 'Pronto per Freelance'],
                'category_label' => ['ar' => 'الترجمة والاعتماد', 'en' => 'Translation & Certification', 'it' => 'Traduzione & Asseverazione'],
                'level' => ['ar' => 'من المبتدئ حتى الاحتراف والعمل الحر', 'en' => 'From Beginner to Professional Freelancer', 'it' => 'Da Principiante a Professionista'],
                'duration' => ['ar' => 'ورش عمل ومشاريع تطبيقية', 'en' => 'Workshops & Real Projects', 'it' => 'Workshop & Progetti Reali'],
                'mode' => ['ar' => 'مشاريع عملية حقيقية', 'en' => 'Hands-on Real Projects', 'it' => 'Progetti Pratici'],
                'target_audience' => ['ar' => 'خريجو كليات اللغات والآداب والمترجمون المستقلون', 'en' => 'Language graduates and freelance translators', 'it' => 'Laureati in lingue'],
                'salary_range' => ['ar' => 'عائد مميز بالدولار واليورو عبر منصات الفريلانس', 'en' => 'Strong income in USD/EUR on freelance platforms', 'it' => 'Compensi in valuta estera'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود الاستفسار عن كورس احتراف الترجمة والعمل الحر', 'en' => 'Hello, I want to inquire about Translation Mastery', 'it' => 'Vorrei informazioni sul corso di traduzione'],
                'features' => [
                    'ar' => [
                        'تدريب تطبيقي على الترجمة التحريرية والفورية في المجالات القانونية والطبية والتقنية',
                        'إتقان أدوات الترجمة بمساعدة الحاسوب (CAT Tools) ومعايير الجودة العالمية',
                        'تأهيل مباشر لدخول منصات العمل الحر (Freelancing) ووكالات الترجمة الدولية',
                        'بناء بورتفوليو مهني وسيرة ذاتية قوية تجذب العملاء والشركات',
                    ],
                    'en' => [
                        'Practical training in legal, medical, and technical translation',
                        'Mastery of CAT tools and global translation standards',
                        'Direct qualification for top freelancing platforms and agencies',
                        'Building a strong portfolio and CV that attracts global clients',
                    ],
                    'it' => [
                        'Traduzione giuridica, medica e tecnica',
                        'Uso di strumenti CAT professionali',
                        'Costruzione di portfolio e ingresso nel mercato freelance',
                    ],
                ],
                'icon' => 'language',
                'sort_order' => 3,
            ],
            [
                'slug_ar' => 'ترجمة-معتمدة-احترافية',
                'slug_en' => 'certified-professional-translation',
                'slug_it' => 'traduzione-giurata-professionale',
                'title' => [
                    'ar' => 'ترجمة معتمدة احترافية',
                    'en' => 'Certified Professional Translation',
                    'it' => 'Traduzione Giurata Professionale',
                ],
                'summary' => [
                    'ar' => 'خدمة ترجمة معتمدة لجميع المستندات بدقة عالية وسرعة تنفيذ، مع توثيق رسمي معترف به للجهات الحكومية والسفارات.',
                    'en' => 'Certified translation service for all documents with top accuracy, speed, and official recognition by embassies and government bodies.',
                    'it' => 'Servizio di traduzione asseverata per documenti ufficiali riconosciuto da ambasciate e consolati.',
                ],
                'description' => [
                    'ar' => 'خدمة ترجمة معتمدة لجميع المستندات بدقة عالية وسرعة تنفيذ، مع توثيق رسمي معترف به للجهات الحكومية والسفارات. تشمل ترجمة الأوراق الدراسية وشهادات الميلاد وعقود العمل والملفات القانونية.',
                    'en' => 'Certified translations of visa files, academic certificates, transcripts, and official declarations recognized by Italian and European embassies.',
                    'it' => 'Traduzioni certificate di certificati di studio, documenti di identità e pratiche per visti consolari.',
                ],
                'badge' => ['ar' => 'معتمدة رسمياً للسفارات', 'en' => 'Officially Embassy Certified', 'it' => 'Certificata per Ambasciate'],
                'category_label' => ['ar' => 'الترجمة والاعتماد', 'en' => 'Translation & Certification', 'it' => 'Traduzione & Asseverazione'],
                'level' => ['ar' => 'توثيق وتصديق قانوني وقنصلي', 'en' => 'Legal and Consular Authentication', 'it' => 'Asseverazione Legale & Consolare'],
                'duration' => ['ar' => 'تسليم سريع (24-48 ساعة)', 'en' => 'Fast delivery (24-48 hrs)', 'it' => 'Consegna rapida (24-48h)'],
                'mode' => ['ar' => 'معتمدة ومختومة رسمياً', 'en' => 'Officially stamped & sealed', 'it' => 'Ufficialmente timbrata'],
                'target_audience' => ['ar' => 'المسافرون للعمل والدراسة والشركات', 'en' => 'Travelers for work, study, and companies', 'it' => 'Richiedenti visto e aziende'],
                'salary_range' => ['ar' => 'قبول رسمي 100% دون أي مخاطرة بالرفض', 'en' => '100% acceptance guarantee', 'it' => 'Accettazione garantita'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود ترجمة مستندات ترجمة معتمدة رسمية للسفارة', 'en' => 'Hello, I need certified translations for the embassy', 'it' => 'Vorrei un preventivo per traduzione asseverata'],
                'features' => [
                    'ar' => [
                        'ترجمة معتمدة وموثقة لجميع المستندات الشخصية، شهادات التخرج، وإعلانات القيمة',
                        'معترف بها رسمياً لدى السفارات والقنصليات الأوروبية والجهات الحكومية',
                        'دقة لغوية وقانونية متناهية مع خيارات تسليم فوري للملفات المستعجلة',
                        'إنهاء التصديقات والمعاملات الحكومية اللازمة لسفرك',
                    ],
                    'en' => [
                        'Certified translation for personal documents, degrees, and Dichiarazione di Valore',
                        'Recognized by European embassies and all governmental authorities',
                        'Extreme linguistic and legal precision with rush delivery options',
                        'Full handling of consular legalizations and authentications',
                    ],
                    'it' => [
                        'Traduzione giurata di certificati di laurea, atti e dichiarazioni di valore',
                        'Riconosciuta dalle ambasciate europee e dalle istituzioni ufficiali',
                    ],
                ],
                'icon' => 'documents',
                'sort_order' => 4,
            ],
            [
                'slug_ar' => 'التأهيل-للاختبارات-الدولية',
                'slug_en' => 'international-exam-preparation',
                'slug_it' => 'preparazione-esami-internazionali',
                'title' => [
                    'ar' => 'التأهيل للاختبارات الدولية',
                    'en' => 'International Exam Preparation',
                    'it' => 'Preparazione Esami Internazionali',
                ],
                'summary' => [
                    'ar' => 'برامج تدريبية متخصصة لإعدادك لاجتياز الاختبارات الدولية مثل IELTS وTOEFL، مع تدريب عملي على جميع المهارات.',
                    'en' => 'Specialized training programs to prepare you for international exams such as IELTS and TOEFL with hands-on practice across all skills.',
                    'it' => 'Corsi mirati per superare esami internazionali come IELTS, TOEFL e certificazioni europee.',
                ],
                'description' => [
                    'ar' => 'برامج تدريبية متخصصة لإعدادك لاجتياز الاختبارات الدولية مثل IELTS وTOEFL، مع تدريب عملي على جميع المهارات ومراجعات مستمرة تضمن لك تحقيق الدرجة المطلوبة في وقت قياسي.',
                    'en' => 'Tailored preparation for IELTS, TOEFL, and Italian exams (CILS, CELI) required for European admissions and scholarships.',
                    'it' => 'Preparazione intensiva per esami universitari e certificazioni linguistiche con test pratici.',
                ],
                'badge' => ['ar' => 'ضمان اجتياز الاختبار', 'en' => 'Pass Guaranteed', 'it' => 'Superamento Garantito'],
                'category_label' => ['ar' => 'اللغات والاختبارات', 'en' => 'Languages & Exams', 'it' => 'Lingue & Certificazioni'],
                'level' => ['ar' => 'إعداد معتمد رسمي (IELTS / TOEFL / CILS / CELI)', 'en' => 'Official Preparation (IELTS / TOEFL / CILS)', 'it' => 'Preparazione Ufficiale'],
                'duration' => ['ar' => 'خطط مكثفة بحسب المستوى', 'en' => 'Intensive customized plans', 'it' => 'Piani intensivi su misura'],
                'mode' => ['ar' => 'مجموعات صغيرة + متابعة فردية', 'en' => 'Small groups + 1-on-1 coaching', 'it' => 'Piccoli gruppi + tutoring individuale'],
                'target_audience' => ['ar' => 'المتقدمون للمنح والجامعات والسفر بالخارج', 'en' => 'Scholarship applicants and study abroad seekers', 'it' => 'Candidati a borse di studio'],
                'salary_range' => ['ar' => 'تحقيق السكور المطلوب للقبول الجامعي والهجرة', 'en' => 'Achieving required band score for visa & admission', 'it' => 'Punteggio richiesto garantito'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود الاستفسار عن دورات التأهيل لاختبارات IELTS / TOEFL / CILS', 'en' => 'Hello, I want to inquire about IELTS/TOEFL/CILS training', 'it' => 'Vorrei informazioni sui corsi di preparazione esami'],
                'features' => [
                    'ar' => [
                        'استراتيجيات متقدمة لاجتياز اختبارات IELTS & TOEFL واختبارات الإيطالي (CILS/CELI)',
                        'تدريب مكثف على مهارات التحدث، الاستماع، القراءة، والكتابة الأكاديمية',
                        'اختبارات تجريبية تحاكي الاختبار الحقيقي بنسبة 100% مع تقييم دقيق لنقاط القوة',
                        'متابعة دورية لتطوير جوانب القصور وضمان السكور المطلوب',
                    ],
                    'en' => [
                        'Advanced strategies for IELTS, TOEFL, and Italian (CILS/CELI) exams',
                        'Intensive coaching across speaking, listening, reading, and academic writing',
                        '100% realistic mock exams with precise scoring diagnostics',
                    ],
                    'it' => [
                        'Strategie avanzate per IELTS, TOEFL e certificazioni di italiano (CILS/CELI)',
                    ],
                ],
                'icon' => 'certificate',
                'sort_order' => 5,
            ],
            [
                'slug_ar' => 'إعداد-محاضري-اللغات',
                'slug_en' => 'language-instructor-training',
                'slug_it' => 'formazione-docenti-di-lingua',
                'title' => [
                    'ar' => 'إعداد محاضري اللغات',
                    'en' => 'Language Instructor Training',
                    'it' => 'Formazione Docenti di Lingua',
                ],
                'summary' => [
                    'ar' => 'برنامج متخصص لإعداد مدربي اللغات بمهارات التدريس والتواصل، مع تطبيق عملي يؤهلك للعمل بثقة.',
                    'en' => 'A specialized program preparing language instructors with teaching and pedagogical communication skills and hands-on teaching practice.',
                    'it' => 'Programma per formare docenti ed esperti di lingue con metodologie moderne e pratiche di insegnamento.',
                ],
                'description' => [
                    'ar' => 'برنامج متخصص لإعداد مدربي اللغات بمهارات التدريس والتواصل، مع تطبيق عملي يؤهلك للعمل بثقة. يركز على علم التدريس الحديث وإدارة سلوك المتعلمين واستخدام الأدوات الرقمية في الشرح.',
                    'en' => 'Equipping instructors with modern interactive teaching methodologies, curriculum design, classroom management, and online teaching.',
                    'it' => 'Metodologie didattiche avanzate, gestione dell aula e pianificazione dei corsi di lingua.',
                ],
                'badge' => ['ar' => 'برنامج مدرب معتمد (TOT)', 'en' => 'Certified Trainer (TOT)', 'it' => 'Docente Certificato (TOT)'],
                'category_label' => ['ar' => 'اللغات وتأهيل المحاضرين', 'en' => 'Instructor Qualification', 'it' => 'Formazione Docenti'],
                'level' => ['ar' => 'دبلومة مهنية متقدمة في تدريس اللغات', 'en' => 'Advanced Professional Diploma in Language Teaching', 'it' => 'Diploma Professionale Docenti'],
                'duration' => ['ar' => 'تدريب تدريسي تطبيقي مكثف', 'en' => 'Intensive practical teaching', 'it' => 'Tirocinio pratico intensivo'],
                'mode' => ['ar' => 'محاكاة تدريس حي بقاعات ذكية', 'en' => 'Live classroom teaching simulation', 'it' => 'Simulazioni di docenza in aula'],
                'target_audience' => ['ar' => 'المعلمون والمدربون وخريجو اللغات والتربية', 'en' => 'Teachers, trainers, and education/language graduates', 'it' => 'Docenti e laureati'],
                'salary_range' => ['ar' => 'عقود عمل بمدارس دولية وأكاديميات كبرى', 'en' => 'Contracts with international schools and top academies', 'it' => 'Opportunità in scuole internazionali'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود الاستفسار عن دبلومة إعداد محاضري اللغات المعتمدة (TOT)', 'en' => 'Hello, I want to inquire about Language Instructor TOT', 'it' => 'Vorrei informazioni sul corso TOT'],
                'features' => [
                    'ar' => [
                        'أحدث استراتيجيات التدريس التفاعلي وتقنيات إدارة القاعات والمناهج الذكية',
                        'تطوير مهارات الإلقاء والشرح الإبداعي وبناء الأنشطة التعليمية الحديثة',
                        'تطبيقات تدريس حية ومباشرة تؤهلك للتعاقد مع كبرى الأكاديميات والمدارس الدولية',
                        'شهادة مدرب معتمد تؤهلك لتقديم الكورسات التدريبية باحتراف',
                    ],
                    'en' => [
                        'Latest interactive teaching strategies and smart classroom management',
                        'Public speaking and engaging lesson design',
                        'Live teaching practice qualifying for international schools contracts',
                        'Accredited trainer certificate',
                    ],
                    'it' => [
                        'Metodologie didattiche moderne e gestione della classe',
                    ],
                ],
                'icon' => 'presentation',
                'sort_order' => 6,
            ],
            [
                'slug_ar' => 'التدقيق-اللغوي-الاحترافي',
                'slug_en' => 'professional-proofreading',
                'slug_it' => 'correzione-di-bozze-professionale',
                'title' => [
                    'ar' => 'التدقيق اللغوي الاحترافي',
                    'en' => 'Professional Proofreading',
                    'it' => 'Correzione di Bozze Professionale',
                ],
                'summary' => [
                    'ar' => 'مراجعة لغوية دقيقة للنصوص مع تصحيح الأخطاء النحوية والإملائية وتحسين الصياغة لتظهر بشكل احترافي وواضح.',
                    'en' => 'Meticulous linguistic review correcting grammatical and spelling mistakes while enhancing style for clear, professional output.',
                    'it' => 'Revisione linguistica accurata, correzione di errori grammaticali e ottimizzazione stilistica.',
                ],
                'description' => [
                    'ar' => 'مراجعة لغوية دقيقة للنصوص مع تصحيح الأخطاء النحوية والإملائية وتحسين الصياغة لتظهر بشكل احترافي وواضح. تشمل التدقيق الإملائي والنحوي والأسلوبي للأبحاث العلمية والكتب والمقالات.',
                    'en' => 'Comprehensive proofreading for academic papers, thesis, motivation letters, CVs, and advertising content across languages.',
                    'it' => 'Revisione approfondita di tesi, lettere motivazionali, curriculum e testi accademici.',
                ],
                'badge' => ['ar' => 'سلامة لغوية 100%', 'en' => '100% Linguistic Accuracy', 'it' => 'Precisione al 100%'],
                'category_label' => ['ar' => 'الترجمة والتدقيق', 'en' => 'Proofreading & Editing', 'it' => 'Revisione & Editing'],
                'level' => ['ar' => 'مراجعة أكاديمية وأسلوبية دقيقة', 'en' => 'Academic and stylistic rigorous review', 'it' => 'Revisione stilistica e accademica'],
                'duration' => ['ar' => 'مرن وسريع مع الحفاظ على الدقة', 'en' => 'Fast turnaround with zero compromise', 'it' => 'Rapido e accurato'],
                'mode' => ['ar' => 'سرية تامة ومطابقة للمعايير', 'en' => 'Complete confidentiality & standards compliance', 'it' => 'Massima riservatezza'],
                'target_audience' => ['ar' => 'الباحثون، الأكاديميون، والمؤلفون والشركات', 'en' => 'Researchers, academics, authors, and enterprises', 'it' => 'Ricercatori e aziende'],
                'salary_range' => ['ar' => 'اعتماد للأبحاث والرسائل العلمية للنشر الدولي', 'en' => 'Approved for international publication', 'it' => 'Pronto per pubblicazioni internazionali'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود إرسال مستند لخدمة التدقيق اللغوي الاحترافي', 'en' => 'Hello, I need professional proofreading service', 'it' => 'Vorrei un preventivo per correzione di bozze'],
                'features' => [
                    'ar' => [
                        'فحص دقيق لكافة الأخطاء النحوية والإملائية والأسلوبية وضبط علامات الترقيم',
                        'تحسين الصياغة البلاغية مع الحفاظ على روح النص والمعنى الأصلي للكاتب',
                        'مراجعة شاملة لرسائل الماجستير والدكتوراة، السير الذاتية، والمحتوى التسويقي',
                        'تقرير تدقيق تفصيلي بالتعديلات والتحسينات المقترحة',
                    ],
                    'en' => [
                        'Thorough check for grammatical, spelling, stylistic and punctuation errors',
                        'Stylistic enhancement preserving original voice and message',
                        'Review of master/PhD theses, CVs, and marketing materials',
                    ],
                    'it' => [
                        'Correzione grammaticale e ortografica rigorosa',
                    ],
                ],
                'icon' => 'edit',
                'sort_order' => 7,
            ],
            [
                'slug_ar' => 'دورات-اللغات-الاحترافية',
                'slug_en' => 'professional-language-courses',
                'slug_it' => 'corsi-di-lingua-professionali',
                'title' => [
                    'ar' => 'دورات اللغات الاحترافية',
                    'en' => 'Professional Language Courses',
                    'it' => 'Corsi di Lingua Professionali',
                ],
                'summary' => [
                    'ar' => 'تعلم اللغات الأجنبية بطريقة حديثة وسهلة، من الصفر للاحتراف مع متابعة مستمرة لتحقيق الطلاقة بسرعة.',
                    'en' => 'Learn foreign languages with modern, easy methods from beginner to professional level with continuous follow-up for quick fluency.',
                    'it' => 'Impara lingue straniere con metodi moderni e pratici, da zero a livello avanzato con rapida fluidità.',
                ],
                'description' => [
                    'ar' => 'تعلم اللغات الأجنبية بطريقة حديثة وسهلة، من الصفر للاحتراف مع متابعة مستمرة لتحقيق الطلاقة بسرعة. دورات عملية في الإيطالية والإنجليزية والألمانية تمنحك الثقة الكاملة في التحدث والتواصل.',
                    'en' => 'Specialized courses in Italian, English, and German focused on conversational fluency, tailored for study abroad and careers.',
                    'it' => 'Corsi di italiano, inglese e tedesco incentrati sulla conversazione e preparazione per studio e lavoro all estero.',
                ],
                'badge' => ['ar' => 'من الصفر حتى الطلاقة', 'en' => 'Zero to Fluency', 'it' => 'Da Zero alla Fluidità'],
                'category_label' => ['ar' => 'اللغات والاختبارات', 'en' => 'Languages & Exams', 'it' => 'Corsi di Lingue'],
                'level' => ['ar' => 'إيطالي - إنجليزي - ألماني (مستويات A1 حتى C2)', 'en' => 'Italian - English - German (A1 to C2)', 'it' => 'Italiano - Inglese - Tedesco (A1 - C2)'],
                'duration' => ['ar' => 'مستويات تدريجية تفاعلية', 'en' => 'Progressive interactive levels', 'it' => 'Livelli progressivi interattivi'],
                'mode' => ['ar' => 'تركيز 80% على المحادثة والاستماع', 'en' => '80% focus on speaking & listening', 'it' => '80% conversazione e ascolto'],
                'target_audience' => ['ar' => 'المبتدئون وراغبو السفر والعمل بالخارج', 'en' => 'Beginners and travel/career seekers', 'it' => 'Principianti e candidati al lavoro estero'],
                'salary_range' => ['ar' => 'طلاقة محادثة وثقة تامة في التحدث مع الأجانب', 'en' => 'Full conversational confidence and fluency', 'it' => 'Fluidità e sicurezza nel parlare'],
                'whatsapp_message' => ['ar' => 'مرحباً، أود الاستفسار والتسجيل في دورات اللغات الاحترافية (إيطالي/إنجليزي/ألماني)', 'en' => 'Hello, I want to inquire about language courses', 'it' => 'Vorrei informazioni sui corsi di lingua'],
                'features' => [
                    'ar' => [
                        'منهجية حديثة تركز على الطلاقة والمحادثة الحية وكسر حاجز الخوف من النطق',
                        'محادثات واقعية مع مدربين متخصصين تحاكي الحياة اليومية والعملية في أوروبا',
                        'متابعة دورية وتقييم مستمر لتحقيق المستوى المطلوب للقبول الجامعي وسوق العمل',
                        'تطبيق عملي من خلال مواقف وسيناريوهات تفاعلية يومية',
                    ],
                    'en' => [
                        'Modern methodology focused on spoken fluency and breaking pronunciation barriers',
                        'Real-life conversations simulating daily and professional European environments',
                        'Periodic assessments to guarantee level needed for admissions and jobs',
                    ],
                    'it' => [
                        'Metodologia comunicativa incentrata sulla conversazione',
                    ],
                ],
                'icon' => 'book-open',
                'sort_order' => 8,
            ],
        ];

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
