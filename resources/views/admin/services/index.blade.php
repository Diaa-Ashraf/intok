@extends('layouts.admin')

@section('title', 'إدارة الخدمات والمسارات التدريبية')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <!-- Back to Dashboard -->
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للوحة الإدارة</span>
        </a>
    </div>

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 flex items-center gap-2">
                <span>إدارة الخدمات والمسارات التدريبية</span>
                <span class="rounded-full bg-red-100 text-red-700 px-3 py-0.5 text-xs font-bold">{{ $totalCount }} خدمة</span>
            </h1>
            <p class="mt-1 text-sm text-slate-500">تحكم كامل في كافة برامج ومسارات الأكاديمية (الكول سنتر، الدراسة بإيطاليا، الترجمة، اللغات، والتأهيل).</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-xs hover:bg-slate-50 hover:border-slate-400 transition">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                <span>معاينة على الموقع</span>
            </a>
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-black text-white shadow-md hover:bg-red-700 transition">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>إضافة خدمة جديدة</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">إجمالي الخدمات المضافة</span>
                <span class="grid size-8 place-items-center rounded-lg bg-slate-100 text-slate-600 font-black text-xs">
                    #
                </span>
            </div>
            <div class="mt-2 text-3xl font-black text-slate-900">{{ $totalCount }}</div>
            <p class="mt-1 text-xs text-slate-400">تشمل المسارات والخدمات الأساسية</p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-700">الخدمات النشطة على الموقع</span>
                <span class="grid size-8 place-items-center rounded-lg bg-emerald-100 text-emerald-700 font-black text-xs">
                    ✓
                </span>
            </div>
            <div class="mt-2 text-3xl font-black text-emerald-900">{{ $activeCount }}</div>
            <p class="mt-1 text-xs text-emerald-600">تظهر في الصفحة الرئيسية وصفحة الخدمات</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">خدمات متوقفة / مخفية</span>
                <span class="grid size-8 place-items-center rounded-lg bg-amber-100 text-amber-700 font-black text-xs">
                    ⏸
                </span>
            </div>
            <div class="mt-2 text-3xl font-black text-slate-700">{{ $inactiveCount }}</div>
            <p class="mt-1 text-xs text-slate-400">مخفية من الموقع لحين إعادة التفعيل</p>
        </div>
    </div>

    <!-- Flash message -->
    @if (session('status'))
        <div role="status" class="mt-6 rounded-2xl bg-emerald-50 p-4 text-emerald-900 border border-emerald-200 font-bold flex items-center gap-3">
            <svg class="size-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- Services Table Section -->
    <section class="mt-6 rounded-3xl border border-slate-200 bg-white p-4 sm:p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-right text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-black uppercase text-slate-500">
                        <th class="px-4 py-3.5 text-center w-16">الترتيب</th>
                        <th class="px-4 py-3.5">الخدمة / المسار التدريبي</th>
                        <th class="px-4 py-3.5">التصنيف والشارة</th>
                        <th class="px-4 py-3.5">المستوى والمؤهل</th>
                        <th class="px-4 py-3.5 text-center">الحالة</th>
                        <th class="px-4 py-3.5 text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($services as $service)
                        <tr class="hover:bg-slate-50/80 transition group">
                            <!-- Sort order badge -->
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex size-7 items-center justify-center rounded-lg bg-slate-100 font-mono text-xs font-black text-slate-700">
                                    {{ $service->sort_order }}
                                </span>
                            </td>

                            <!-- Title & Image / Icon -->
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($service->image_path)
                                        <img src="{{ asset('storage/'.$service->image_path) }}" alt="{{ $service->title['ar'] ?? '' }}" class="size-12 shrink-0 rounded-xl object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="grid size-12 shrink-0 place-items-center rounded-xl bg-red-50 text-red-600 border border-red-200 font-black">
                                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-black text-slate-900 group-hover:text-red-600 transition text-base">
                                            {{ $service->title['ar'] ?? 'بدون عنوان' }}
                                        </div>
                                        <div class="text-xs text-slate-400 font-mono mt-0.5 truncate max-w-xs" dir="ltr">
                                            /services/{{ $service->slug_ar ?? $service->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category & Badge -->
                            <td class="px-4 py-4">
                                <div class="space-y-1">
                                    @if (!empty($service->badge['ar']))
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-black text-amber-800 border border-amber-200">
                                            {{ $service->badge['ar'] }}
                                        </span>
                                    @endif
                                    <div class="text-xs text-slate-500 font-bold">
                                        {{ $service->category_label['ar'] ?? 'مسار تدريبي معتمد' }}
                                    </div>
                                </div>
                            </td>

                            <!-- Level & Target -->
                            <td class="px-4 py-4">
                                <div class="text-xs font-bold text-slate-700 max-w-xs">
                                    {{ $service->level['ar'] ?? 'جميع المؤهلات' }}
                                </div>
                                @if (!empty($service->salary_range['ar']))
                                    <div class="text-[11px] text-emerald-600 font-bold mt-0.5">
                                        {{ $service->salary_range['ar'] }}
                                    </div>
                                @endif
                            </td>

                            <!-- Active toggle status -->
                            <td class="px-4 py-4 text-center">
                                <form method="POST" action="{{ route('admin.services.toggle', $service) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if ($service->is_active)
                                        <button type="submit" title="انقر لإيقاف الخدمة" class="cursor-pointer inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-black text-emerald-800 border border-emerald-300 hover:bg-emerald-200 transition">
                                            <span class="size-2 rounded-full bg-emerald-600 animate-pulse"></span>
                                            <span>نشطة ومفعلة</span>
                                        </button>
                                    @else
                                        <button type="submit" title="انقر لتفعيل الخدمة" class="cursor-pointer inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 border border-slate-300 hover:bg-slate-200 transition">
                                            <span class="size-2 rounded-full bg-slate-400"></span>
                                            <span>متوقفة (مخفية)</span>
                                        </button>
                                    @endif
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('services.show', ['locale' => 'ar', 'slug' => $service->slug_ar ?? $service->id]) }}" target="_blank" title="مشاهدة على الموقع" class="rounded-xl border border-slate-200 p-2 text-slate-600 hover:border-slate-300 hover:bg-slate-100 transition">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="rounded-xl border border-slate-200 px-3.5 py-1.5 text-xs font-black text-red-600 hover:border-red-300 hover:bg-red-50 transition flex items-center gap-1">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                        <span>تعديل</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة نهائياً؟')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-slate-200 p-2 text-slate-400 hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition" title="حذف الخدمة">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                                <div class="max-w-sm mx-auto">
                                    <div class="grid size-12 place-items-center rounded-2xl bg-slate-100 text-slate-400 mx-auto mb-3">
                                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800">لا توجد خدمات مضافة حالياً</h3>
                                    <p class="mt-1 text-xs text-slate-400">ابدأ بإضافة أول مسار تدريبي أو خدمة لظهورها في الموقع.</p>
                                    <a href="{{ route('admin.services.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700">
                                        <span>إضافة خدمة جديدة</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 border-t border-slate-100 pt-4">{{ $services->links() }}</div>
    </section>
</div>
@endsection
