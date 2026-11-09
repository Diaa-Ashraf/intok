<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة الإدارة') | INTOK Academy</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=2">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/intok-logo.jpg') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=2">
    @include('components.assets')
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased font-sans">
    <header class="border-b border-slate-200 bg-white sticky top-0 z-40 shadow-xs">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
            <!-- Left: Back Button & Logo -->
            <div class="flex items-center gap-3">
                <button type="button" onclick="if(window.history.length > 1){window.history.back()}else{window.location.href='{{ route('admin.dashboard') }}'}" class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-700 shadow-xs hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition" title="رجوع للصفحة السابقة">
                    <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    <span>رجوع</span>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('assets/images/intok-logo.jpg') }}" alt="INTOK Logo" class="size-8 rounded-full border border-slate-200 object-cover shadow-xs group-hover:scale-105 transition">
                    <span class="text-lg font-black text-red-600">INTOK <span class="text-sm font-semibold text-slate-500">لوحة الإدارة</span></span>
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button type="button" onclick="document.getElementById('admin-mobile-nav').classList.toggle('hidden')" class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 focus:outline-none" aria-label="تبديل القائمة">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>

            <!-- Desktop Navigation -->
            <nav aria-label="التنقل الإداري" class="hidden lg:flex flex-wrap items-center gap-1 text-sm font-semibold">
                <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.dashboard') }}">الرئيسية</a>
                <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.inquiries.index') }}">الاستفسارات</a>
                <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.bookings.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.bookings.index') }}">الحجوزات</a>
                <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.registrations.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.registrations.index') }}">التسجيلات</a>
                
                @if (auth()->user()?->hasRole('Admin'))
                    <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.services.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.services.index') }}">الخدمات</a>
                    <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.team.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.team.index') }}">الفريق</a>
                    <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.pages.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.pages.index') }}">الصفحات</a>
                    <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.testimonials.index') }}">قصص النجاح</a>
                    <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.moderators.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.moderators.index') }}">المشرفين</a>
                    <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.settings.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.settings.edit') }}">الإعدادات</a>
                @endif
                
                <a class="rounded-xl px-2.5 py-1.5 transition {{ request()->routeIs('admin.profile.*') ? 'bg-red-50 text-red-700 font-bold' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.profile.edit') }}">الحساب</a>
                <a class="rounded-xl border border-slate-200 px-2.5 py-1.5 text-xs text-slate-600 hover:bg-slate-100 transition" href="{{ route('home', ['locale' => 'ar']) }}" target="_blank">الموقع ↗</a>
                
                <form method="POST" action="{{ route('admin.logout') }}" class="ms-1">
                    @csrf
                    <button type="submit" class="rounded-xl bg-slate-900 px-3.5 py-1.5 text-xs font-bold text-white hover:bg-slate-800 transition">خروج</button>
                </form>
            </nav>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="admin-mobile-nav" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 py-3 space-y-1">
            <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.dashboard') }}">الرئيسية</a>
            <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.inquiries.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.inquiries.index') }}">الاستفسارات</a>
            <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.bookings.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.bookings.index') }}">حجوزات الاستشارات</a>
            <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.registrations.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.registrations.index') }}">تسجيلات العملاء</a>
            
            @if (auth()->user()?->hasRole('Admin'))
                <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.services.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.services.index') }}">إدارة الخدمات</a>
                <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.team.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.team.index') }}">إدارة الفريق</a>
                <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.pages.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.pages.index') }}">إدارة الصفحات</a>
                <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.testimonials.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.testimonials.index') }}">قصص النجاح</a>
                <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.moderators.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.moderators.index') }}">إدارة المشرفين</a>
                <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.settings.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.settings.edit') }}">إعدادات الموقع</a>
            @endif
            
            <a class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.profile.*') ? 'bg-red-50 text-red-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('admin.profile.edit') }}">الملف الشخصي والحساب</a>
            <a class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50" href="{{ route('home', ['locale' => 'ar']) }}" target="_blank">زيارة الموقع العام ↗</a>
            
            <div class="pt-2 border-t border-slate-100">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right rounded-xl px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-50">تسجيل الخروج</button>
                </form>
            </div>
        </div>
    </header>
    <main>@yield('content')</main>
</body>
</html>
