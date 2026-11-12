@php
    $service = $service ?? null;
    $editing = isset($service) && $service?->exists;
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('admin.services.update', $service) : route('admin.services.store') }}" class="space-y-8" id="service-form">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <!-- Global Error Alert -->
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
            <div class="flex items-center gap-2 font-black text-sm">
                <svg class="size-5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>يرجى مراجعة الحقول التالية وتصحيح الأخطاء:</span>
            </div>
            <ul class="mt-2 list-disc list-inside text-xs space-y-1 text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Language Switcher Tabs -->
    <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-xs flex items-center gap-2" id="locale-tabs-bar">
        <button type="button" onclick="switchLocaleTab('ar')" id="tab-btn-ar" class="tab-btn flex-1 rounded-xl px-4 py-2.5 text-center text-sm font-black transition bg-red-600 text-white shadow-xs">
            🇪🇬 اللغة العربية (الأساسية)
        </button>
        <button type="button" onclick="switchLocaleTab('en')" id="tab-btn-en" class="tab-btn flex-1 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
            🇬🇧 English (اختياري)
        </button>
        <button type="button" onclick="switchLocaleTab('it')" id="tab-btn-it" class="tab-btn flex-1 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
            🇮🇹 Italiano (اختياري)
        </button>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'it' => 'Italiano'] as $loc => $locLabel)
        <div id="locale-panel-{{ $loc }}" class="locale-panel {{ $loc === 'ar' ? '' : 'hidden' }} space-y-8" dir="{{ $loc === 'ar' ? 'rtl' : 'ltr' }}">
            
            <!-- Section 1: Main Basic Details -->
            <section class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-4 mb-6">
                    <span class="grid size-8 place-items-center rounded-xl bg-red-50 text-red-600 font-black text-sm">1</span>
                    <h2 class="text-lg font-black text-slate-900">
                        {{ $loc === 'ar' ? 'البيانات الأساسية للخدمة' : ($loc === 'en' ? 'Core Service Information' : 'Informazioni Principali') }}
                    </h2>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="title-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'عنوان الخدمة / المسار' : 'Service Title' }}
                            @if($loc === 'ar') <span class="text-red-600">*</span> @endif
                        </label>
                        <input type="text" id="title-{{ $loc }}" name="title[{{ $loc }}]" value="{{ old('title.'.$loc, $service?->title[$loc] ?? '') }}" {{ $loc === 'ar' ? 'required' : '' }} placeholder="{{ $loc === 'ar' ? 'مثال: تدريب الكول سنتر الاحترافي' : 'e.g. Professional Call Center Training' }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition">
                        @error('title.'.$loc) <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'الرابط المختصر (Slug)' : 'URL Slug' }}
                            @if($loc === 'ar') <span class="text-red-600">*</span> @endif
                        </label>
                        <input type="text" id="slug-{{ $loc }}" name="slug[{{ $loc }}]" value="{{ old('slug.'.$loc, $service?->slug[$loc] ?? ($loc === 'ar' ? $service?->slug_ar : ($loc === 'en' ? $service?->slug_en : $service?->slug_it))) }}" placeholder="{{ $loc === 'ar' ? 'call-center-training (يترك فارغاً للإنشاء التلقائي)' : 'call-center-training' }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition">
                        @error('slug.'.$loc) <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="summary-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'الملخص التعريفي المختصر (يظهر في كروت الموقع والبحث)' : 'Short Summary' }}
                            @if($loc === 'ar') <span class="text-red-600">*</span> @endif
                        </label>
                        <textarea id="summary-{{ $loc }}" name="summary[{{ $loc }}]" rows="2" {{ $loc === 'ar' ? 'required' : '' }} placeholder="{{ $loc === 'ar' ? 'برنامج تدريبي يؤهلك للعمل في الكول سنتر باحتراف، مع تطوير مهارات التواصل وخدمة العملاء...' : 'Brief summary of the program...' }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition">{{ old('summary.'.$loc, $service?->summary[$loc] ?? '') }}</textarea>
                        @error('summary.'.$loc) <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'الوصف الكامل والتفصيلي للخدمة' : 'Full Detailed Description' }}
                            @if($loc === 'ar') <span class="text-red-600">*</span> @endif
                        </label>
                        <textarea id="description-{{ $loc }}" name="description[{{ $loc }}]" rows="4" {{ $loc === 'ar' ? 'required' : '' }} placeholder="{{ $loc === 'ar' ? 'اكتب شرحاً متكاملاً عن المسار التدريبي ومحتواه...' : 'Full comprehensive program description...' }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition">{{ old('description.'.$loc, $service?->description[$loc] ?? '') }}</textarea>
                        @error('description.'.$loc) <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <!-- Section 2: Interactive Showcase Card Metadata -->
            <section class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-4 mb-6">
                    <span class="grid size-8 place-items-center rounded-xl bg-amber-50 text-amber-700 font-black text-sm">2</span>
                    <div>
                        <h2 class="text-lg font-black text-slate-900">
                            {{ $loc === 'ar' ? 'بيانات الشارة والعرض التفاعلي في الرئيسية' : 'Interactive Showcase Card Metadata' }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ $loc === 'ar' ? 'تتحكم هذه الحقول بالبطاقات والأشرطة التفاعلية في الصفحة الرئيسية وصفحة الخدمات.' : 'These fields power the live interactive tracks and filters.' }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label for="badge-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'الشارة الترويجية (Badge)' : 'Promotional Badge' }}
                        </label>
                        <input type="text" id="badge-{{ $loc }}" name="badge[{{ $loc }}]" value="{{ old('badge.'.$loc, $service?->badge[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: الأكثر طلباً / منحة 8,000€' : 'e.g. Most Popular' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="cat-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'تصنيف المسار (Category)' : 'Category Label' }}
                        </label>
                        <input type="text" id="cat-{{ $loc }}" name="category_label[{{ $loc }}]" value="{{ old('category_label.'.$loc, $service?->category_label[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: تأهيل لسوق العمل والكول سنتر' : 'e.g. Career & Call Center' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="level-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'المستوى والمؤهل المطلوب' : 'Level / Target Qualification' }}
                        </label>
                        <input type="text" id="level-{{ $loc }}" name="level[{{ $loc }}]" value="{{ old('level.'.$loc, $service?->level[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: تأهيل وظيفي مباشر لكبرى الشركات' : 'e.g. Direct Career Qualification' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="dur-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'المدة التدريبية' : 'Duration' }}
                        </label>
                        <input type="text" id="dur-{{ $loc }}" name="duration[{{ $loc }}]" value="{{ old('duration.'.$loc, $service?->duration[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: مكثف (4 - 6 أسابيع)' : 'e.g. Intensive (4-6 weeks)' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="mode-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'نظام الحضور والقاعات' : 'Training Mode' }}
                        </label>
                        <input type="text" id="mode-{{ $loc }}" name="mode[{{ $loc }}]" value="{{ old('mode.'.$loc, $service?->mode[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: قاعات مجهزة + أونلاين تفاعلي' : 'e.g. Smart Classrooms + Online' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="sal-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'العائد المالي / الراتب المتوقع' : 'Financial Return / Expected Salary' }}
                        </label>
                        <input type="text" id="sal-{{ $loc }}" name="salary_range[{{ $loc }}]" value="{{ old('salary_range.'.$loc, $service?->salary_range[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: 15,000 - 30,000+ ج.م شهرياً' : 'e.g. 15k - 30k+ EGP' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="target-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'الفئة المستهدفة' : 'Target Audience' }}
                        </label>
                        <input type="text" id="target-{{ $loc }}" name="target_audience[{{ $loc }}]" value="{{ old('target_audience.'.$loc, $service?->target_audience[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مثال: الطلاب والخريجون والأفراد والشركات' : 'e.g. Students, graduates, individuals' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-3">
                        <label for="wa-{{ $loc }}" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'رسالة الواتساب الجاهزة عند النقر على الحجز' : 'Pre-filled WhatsApp Message' }}
                        </label>
                        <input type="text" id="wa-{{ $loc }}" name="whatsapp_message[{{ $loc }}]" value="{{ old('whatsapp_message.'.$loc, $service?->whatsapp_message[$loc] ?? '') }}" placeholder="{{ $loc === 'ar' ? 'مرحباً، أود الاستفسار والتسجيل في هذا المسار التدريبي' : 'Hello, I want to inquire about this training track' }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>
                </div>
            </section>

            <!-- Section 3: Points, Features, FAQs -->
            <section class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-4 mb-6">
                    <span class="grid size-8 place-items-center rounded-xl bg-blue-50 text-blue-700 font-black text-sm">3</span>
                    <h2 class="text-lg font-black text-slate-900">
                        {{ $loc === 'ar' ? 'المخرجات والمميزات والأسئلة الشائعة' : 'Features, Requirements & FAQs' }}
                    </h2>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'أبرز مميزات ومخرجات المسار (ميزة في كل سطر)' : 'Key Outcomes & Features (one per line)' }}
                        </label>
                        <textarea name="features_text[{{ $loc }}]" rows="5" placeholder="{{ $loc === 'ar' ? "محاكاة حقيقية لمقابلات كبرى الشركات\nتدريب عملي تفاعلي على الشاشات الذكية\nتأهيل للعمل برواتب مجزية" : "Feature 1\nFeature 2" }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-xs sm:text-sm focus:border-red-500 focus:outline-none font-mono leading-relaxed">{{ old('features_text.'.$loc, implode("\n", $service?->features[$loc] ?? [])) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'شروط ومتطلبات الالتحاق (متطلب في كل سطر)' : 'Admission Requirements (one per line)' }}
                        </label>
                        <textarea name="requirements_text[{{ $loc }}]" rows="5" placeholder="{{ $loc === 'ar' ? "الرغبة الجادة في التعلم\nالتزام بحضور الورش العملية" : "Requirement 1\nRequirement 2" }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-xs sm:text-sm focus:border-red-500 focus:outline-none font-mono leading-relaxed">{{ old('requirements_text.'.$loc, implode("\n", $service?->requirements[$loc] ?? [])) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'خطوات الالتحاق والتسجيل (خطوة في كل سطر)' : 'Registration Steps (one per line)' }}
                        </label>
                        <textarea name="steps_text[{{ $loc }}]" rows="4" placeholder="{{ $loc === 'ar' ? "تحديد المستوى مجاناً\nحضور ورش التدريب العملي\nالتعاقد واستلام الشهادة" : "Step 1\nStep 2" }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-xs sm:text-sm focus:border-red-500 focus:outline-none font-mono leading-relaxed">{{ old('steps_text.'.$loc, implode("\n", $service?->steps[$loc] ?? [])) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'الأسئلة الشائعة (سؤال | جواب في كل سطر)' : 'FAQs (Question | Answer per line)' }}
                        </label>
                        <textarea name="faqs_text[{{ $loc }}]" rows="4" placeholder="{{ $loc === 'ar' ? "هل يشترط مؤهل معين؟ | البرنامج متاح لجميع المؤهلات\nما هي الرواتب المتوقعة؟ | تبدأ من 15 ألف وحتى 30 ألف" : "Question? | Answer here" }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-xs sm:text-sm focus:border-red-500 focus:outline-none font-mono leading-relaxed">{{ old('faqs_text.'.$loc, collect($service?->faqs[$loc] ?? [])->map(fn ($faq) => ($faq['question'] ?? '').' | '.($faq['answer'] ?? ''))->implode("\n")) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'عنوان مخصص للـ SEO (محركات البحث)' : 'SEO Title' }}
                        </label>
                        <input type="text" name="seo_title[{{ $loc }}]" value="{{ old('seo_title.'.$loc, $service?->seo_title[$loc] ?? '') }}" maxlength="70" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-700 uppercase">
                            {{ $loc === 'ar' ? 'وصف مخصص للـ SEO (محركات البحث)' : 'SEO Description' }}
                        </label>
                        <input type="text" name="seo_description[{{ $loc }}]" value="{{ old('seo_description.'.$loc, $service?->seo_description[$loc] ?? '') }}" maxlength="180" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>
                </div>
            </section>
        </div>
    @endforeach

    <!-- Section 4: Global Settings (Order, Image, Active Status) -->
    <section class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
        <div class="flex items-center gap-2 border-b border-slate-100 pb-4 mb-6">
            <span class="grid size-8 place-items-center rounded-xl bg-purple-50 text-purple-700 font-black text-sm">4</span>
            <h2 class="text-lg font-black text-slate-900">إعدادات الظهور، الترتيب، والصورة الرسمية</h2>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 items-start">
            <div>
                <label for="sort_order" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                    ترتيب ظهور الخدمة (رقم 1 يظهر أولاً)
                </label>
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $service?->sort_order ?? 1) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-mono font-bold focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                <p class="mt-1 text-xs text-slate-400">تُرتّب الخدمات في الموقع تصاعدياً حسب هذا الرقم.</p>
            </div>

            <div>
                <label class="mb-2 block text-xs font-black text-slate-700 uppercase">حالة نشر الخدمة</label>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3.5 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-sm text-slate-800">تفعيل الخدمة</div>
                        <div class="text-xs text-slate-500">تظهر للزوار في الرئيسية وصفحة الخدمات</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $service?->is_active ?? true)) class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                    </label>
                </div>
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <label for="image" class="mb-2 block text-xs font-black text-slate-700 uppercase">
                    صورة الغلاف الرسمية للمسار (اختياري، JPG/PNG/WebP حتى 5 ميجابايت)
                </label>
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm file:me-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    @if($editing && $service?->image_path)
                        <div class="shrink-0 flex items-center gap-3 rounded-2xl border border-slate-200 p-2 bg-slate-50">
                            <img src="{{ asset('storage/'.$service->image_path) }}" alt="الصورة الحالية" class="size-16 rounded-xl object-cover">
                            <div class="text-xs text-slate-500 font-bold">الصورة الحالية مستخدمة</div>
                        </div>
                    @endif
                </div>
                @error('image')
                    <p class="mt-2 text-xs text-red-600 font-bold">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <!-- Form Submit / Cancel Actions -->
    <div class="flex flex-wrap items-center gap-3 pt-4">
        <button type="submit" class="rounded-full bg-red-600 px-8 py-3.5 text-sm font-black text-white shadow-lg shadow-red-600/30 hover:bg-red-700 hover:scale-105 transition transform flex items-center gap-2">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ $editing ? 'حفظ كافة التعديلات' : 'إضافة ونشر الخدمة الآن' }}</span>
        </button>
        <a href="{{ route('admin.services.index') }}" class="rounded-full border border-slate-300 bg-white px-7 py-3.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
            إلغاء والعودة
        </a>
    </div>
</form>

<script>
    function switchLocaleTab(locale) {
        document.querySelectorAll('.locale-panel').forEach(function(panel) {
            panel.classList.add('hidden');
        });
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.classList.remove('bg-red-600', 'text-white', 'shadow-xs');
            btn.classList.add('text-slate-600');
        });

        var activePanel = document.getElementById('locale-panel-' + locale);
        if (activePanel) {
            activePanel.classList.remove('hidden');
        }

        var activeBtn = document.getElementById('tab-btn-' + locale);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600');
            activeBtn.classList.add('bg-red-600', 'text-white', 'shadow-xs');
        }
    }
</script>
