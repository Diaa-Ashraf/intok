@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-4">
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.dashboard') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للوحة الإدارة</span>
        </button>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-black text-slate-900">{{ $title }}</h1>
            <p class="mt-1 text-sm text-slate-500">تابع الطلبات الواردة وحدّث حالة المتابعة وتفاصيل كل عميل.</p>
        </div>
        <a href="{{ route('admin.'.$kind.'.export') }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2.5 font-bold text-white shadow-xs hover:bg-slate-800 transition">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            <span>تصدير CSV</span>
        </a>
    </div>

    @if (session('status'))
        <div role="status" class="mt-5 rounded-xl bg-green-50 p-4 text-green-800 border border-green-200 font-semibold flex items-center gap-2">
            <svg class="size-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="GET" class="mt-6 flex flex-wrap gap-3 rounded-2xl bg-white p-4 shadow-sm border border-slate-200">
        <input name="search" value="{{ $filters['search'] ?? '' }}" placeholder="ابحث بالاسم أو الهاتف أو البريد..." class="min-w-60 flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
        <select name="status" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
            <option value="">كل الحالات</option>
            @foreach (['new'=>'جديد', 'contacted'=>'تم التواصل', 'closed'=>'مغلق'] as $value=>$label)
                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-xl bg-red-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-red-700 transition">تطبيق</button>
        <a href="{{ route('admin.'.$kind.'.index') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">إلغاء التصفية</a>
    </form>

    <section class="mt-6 space-y-4">
        @forelse ($records as $record)
            <article class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200 sm:p-6 transition hover:shadow-md">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-bold text-slate-900">{{ $record->name }}</h2>
                            @if ($record->status === 'new')
                                <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-600 border border-red-200">جديد</span>
                            @elseif ($record->status === 'contacted')
                                <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700 border border-amber-200">تم التواصل</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-600 border border-slate-200">مغلق</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-slate-600" dir="ltr">{{ $record->email ?? '—' }} · {{ $record->phone }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $record->created_at?->format('Y-m-d H:i') }} · اللغة: {{ strtoupper($kind === 'bookings' ? $record->language : $record->locale) }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.'.$kind.'.status', $record) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <label class="sr-only" for="status-{{ $kind }}-{{ $record->id }}">حالة الطلب</label>
                        <select id="status-{{ $kind }}-{{ $record->id }}" name="status" class="rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold focus:border-red-500 focus:outline-none">
                            @foreach (['new'=>'جديد', 'contacted'=>'تم التواصل', 'closed'=>'مغلق'] as $value=>$label)
                                <option value="{{ $value }}" @selected($record->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="rounded-xl bg-slate-900 px-3.5 py-1.5 text-xs font-bold text-white hover:bg-slate-800 transition">تحديث</button>
                    </form>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100">
                    @if ($kind === 'bookings')
                        <div class="grid gap-2 text-sm text-slate-700 sm:grid-cols-2 bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p><strong>الموعد المفضل:</strong> <span class="font-semibold text-slate-900">{{ $record->preferred_at?->format('Y-m-d H:i') ?? '—' }}</span></p>
                            <p><strong>الخدمة المطلوبة:</strong> <span class="font-semibold text-slate-900">{{ data_get($record->service?->title, app()->getLocale(), '—') }}</span></p>
                            @if ($record->notes)
                                <p class="whitespace-pre-line sm:col-span-2 pt-1 border-t border-slate-200"><strong>ملاحظات العميل:</strong> {{ $record->notes }}</p>
                            @endif
                        </div>
                    @else
                        <div class="grid gap-2 text-sm text-slate-700 sm:grid-cols-3 bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p><strong>الدولة:</strong> <span class="font-semibold text-slate-900">{{ $record->country ?: '—' }}</span></p>
                            <p><strong>المستوى التعليمي:</strong> <span class="font-semibold text-slate-900">{{ $record->education_level ?: '—' }}</span></p>
                            <p><strong>الخدمة / المسار:</strong> <span class="font-semibold text-slate-900">{{ data_get($record->service?->title, app()->getLocale(), '—') }}</span></p>
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-2xl bg-white p-10 text-center text-slate-500 border border-slate-200">لا توجد طلبات مطابقة حالياً.</div>
        @endforelse
    </section>

    <div class="mt-6">{{ $records->links() }}</div>
</div>
@endsection
