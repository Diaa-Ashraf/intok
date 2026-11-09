@extends('layouts.admin')

@section('title', 'إدارة الخدمات')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-4">
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.dashboard') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للوحة الإدارة</span>
        </button>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900">إدارة الخدمات والمسارات التدريبية</h1>
            <p class="mt-1 text-sm text-slate-500">تحكم بالخدمات المنشورة وتعديل بياناتها وترتيب ظهورها على الموقع.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-5 py-2.5 font-bold text-white shadow-xs hover:bg-red-700 transition">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>إضافة خدمة جديدة</span>
        </a>
    </div>

    @if (session('status'))
        <div role="status" class="mt-6 rounded-xl bg-green-50 p-4 text-green-800 border border-green-200 font-semibold flex items-center gap-2">
            <svg class="size-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <section class="mt-7 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-right text-sm">
                <thead>
                    <tr class="border-b text-slate-500 font-bold">
                        <th class="px-3 py-3">الخدمة</th>
                        <th class="px-3 py-3">الرابط العربي</th>
                        <th class="px-3 py-3 text-center">الترتيب</th>
                        <th class="px-3 py-3 text-center">الحالة</th>
                        <th class="px-3 py-3 text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr class="border-b last:border-0 hover:bg-slate-50/70 transition">
                            <td class="px-3 py-4 font-bold text-slate-900">{{ $service->title['ar'] ?? '—' }}</td>
                            <td class="px-3 py-4 text-slate-600 font-mono text-xs" dir="ltr">{{ $service->slug_ar ?? '—' }}</td>
                            <td class="px-3 py-4 text-center font-bold text-slate-700">{{ $service->sort_order }}</td>
                            <td class="px-3 py-4 text-center">
                                @if ($service->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="size-1.5 rounded-full bg-emerald-600"></span>
                                        <span>نشطة</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 border border-slate-200">
                                        <span>متوقفة</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-red-600 hover:border-red-300 hover:bg-red-50 transition" href="{{ route('admin.services.edit', $service) }}">
                                        تعديل
                                    </a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('هل تريد حذف هذه الخدمة؟')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-500 hover:border-red-300 hover:bg-red-50 hover:text-red-700 transition">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-8 text-center text-slate-500">لا توجد خدمات مضافة بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $services->links() }}</div>
    </section>
</div>
@endsection
