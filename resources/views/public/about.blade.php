@extends('public.layouts.app')

@section('title', $page->seo_title[$locale] ?? $page->title[$locale] ?? __('site.nav_about'))
@section('meta_description', $page->seo_description[$locale] ?? Str::limit(strip_tags($page->content[$locale] ?? ''), 170))

@php
    $aboutContent = $page->content[$locale] ?? $page->content['en'] ?? '';
    $pageTitle = $page->title[$locale] ?? $page->title['en'] ?? __('site.nav_about');
@endphp

@section('content')
    <!-- ==========================================================
         HERO SECTION: EXECUTIVE BANNER (BRAND MUSTARD & RED)
         ========================================================== -->
    <section class="relative isolate overflow-hidden bg-intok-hero py-16 sm:py-20 text-slate-900 border-b border-slate-100">
        <!-- Living Background Accents -->
        <div class="animate-aurora-1 pointer-events-none absolute -top-24 start-10 -z-10 size-[32rem] rounded-full bg-red-500/10 blur-[110px]"></div>
        <div class="animate-aurora-2 pointer-events-none absolute top-1/4 end-10 -z-10 size-[30rem] rounded-full bg-amber-500/10 blur-[100px]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
            <div class="max-w-3xl reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white/90 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#fe0002] opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-[#fe0002]"></span>
                    </span>
                    <span>INTOK ACADEMY • {{ $pageTitle }}</span>
                </span>

                <h1 class="mt-5 text-3xl font-black leading-tight text-[#c27803] sm:text-5xl lg:text-6xl tracking-tight">
                    {{ $pageTitle }}
                </h1>

                <p class="mt-4 text-base sm:text-lg leading-relaxed text-slate-600 font-medium">
                    قصة التمكين والريادة الأكاديمية: نفتح أبواب الجامعات الإيطالية وسوق العمل الدولي للشباب العربي وحملة الدبلومات والثانوية العامة.
                </p>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         MAIN CONTENT & EXECUTIVE COCKPIT (SPLIT VIEW)
         ========================================================== -->
    <section class="relative bg-intok-section py-16 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 items-start">
                
                <!-- Main Narrative Content from Database (7 Cols) -->
                <div class="lg:col-span-7 space-y-6 reveal-up">
                    <div class="card-poster-white p-4 sm:p-7 lg:p-10 bg-white border border-slate-200 shadow-md">
                        
                        <!-- Top Header with Brand Badge -->
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="grid size-11 place-items-center rounded-2xl bg-red-50 text-[#fe0002] border border-red-200 shadow-xs">
                                    <svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </span>
                                <div>
                                    <h2 class="text-base font-black text-slate-900 leading-snug">
                                        رسالتنا وهويتنا المؤسسية
                                    </h2>
                                    <span class="text-xs font-bold text-slate-500">
                                        معايير الجودة والاعتماد الرسمي
                                    </span>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-black text-emerald-700">
                                <svg class="size-3 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>معتمد رسمياً</span>
                            </span>
                        </div>

                        <!-- Dynamic Markdown Content with Luxury Styling -->
                        <div class="page-content text-sm sm:text-base leading-loose text-slate-700 space-y-4">
                            {!! Str::markdown($aboutContent, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                        </div>

                        <!-- Bottom CTAs -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center gap-4">
                            <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="btn-intok-primary inline-flex items-center gap-2 px-7 py-3.5 text-xs sm:text-sm font-black shadow-md">
                                <span>احجز استشارتك الأكاديمية الآن</span>
                            </a>
                            <a href="{{ route('services.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 rounded-full border-2 border-slate-200 bg-slate-50 px-6 py-3.5 text-xs sm:text-sm font-black text-slate-700 hover:bg-white hover:border-[#fe0002] hover:text-[#fe0002] transition shadow-xs">
                                <span>استكشف برامجنا وتدريباتنا</span>
                                <span>&larr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Executive Fast-Facts & Credentials Cockpit (5 Cols) -->
                <div class="lg:col-span-5 space-y-6 reveal-up">
                    
                    <!-- Academy Profile Card -->
                    <div class="card-poster-white p-6 bg-white border border-slate-200 shadow-md text-start">
                        <div class="flex items-center gap-3.5 mb-5 pb-4 border-b border-slate-100">
                            <div class="size-14 rounded-2xl border-2 border-[#fe0002] p-1 bg-white shadow-xs shrink-0">
                                <img src="{{ asset('assets/images/intok-logo.jpg') }}" alt="INTOK Logo" class="size-full object-cover rounded-xl">
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-900 leading-tight">INTOK ACADEMY</h3>
                                <p class="text-xs font-bold text-[#c27803] mt-0.5">Connecting You to the World</p>
                                <span class="text-[10px] text-slate-500 font-medium">أكاديمية معتمدة للتدريب والدراسة في إيطاليا</span>
                            </div>
                        </div>

                        <!-- 4 Stat Badges Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-3.5 text-center">
                                <span class="grid size-8 mx-auto mb-1 place-items-center text-[#fe0002]">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <span class="text-base font-black text-[#fe0002] block font-mono">{{ data_get($siteSettings ?? [], 'hero_stat_3_val', '8,000€') }}</span>
                                <span class="text-[10px] font-bold text-slate-600">{{ data_get($siteSettings ?? [], 'hero_stat_3_lbl.'.$locale, 'بدل سنوي + سكن مجاني') }}</span>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-3.5 text-center">
                                <span class="grid size-8 mx-auto mb-1 place-items-center text-[#c27803]">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                                </span>
                                <span class="text-base font-black text-[#c27803] block font-mono">{{ data_get($siteSettings ?? [], 'hero_stat_2_val', '+1,200') }}</span>
                                <span class="text-[10px] font-bold text-slate-600">{{ data_get($siteSettings ?? [], 'hero_stat_2_lbl.'.$locale, 'طالب تم قبولهم بنجاح') }}</span>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-3.5 text-center">
                                <span class="grid size-8 mx-auto mb-1 place-items-center text-emerald-700">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                                </span>
                                <span class="text-base font-black text-emerald-700 block font-mono">15k-30k+</span>
                                <span class="text-[10px] font-bold text-slate-600">رواتب الكول سنتر ج.م</span>
                            </div>
                            <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-3.5 text-center">
                                <span class="grid size-8 mx-auto mb-1 place-items-center text-blue-700">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </span>
                                <span class="text-base font-black text-blue-700 block font-mono">{{ data_get($siteSettings ?? [], 'hero_stat_1_val', '100%') }}</span>
                                <span class="text-[10px] font-bold text-slate-600">{{ data_get($siteSettings ?? [], 'hero_stat_1_lbl.'.$locale, 'نسبة نجاح استخراج التأشيرات') }}</span>
                            </div>
                        </div>

                        <!-- Guarantee Message -->
                        <div class="rounded-2xl bg-red-50/80 border border-red-200 p-4 flex items-start gap-3">
                            <span class="grid size-6 place-items-center text-[#fe0002] shrink-0 mt-0.5">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                            <p class="text-xs font-bold text-red-950 leading-relaxed">
                                مرافقة شخصية 360 درجة من أول جلسة استشارة وفحص أوراقك، حتى استلام تأشيرتك ومفاتيح سكنك بإيطاليا.
                            </p>
                        </div>

                        <!-- Direct WhatsApp Quick Chat -->
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode('مرحباً، أود معرفة المزيد عن خدمات أكاديمية إنتوك وفرص الدراسة في إيطاليا') }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 rounded-full border-2 border-emerald-500 bg-emerald-50 py-3 px-4 text-xs font-black text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-xs">
                                <span>تواصل فوري مع الإدارة عبر الواتساب</span>
                            </a>
                        </div>
                    </div>

                    <!-- Direct Advisory or Team Link -->
                    @if(\App\Models\TeamMember::query()->where('is_active', true)->exists())
                        <div class="card-poster-white p-5 bg-gradient-to-br from-amber-50/50 to-white border border-amber-200 rounded-3xl flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="grid size-11 place-items-center rounded-2xl bg-amber-100 text-amber-800 shadow-xs">
                                    <svg class="size-6 text-amber-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </span>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900">نخبة مستشارينا ومدربينا</h4>
                                    <p class="text-[11px] font-medium text-slate-500 mt-0.5">تعرف على فريق العمل الأكاديمي</p>
                                </div>
                            </div>
                            <a href="{{ route('team', ['locale' => $locale]) }}" class="inline-flex items-center gap-1 rounded-full bg-white border border-amber-300 px-4 py-2 text-xs font-black text-amber-900 hover:bg-amber-100 transition shadow-xs shrink-0">
                                <span>فريقنا</span>
                                <span>&larr;</span>
                            </a>
                        </div>
                    @else
                        <div class="card-poster-white p-5 bg-gradient-to-br from-red-50/50 to-white border border-red-200 rounded-3xl flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="grid size-11 place-items-center rounded-2xl bg-red-100 text-[#fe0002] shadow-xs">
                                    <svg class="size-6 text-[#fe0002]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                                </span>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900">مستشارك الأكاديمي الشخصي</h4>
                                    <p class="text-[11px] font-medium text-slate-500 mt-0.5">تقييم ملفك وتحديد فرصة قبولك مجاناً</p>
                                </div>
                            </div>
                            <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="inline-flex items-center gap-1 rounded-full bg-[#fe0002] text-white px-4 py-2 text-xs font-black hover:bg-red-700 transition shadow-xs shrink-0">
                                <span>ابدأ الآن</span>
                                <span>&larr;</span>
                            </a>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================
         4 CORE PILLARS OF INTOK EXCELLENCE
         ========================================================== -->
    <section class="relative bg-white py-16 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-4 py-1.5 text-xs font-black text-[#fe0002] shadow-xs">
                    <span>معايير الثقة والريادة</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-4xl">
                    لماذا يختار آلاف الطلاب أكاديمية إنتوك؟
                </h2>
                <p class="mt-3 text-sm sm:text-base text-slate-600 font-medium">
                    منظومة متكاملة لا تكتفي بتقديم الدورات، بل تصنع مستقبلك الأكاديمي والمهني بمعايير أوروبية موثقة.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-amber-50 border border-amber-200 text-[#c27803] mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        </span>
                        <h3 class="text-base font-black text-[#c27803] mb-2">منحة DSU والسكن المجاني</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            حساب دقيق لـ ISEE يضمن إعفاء 100% من المصروفات وسكن مجاني وبدل نقدي 8,000 يورو للدبلومات والثانوية.
                        </p>
                    </div>
                </div>

                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                        </span>
                        <h3 class="text-base font-black text-[#c27803] mb-2">تأهيل الكول سنتر وسوق العمل</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            تدريب عملي على الشاشات التفاعلية ومحاكاة لمقابلات الشركات العالمية برواتب تصل إلى 30,000+ ج.م.
                        </p>
                    </div>
                </div>

                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        <h3 class="text-base font-black text-[#c27803] mb-2">ترجمة معتمدة رسمياً للسفارات</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            ترجمات وتصديقات معترف بها لدى القنصلية الإيطالية وكافة السفارات الأوروبية لضمان قبول ملفك.
                        </p>
                    </div>
                </div>

                <div class="card-poster-white p-6 bg-slate-50 border border-slate-200 flex flex-col justify-between reveal-up">
                    <div>
                        <span class="grid size-12 place-items-center rounded-2xl bg-red-50 border border-red-200 text-[#fe0002] mb-4">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </span>
                        <h3 class="text-base font-black text-[#c27803] mb-2">استقبال وتسكين بإيطاليا</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            فريق ميداني يستقبلك في مطارات ميلانو وروما ويسلمك السكن ويساعدك في استخراج الإقامة والحساب البنكي.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         REAL ACADEMY TRAINING SHOWCASE (PHOTOS)
         ========================================================== -->
    <section class="relative bg-intok-section py-16 border-b border-slate-200/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10 reveal-up">
                <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 border border-amber-200 px-4 py-1.5 text-xs font-black text-amber-900 shadow-xs">
                    <span>لقطات حية من قاعاتنا</span>
                </span>
                <h2 class="mt-4 text-3xl font-black text-[#c27803] sm:text-4xl">
                    شاهد واقع التعليم والتدريب في INTOK
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 max-w-4xl mx-auto reveal-up">
                <div class="rounded-3xl overflow-hidden border-2 border-slate-200 shadow-lg group relative">
                    <img src="{{ asset('assets/images/academy/live-speaker-training.jpg') }}" alt="تدريب المحادثة والخطابة على الشاشات الذكية في إنتوك" class="w-full h-64 sm:h-72 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-5 flex flex-col justify-end text-white">
                        <span class="inline-block bg-[#fe0002] px-3 py-1 rounded-full text-[10px] font-black w-max mb-1.5">
                            تدريب عملي تطبيقي
                        </span>
                        <h3 class="text-sm sm:text-base font-black text-white leading-snug">
                            محاكاة المقابلات الدولية ومحاضرات الطلاقة والخطابة باللغات
                        </h3>
                    </div>
                </div>

                <div class="rounded-3xl overflow-hidden border-2 border-slate-200 shadow-lg group relative">
                    <img src="{{ asset('assets/images/academy/italian-classroom-lecture.jpg') }}" alt="محاضرة اللغة الإيطالية وقواعد النطق" class="w-full h-64 sm:h-72 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-5 flex flex-col justify-end text-white">
                        <span class="inline-block bg-amber-500 px-3 py-1 rounded-full text-[10px] font-black w-max mb-1.5">
                            قاعات ذكية مجهزة
                        </span>
                        <h3 class="text-sm sm:text-base font-black text-white leading-snug">
                            تدريس تفاعلي على السبورات الذكية للغة الإيطالية المعتمدة
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         CALL TO ACTION: JOIN THE SUCCESS STORY
         ========================================================== -->
    <section class="relative bg-gradient-to-r from-[#fe0002] to-red-700 py-14 text-white text-center overflow-hidden">
        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <span class="inline-block rounded-full bg-white/20 border border-white/30 px-4 py-1 text-xs font-black text-amber-200 mb-3">
                خطوتك الأولى تبدأ الآن
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                جاهز لبدء رحلتك نحو إيطاليا والوظائف الدولية؟
            </h2>
            <p class="mt-3 text-xs sm:text-sm text-red-100 font-medium max-w-xl mx-auto leading-relaxed">
                سواء كنت حاملاً لدبلوم فني أو ثانوية عامة أو خريجاً، مستشارك الأكاديمي في INTOK جاهز لدراسة ملفك وتحديد خطتك مجاناً.
            </p>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('consultation.create', ['locale' => $locale]) }}" class="rounded-full bg-white px-7 py-3.5 text-xs sm:text-sm font-black text-[#fe0002] shadow-lg hover:bg-amber-100 transition transform hover:scale-105">
                    احجز استشارتك الأكاديمية المجانية
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($siteSettings ?? [], 'whatsapp_number', '201008238323')) }}?text={{ urlencode('مرحباً، أود استشارة لتحديد المسار المناسب لي في أكاديمية إنتوك') }}" target="_blank" class="rounded-full border-2 border-white/40 bg-white/10 px-6 py-3.5 text-xs sm:text-sm font-black text-white backdrop-blur-md hover:bg-white hover:text-slate-900 transition">
                    تواصل مباشر واتساب
                </a>
            </div>
        </div>
    </section>
@endsection