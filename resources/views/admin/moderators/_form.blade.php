@php
    $isEdit = isset($moderator);
    $currentRole = old('role', $isEdit ? $moderator->roles->first()?->name : 'Editor');
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.moderators.update', $moderator) : route('admin.moderators.store') }}" class="mt-6 space-y-6 rounded-2xl bg-white p-6 shadow-sm sm:p-8">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="mb-2 block text-sm font-bold text-slate-700">اسم المشرف / المدير <span class="text-red-600">*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name', $moderator->name ?? '') }}" required placeholder="مثال: أحمد محمود" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-bold text-slate-700">البريد الإلكتروني للدخول <span class="text-red-600">*</span></label>
        <input id="email" name="email" type="email" value="{{ old('email', $moderator->email ?? '') }}" required placeholder="moderator@intok.com" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="role" class="mb-2 block text-sm font-bold text-slate-700">الدور والصلاحية <span class="text-red-600">*</span></label>
        <select id="role" name="role" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
            <option value="Editor" @selected($currentRole === 'Editor')>مشرف (إدارة الاستفسارات والحجوزات والتسجيلات وخدمات الموقع)</option>
            <option value="Admin" @selected($currentRole === 'Admin')>مدير عام (صلاحيات كاملة تشمل إدارة المشرفين وإعدادات الموقع)</option>
        </select>
        <p class="mt-1 text-xs text-slate-500">المشرف يمكنه متابعة العملاء والطلبات والتواصل، بينما المدير العام يمتلك حق إدارة إعدادات الموقع وإضافة المشرفين.</p>
        @error('role')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="password" class="mb-2 block text-sm font-bold text-slate-700">
                كلمة المرور
                @if ($isEdit)
                    <span class="text-xs font-normal text-slate-500">(اتركها فارغة إذا كنت لا تريد تغييرها)</span>
                @else
                    <span class="text-red-600">*</span>
                @endif
            </label>
            <input id="password" name="password" type="password" {{ $isEdit ? '' : 'required' }} minlength="8" placeholder="8 أحرف على الأقل" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">تأكيد كلمة المرور</label>
            <input id="password_confirmation" name="password_confirmation" type="password" {{ $isEdit ? '' : 'required' }} minlength="8" placeholder="أعد كتابة كلمة المرور" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" dir="ltr">
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <a href="{{ route('admin.moderators.index') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">إلغاء</a>
        <button type="submit" class="rounded-xl bg-red-600 px-6 py-2.5 text-sm font-bold text-white shadow-xs hover:bg-red-700 transition">
            {{ $isEdit ? 'حفظ التعديلات' : 'إضافة المشرف' }}
        </button>
    </div>
</form>

