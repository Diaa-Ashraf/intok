@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-7 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">إدارة محتوى ونصوص الموقع بالكامل</h1>
            <p class="mt-1 text-sm text-slate-500">تحكم كامل وديناميكي في جميع نصوص وعناوين وفقرات وأزرار وإحصائيات كافة صفحات الموقع.</p>
        </div>
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.dashboard') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للخلف</span>
        </button>
    </div>

    @if (session('status'))
        <div role="status" class="mb-5 rounded-xl bg-green-50 p-4 text-green-800 border border-green-200 font-bold flex items-center gap-2">
            <svg class="size-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 p-4 text-red-800 border border-red-200">
            <p class="font-bold">يرجى مراجعة الحقول التالية:</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Navigation Tabs for Sections -->
    <div class="mb-6 flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3" id="settings-tab-nav">
        <button type="button" class="settings-tab-btn active-tab px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-general">الهوية والتواصل</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-hero">واجهة الهيرو</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-services">قسم الخدمات والتدريب</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-slider">سلايدر التدريب الحي</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-finder">فاحص المسار والمنحة</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-why">لماذا تختار إنتوك؟</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-pages">نصوص الصفحات الداخلية</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-roadmap">خارطة الطريق (4 خطوات)</button>
        <button type="button" class="settings-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition" data-target="tab-cta">بانر الحجز والـ CTA</button>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- TAB 1: GENERAL IDENTITY & CONTACT -->
        <div class="settings-panel" id="tab-general">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">الهوية والشعارات</h2>
                    <p class="text-xs text-slate-500">اسم الأكاديمية واللوجو والشعار التعريفي.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="text-sm font-medium">الشعار (Logo)
                        <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="admin-input mt-1">
                        @if(data_get($settings, 'logo_path'))
                            <img class="mt-3 h-14 max-w-56 object-contain border p-1 rounded" src="{{ asset('storage/'.data_get($settings, 'logo_path')) }}" alt="الشعار الحالي">
                        @endif
                    </label>
                    <label class="text-sm font-medium">أيقونة الموقع (Favicon)
                        <input type="file" name="favicon" accept="image/jpeg,image/png,image/webp" class="admin-input mt-1">
                        @if(data_get($settings, 'favicon_path'))
                            <img class="mt-3 size-10 object-contain border p-1 rounded" src="{{ asset('storage/'.data_get($settings, 'favicon_path')) }}" alt="أيقونة الموقع">
                        @endif
                    </label>
                </div>

                <div class="grid gap-5 md:grid-cols-3 pt-3">
                    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $locale => $label)
                        <div class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <h3 class="font-bold text-sm text-slate-800">{{ $label }}</h3>
                            <label class="block text-xs font-bold text-slate-700">اسم الموقع
                                <input name="site_name[{{ $locale }}]" value="{{ old('site_name.'.$locale, data_get($settings, 'site_name.'.$locale, 'INTOK Academy')) }}" required maxlength="120" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">الشعار التعريفي (Tagline)
                                <textarea name="tagline[{{ $locale }}]" required maxlength="250" rows="3" class="admin-input mt-1">{{ old('tagline.'.$locale, data_get($settings, 'tagline.'.$locale, '')) }}</textarea>
                            </label>
                            <label class="block text-xs font-bold text-slate-700">عنوان SEO الافتراضي
                                <input name="default_seo_title[{{ $locale }}]" value="{{ old('default_seo_title.'.$locale, data_get($settings, 'default_seo_title.'.$locale, '')) }}" maxlength="100" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">وصف SEO الافتراضي
                                <textarea name="default_seo_description[{{ $locale }}]" maxlength="250" rows="3" class="admin-input mt-1">{{ old('default_seo_description.'.$locale, data_get($settings, 'default_seo_description.'.$locale, '')) }}</textarea>
                            </label>
                            <label class="block text-xs font-bold text-slate-700">حقوق النشر في التذييل (Footer Copyright)
                                <input name="footer_copyright[{{ $locale }}]" value="{{ old('footer_copyright.'.$locale, data_get($settings, 'footer_copyright.'.$locale, 'INTOK ACADEMY. All Rights Reserved.')) }}" maxlength="250" class="admin-input mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-base font-bold text-slate-900 mb-3">بيانات التواصل والروابط الاجتماعية</h3>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="text-xs font-bold text-slate-700">رقم الهاتف
                            <input name="contact_phone" value="{{ old('contact_phone', data_get($settings, 'contact_phone', '+201008238323')) }}" required maxlength="30" class="admin-input mt-1">
                        </label>
                        <label class="text-xs font-bold text-slate-700">رقم الواتساب (بصيغة دولية بدون +)
                            <input name="whatsapp_number" value="{{ old('whatsapp_number', data_get($settings, 'whatsapp_number', '201008238323')) }}" required class="admin-input mt-1">
                        </label>
                        <label class="text-xs font-bold text-slate-700">البريد الإلكتروني
                            <input name="contact_email" type="email" value="{{ old('contact_email', data_get($settings, 'contact_email', 'info@intokacademy.com')) }}" class="admin-input mt-1">
                        </label>
                        <label class="text-xs font-bold text-slate-700 sm:col-span-2">رابط تضمين خريطة Google (iframe src)
                            <input type="url" name="map_embed" value="{{ old('map_embed', data_get($settings, 'map_embed', '')) }}" maxlength="2000" class="admin-input mt-1">
                        </label>
                        @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'tiktok' => 'TikTok', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube'] as $key => $label)
                            <label class="text-xs font-bold text-slate-700">{{ $label }}
                                <input type="url" name="social_links[{{ $key }}]" value="{{ old('social_links.'.$key, data_get($settings, 'social_links.'.$key, '')) }}" class="admin-input mt-1">
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB 2: HERO SECTION -->
        <div class="settings-panel hidden" id="tab-hero">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">الواجهة الرئيسية (Hero Section)</h2>
                    <p class="text-xs text-slate-500">نصوص الشارة العلوية، العنوان الرئيسي، الوصف، وأزرار اتخاذ القرار.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $locale => $label)
                        <div class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <h3 class="font-bold text-sm text-slate-800">{{ $label }}</h3>
                            <label class="block text-xs font-bold text-slate-700">الشارة العلوية (Badge)
                                <input name="hero_badge[{{ $locale }}]" value="{{ old('hero_badge.'.$locale, data_get($settings, 'hero_badge.'.$locale, '')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">العنوان الرئيسي للهيرو
                                <input name="hero_title[{{ $locale }}]" value="{{ old('hero_title.'.$locale, data_get($settings, 'hero_title.'.$locale, '')) }}" required class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">نص وفقرة الهيرو
                                <textarea name="hero_text[{{ $locale }}]" required rows="4" class="admin-input mt-1">{{ old('hero_text.'.$locale, data_get($settings, 'hero_text.'.$locale, '')) }}</textarea>
                            </label>
                            <label class="block text-xs font-bold text-slate-700">نص زر الهيرو الأساسي
                                <input name="hero_cta[{{ $locale }}]" value="{{ old('hero_cta.'.$locale, data_get($settings, 'hero_cta.'.$locale, '')) }}" required class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">نص زر الهيرو الثانوي
                                <input name="hero_secondary_cta[{{ $locale }}]" value="{{ old('hero_secondary_cta.'.$locale, data_get($settings, 'hero_secondary_cta.'.$locale, '')) }}" class="admin-input mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-base font-bold text-slate-900 mb-3">أرقام وإحصائيات الهيرو (Stats)</h3>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                            <label class="block text-xs font-bold text-slate-700">الرقم / النسبة (Stat 1)
                                <input name="hero_stat_1_val" value="{{ old('hero_stat_1_val', data_get($settings, 'hero_stat_1_val', '100%')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">الوصف بالعربية
                                <input name="hero_stat_1_lbl[ar]" value="{{ old('hero_stat_1_lbl.ar', data_get($settings, 'hero_stat_1_lbl.ar', 'نسبة نجاح استخراج التأشيرات والقبول')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                            <label class="block text-xs font-bold text-slate-700">الرقم / النسبة (Stat 2)
                                <input name="hero_stat_2_val" value="{{ old('hero_stat_2_val', data_get($settings, 'hero_stat_2_val', '+1,200')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">الوصف بالعربية
                                <input name="hero_stat_2_lbl[ar]" value="{{ old('hero_stat_2_lbl.ar', data_get($settings, 'hero_stat_2_lbl.ar', 'طالب ومتدرب تم تأهيلهم بنجاح')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                            <label class="block text-xs font-bold text-slate-700">الرقم / النسبة (Stat 3)
                                <input name="hero_stat_3_val" value="{{ old('hero_stat_3_val', data_get($settings, 'hero_stat_3_val', '8,000€')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">الوصف بالعربية
                                <input name="hero_stat_3_lbl[ar]" value="{{ old('hero_stat_3_lbl.ar', data_get($settings, 'hero_stat_3_lbl.ar', 'بدل سنوي وسكن مجاني بمنحة DSU')) }}" class="admin-input mt-1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-base font-bold text-slate-900 mb-3">عبارات تميمة الروبوت التفاعلية (Mascot Speech Bubbles)</h3>
                    <p class="text-xs text-slate-500 mb-3">العبارات التحفيزية التي تظهر في بالونة الحديث بجانب الروبوت.</p>
                    <div class="space-y-2">
                        @php
                            $currentQuotes = data_get($settings, 'robot_quotes', [
                                "\"مين قال إن الدبلوم آخر الطريق؟ شهادتك بداية لفرصة جديدة في إيطاليا!\"",
                                "\"مجموعك القليل مش كارثة... لأن مستقبلك مش بيقف على رقم!\"",
                                "\"منحة DSU تغطي مصروفاتك وسكن مجاني وبدل سنوي 8,000 يورو!\"",
                                "\"تدريب الكول سنتر واللغات في INTOK يفتح لك أبواب كبرى الشركات الدولية!\"",
                                "\"ترجمة معتمدة رسمياً وموثقة للسفارة الإيطالية بدون أي تعقيدات!\""
                            ]);
                        @endphp
                        @for ($i = 0; $i < 5; $i++)
                            <input name="robot_quotes[{{ $i }}]" value="{{ old('robot_quotes.'.$i, $currentQuotes[$i] ?? '') }}" class="admin-input" placeholder="عبارة الروبوت {{ $i + 1 }}">
                        @endfor
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <div class="border-b border-slate-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-slate-900">برواز المشاهد التفاعلية للهيرو (Hero Cinematic 3D Frame)</h3>
                        <p class="text-xs text-slate-500">تحكم بصور وعناوين وتبويبات الإطار التفاعلي ثلاثي الأبعاد في الواجهة الرئيسية (4 مشاهد).</p>
                    </div>

                    @php
                        $defaultHeroScenes = [
                            1 => [
                                'tab' => 'ميلانو',
                                'badge' => 'عاصمة الدراسة والصناعة • ميلانو',
                                'title' => 'جامعات ومدارس ميلانو الحكومية',
                                'desc' => 'استكمال دراستك في أعرق الصروح التعليمية مع منحة DSU الشاملة (8,000 يورو + سكن مجاني) وتأشيرة دراسية رسمية.',
                                'stat' => '8,000€ بدل سنوي + سكن مجاني',
                                'default_img' => 'assets/images/schools/san-giorgio.jpg',
                            ],
                            2 => [
                                'tab' => 'روما',
                                'badge' => 'التاريخ والأكاديمية • روما',
                                'title' => 'دراسة البكالوريوس والماجستير بروما',
                                'desc' => 'الالتحاق بأعرق الجامعات والمدارس الإيطالية مع تصريح عمل قانوني باليورو وتأشيرة شنغن رسمية.',
                                'stat' => '99.4% نسبة نجاح وقبول الملفات',
                                'default_img' => 'assets/images/schools/galileo-galilei.jpg',
                            ],
                            3 => [
                                'tab' => 'قاعات إنتوك',
                                'badge' => 'قاعات إنتوك الذكية • تدريب حي',
                                'title' => 'تعليم الإيطالية واللغات المعتمدة',
                                'desc' => 'محاضرات تفاعلية على السبورات الذكية لتأسيس النطق وتأهيلك لاجتياز اختبارات CILS و CELI ومقابلات السفارة.',
                                'stat' => 'CILS / CELI معتمد رسمياً',
                                'default_img' => 'assets/images/academy/italian-classroom-lecture.jpg',
                            ],
                            4 => [
                                'tab' => 'الكول سنتر',
                                'badge' => 'كول سنتر وسوق العمل الدولي',
                                'title' => 'محاكاة المقابلات والطلاقة باللغات',
                                'desc' => 'تدريب تطبيقي مكثف يجعلك واثقاً من مهاراتك الصوتية والتواصلية لاقتناص وظائف كبرى الشركات العالمية فوراً.',
                                'stat' => 'رواتب 15k - 30k+ ج.م',
                                'default_img' => 'assets/images/academy/live-speaker-training.jpg',
                            ],
                        ];
                    @endphp

                    <div class="space-y-6">
                        @foreach($defaultHeroScenes as $idx => $scene)
                            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4 space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                                    <span class="font-bold text-sm text-slate-800">المشهد {{ $idx }}: {{ $scene['tab'] }}</span>
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-semibold">Scene {{ $idx }}</span>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-12 items-start">
                                    <div class="sm:col-span-4">
                                        <label class="block text-xs font-bold text-slate-700">صورة المشهد {{ $idx }}
                                            <input type="file" name="hero_scene_{{ $idx }}_img" accept="image/jpeg,image/png,image/webp" class="admin-input mt-1">
                                        </label>
                                        <div class="mt-2">
                                            @if(data_get($settings, 'hero_scene_'.$idx.'_img'))
                                                <div class="relative">
                                                    <img src="{{ asset('storage/'.data_get($settings, 'hero_scene_'.$idx.'_img')) }}" class="h-28 w-full object-cover rounded-lg border border-slate-200 shadow-xs" alt="صورة المشهد {{ $idx }}">
                                                    <span class="absolute bottom-1 start-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded">الصورة الحالية المرفوعة</span>
                                                </div>
                                            @else
                                                <div class="relative">
                                                    <img src="{{ asset($scene['default_img']) }}" class="h-28 w-full object-cover rounded-lg border border-slate-200 opacity-80" alt="صورة المشهد الافتراضية">
                                                    <span class="absolute bottom-1 start-1 bg-slate-800/70 text-white text-[10px] px-1.5 py-0.5 rounded">الصورة الافتراضية</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="sm:col-span-8 grid gap-3 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700">اسم التبويب (Tab Name)
                                                <input name="hero_scene_{{ $idx }}_tab[ar]" value="{{ old('hero_scene_'.$idx.'_tab.ar', data_get($settings, 'hero_scene_'.$idx.'_tab.ar', $scene['tab'])) }}" class="admin-input mt-1">
                                            </label>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700">الشارة العلوية (Badge)
                                                <input name="hero_scene_{{ $idx }}_badge[ar]" value="{{ old('hero_scene_'.$idx.'_badge.ar', data_get($settings, 'hero_scene_'.$idx.'_badge.ar', $scene['badge'])) }}" class="admin-input mt-1">
                                            </label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700">عنوان المشهد الرئيسي
                                                <input name="hero_scene_{{ $idx }}_title[ar]" value="{{ old('hero_scene_'.$idx.'_title.ar', data_get($settings, 'hero_scene_'.$idx.'_title.ar', $scene['title'])) }}" class="admin-input mt-1">
                                            </label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700">نص الإحصائية / الزر الأسفل
                                                <input name="hero_scene_{{ $idx }}_stat[ar]" value="{{ old('hero_scene_'.$idx.'_stat.ar', data_get($settings, 'hero_scene_'.$idx.'_stat.ar', $scene['stat'])) }}" class="admin-input mt-1">
                                            </label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700">وصف المشهد
                                                <textarea name="hero_scene_{{ $idx }}_desc[ar]" rows="2" class="admin-input mt-1">{{ old('hero_scene_'.$idx.'_desc.ar', data_get($settings, 'hero_scene_'.$idx.'_desc.ar', $scene['desc'])) }}</textarea>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-base font-bold text-slate-900 mb-1">البادجات العائمة ثلاثية الأبعاد (Floating 3D Badges)</h3>
                    <p class="text-xs text-slate-500 mb-4">البادجات التي تطفو حول البرواز التفاعلي في الهيرو.</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4 space-y-3">
                            <span class="font-bold text-xs text-slate-800 block border-b pb-1">البادج العلوي الأيمن (منحة DSU)</span>
                            <label class="block text-xs font-bold text-slate-700">الوسم (Tag)
                                <input name="hero_float_1_tag" value="{{ old('hero_float_1_tag', data_get($settings, 'hero_float_1_tag', 'DSU')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">العنوان
                                <input name="hero_float_1_title[ar]" value="{{ old('hero_float_1_title.ar', data_get($settings, 'hero_float_1_title.ar', 'منحة DSU الحكومية')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">النص التوضيحي
                                <input name="hero_float_1_sub[ar]" value="{{ old('hero_float_1_sub.ar', data_get($settings, 'hero_float_1_sub.ar', '8,000€ + سكن معفى 100%')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4 space-y-3">
                            <span class="font-bold text-xs text-slate-800 block border-b pb-1">البادج السفلي الأيسر (تأشيرة رسمية)</span>
                            <label class="block text-xs font-bold text-slate-700">الوسم (Tag)
                                <input name="hero_float_2_tag" value="{{ old('hero_float_2_tag', data_get($settings, 'hero_float_2_tag', 'VISA')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">العنوان
                                <input name="hero_float_2_title[ar]" value="{{ old('hero_float_2_title.ar', data_get($settings, 'hero_float_2_title.ar', 'تأشيرة رسمية معتمدة')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">النص التوضيحي
                                <input name="hero_float_2_sub[ar]" value="{{ old('hero_float_2_sub.ar', data_get($settings, 'hero_float_2_sub.ar', 'نسبة نجاح الملفات 99.4%')) }}" class="admin-input mt-1">
                            </label>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB 3: SERVICES SECTION -->
        <div class="settings-panel hidden" id="tab-services">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">قسم خدمات وتدريب INTOK ACADEMY</h2>
                    <p class="text-xs text-slate-500">نصوص رأس القسم (الخدمات الفردية يتم تعديلها من تبويب "الخدمات").</p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $locale => $label)
                        <div class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <h3 class="font-bold text-sm text-slate-800">{{ $label }}</h3>
                            <label class="block text-xs font-bold text-slate-700">شارة القسم (Badge)
                                <input name="services_badge[{{ $locale }}]" value="{{ old('services_badge.'.$locale, data_get($settings, 'services_badge.'.$locale, 'برامج وتدريب معتمد دولياً')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">عنوان القسم الرئيسي
                                <input name="services_title[{{ $locale }}]" value="{{ old('services_title.'.$locale, data_get($settings, 'services_title.'.$locale, 'خدمات وتدريب INTOK ACADEMY')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">وصف القسم
                                <textarea name="services_subtitle[{{ $locale }}]" rows="3" class="admin-input mt-1">{{ old('services_subtitle.'.$locale, data_get($settings, 'services_subtitle.'.$locale, '')) }}</textarea>
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- TAB 4: LIVE SLIDER SECTION -->
        <div class="settings-panel hidden" id="tab-slider">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">سلايدر نبض التدريب والمحاضرات الحية</h2>
                    <p class="text-xs text-slate-500">عناوين وتفاصيل سلايدر قاعات وتدريبات الأكاديمية التفاعلي.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $locale => $label)
                        <div class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <h3 class="font-bold text-sm text-slate-800">{{ $label }}</h3>
                            <label class="block text-xs font-bold text-slate-700">شارة السلايدر
                                <input name="live_slider_badge[{{ $locale }}]" value="{{ old('live_slider_badge.'.$locale, data_get($settings, 'live_slider_badge.'.$locale, 'نبض التدريب والمحاضرات الحية في الأكاديمية')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">عنوان السلايدر
                                <input name="live_slider_title[{{ $locale }}]" value="{{ old('live_slider_title.'.$locale, data_get($settings, 'live_slider_title.'.$locale, 'شاهد قاعاتنا وتدريباتنا التفاعلية')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">وصف السلايدر
                                <textarea name="live_slider_subtitle[{{ $locale }}]" rows="3" class="admin-input mt-1">{{ old('live_slider_subtitle.'.$locale, data_get($settings, 'live_slider_subtitle.'.$locale, '')) }}</textarea>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <div class="border-b border-slate-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-slate-900">شرائح تدريب وقاعات الأكاديمية (Live Training Slides)</h3>
                        <p class="text-xs text-slate-500">تحكم بصور وعناوين وشارات وتفاصيل شرائح السلايدر التفاعلي ذو تأثير التفتيت والتلاشي السينمائي.</p>
                    </div>

                    @php
                        $defaultLiveSlides = [
                            1 => [
                                'badge' => 'تدريب الكول سنتر والمحادثة المباشرة',
                                'title' => 'How to Be a Confident Speaker - محاكاة المقابلات والطلاقة',
                                'desc' => 'تدريب تفاعلي على الشاشات الذكية لتطوير مهارات التواصل وخدمة العملاء واجتياز المقابلات الدولية بثقة.',
                                'default_img' => 'assets/images/academy/live-speaker-training.jpg',
                            ],
                            2 => [
                                'badge' => 'محاضرات اللغة الإيطالية والقبول الجامعي',
                                'title' => 'شرح تفاعلي لقواعد ومحادثة اللغة الإيطالية (Grammatica Italiana)',
                                'desc' => 'تأسيس المتدربين من الصفر وحتى الطلاقة والتأهيل لاختبارات السفارة والالتحاق بالجامعات الإيطالية مع نخبة من الأساتذة.',
                                'default_img' => 'assets/images/academy/italian-classroom-lecture.jpg',
                            ],
                            3 => [
                                'badge' => 'بوابتك نحو إيطاليا وأوروبا',
                                'title' => 'من قاعات INTOK إلى أعرق الصروح التعليمية في روما وميلانو',
                                'desc' => 'رحلة متكاملة تؤهلك للحصول على منحة DSU الشاملة (8,000 يورو سنوياً + سكن مجاني) والإقامة القانونية والعمل باليورو.',
                                'default_img' => 'assets/images/schools/galileo-galilei.jpg',
                            ],
                            4 => [
                                'badge' => 'معايير التميز الأكاديمي',
                                'title' => 'الاعتماد الدولي والمنح الدراسية الموثقة',
                                'desc' => 'تأهيل متكامل للطلبة لمرحلة البكالوريوس والماجستير وتصديق الشهادات لدى القنصلية الإيطالية.',
                                'default_img' => 'assets/images/schools/bologna-university.jpg',
                            ],
                        ];
                    @endphp

                    <div class="space-y-6">
                        @foreach($defaultLiveSlides as $idx => $slide)
                            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4 space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                                    <span class="font-bold text-sm text-slate-800">الشريحة {{ $idx }} (Slide {{ $idx }})</span>
                                    <span class="text-xs bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full font-semibold">تأثير تفتيت تفاعلي</span>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-12 items-start">
                                    <div class="sm:col-span-4">
                                        <label class="block text-xs font-bold text-slate-700">صورة الشريحة {{ $idx }}
                                            <input type="file" name="live_slide_{{ $idx }}_img" accept="image/jpeg,image/png,image/webp" class="admin-input mt-1">
                                        </label>
                                        <div class="mt-2">
                                            @if(data_get($settings, 'live_slide_'.$idx.'_img'))
                                                <div class="relative">
                                                    <img src="{{ asset('storage/'.data_get($settings, 'live_slide_'.$idx.'_img')) }}" class="h-28 w-full object-cover rounded-lg border border-slate-200 shadow-xs" alt="صورة الشريحة {{ $idx }}">
                                                    <span class="absolute bottom-1 start-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded">الصورة الحالية المرفوعة</span>
                                                </div>
                                            @else
                                                <div class="relative">
                                                    <img src="{{ asset($slide['default_img']) }}" class="h-28 w-full object-cover rounded-lg border border-slate-200 opacity-80" alt="الصورة الافتراضية">
                                                    <span class="absolute bottom-1 start-1 bg-slate-800/70 text-white text-[10px] px-1.5 py-0.5 rounded">الصورة الافتراضية</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="sm:col-span-8 grid gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700">شارة الشريحة (Badge)
                                                <input name="live_slide_{{ $idx }}_badge[ar]" value="{{ old('live_slide_'.$idx.'_badge.ar', data_get($settings, 'live_slide_'.$idx.'_badge.ar', $slide['badge'])) }}" class="admin-input mt-1">
                                            </label>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700">عنوان الشريحة الرئيسي
                                                <input name="live_slide_{{ $idx }}_title[ar]" value="{{ old('live_slide_'.$idx.'_title.ar', data_get($settings, 'live_slide_'.$idx.'_title.ar', $slide['title'])) }}" class="admin-input mt-1">
                                            </label>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700">تفاصيل ووصف الشريحة
                                                <textarea name="live_slide_{{ $idx }}_desc[ar]" rows="2" class="admin-input mt-1">{{ old('live_slide_'.$idx.'_desc.ar', data_get($settings, 'live_slide_'.$idx.'_desc.ar', $slide['desc'])) }}</textarea>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB 5: FINDER CONSOLE -->
        <div class="settings-panel hidden" id="tab-finder">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">كونسول فاحص المسار والمنحة الذكي</h2>
                    <p class="text-xs text-slate-500">تسميات الخطوات الثلاث وزر الفحص.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $locale => $label)
                        <div class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <h3 class="font-bold text-sm text-slate-800">{{ $label }}</h3>
                            <label class="block text-xs font-bold text-slate-700">تسمية الخيار 1 (المسار الحالي)
                                <input name="finder_step1_label[{{ $locale }}]" value="{{ old('finder_step1_label.'.$locale, data_get($settings, 'finder_step1_label.'.$locale, '1. مسارك التعليمي الحالي')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">تسمية الخيار 2 (الهدف)
                                <input name="finder_step2_label[{{ $locale }}]" value="{{ old('finder_step2_label.'.$locale, data_get($settings, 'finder_step2_label.'.$locale, '2. هدفك المنشود')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">تسمية الخيار 3 (موسم الالتحاق)
                                <input name="finder_step3_label[{{ $locale }}]" value="{{ old('finder_step3_label.'.$locale, data_get($settings, 'finder_step3_label.'.$locale, '3. موسم الالتحاق')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">نص زر الفحص
                                <input name="finder_btn_text[{{ $locale }}]" value="{{ old('finder_btn_text.'.$locale, data_get($settings, 'finder_btn_text.'.$locale, 'فحص شروط القبول والمنحة')) }}" class="admin-input mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- TAB 6: WHY CHOOSE US (BENTO) -->
        <div class="settings-panel hidden" id="tab-why">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">قسم لماذا تختار أكاديمية إنتوك؟ (Bento Grid)</h2>
                        <p class="text-xs text-slate-500">تحكم كامل وديناميكي في كل كلمة، إحصائية، ميزة، مقارنة، وزر داخل كروت المنظومة الستة.</p>
                    </div>
                    <span class="rounded-full bg-red-50 border border-red-200 px-3 py-1 text-xs font-bold text-red-700">6 كروت تفاعلية</span>
                </div>

                <!-- Section Header -->
                <div class="grid gap-4 sm:grid-cols-3">
                    <label class="block text-xs font-bold text-slate-700">شارة القسم (Badge)
                        <input name="why_badge[ar]" value="{{ old('why_badge.ar', data_get($settings, 'why_badge.ar', 'معايير الثقة والريادة الدولية')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700">عنوان القسم الرئيسي
                        <input name="why_title[ar]" value="{{ old('why_title.ar', data_get($settings, 'why_title.ar', 'لماذا تختار أكاديمية إنتوك؟')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700">عنوان المقارنة في الكارت
                        <input name="why_comparison_title[ar]" value="{{ old('why_comparison_title.ar', data_get($settings, 'why_comparison_title.ar', 'لماذا إنتوك أفضل؟')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700 sm:col-span-3">وصف القسم
                        <textarea name="why_subtitle[ar]" rows="2" class="admin-input mt-1">{{ old('why_subtitle.ar', data_get($settings, 'why_subtitle.ar', 'منظومة متكاملة لا تكتفي بتقديم الكورسات أو الترجمة، بل تصنع معك مستقبلاً حقيقياً بالدراسة في إيطاليا والعمل في كبرى الشركات العالمية بأعلى عائد.')) }}</textarea>
                    </label>
                </div>

                <div class="border-t border-slate-100 pt-6 space-y-8">
                    @php
                        $bentoCardsConfig = [
                            [
                                'id' => 'dsu',
                                'num' => '1',
                                'name' => 'منحة DSU الشاملة والسكن المجاني',
                                'color' => 'text-red-700 border-red-200 bg-red-50/50',
                                'defaults' => [
                                    'nav_title' => 'منحة DSU والسكن',
                                    'nav_sub' => '8,000€ + سكن مجاني',
                                    'badge' => 'منحة إقليمية حكومية',
                                    'title' => 'أعلى نسبة قبول لمنح DSU الحكومية الإيطالية',
                                    'desc' => 'نضمن لك حساب مؤشر ISEE بدقة هندسية وقانونية لضمان استيفاء شروط المنحة الإقليمية وسكن جامعي معفى تماماً، مع فتح الباب لحملة الدبلومات الفنية (صنايع / تجارة / زراعة) والثانوية العامة والجامعيين.',
                                    'stat_val' => '8,000€',
                                    'stat_unit' => 'سنوياً',
                                    'stat_label' => 'بدل نقدي مباشر لحساب الطالب',
                                    'stat_sub' => 'إعفاء 100% من المصروفات + سكن مجاني',
                                    'points' => "حساب دقيق لمؤشر ISEE Parificato وفق المعايير الرسمية للمنحة الإقليمية\nإعفاء كامل 100% من الرسوم والمصروفات الدراسية الجامعية في إيطاليا\nتأمين سكن جامعي مجاني ومجهز طوال فترة سنوات دراستك\nوجبات غذائية مدعومة بمطاعم الجامعات الإيطالية يومياً\nحق العمل القانوني للطلاب 20 ساعة أسبوعياً باليورو",
                                    'vs_traditional' => 'إهمال المنحة وتوريط الطالب بمصروفات دراسية باهظة بدون سكن أو دعم نقدي',
                                    'vs_intok' => 'ملف منحة متكامل بدقة 100% يضمن لك أعلى فرصة للحصول على الـ 8,000 يورو والسكن',
                                    'cta_text' => 'افحص فرصة حصولك على منحة DSU',
                                ]
                            ],
                            [
                                'id' => 'callcenter',
                                'num' => '2',
                                'name' => 'تأهيل الكول سنتر والتوظيف الدولي',
                                'color' => 'text-emerald-700 border-emerald-200 bg-emerald-50/50',
                                'defaults' => [
                                    'nav_title' => 'الكول سنتر والتوظيف',
                                    'nav_sub' => 'رواتب 15k - 30k+ ج.م',
                                    'badge' => 'تأهيل وظيفي فوري',
                                    'title' => 'تأهيل وظيفي فوري لكبرى شركات الكول سنتر',
                                    'desc' => 'تدريب تطبيقي على الشاشات الذكية ومحاكاة لمقابلات شركات متعددة الجنسيات (Vodafone UK, Concentrix, Teleperformance) يؤهلك للعمل المباشر.',
                                    'stat_val' => '15k - 30k+',
                                    'stat_unit' => 'ج.م / شهرياً',
                                    'stat_label' => 'متوسط الراتب لحديثي التخرج والخريجين',
                                    'stat_sub' => 'فرص عمل فوري بكبرى الشركات الدولية',
                                    'points' => "تدريب عملي ومحاكاة لمكالمات وأنظمة خدمة العملاء والدعم الفني الحقيقية\nمحاكاة لأسئلة واختبارات الـ HR والـ Operations في الشركات متعددة الجنسيات\nإتقان اللهجة ونبرة الصوت المناسبة لمختلف أسواق العمل الدولية\nورش مكثفة لاجتياز المقابلات الشخصية بنجاح من المقابلة الأولى\nترشيح مباشر وتوصية للتوظيف لدى شبكة شركائنا بعد التخرج",
                                    'vs_traditional' => 'كورسات نظرية عامة بدون شاشات تفاعلية أو محاكاة حقيقية وبلا أي فرص توظيف',
                                    'vs_intok' => 'محاكاة واقعية 100% تؤهلك لاجتياز مقابلات الشركات العالمية فور التخرج',
                                    'cta_text' => 'سجل في تدريب الكول سنتر المباشر',
                                ]
                            ],
                            [
                                'id' => 'trans',
                                'num' => '3',
                                'name' => 'الترجمة المعتمدة قنصلياً ورسمياً',
                                'color' => 'text-amber-800 border-amber-200 bg-amber-50/50',
                                'defaults' => [
                                    'nav_title' => 'الترجمة المعتمدة',
                                    'nav_sub' => 'معتمدة قنصلياً 100%',
                                    'badge' => 'توثيق رسمي للسفارات',
                                    'title' => 'ترجمة معتمدة رسمياً وموثقة لجميع السفارات',
                                    'desc' => 'ترجمة رسمية معترف بها أمام القنصلية الإيطالية وكافة السفارات الأوروبية، لشهادات التخرج، إعلانات القيمة، وعقود العمل دون مخاطرة بالرفض.',
                                    'stat_val' => '24 - 48h',
                                    'stat_unit' => 'تسليم مستعجل',
                                    'stat_label' => 'سرعة إنجاز وتوثيق الملفات الرسمية',
                                    'stat_sub' => 'دقة قانونية متناهية بدون أخطاء ترفض ملفك',
                                    'points' => "ترجمة معتمدة ومقبولة لدى القنصلية الإيطالية بالقاهرة والإسكندرية\nترجمة إعلان القيمة (Dichiarazione di Valore) وبيانات الدرجات والمقررات\nإنهاء تصديقات الخارجية المصرية ونقابة المترجمين والغرفة التجارية\nتدقيق لغوي وقانوني مزدوج لضمان خلو الأوراق من أي ثغرات قنصلية\nتوصيل فوري لجميع محافظات مصر مع إمكانية المعاينة الرقمية",
                                    'vs_traditional' => 'ترجمات غير معتمدة أو مليئة بالأخطاء تؤدي لرفض التأشيرة وإضاعة المواعيد',
                                    'vs_intok' => 'اعتماد قنصلي رسمي 100% يضمن قبول أوراقك في السفارة من المرة الأولى',
                                    'cta_text' => 'اطلب ترجمتك المعتمدة فوراً',
                                ]
                            ],
                            [
                                'id' => 'reception',
                                'num' => '4',
                                'name' => 'الاستقبال والمرافقة في إيطاليا',
                                'color' => 'text-red-700 border-red-200 bg-red-50/50',
                                'defaults' => [
                                    'nav_title' => 'الاستقبال بإيطاليا',
                                    'nav_sub' => 'ميلانو وروما وتسكين مباشر',
                                    'badge' => 'مرافقة ميدانية بأوروبا',
                                    'title' => 'استقبال في المطار وتسليم السكن بإيطاليا',
                                    'desc' => 'رحلتك معنا لا تنتهي عند باب المطار؛ بل يستقبلك فريقنا الميداني في ميلانو وروما لتسليم السكن، واستخراج الإقامة والحساب البنكي.',
                                    'stat_val' => '100%',
                                    'stat_unit' => 'أمان ورعاية',
                                    'stat_label' => 'مرافقة ميدانية من لحظة الهبوط بالمطار',
                                    'stat_sub' => 'فريق ميداني رسمي يتحدث العربية والإيطالية',
                                    'points' => "استقبالك بالاسم في صالة الوصول بمطارات ميلانو (Malpensa) وروما (Fiumicino)\nتوصيلك مباشرة إلى مقر إقامتك وتسليمك مفاتيح السكن الجامعي أو الخاص\nمرافقة لتقديم أوراق تصريح الإقامة (Permesso di Soggiorno) بالبريد والشرطة\nاستخراج الرقم الضريبي الإيطالي (Codice Fiscale) وشراء شريحة اتصال إيطالية\nمساعدتك في فتح حساب بنكي إيطالي وتوجيهك لفرص العمل والأنشطة الطلابية",
                                    'vs_traditional' => 'ينتهي دور المكتب بمجرد السفر ويُترك الطالب وحيداً وتائهاً في المطار والغربة',
                                    'vs_intok' => 'فريقنا الميداني في إيطاليا يستقبلك ويلازمك حتى تستقر في سكنك وتنهي أوراقك',
                                    'cta_text' => 'احجز باقة الاستقبال والمرافقة بإيطاليا',
                                ]
                            ],
                            [
                                'id' => 'languages',
                                'num' => '5',
                                'name' => 'إتقان اللغات واختبارات CILS & IELTS',
                                'color' => 'text-purple-700 border-purple-200 bg-purple-50/50',
                                'defaults' => [
                                    'nav_title' => 'إتقان اللغات وCILS',
                                    'nav_sub' => 'من الصفر حتى الطلاقة التامة',
                                    'badge' => 'شهادات دولية معتمدة',
                                    'title' => 'إتقان اللغات من الصفر واجتياز CILS & IELTS',
                                    'desc' => 'دورات مكثفة في الإيطالية والإنجليزية والألمانية تركز 80% على المحادثة والطلاقة الواقعية، وتؤهلك لاجتياز امتحانات السفارات والجامعات.',
                                    'stat_val' => '80%',
                                    'stat_unit' => 'محادثة وتطبيق',
                                    'stat_label' => 'نسبة التركيز على التحدث والطلاقة العملية',
                                    'stat_sub' => 'كسر حاجز الخوف والحديث بطلاقة خلال أسابيع',
                                    'points' => "مناهج أوروبية معتمدة ومطابقة للإطار المرجعي الأوروبي للغات (CEFR)\nتدريب مكثف على نماذج اختبارات اللغة الإيطالية الرسمية (CILS, CELI, PLIDA)\nدورات متخصصة لاجتياز اختبارات الآيلتس (IELTS) والتوفل (TOEFL) الدولية\nمحاضرون خبراء معتمدون وناطقون أصليون يتابعون مستواك يومياً\nشهادات تخرج معتمدة توثق مستواك اللغوي وتؤهلك للجامعات وسوق العمل",
                                    'vs_traditional' => 'طرق تدريس قديمة تعتمد على الحفظ الصم دون إتاحة الفرصة لممارسة المحادثة',
                                    'vs_intok' => 'منهج تفاعلي يركز 80% على المحادثة المباشرة ويكسر حاجز الرهبة تماماً',
                                    'cta_text' => 'ابدأ كورس اللغة وتحديد المستوى',
                                ]
                            ],
                            [
                                'id' => 'mentorship',
                                'num' => '6',
                                'name' => 'الإرشاد الشخصي 1-on-1 والمتابعة المستمرة',
                                'color' => 'text-blue-700 border-blue-200 bg-blue-50/50',
                                'defaults' => [
                                    'nav_title' => 'الإرشاد والمتابعة 24/7',
                                    'nav_sub' => 'مستشار أكاديمي شخصي مخصص',
                                    'badge' => 'متابعة مستمرة ودقيقة',
                                    'title' => 'إرشاد شخصي 1-on-1 ومتابعة مستمرة',
                                    'desc' => 'مستشار أكاديمي مخصص يدرس ملفك ويضع خطتك المناسبة، مع نظام تنبيهات لمواعيد المنح والتقديمات لضمان عدم فوات أي موعد رسمي.',
                                    'stat_val' => '24/7',
                                    'stat_unit' => 'دعم متواصل',
                                    'stat_label' => 'مستشارك الأكاديمي بجانبك طوال رحلتك',
                                    'stat_sub' => 'متابعة دقيقة لكل خطوة وموعد تقديم رسمي',
                                    'points' => "جلسة استشارة فردية 1-on-1 لتحليل مؤهلك (دبلوم فني، ثانوية، بكالوريوس) واختيار أفضل طريق\nخطة زمنية مدروسة تضمن استيفاء كافة الأوراق والمواعيد قبل إغلاق باب التقديم\nمراجعة وتدقيق شامل لملفك الدراسي لمنع أي خطأ قد يؤدي للرفض\nتذكير دوري بمواعيد المقابلات والمنح والتصديقات خطوة بخطوة\nدعم متواصل عبر الواتساب والمكالمات والاجتماعات الافتراضية طوال فترة التقديم",
                                    'vs_traditional' => 'إهمال استفسارات الطلاب والتأخر في الرد وضياع المواعيد الرسمية للمنح',
                                    'vs_intok' => 'مستشار أكاديمي ملازم لك يومياً ومتابعة دقيقة تضمن عدم تفويت أي فرصة',
                                    'cta_text' => 'احجز استشارتك الأكاديمية الآن',
                                ]
                            ],
                        ];
                    @endphp

                    @foreach($bentoCardsConfig as $card)
                        @php
                            $cId = $card['id'];
                            $def = $card['defaults'];
                            $pointsVal = old('why_bento_'.$cId.'_points.ar', data_get($settings, 'why_bento_'.$cId.'_points.ar', $def['points']));
                            if (is_array($pointsVal)) {
                                $pointsVal = implode("\n", $pointsVal);
                            }
                        @endphp
                        <div class="rounded-2xl border p-5 sm:p-6 {{ $card['color'] }} space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
                                <h3 class="font-black text-sm sm:text-base flex items-center gap-2">
                                    <span class="size-6 rounded-lg bg-white border grid place-items-center text-xs font-mono">{{ $card['num'] }}</span>
                                    <span>{{ $card['name'] }}</span>
                                </h3>
                                <span class="text-xs font-mono font-bold text-slate-500">كارت #{{ $cId }}</span>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <label class="block text-xs font-bold text-slate-700">عنوان التاب (في الشريط)
                                    <input name="why_bento_{{ $cId }}_nav_title[ar]" value="{{ old('why_bento_'.$cId.'_nav_title.ar', data_get($settings, 'why_bento_'.$cId.'_nav_title.ar', $def['nav_title'])) }}" class="admin-input mt-1">
                                </label>
                                <label class="block text-xs font-bold text-slate-700">النص التوضيحي للتاب
                                    <input name="why_bento_{{ $cId }}_nav_sub[ar]" value="{{ old('why_bento_'.$cId.'_nav_sub.ar', data_get($settings, 'why_bento_'.$cId.'_nav_sub.ar', $def['nav_sub'])) }}" class="admin-input mt-1">
                                </label>
                                <label class="block text-xs font-bold text-slate-700">شارة الكارت (Badge)
                                    <input name="why_bento_{{ $cId }}_badge[ar]" value="{{ old('why_bento_'.$cId.'_badge.ar', data_get($settings, 'why_bento_'.$cId.'_badge.ar', $def['badge'])) }}" class="admin-input mt-1">
                                </label>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-1">
                                <label class="block text-xs font-bold text-slate-700">العنوان الرئيسي للكارت
                                    <input name="why_bento_{{ $cId }}_title[ar]" value="{{ old('why_bento_'.$cId.'_title.ar', data_get($settings, 'why_bento_'.$cId.'_title.ar', $def['title'])) }}" class="admin-input mt-1">
                                </label>
                                <label class="block text-xs font-bold text-slate-700">الوصف والشرح المفصل
                                    <textarea name="why_bento_{{ $cId }}_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_'.$cId.'_desc.ar', data_get($settings, 'why_bento_'.$cId.'_desc.ar', $def['desc'])) }}</textarea>
                                </label>
                            </div>

                            <!-- Stats Section -->
                            <div class="rounded-xl bg-white p-4 border border-slate-200/80 space-y-3">
                                <h4 class="text-xs font-black text-slate-800">بيانات الكارت الإحصائية (HUD Stats)</h4>
                                <div class="grid gap-3 sm:grid-cols-4">
                                    <label class="block text-[11px] font-bold text-slate-700">القيمة الإحصائية (الرقم)
                                        <input name="why_bento_{{ $cId }}_stat_val" value="{{ old('why_bento_'.$cId.'_stat_val', data_get($settings, 'why_bento_'.$cId.'_stat_val', $def['stat_val'])) }}" class="admin-input mt-1">
                                    </label>
                                    <label class="block text-[11px] font-bold text-slate-700">الوحدة الإحصائية
                                        <input name="why_bento_{{ $cId }}_stat_unit[ar]" value="{{ old('why_bento_'.$cId.'_stat_unit.ar', data_get($settings, 'why_bento_'.$cId.'_stat_unit.ar', $def['stat_unit'])) }}" class="admin-input mt-1">
                                    </label>
                                    <label class="block text-[11px] font-bold text-slate-700">عنوان الإحصائية
                                        <input name="why_bento_{{ $cId }}_stat_label[ar]" value="{{ old('why_bento_'.$cId.'_stat_label.ar', data_get($settings, 'why_bento_'.$cId.'_stat_label.ar', $def['stat_label'])) }}" class="admin-input mt-1">
                                    </label>
                                    <label class="block text-[11px] font-bold text-slate-700">الوصف الإضافي
                                        <input name="why_bento_{{ $cId }}_stat_sub[ar]" value="{{ old('why_bento_'.$cId.'_stat_sub.ar', data_get($settings, 'why_bento_'.$cId.'_stat_sub.ar', $def['stat_sub'])) }}" class="admin-input mt-1">
                                    </label>
                                </div>
                            </div>

                            <!-- Bullet Points (5 Points) -->
                            <div class="rounded-xl bg-white p-4 border border-slate-200/80 space-y-2">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-black text-slate-800">نقاط المميزات التفصيلية (كل سطر = نقطة مميزة تظهر بعلامة صح)</h4>
                                    <span class="text-[11px] font-bold text-slate-400">سطر جديد لكل ميزة</span>
                                </div>
                                <textarea name="why_bento_{{ $cId }}_points[ar]" rows="4" class="admin-input font-medium text-xs leading-relaxed" placeholder="اكتب كل ميزة في سطر منفصل...">{{ $pointsVal }}</textarea>
                            </div>

                            <!-- Comparison & CTA Button -->
                            <div class="rounded-xl bg-white p-4 border border-slate-200/80 space-y-3">
                                <h4 class="text-xs font-black text-slate-800">مقارنة الواقع وزر الإجراء</h4>
                                <div class="grid gap-3 sm:grid-cols-3">
                                    <label class="block text-[11px] font-bold text-slate-700">الطرق والمكاتب التقليدية (الجانب السلبي)
                                        <textarea name="why_bento_{{ $cId }}_vs_traditional[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_'.$cId.'_vs_traditional.ar', data_get($settings, 'why_bento_'.$cId.'_vs_traditional.ar', $def['vs_traditional'])) }}</textarea>
                                    </label>
                                    <label class="block text-[11px] font-bold text-slate-700">معيار وضمان INTOK Academy (الجانب الإيجابي)
                                        <textarea name="why_bento_{{ $cId }}_vs_intok[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_'.$cId.'_vs_intok.ar', data_get($settings, 'why_bento_'.$cId.'_vs_intok.ar', $def['vs_intok'])) }}</textarea>
                                    </label>
                                    <label class="block text-[11px] font-bold text-slate-700">نص زر الإجراء (CTA)
                                        <input name="why_bento_{{ $cId }}_cta_text[ar]" value="{{ old('why_bento_'.$cId.'_cta_text.ar', data_get($settings, 'why_bento_'.$cId.'_cta_text.ar', $def['cta_text'])) }}" class="admin-input mt-1">
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- TAB: INTERNAL PAGES CONTENT (ABOUT, SERVICES, ADVISORY, ETC.) -->
        <div class="settings-panel hidden" id="tab-pages">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-8">
                <div class="border-b border-slate-100 pb-3 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">نصوص وعناوين الصفحات الداخلية بالكامل</h2>
                        <p class="text-xs text-slate-500">تحكم كامل في نصوص شارات وعناوين وشروحات وبنرات صفحات: من نحن، الخدمات، الاستشارات، التسجيل، تواصل معنا، فريقنا، وقصص النجاح.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-bold text-emerald-700">تحكم 100% ديناميكي</span>
                </div>

                <!-- 1. صفحة من نحن (About Page) -->
                <div class="rounded-2xl border border-amber-200 bg-amber-50/30 p-5 space-y-4">
                    <div class="flex items-center gap-2 border-b border-amber-200/80 pb-2">
                        <span class="size-2 rounded-full bg-amber-500"></span>
                        <h3 class="font-black text-sm text-[#c27803]">1. صفحة من نحن (About Us)</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-xs font-bold text-slate-700">شارة قسم الهيرو
                            <input name="about_hero_badge[ar]" value="{{ old('about_hero_badge.ar', data_get($settings, 'about_hero_badge.ar', 'INTOK ACADEMY • من نحن')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الوصف التعريفي بالهيرو
                            <input name="about_hero_subtitle[ar]" value="{{ old('about_hero_subtitle.ar', data_get($settings, 'about_hero_subtitle.ar', 'قصة التمكين والريادة الأكاديمية: نفتح أبواب الجامعات الإيطالية وسوق العمل الدولي للشباب العربي وحملة الدبلومات والثانوية العامة.')) }}" class="admin-input mt-1">
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-xs font-bold text-slate-700">عنوان صندوق الرسالة والهوية
                            <input name="about_mission_title[ar]" value="{{ old('about_mission_title.ar', data_get($settings, 'about_mission_title.ar', 'رسالتنا وهويتنا المؤسسية')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الوصف الفرعي لصندوق الرسالة
                            <input name="about_mission_subtitle[ar]" value="{{ old('about_mission_subtitle.ar', data_get($settings, 'about_mission_subtitle.ar', 'معايير الجودة والاعتماد الرسمي')) }}" class="admin-input mt-1">
                        </label>
                    </div>

                    <label class="block text-xs font-bold text-slate-700">نص رسالة الضمان 360 درجة (في الكارت الجانبي)
                        <textarea name="about_guarantee_text[ar]" rows="2" class="admin-input mt-1">{{ old('about_guarantee_text.ar', data_get($settings, 'about_guarantee_text.ar', 'مرافقة شخصية 360 درجة من أول جلسة استشارة وفحص أوراقك، حتى استلام تأشيرتك ومفاتيح سكنك بإيطاليا.')) }}</textarea>
                    </label>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-xs font-bold text-slate-700">شارة قسم لقطات القاعات
                            <input name="about_gallery_badge[ar]" value="{{ old('about_gallery_badge.ar', data_get($settings, 'about_gallery_badge.ar', 'لقطات حية من قاعاتنا')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">عنوان قسم لقطات القاعات
                            <input name="about_gallery_title[ar]" value="{{ old('about_gallery_title.ar', data_get($settings, 'about_gallery_title.ar', 'شاهد واقع التعليم والتدريب في INTOK')) }}" class="admin-input mt-1">
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <label class="block text-xs font-bold text-slate-700">شارة البانر السفلي (CTA)
                            <input name="about_cta_badge[ar]" value="{{ old('about_cta_badge.ar', data_get($settings, 'about_cta_badge.ar', 'خطوتك الأولى تبدأ الآن')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">عنوان البانر السفلي
                            <input name="about_cta_title[ar]" value="{{ old('about_cta_title.ar', data_get($settings, 'about_cta_title.ar', 'جاهز لبدء رحلتك نحو إيطاليا والوظائف الدولية؟')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">وصف البانر السفلي
                            <input name="about_cta_subtitle[ar]" value="{{ old('about_cta_subtitle.ar', data_get($settings, 'about_cta_subtitle.ar', 'سواء كنت حاملاً لدبلوم فني أو ثانوية عامة أو خريجاً، مستشارك الأكاديمي في INTOK جاهز لدراسة ملفك وتحديد خطتك مجاناً.')) }}" class="admin-input mt-1">
                        </label>
                    </div>
                </div>

                <!-- 2. صفحة الخدمات والتدريب (Services Page) -->
                <div class="rounded-2xl border border-red-200 bg-red-50/30 p-5 space-y-4">
                    <div class="flex items-center gap-2 border-b border-red-200/80 pb-2">
                        <span class="size-2 rounded-full bg-red-600"></span>
                        <h3 class="font-black text-sm text-[#fe0002]">2. صفحة الخدمات والتدريب (Services Page)</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <label class="block text-xs font-bold text-slate-700">شارة قسم الجودة والاعتماد
                            <input name="services_why_badge[ar]" value="{{ old('services_why_badge.ar', data_get($settings, 'services_why_badge.ar', 'معايير الجودة والاعتماد الأكاديمي')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">عنوان قسم لماذا يثق الآلاف
                            <input name="services_why_title[ar]" value="{{ old('services_why_title.ar', data_get($settings, 'services_why_title.ar', 'لماذا يثق الآلاف في برامج INTOK ACADEMY؟')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">وصف قسم لماذا يثق الآلاف
                            <input name="services_why_subtitle[ar]" value="{{ old('services_why_subtitle.ar', data_get($settings, 'services_why_subtitle.ar', 'نجمع بين التدريب العملي المباشر، والاعتماد القنصلي الرسمي، والشراكات الدولية المؤهلة للتوظيف والدراسة.')) }}" class="admin-input mt-1">
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 pt-2">
                        <!-- Pillar 1 -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 1: العنوان
                                <input name="services_pillar1_title[ar]" value="{{ old('services_pillar1_title.ar', data_get($settings, 'services_pillar1_title.ar', 'شاشات ذكية ومحاكاة واقعية')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 1: الشرح
                                <textarea name="services_pillar1_desc[ar]" rows="2" class="admin-input mt-1">{{ old('services_pillar1_desc.ar', data_get($settings, 'services_pillar1_desc.ar', 'تدريب تطبيقي على أنظمة كبرى شركات الكول سنتر العالمية وقاعات ذكية تحاكي بيئة العمل الفعلية.')) }}</textarea>
                            </label>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 2: العنوان
                                <input name="services_pillar2_title[ar]" value="{{ old('services_pillar2_title.ar', data_get($settings, 'services_pillar2_title.ar', 'اعتماد وتوثيق قنصلي 100%')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 2: الشرح
                                <textarea name="services_pillar2_desc[ar]" rows="2" class="admin-input mt-1">{{ old('services_pillar2_desc.ar', data_get($settings, 'services_pillar2_desc.ar', 'شهادات تدريب موثقة وترجمات معتمدة رسمياً أمام السفارة الإيطالية وكافة السفارات والجهات الحكومية.')) }}</textarea>
                            </label>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 3: العنوان
                                <input name="services_pillar3_title[ar]" value="{{ old('services_pillar3_title.ar', data_get($settings, 'services_pillar3_title.ar', 'تأهيل وظيفي وترشيح مباشر')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 3: الشرح
                                <textarea name="services_pillar3_desc[ar]" rows="2" class="admin-input mt-1">{{ old('services_pillar3_desc.ar', data_get($settings, 'services_pillar3_desc.ar', 'توصيات مباشرة وتأهيل لاجتياز مقابلات الـ HR والـ Operations برواتب تصل 30,000+ ج.م.')) }}</textarea>
                            </label>
                        </div>

                        <!-- Pillar 4 -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 4: العنوان
                                <input name="services_pillar4_title[ar]" value="{{ old('services_pillar4_title.ar', data_get($settings, 'services_pillar4_title.ar', 'إشراف على منحة DSU الإيطالية')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">ركيزة 4: الشرح
                                <textarea name="services_pillar4_desc[ar]" rows="2" class="admin-input mt-1">{{ old('services_pillar4_desc.ar', data_get($settings, 'services_pillar4_desc.ar', 'حساب دقيق لـ ISEE يضمن إعفاء 100% من المصروفات وسكن مجاني وبدل 8,000 يورو للدبلومات والثانوية.')) }}</textarea>
                            </label>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3 pt-2">
                        <label class="block text-xs font-bold text-slate-700">شارة بانر الخدمات السفلي
                            <input name="services_cta_badge[ar]" value="{{ old('services_cta_badge.ar', data_get($settings, 'services_cta_badge.ar', 'خطوتك الأولى نحو مستقبلك الدولي')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">عنوان بانر الخدمات السفلي
                            <input name="services_cta_title[ar]" value="{{ old('services_cta_title.ar', data_get($settings, 'services_cta_title.ar', 'هل تحتاج لمساعدة في اختيار المسار التدريبي الأنسب لك؟')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">وصف بانر الخدمات السفلي
                            <input name="services_cta_subtitle[ar]" value="{{ old('services_cta_subtitle.ar', data_get($settings, 'services_cta_subtitle.ar', 'تحدث مع مستشارنا الأكاديمي مباشرة ليحلل مؤهلك الدراسي ويرشح لك أنسب برنامج.')) }}" class="admin-input mt-1">
                        </label>
                    </div>
                </div>

                <!-- 3. عناوين باقي الصفحات (Consultation, Registration, Contact, Team, Testimonials) -->
                <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5 space-y-5">
                    <h3 class="font-black text-sm text-slate-900 border-b border-slate-200/80 pb-2">3. شارات وعناوين الصفحات الأخرى</h3>
                    
                    <div class="grid gap-4 sm:grid-cols-3">
                        <!-- Consultation -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <span class="text-xs font-black text-red-700 block">صفحة حجز الاستشارة</span>
                            <label class="block text-[11px] font-bold text-slate-700">الشارة
                                <input name="consultation_badge[ar]" value="{{ old('consultation_badge.ar', data_get($settings, 'consultation_badge.ar', 'جلسة إرشادية 1-on-1')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">العنوان
                                <input name="consultation_title[ar]" value="{{ old('consultation_title.ar', data_get($settings, 'consultation_title.ar', 'حجز استشارة أكاديمية')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">الوصف التمهيدي
                                <input name="consultation_intro[ar]" value="{{ old('consultation_intro.ar', data_get($settings, 'consultation_intro.ar', 'حدد موعدك مع مستشارك الأكاديمي لفحص أوراقك ومؤهلك وتحديد فرص قبولك بالمنح والجامعات الإيطالية.')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <!-- Registration -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <span class="text-xs font-black text-emerald-700 block">صفحة تسجيل العميل / الطالب</span>
                            <label class="block text-[11px] font-bold text-slate-700">الشارة
                                <input name="registration_badge[ar]" value="{{ old('registration_badge.ar', data_get($settings, 'registration_badge.ar', 'ملف الطالب الأكاديمي')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">العنوان
                                <input name="registration_title[ar]" value="{{ old('registration_title.ar', data_get($settings, 'registration_title.ar', 'تسجيل عميل جديد')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">الوصف التمهيدي
                                <input name="registration_intro[ar]" value="{{ old('registration_intro.ar', data_get($settings, 'registration_intro.ar', 'سجل بياناتك ومؤهلك لفتح ملفك الأكاديمي والبدء في إجراءات القبول والتدريب.')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <!-- Contact -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <span class="text-xs font-black text-blue-700 block">صفحة تواصل معنا</span>
                            <label class="block text-[11px] font-bold text-slate-700">الشارة
                                <input name="contact_badge[ar]" value="{{ old('contact_badge.ar', data_get($settings, 'contact_badge.ar', 'قنوات التواصل المباشر')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">العنوان
                                <input name="contact_page_title[ar]" value="{{ old('contact_page_title.ar', data_get($settings, 'contact_page_title.ar', 'تواصل معنا')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">الوصف التمهيدي
                                <input name="contact_intro[ar]" value="{{ old('contact_intro.ar', data_get($settings, 'contact_intro.ar', 'فريق خدمة العملاء والمستشارين متاح للرد على كافة أسئلتكم ومساعدتكم في كل خطوة.')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <!-- Team -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <span class="text-xs font-black text-amber-700 block">صفحة فريق العمل</span>
                            <label class="block text-[11px] font-bold text-slate-700">الشارة
                                <input name="team_badge[ar]" value="{{ old('team_badge.ar', data_get($settings, 'team_badge.ar', 'خبراء التعليم الدولي')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">العنوان
                                <input name="team_page_title[ar]" value="{{ old('team_page_title.ar', data_get($settings, 'team_page_title.ar', 'فريقنا')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">الوصف التمهيدي
                                <input name="team_intro[ar]" value="{{ old('team_intro.ar', data_get($settings, 'team_intro.ar', 'نخبة من المحاضرين المعتمدين والمستشارين الأكاديميين ذوي الخبرة الأوروبية.')) }}" class="admin-input mt-1">
                            </label>
                        </div>

                        <!-- Testimonials -->
                        <div class="rounded-xl bg-white p-3.5 border border-slate-200 space-y-2">
                            <span class="text-xs font-black text-purple-700 block">صفحة قصص النجاح</span>
                            <label class="block text-[11px] font-bold text-slate-700">الشارة
                                <input name="testimonials_badge[ar]" value="{{ old('testimonials_badge.ar', data_get($settings, 'testimonials_badge.ar', 'قصص واقعية وتجارب ملهمة')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">العنوان
                                <input name="testimonials_page_title[ar]" value="{{ old('testimonials_page_title.ar', data_get($settings, 'testimonials_page_title.ar', 'قصص نجاح طلابنا')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-[11px] font-bold text-slate-700">الوصف التمهيدي
                                <input name="testimonials_intro[ar]" value="{{ old('testimonials_intro.ar', data_get($settings, 'testimonials_intro.ar', 'تجارب حقيقية لشباب وصلوا إلى الجامعات الإيطالية وكبرى شركات التوظيف بدعم من INTOK.')) }}" class="admin-input mt-1">
                            </label>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB 7: ROADMAP (4 STEPS) -->
        <div class="settings-panel hidden" id="tab-roadmap">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">خارطة طريق التقديم (4 خطوات)</h2>
                    <p class="text-xs text-slate-500">نصوص المراحل الأربعة من الاستشارة وحتى السفر والاستقرار.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <label class="block text-xs font-bold text-slate-700">شارة القسم (Badge)
                        <input name="roadmap_badge[ar]" value="{{ old('roadmap_badge.ar', data_get($settings, 'roadmap_badge.ar', 'خارطة طريق واضحة ومضمونة')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700">عنوان القسم الرئيسي
                        <input name="roadmap_title[ar]" value="{{ old('roadmap_title.ar', data_get($settings, 'roadmap_title.ar', 'خطوات التحاقك من البداية حتى الاستقرار')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700 sm:col-span-3">وصف القسم
                        <textarea name="roadmap_subtitle[ar]" rows="2" class="admin-input mt-1">{{ old('roadmap_subtitle.ar', data_get($settings, 'roadmap_subtitle.ar', '')) }}</textarea>
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 pt-4">
                    <!-- Step 1 -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                        <h4 class="font-bold text-xs text-red-600">المرحلة 01</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="roadmap_step1_title[ar]" value="{{ old('roadmap_step1_title.ar', data_get($settings, 'roadmap_step1_title.ar', 'الاستشارة وتحديد المسار')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الوصف
                            <textarea name="roadmap_step1_desc[ar]" rows="2" class="admin-input mt-1">{{ old('roadmap_step1_desc.ar', data_get($settings, 'roadmap_step1_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Step 2 -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                        <h4 class="font-bold text-xs text-red-600">المرحلة 02</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="roadmap_step2_title[ar]" value="{{ old('roadmap_step2_title.ar', data_get($settings, 'roadmap_step2_title.ar', 'تجهيز الأوراق والتدريب')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الوصف
                            <textarea name="roadmap_step2_desc[ar]" rows="2" class="admin-input mt-1">{{ old('roadmap_step2_desc.ar', data_get($settings, 'roadmap_step2_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Step 3 -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                        <h4 class="font-bold text-xs text-red-600">المرحلة 03</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="roadmap_step3_title[ar]" value="{{ old('roadmap_step3_title.ar', data_get($settings, 'roadmap_step3_title.ar', 'التقديم للمنح والقبول')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الوصف
                            <textarea name="roadmap_step3_desc[ar]" rows="2" class="admin-input mt-1">{{ old('roadmap_step3_desc.ar', data_get($settings, 'roadmap_step3_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Step 4 -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-2">
                        <h4 class="font-bold text-xs text-red-600">المرحلة 04</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="roadmap_step4_title[ar]" value="{{ old('roadmap_step4_title.ar', data_get($settings, 'roadmap_step4_title.ar', 'التأشيرة والاستقبال بإيطاليا')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الوصف
                            <textarea name="roadmap_step4_desc[ar]" rows="2" class="admin-input mt-1">{{ old('roadmap_step4_desc.ar', data_get($settings, 'roadmap_step4_desc.ar', '')) }}</textarea>
                        </label>
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB 8: FINAL CTA BANNER -->
        <div class="settings-panel hidden" id="tab-cta">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">بانر الدعوة لاتخاذ القرار النهائي (Bottom CTA)</h2>
                    <p class="text-xs text-slate-500">البانر الأسود الفخم أسفل الصفحة الرئيسية وقبل التذييل.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $locale => $label)
                        <div class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <h3 class="font-bold text-sm text-slate-800">{{ $label }}</h3>
                            <label class="block text-xs font-bold text-slate-700">الشارة (Badge)
                                <input name="cta_badge[{{ $locale }}]" value="{{ old('cta_badge.'.$locale, data_get($settings, 'cta_badge.'.$locale, 'ابدأ مستقبلك اليوم')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">العنوان الرئيسي
                                <input name="cta_title[{{ $locale }}]" value="{{ old('cta_title.'.$locale, data_get($settings, 'cta_title.'.$locale, 'جاهز لبدء رحلتك نحو إيطاليا وأرقى الوظائف الدولية؟')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">الوصف
                                <textarea name="cta_subtitle[{{ $locale }}]" rows="3" class="admin-input mt-1">{{ old('cta_subtitle.'.$locale, data_get($settings, 'cta_subtitle.'.$locale, '')) }}</textarea>
                            </label>
                            <label class="block text-xs font-bold text-slate-700">نص الزر الأساسي (حجز)
                                <input name="cta_btn_primary[{{ $locale }}]" value="{{ old('cta_btn_primary.'.$locale, data_get($settings, 'cta_btn_primary.'.$locale, 'احجز استشارتك الآن')) }}" class="admin-input mt-1">
                            </label>
                            <label class="block text-xs font-bold text-slate-700">نص الزر الثانوي (واتساب)
                                <input name="cta_btn_secondary[{{ $locale }}]" value="{{ old('cta_btn_secondary.'.$locale, data_get($settings, 'cta_btn_secondary.'.$locale, 'واتساب مباشر')) }}" class="admin-input mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Sticky Submit Footer Bar -->
        <div class="sticky bottom-6 z-30 flex items-center justify-between rounded-2xl bg-slate-900/95 p-4 text-white shadow-2xl backdrop-blur-md border border-slate-700">
            <span class="text-xs font-bold text-slate-300">
                تم تطبيق نظام التعديل الديناميكي الكامل على كافة الصفحات.
            </span>
            <button type="submit" class="rounded-xl bg-[#fe0002] px-8 py-3 text-xs font-black text-white hover:bg-red-700 transition shadow-lg cursor-pointer">
                حفظ كافة التعديلات
            </button>
        </div>
    </form>
</div>

<style>
    .settings-tab-btn {
        background: #f1f5f9;
        color: #475569;
        cursor: pointer;
        user-select: none;
    }
    .settings-tab-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .settings-tab-btn.active-tab {
        background: #fe0002;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(254, 0, 2, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabBtns = document.querySelectorAll('.settings-tab-btn');
        const panels = document.querySelectorAll('.settings-panel');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active-tab'));
                btn.classList.add('active-tab');

                const targetId = btn.getAttribute('data-target');
                panels.forEach(p => {
                    if (p.id === targetId) {
                        p.classList.remove('hidden');
                    } else {
                        p.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endsection
