@extends('layouts.admin')

@section('title', 'الملف الشخصي والحساب')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8 sm:px-6">
    <div class="mb-4">
        <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.dashboard') }}'}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            <span>رجوع للوحة الإدارة</span>
        </button>
    </div>

    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-900">الملف الشخصي والحساب</h1>
        <p class="mt-1 text-sm text-slate-500">تحديث بيانات حساب الإدارة وكلمة المرور الخاصة بك.</p>
    </div>

    @if (session('status'))
        <div role="status" class="mb-6 rounded-xl bg-green-50 p-4 text-green-800 border border-green-200 font-semibold flex items-center gap-2">
            <svg class="size-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6 rounded-2xl bg-white p-6 shadow-sm border border-slate-200 sm:p-8">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-2 block text-sm font-bold text-slate-700">الاسم</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-bold text-slate-700">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-slate-100">
            <h2 class="text-base font-bold text-slate-900 mb-1">تغيير كلمة المرور</h2>
            <p class="text-xs text-slate-500 mb-4">اترك الحقول أدناه فارغة إذا كنت لا ترغب بتغيير كلمة المرور الحالية.</p>

            <div class="space-y-4">
                <div>
                    <label for="current_password" class="mb-2 block text-sm font-semibold text-slate-700">كلمة المرور الحالية</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">كلمة المرور الجديدة</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">تأكيد كلمة المرور الجديدة</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="rounded-xl bg-red-600 px-6 py-3 font-bold text-white shadow-xs hover:bg-red-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
