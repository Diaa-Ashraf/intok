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
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">قسم لماذا تختار أكاديمية إنتوك؟ (Bento Grid)</h2>
                    <p class="text-xs text-slate-500">نصوص وعناوين وشروحات كروت البينتو الستة.</p>
                </div>

                <!-- Section Header -->
                <div class="grid gap-4 sm:grid-cols-3">
                    <label class="block text-xs font-bold text-slate-700">شارة القسم (Badge)
                        <input name="why_badge[ar]" value="{{ old('why_badge.ar', data_get($settings, 'why_badge.ar', 'معايير الثقة والريادة الدولية')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700">عنوان القسم الرئيسي
                        <input name="why_title[ar]" value="{{ old('why_title.ar', data_get($settings, 'why_title.ar', 'لماذا تختار أكاديمية إنتوك؟')) }}" class="admin-input mt-1">
                    </label>
                    <label class="block text-xs font-bold text-slate-700 sm:col-span-3">وصف القسم
                        <textarea name="why_subtitle[ar]" rows="2" class="admin-input mt-1">{{ old('why_subtitle.ar', data_get($settings, 'why_subtitle.ar', '')) }}</textarea>
                    </label>
                </div>

                <div class="border-t border-slate-100 pt-6 space-y-6">
                    <!-- Bento 1: DSU -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-3">
                        <h4 class="font-bold text-sm text-red-700">1. كارت منحة DSU الشاملة (Hero Bento)</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="why_bento_dsu_title[ar]" value="{{ old('why_bento_dsu_title.ar', data_get($settings, 'why_bento_dsu_title.ar', 'أعلى نسبة قبول لمنح DSU الحكومية الإيطالية')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الشرح والوصف
                            <textarea name="why_bento_dsu_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_dsu_desc.ar', data_get($settings, 'why_bento_dsu_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Bento 2: Call Center -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-3">
                        <h4 class="font-bold text-sm text-emerald-700">2. كارت تأهيل الكول سنتر وسوق العمل</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="why_bento_callcenter_title[ar]" value="{{ old('why_bento_callcenter_title.ar', data_get($settings, 'why_bento_callcenter_title.ar', 'تأهيل وظيفي فوري لكبرى شركات الكول سنتر')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الشرح والوصف
                            <textarea name="why_bento_callcenter_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_callcenter_desc.ar', data_get($settings, 'why_bento_callcenter_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Bento 3: Translation -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-3">
                        <h4 class="font-bold text-sm text-amber-700">3. كارت الترجمة المعتمدة للسفارات</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="why_bento_trans_title[ar]" value="{{ old('why_bento_trans_title.ar', data_get($settings, 'why_bento_trans_title.ar', 'ترجمة معتمدة رسمياً وموثقة لجميع السفارات')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الشرح والوصف
                            <textarea name="why_bento_trans_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_trans_desc.ar', data_get($settings, 'why_bento_trans_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Bento 4: Reception -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-3">
                        <h4 class="font-bold text-sm text-red-700">4. كارت الاستقبال والمرافقة في إيطاليا</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="why_bento_reception_title[ar]" value="{{ old('why_bento_reception_title.ar', data_get($settings, 'why_bento_reception_title.ar', 'استقبال في المطار وتسليم السكن بإيطاليا')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الشرح والوصف
                            <textarea name="why_bento_reception_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_reception_desc.ar', data_get($settings, 'why_bento_reception_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Bento 5: Languages -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-3">
                        <h4 class="font-bold text-sm text-purple-700">5. كارت إتقان اللغات واختبارات CILS & IELTS</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="why_bento_languages_title[ar]" value="{{ old('why_bento_languages_title.ar', data_get($settings, 'why_bento_languages_title.ar', 'إتقان اللغات من الصفر واجتياز CILS & IELTS')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الشرح والوصف
                            <textarea name="why_bento_languages_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_languages_desc.ar', data_get($settings, 'why_bento_languages_desc.ar', '')) }}</textarea>
                        </label>
                    </div>

                    <!-- Bento 6: Mentorship -->
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 space-y-3">
                        <h4 class="font-bold text-sm text-blue-700">6. كارت الإرشاد الشخصي 1-on-1</h4>
                        <label class="block text-xs font-bold text-slate-700">العنوان
                            <input name="why_bento_mentorship_title[ar]" value="{{ old('why_bento_mentorship_title.ar', data_get($settings, 'why_bento_mentorship_title.ar', 'إرشاد شخصي 1-on-1 ومتابعة ذكية مستمرة')) }}" class="admin-input mt-1">
                        </label>
                        <label class="block text-xs font-bold text-slate-700">الشرح والوصف
                            <textarea name="why_bento_mentorship_desc[ar]" rows="2" class="admin-input mt-1">{{ old('why_bento_mentorship_desc.ar', data_get($settings, 'why_bento_mentorship_desc.ar', '')) }}</textarea>
                        </label>
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
