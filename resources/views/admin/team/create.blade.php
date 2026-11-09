@extends('layouts.admin')

@section('title', 'إضافة عضو فريق')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
    <div class="mb-4">
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.team.index') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للفريق</span>
        </button>
    </div>

    <div class="mb-4">
        <h1 class="text-3xl font-black text-slate-900">إضافة عضو فريق جديد</h1>
        <p class="mt-1 text-sm text-slate-500">أدخل اسم العضو والمسمى الوظيفي والصورة وروابط التواصل.</p>
    </div>

    @include('admin.team._form')
</div>
@endsection
