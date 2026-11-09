<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    /** @return array<string, mixed> */
    public function rules(): array { return ['token' => ['required', 'string'], 'email' => ['required', 'email'], 'password' => ['required', 'confirmed', 'min:12']]; }
    /** @return array<string, string> */
    public function messages(): array { return ['required' => 'هذا الحقل مطلوب.', 'email' => 'يرجى إدخال بريد إلكتروني صحيح.', 'confirmed' => 'تأكيد كلمة المرور غير متطابق.', 'min' => 'يجب أن تتكون كلمة المرور من 12 حرفًا على الأقل.']; }
    /** @return array<string, string> */
    public function attributes(): array { return ['token' => 'رمز الاستعادة', 'email' => 'البريد الإلكتروني', 'password' => 'كلمة المرور']; }
}
