@extends('public.layouts.app')

@php
    $locale = $locale ?? app()->getLocale();
    $activeTab = old('booking_type', session('active_tab', request()->query('tab', 'general')));
@endphp

@section('title', __('site.booking_title'))

@section('content')
@php
    $locale = $locale ?? app()->getLocale();
    $activeTab = $activeTab ?? old('booking_type', session('active_tab', request()->query('tab', 'general')));
@endphp
<section class="relative isolate overflow-hidden bg-intok-hero py-14 sm:py-20 text-slate-900 border-b border-slate-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-start">
        <span class="inline-block rounded-full border border-red-200 bg-white/90 px-4 py-1 text-xs font-black text-[#fe0002] shadow-xs">
            {{ data_get($siteSettings ?? [], 'consultation_badge.'.$locale, match($locale) {
                'it' => 'Consulenza 1 a 1 Gratuita',
                'en' => '1-on-1 Advisory Session',
                default => 'جلسة إرشادية متخصصة 1-on-1',
            }) }}
        </span>
        <h1 class="mt-4 text-3xl font-black text-[#c27803] sm:text-5xl">
            {{ data_get($siteSettings ?? [], 'consultation_title.'.$locale, match($locale) {
                'it' => 'Prenota la Tua Consulenza con INTOK',
                'en' => 'Book Your Consultation with INTOK',
                default => 'احجز استشارتك مع INTOK',
            }) }}
        </h1>
        <p class="mt-4 max-w-2xl leading-relaxed text-slate-600 font-medium">
            {{ data_get($siteSettings ?? [], 'consultation_intro.'.$locale, match($locale) {
                'it' => 'Registra i tuoi dati e seleziona il servizio di cui hai bisogno: il nostro team ti contatterà per guidarti passo dopo passo.',
                'en' => 'Enter your details and select the service you need: our team will contact you to assist with every step.',
                default => 'سجل بياناتك وحدد الخدمة أو المسار الدراسي اللي محتاجه، وفريقنا المتخصص هيتواصل معاك لمساعدتك في كل خطوة.',
            }) }}
        </p>

        <!-- Consultation Type Switcher -->
        <div class="mt-8 inline-flex items-center p-1.5 bg-white rounded-2xl border border-slate-200 shadow-sm" id="consultation-tabs-nav">
            <button type="button" class="cons-tab-btn {{ $activeTab !== 'study_abroad' ? 'active-cons-tab' : 'text-slate-600' }} px-5 py-2.5 rounded-xl text-xs sm:text-sm font-black transition cursor-pointer flex items-center gap-2" data-tab="general">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>{{ match($locale) { 'it' => 'Consulenza Generale Servizi', 'en' => 'General Services Consultation', default => 'استشارة عامة في الخدمات' } }}</span>
            </button>
            <button type="button" class="cons-tab-btn {{ $activeTab === 'study_abroad' ? 'active-cons-tab' : 'text-slate-600' }} px-5 py-2.5 rounded-xl text-xs sm:text-sm font-black transition cursor-pointer flex items-center gap-2" data-tab="study_abroad">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                <span>{{ match($locale) { 'it' => 'Consulenza Studio all\'Estero', 'en' => 'Study Abroad Consultation', default => 'نموذج استشارة الدراسة بالخارج' } }}</span>
            </button>
        </div>
    </div>
</section>

