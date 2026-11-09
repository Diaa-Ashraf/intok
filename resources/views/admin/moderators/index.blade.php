@extends('layouts.admin')

@section('title', 'إدارة المشرفين والمديرين')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-4">
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.dashboard') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع</span>
        </button>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-black text-slate-900">إدارة المشرفين والمديرين</h1>
            <p class="mt-2 text-slate-600">يمكنك هنا إضافة مشرفين جدد للوحة الإدارة أو تعديل صلاحياتهم، وضمان عدم دخول أي شخص غير مصرح له.</p>
        </div>
        <a href="{{ route('admin.moderators.create') }}" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-5 py-3 font-bold text-white shadow-xs hover:bg-red-700 transition">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>إضافة مشرف جديد</span>
        </a>
    </div>

    @if (session('status'))
        <div role="status" class="mt-5 rounded-xl bg-green-50 p-4 text-green-800 border border-green-200 font-semibold flex items-center gap-2">
            <svg class="size-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-5 rounded-xl bg-red-50 p-4 text-red-800 border border-red-200 font-semibold">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="mt-7 overflow-x-auto rounded-2xl bg-white p-4 shadow-sm border border-slate-200">
        <table class="w-full min-w-[700px] text-right text-sm">
            <thead>
                <tr class="border-b text-slate-500 font-bold">
                    <th class="p-3.5">الاسم</th>
                    <th class="p-3.5">البريد الإلكتروني</th>
                    <th class="p-3.5">الصلاحية / الدور</th>
                    <th class="p-3.5">تاريخ الإضافة</th>
                    <th class="p-3.5 text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($moderators as $moderator)
                    @php
                        $roleName = $moderator->roles->first()?->name ?? 'Editor';
                        $isAdmin = $roleName === 'Admin';
                        $isCurrent = $moderator->id === auth()->id();
                        $isSuperAdmin = $moderator->email === 'admin@intok.com' || $moderator->id === 1;
                    @endphp
                    <tr class="border-b last:border-0 hover:bg-slate-50/70 transition">
                        <td class="p-3.5 font-bold text-slate-900 flex items-center gap-2">
                            <span class="grid size-9 place-items-center rounded-full bg-slate-100 text-slate-700 font-bold text-xs uppercase">
                                {{ mb_substr($moderator->name, 0, 1) }}
                            </span>
                            <div>
                                <span>{{ $moderator->name }}</span>
                                @if ($isCurrent)
                                    <span class="ms-1.5 rounded-full bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700 border border-blue-200">أنت</span>
                                @endif
                            </div>
                        </td>
                        <td class="p-3.5 text-slate-600 font-mono text-xs" dir="ltr">{{ $moderator->email }}</td>
                        <td class="p-3.5">
                            @if ($isAdmin)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700 border border-red-200">
                                    <span class="size-1.5 rounded-full bg-red-600"></span>
                                    <span>مدير عام (Admin)</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                    <span class="size-1.5 rounded-full bg-emerald-600"></span>
                                    <span>مشرف (Editor)</span>
                                </span>
                            @endif
                        </td>
                        <td class="p-3.5 text-slate-500 text-xs">{{ $moderator->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        <td class="p-3.5 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.moderators.edit', $moderator) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:border-red-300 hover:bg-red-50 hover:text-red-700 transition">
                                    تعديل
                                </a>
                                @if (! $isCurrent && ! $isSuperAdmin)
                                    <form method="POST" action="{{ route('admin.moderators.destroy', $moderator) }}" onsubmit="return confirm('هل أنت متأكد من حذف حساب هذا المشرف؟ لن يتمكن من دخول لوحة الإدارة بعد الآن.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-red-600 hover:border-red-300 hover:bg-red-50 transition">
                                            حذف
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500">لا يوجد مشرفون مسجلون حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $moderators->links() }}</div>
</div>
@endsection

