<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return ['email' => ['required', 'email'], 'password' => ['required', 'string']];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return ['required' => 'حقل :attribute مطلوب.', 'email' => 'يرجى إدخال بريد إلكتروني صحيح.'];
    }

    /** @return array<string, string> */
    public function attributes(): array { return ['email' => 'البريد الإلكتروني', 'password' => 'كلمة المرور']; }
}