<section class="bg-intok-section py-14 sm:py-20 text-slate-900 min-h-[60vh]">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        
        @if(session('status'))
            <div role="status" class="mb-8 flex items-center gap-3 rounded-2xl border border-emerald-500/30 bg-emerald-50 p-5 text-sm font-bold text-emerald-800 shadow-sm">
                <svg class="size-6 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <div class="leading-relaxed">{{ session('status') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 rounded-2xl border border-red-300 bg-red-50 p-4 text-xs font-bold text-red-800">
                <p class="mb-2 font-black">يرجى تصحيح الأخطاء التالية:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ==========================================
             FORM 1: GENERAL SERVICES CONSULTATION
             ========================================== -->
        <div id="panel-cons-general" class="{{ $activeTab === 'study_abroad' ? 'hidden' : '' }}">
            <form method="POST" action="{{ route('consultation.store', ['locale' => $locale]) }}" class="card-poster-white space-y-6 p-5 sm:p-8 md:p-10 bg-white border border-slate-200 shadow-md">
                @csrf
                <input type="hidden" name="booking_type" value="general">
                <input type="hidden" name="language" value="{{ $locale }}">
                <div class="absolute -left-[10000px] h-px w-px overflow-hidden" aria-hidden="true"><label for="website_general">Website</label><input id="website_general" name="website" tabindex="-1" autocomplete="off"></div>

                <div class="border-b border-slate-100 pb-4 mb-2">
                    <h3 class="text-base font-black text-slate-900">
                        {{ match($locale) { 'it' => 'Dati per la Consulenza Generale', 'en' => 'General Consultation Information', default => 'بيانات استشارة الخدمات العامة' } }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ match($locale) { 'it' => 'Inserisci le informazioni per essere contattato dal consulente idoneo.', 'en' => 'Provide your info so our specialized advisor can reach out.', default => 'حدد الخدمة المفضلة ووقت التواصل المناسب وسنتواصل معك فوراً.' } }}
                    </p>
                </div>

                <div>
                    <label for="name_gen" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_name') }} <span class="text-red-500">*</span></label>
                    <input id="name_gen" name="name" value="{{ old('name') }}" required maxlength="150" placeholder="{{ match($locale) { 'it' => 'Il tuo nome completo', 'en' => 'Your full name', default => 'الاسم الثلاثي أو بالكامل' } }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                    @error('name')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone_gen" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_phone') }} <span class="text-red-500">*</span></label>
                        <input id="phone_gen" name="phone" value="{{ old('phone') }}" required maxlength="30" placeholder="01xxxxxxxxx" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition text-start" dir="ltr">
                        @error('phone')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email_gen" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.contact_email') }} <span class="text-slate-400 font-normal">({{ match($locale) { 'it' => 'opzionale', 'en' => 'optional', default => 'اختياري' } }})</span></label>
                        <input id="email_gen" name="email" type="email" value="{{ old('email') }}" maxlength="255" placeholder="name@example.com" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition text-start" dir="ltr">
                        @error('email')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="service_id_gen" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.interested_service') }}</label>
                    <select id="service_id_gen" name="service_id" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                        <option value="" class="bg-white">{{ __('site.optional') }}</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id', request()->query('service_id')) == $service->id) class="bg-white">
                                {{ data_get($service->title, $locale, data_get($service->title, 'ar', '')) }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="preferred_contact_time" class="block text-xs font-black uppercase tracking-wider text-slate-700">
                            {{ match($locale) { 'it' => 'Fascia Oraria Preferita di Contatto', 'en' => 'Preferred Contact Time Window', default => 'الموعد المفضل للتواصل' } }}
                        </label>
                        <span class="text-[11px] font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                            {{ match($locale) { 'it' => 'Dom-Gio: 09:00 - 17:00', 'en' => 'Sun-Thu: 9 AM - 5 PM', default => 'مواعيد العمل: الأحد - الخميس (9 ص - 5 م)' } }}
                        </span>
                    </div>
                    <select id="preferred_contact_time" name="preferred_contact_time" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                        <option value="صباحاً (من 9:00 ص إلى 12:00 م)">{{ match($locale) { 'it' => 'Mattina (09:00 - 12:00)', 'en' => 'Morning (9:00 AM - 12:00 PM)', default => 'صباحاً (من 9:00 ص إلى 12:00 م)' } }}</option>
                        <option value="ظهراً (من 12:00 م إلى 3:00 م)">{{ match($locale) { 'it' => 'Primo pomeriggio (12:00 - 15:00)', 'en' => 'Afternoon (12:00 PM - 3:00 PM)', default => 'ظهراً (من 12:00 م إلى 3:00 م)' } }}</option>
                        <option value="عصراً (من 3:00 م إلى 5:00 م)">{{ match($locale) { 'it' => 'Tardo pomeriggio (15:00 - 17:00)', 'en' => 'Late Afternoon (3:00 PM - 5:00 PM)', default => 'عصراً (من 3:00 م إلى 5:00 م)' } }}</option>
                        <option value="في أقرب وقت متاح">{{ match($locale) { 'it' => 'Al più presto disponibile', 'en' => 'Earliest available time', default => 'في أقرب وقت متاح لفريق العمل' } }}</option>
                    </select>
                </div>

                <div>
                    <label for="notes_gen" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-700">{{ __('site.notes') }}</label>
                    <textarea id="notes_gen" name="notes" rows="3" maxlength="2000" placeholder="{{ __('site.notes_placeholder') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">{{ old('notes') }}</textarea>
                    @error('notes')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-intok-primary w-full py-4 text-sm font-black shadow-lg">
                    {{ match($locale) {
                        'it' => 'Conferma e prenota consulenza',
                        'en' => 'Confirm & Book Consultation',
                        default => 'تأكيد وحجز موعد الاستشارة',
                    } }}
                </button>
            </form>
        </div>

        <!-- ==========================================
             FORM 2: STUDY ABROAD CONSULTATION (FULL FORM FROM DOC)
             ========================================== -->
        <div id="panel-cons-abroad" class="{{ $activeTab !== 'study_abroad' ? 'hidden' : '' }}">
            <form method="POST" action="{{ route('consultation.store', ['locale' => $locale]) }}" class="card-poster-white space-y-7 p-5 sm:p-8 md:p-10 bg-white border border-slate-200 shadow-md">
                @csrf
                <input type="hidden" name="booking_type" value="study_abroad">
                <input type="hidden" name="language" value="{{ $locale }}">
                <div class="absolute -left-[10000px] h-px w-px overflow-hidden" aria-hidden="true"><label for="website_abroad">Website</label><input id="website_abroad" name="website" tabindex="-1" autocomplete="off"></div>

                <div class="border-b border-slate-100 pb-4">
                    <span class="inline-block rounded-full bg-red-50 text-[#fe0002] border border-red-200 px-3 py-1 text-xs font-black mb-2">
                        {{ match($locale) { 'it' => 'Modulo Ufficiale di Studio all\'Estero', 'en' => 'Official Study Abroad Application', default => 'نموذج استشارة الدراسة بالخارج' } }}
                    </span>
                    <h3 class="text-xl font-black text-slate-900">
                        {{ match($locale) { 'it' => 'Registra i tuoi dati e inizia il tuo percorso di studi', 'en' => 'Register Your Data & Begin Your Study Journey', default => 'سجّل بياناتك وابدأ رحلتك الدراسية' } }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ match($locale) { 'it' => 'Compila i seguenti dati: il team INTOK ti aiuterà a individuare la migliore opportunità formativa.', 'en' => 'Fill out the details below: the INTOK team will assist in choosing the ideal study opportunity for you.', default => 'املأ البيانات التالية، وفريق INTOK هيتواصل معاك لمساعدتك في تحديد أنسب فرصة دراسية ليك.' } }}
                    </p>
                </div>

                <!-- Section 1: Personal Details -->
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#c27803] flex items-center gap-2">
                        <span class="size-2 rounded-full bg-[#c27803]"></span>
                        <span>{{ match($locale) { 'it' => '1. Dati Personali', 'en' => '1. Personal Information', default => '1. البيانات الشخصية' } }}</span>
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name_abroad" class="mb-2 block text-xs font-black text-slate-700">{{ match($locale) { 'it' => 'Nome e Cognome', 'en' => 'Full Name', default => 'الاسم بالكامل' } }} <span class="text-red-500">*</span></label>
                            <input id="name_abroad" name="name" value="{{ old('name') }}" required maxlength="150" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @error('name')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black text-slate-700">{{ match($locale) { 'it' => 'Ruolo del richiedente', 'en' => 'Applicant Role', default => 'الصفة' } }} <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 p-3 text-xs font-black cursor-pointer has-checked:border-[#fe0002] has-checked:bg-red-50 has-checked:text-[#fe0002] transition">
                                    <input type="radio" name="applicant_type" value="student" class="accent-[#fe0002]" {{ old('applicant_type', 'student') === 'student' ? 'checked' : '' }} onchange="toggleStudentName(false)">
                                    <span>{{ match($locale) { 'it' => 'Studente', 'en' => 'Student', default => 'الطالب' } }}</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 p-3 text-xs font-black cursor-pointer has-checked:border-[#fe0002] has-checked:bg-red-50 has-checked:text-[#fe0002] transition">
                                    <input type="radio" name="applicant_type" value="parent" class="accent-[#fe0002]" {{ old('applicant_type') === 'parent' ? 'checked' : '' }} onchange="toggleStudentName(true)">
                                    <span>{{ match($locale) { 'it' => 'Genitore / Tutore', 'en' => 'Parent / Guardian', default => 'ولي الأمر' } }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Conditional Student Name (Shown if parent) -->
                    <div id="student_name_wrapper" class="{{ old('applicant_type') === 'parent' ? '' : 'hidden' }}">
                        <label for="student_name" class="mb-2 block text-xs font-black text-slate-700">
                            {{ match($locale) { 'it' => 'Nome dello Studente', 'en' => 'Student Full Name', default => 'اسم الطالب' } }} <span class="text-red-500">*</span>
                        </label>
                        <input id="student_name" name="student_name" value="{{ old('student_name') }}" maxlength="150" placeholder="{{ match($locale) { 'it' => 'Inserisci il nome dello studente', 'en' => 'Enter student name', default => 'اكتب اسم الطالب بالكامل' } }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                        @error('student_name')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone_abroad" class="mb-2 block text-xs font-black text-slate-700">{{ match($locale) { 'it' => 'Numero di Telefono', 'en' => 'Phone Number', default => 'رقم الهاتف' } }} <span class="text-red-500">*</span></label>
                            <input id="phone_abroad" name="phone" value="{{ old('phone') }}" required maxlength="30" placeholder="01xxxxxxxxx" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition text-start" dir="ltr">
                            @error('phone')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="student_birth_date" class="mb-2 block text-xs font-black text-slate-700">
                                {{ match($locale) { 'it' => 'Data di Nascita dello Studente', 'en' => 'Student Birth Date', default => 'تاريخ ميلاد الطالب' } }}
                            </label>
                            <input id="student_birth_date" name="student_birth_date" type="date" value="{{ old('student_birth_date') }}" max="{{ now()->subYears(12)->format('Y-m-d') }}" min="1970-01-01" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @error('student_birth_date')<p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Educational Details -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#c27803] flex items-center gap-2">
                        <span class="size-2 rounded-full bg-[#c27803]"></span>
                        <span>{{ match($locale) { 'it' => '2. Dati Accademici', 'en' => '2. Academic Information', default => '2. البيانات الدراسية' } }}</span>
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="current_education_level" class="mb-2 block text-xs font-black text-slate-700">
                                {{ match($locale) { 'it' => 'Livello di Istruzione Attuale', 'en' => 'Current Education Level', default => 'المرحلة الدراسية الحالية' } }}
                            </label>
                            <select id="current_education_level" name="current_education_level" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                                <option value="الصف الثالث الإعدادي" @selected(old('current_education_level') === 'الصف الثالث الإعدادي')>الصف الثالث الإعدادي</option>
                                <option value="الصف الأول الثانوي" @selected(old('current_education_level') === 'الصف الأول الثانوي')>الصف الأول الثانوي</option>
                                <option value="الصف الثاني الثانوي" @selected(old('current_education_level') === 'الصف الثاني الثانوي')>الصف الثاني الثانوي</option>
                                <option value="الصف الثالث الثانوي" @selected(old('current_education_level') === 'الصف الثالث الثانوي')>الصف الثالث الثانوي (أو دبلوم فني)</option>
                                <option value="الفرقة الأولى جامعة" @selected(old('current_education_level') === 'الفرقة الأولى جامعة')>الفرقة الأولى جامعة</option>
                                <option value="الفرقة الثانية جامعة" @selected(old('current_education_level') === 'الفرقة الثانية جامعة')>الفرقة الثانية جامعة</option>
                                <option value="الفرقة الثالثة جامعة" @selected(old('current_education_level') === 'الفرقة الثالثة جامعة')>الفرقة الثالثة جامعة</option>
                                <option value="الفرقة الرابعة جامعة" @selected(old('current_education_level') === 'الفرقة الرابعة جامعة')>الفرقة الرابعة جامعة</option>
                                <option value="الفرقة الخامسة جامعة" @selected(old('current_education_level') === 'الفرقة الخامسة جامعة')>الفرقة الخامسة جامعة / خريج</option>
                                <option value="ماجستير" @selected(old('current_education_level') === 'ماجستير')>مرحلة الماجستير</option>
                                <option value="دكتوراه" @selected(old('current_education_level') === 'دكتوراه')>مرحلة الدكتوراه</option>
                            </select>
                        </div>

                        <div>
                            <label for="target_education_level" class="mb-2 block text-xs font-black text-slate-700">
                                {{ match($locale) { 'it' => 'Livello di Studio Desiderato', 'en' => 'Target Education Level', default => 'المرحلة الدراسية المطلوبة' } }}
                            </label>
                            <select id="target_education_level" name="target_education_level" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                                <option value="دراسة البكالوريوس (الجامعة)" @selected(old('target_education_level') === 'دراسة البكالوريوس (الجامعة)')>دراسة البكالوريوس (الجامعة)</option>
                                <option value="دراسة المرحلة الثانوية" @selected(old('target_education_level') === 'دراسة المرحلة الثانوية')>دراسة المرحلة الثانوية</option>
                                <option value="دراسة الماجستير" @selected(old('target_education_level') === 'دراسة الماجستير')>دراسة الماجستير</option>
                                <option value="دراسة الدكتوراه" @selected(old('target_education_level') === 'دراسة الدكتوراه')>دراسة الدكتوراه</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="qualification_year" class="mb-2 block text-xs font-black text-slate-700">
                            {{ match($locale) { 'it' => 'Anno di Conseguimento dell\'Ultimo Titolo', 'en' => 'Year of Latest Qualification', default => 'سنة الحصول على آخر مؤهل دراسي' } }}
                        </label>
                        <select id="qualification_year" name="qualification_year" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            @for ($yr = (int)date('Y') + 1; $yr >= 2012; $yr--)
                                <option value="{{ $yr }}" @selected(old('qualification_year', date('Y')) == $yr)>{{ $yr }}</option>
                            @endfor
                            <option value="قبل 2012" @selected(old('qualification_year') === 'قبل 2012')>قبل عام 2012</option>
                        </select>
                    </div>
                </div>

                <!-- Section 3: Study Destination -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#c27803] flex items-center gap-2">
                        <span class="size-2 rounded-full bg-[#c27803]"></span>
                        <span>{{ match($locale) { 'it' => '3. Destinazione di Studio', 'en' => '3. Study Destination', default => '3. وجهة الدراسة' } }}</span>
                    </h4>

                    <div>
                        <label for="destination_country" class="mb-2 block text-xs font-black text-slate-700">
                            {{ match($locale) { 'it' => 'Paese di Interesse per lo Studio', 'en' => 'Interested Study Country', default => 'الدولة المهتم بالدراسة فيها' } }}
                        </label>
                        <select id="destination_country" name="destination_country" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition">
                            <option value="🇮🇹 إيطاليا" @selected(old('destination_country') === '🇮🇹 إيطاليا')>🇮🇹 إيطاليا (Italy)</option>
                            <option value="🇩🇪 ألمانيا" @selected(old('destination_country') === '🇩🇪 ألمانيا')>🇩🇪 ألمانيا (Germany)</option>
                            <option value="🇨🇦 كندا" @selected(old('destination_country') === '🇨🇦 كندا')>🇨🇦 كندا (Canada)</option>
                            <option value="🇹🇷 تركيا" @selected(old('destination_country') === '🇹🇷 تركيا')>🇹🇷 تركيا (Turkey)</option>
                            <option value="🇫🇷 فرنسا" @selected(old('destination_country') === '🇫🇷 فرنسا')>🇫🇷 فرنسا (France)</option>
                            <option value="🇪🇸 إسبانيا" @selected(old('destination_country') === '🇪🇸 إسبانيا')>🇪🇸 إسبانيا (Spain)</option>
                            <option value="🇬🇧 المملكة المتحدة" @selected(old('destination_country') === '🇬🇧 المملكة المتحدة')>🇬🇧 المملكة المتحدة (UK)</option>
                            <option value="🇨🇳 الصين" @selected(old('destination_country') === '🇨🇳 الصين')>🇨🇳 الصين (China)</option>
                            <option value="🇯🇵 اليابان" @selected(old('destination_country') === '🇯🇵 اليابان')>🇯🇵 اليابان (Japan)</option>
                            <option value="🇦🇺 أستراليا" @selected(old('destination_country') === '🇦🇺 أستراليا')>🇦🇺 أستراليا (Australia)</option>
                            <option value="🌐 لسه محتار ومحتاج استشارة" @selected(old('destination_country') === '🌐 لسه محتار ومحتاج استشارة')>🌐 لسه محتار ومحتاج استشارة لتحديد الدولة</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700">
                            {{ match($locale) { 'it' => 'Hai già fatto domanda o studiato all\'estero in precedenza?', 'en' => 'Have you previously applied or studied abroad?', default => 'هل سبق لك التقديم أو الدراسة بالخارج؟' } }}
                        </label>
                        <div class="grid grid-cols-2 gap-3 max-w-sm">
                            <label class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 p-3 text-xs font-black cursor-pointer has-checked:border-[#fe0002] has-checked:bg-red-50 has-checked:text-[#fe0002] transition">
                                <input type="radio" name="has_applied_before" value="yes" class="accent-[#fe0002]" {{ old('has_applied_before') === 'yes' ? 'checked' : '' }}>
                                <span>{{ match($locale) { 'it' => 'Sì', 'en' => 'Yes', default => 'نعم' } }}</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 p-3 text-xs font-black cursor-pointer has-checked:border-[#fe0002] has-checked:bg-red-50 has-checked:text-[#fe0002] transition">
                                <input type="radio" name="has_applied_before" value="no" class="accent-[#fe0002]" {{ old('has_applied_before', 'no') === 'no' ? 'checked' : '' }}>
                                <span>{{ match($locale) { 'it' => 'No', 'en' => 'No', default => 'لا' } }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-intok-primary w-full py-4 text-sm font-black shadow-lg">
                    {{ match($locale) { 'it' => 'Invia Richiesta di Consulenza', 'en' => 'Submit Consultation Request', default => 'إرسال طلب الاستشارة' } }}
                </button>
            </form>
        </div>

    </div>
</section>

<script>
    function toggleStudentName(isParent) {
        const wrapper = document.getElementById('student_name_wrapper');
        const input = document.getElementById('student_name');
        if (wrapper) {
            if (isParent) {
                wrapper.classList.remove('hidden');
                input?.setAttribute('required', 'required');
            } else {
                wrapper.classList.add('hidden');
                input?.removeAttribute('required');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const tabBtns = document.querySelectorAll('.cons-tab-btn');
        const panelGeneral = document.getElementById('panel-cons-general');
        const panelAbroad = document.getElementById('panel-cons-abroad');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.dataset.tab;
                tabBtns.forEach(b => {
                    b.classList.remove('active-cons-tab');
                    b.classList.add('text-slate-600');
                });
                btn.classList.add('active-cons-tab');
                btn.classList.remove('text-slate-600');

                if (targetTab === 'study_abroad') {
                    panelGeneral?.classList.add('hidden');
                    panelAbroad?.classList.remove('hidden');
                } else {
                    panelGeneral?.classList.remove('hidden');
                    panelAbroad?.classList.add('hidden');
                }
            });
        });
    });
</script>

<style>
    .active-cons-tab {
        background-color: #fe0002 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(254, 0, 2, 0.25);
    }
</style>
@endsection
