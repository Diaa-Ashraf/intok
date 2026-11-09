@extends('layouts.admin')

@section('title', 'تعديل بيانات المشرف')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-4">
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.moderators.index') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للمشرفين</span>
        </button>
    </div>

    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-900">تعديل بيانات المشرف: {{ $moderator->name }}</h1>
        <p class="mt-2 text-slate-600">يمكنك تعديل الاسم، البريد الإلكتروني، كلمة المرور، أو تغيير الصلاحية.</p>
    </div>

    @include('admin.moderators._form', ['moderator' => $moderator])
</div>
@endsection

