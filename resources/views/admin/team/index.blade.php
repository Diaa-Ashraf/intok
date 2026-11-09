@extends('layouts.admin')

@section('title', 'إدارة الفريق')

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
            <h1 class="text-3xl font-black text-slate-900">إدارة فريق العمل</h1>
            <p class="mt-1 text-sm text-slate-500">إدارة المستشارين والخبراء والأكاديميين المعروضين في صفحة الفريق.</p>
        </div>
        <a href="{{ route('admin.team.create') }}" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-5 py-2.5 font-bold text-white shadow-xs hover:bg-red-700 transition">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>إضافة عضو جديد</span>
        </a>
    </div>

    @if (session('status'))
        <div role="status" class="mt-5 rounded-xl bg-green-50 p-4 text-green-800 border border-green-200 font-semibold flex items-center gap-2">
            <svg class="size-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="mt-7 overflow-x-auto rounded-2xl bg-white p-4 shadow-sm border border-slate-200">
        <table class="w-full min-w-[650px] text-right text-sm">
            <thead>
                <tr class="border-b text-slate-500 font-bold">
                    <th class="p-3.5">الاسم</th>
                    <th class="p-3.5">المسمى الوظيفي</th>
                    <th class="p-3.5 text-center">الترتيب</th>
                    <th class="p-3.5 text-center">الحالة</th>
                    <th class="p-3.5 text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="border-b last:border-0 hover:bg-slate-50/70 transition">
                        <td class="p-3.5 font-bold text-slate-900 flex items-center gap-3">
                            @if ($member->photo_path)
                                <img src="{{ asset('storage/'.$member->photo_path) }}" alt="" class="size-10 rounded-full object-cover border border-slate-200">
                            @else
                                <span class="grid size-10 place-items-center rounded-full bg-slate-100 text-slate-600 font-bold text-xs uppercase">
                                    {{ mb_substr($member->name['ar'] ?? 'IN', 0, 2) }}
                                </span>
                            @endif
                            <span>{{ $member->name['ar'] ?? '—' }}</span>
                        </td>
                        <td class="p-3.5 text-slate-600">{{ $member->role['ar'] ?? '—' }}</td>
                        <td class="p-3.5 text-center font-bold text-slate-700">{{ $member->sort_order }}</td>
                        <td class="p-3.5 text-center">
                            @if ($member->is_active)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                    <span class="size-1.5 rounded-full bg-emerald-600"></span>
                                    <span>نشط</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 border border-slate-200">
                                    <span>متوقف</span>
                                </span>
                            @endif
                        </td>
                        <td class="p-3.5 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-red-600 hover:border-red-300 hover:bg-red-50 transition" href="{{ route('admin.team.edit', $member) }}">
                                    تعديل
                                </a>
                                <form method="POST" action="{{ route('admin.team.destroy', $member) }}" onsubmit="return confirm('هل أنت متأكد من حذف عضو الفريق؟')" class="inline">
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
                        <td colspan="5" class="p-8 text-center text-slate-500">لا يوجد أعضاء فريق مسجلون حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $members->links() }}</div>
</div>
@endsection
