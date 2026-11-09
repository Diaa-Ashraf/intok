<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', 'min:10', 'required_with:current_password'],
        ], ['required' => 'حقل :attribute مطلوب.', 'required_with' => 'أدخل كلمة المرور الحالية لتغيير كلمة المرور.', 'email' => 'يرجى إدخال بريد صحيح.', 'unique' => 'هذا البريد مستخدم بالفعل.', 'current_password' => 'كلمة المرور الحالية غير صحيحة.', 'confirmed' => 'تأكيد كلمة المرور غير متطابق.', 'min' => 'يجب أن تتكون كلمة المرور من 10 أحرف على الأقل.']);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('status', 'تم تحديث بيانات الحساب.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']], ['required' => 'كلمة المرور مطلوبة.', 'current_password' => 'كلمة المرور غير صحيحة.']);
        $user = $request->user();

        if ($user->email === 'admin@intok.com' || $user->id === 1) {
            return back()->withErrors(['password' => 'لا يمكن حذف حساب المدير العام الأساسي للنظام.']);
        }

        auth()->logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home', ['locale' => 'ar'])->with('status', 'تم حذف الحساب.');
    }
}
