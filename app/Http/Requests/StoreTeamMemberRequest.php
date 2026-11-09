<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Admin') === true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'array'], 'name.ar' => ['required', 'string', 'max:160'], 'name.en' => ['required', 'string', 'max:160'], 'name.it' => ['required', 'string', 'max:160'],
            'role' => ['required', 'array'], 'role.ar' => ['required', 'string', 'max:160'], 'role.en' => ['required', 'string', 'max:160'], 'role.it' => ['required', 'string', 'max:160'],
            'bio' => ['nullable', 'array'], 'bio.ar' => ['nullable', 'string', 'max:3000'], 'bio.en' => ['nullable', 'string', 'max:3000'], 'bio.it' => ['nullable', 'string', 'max:3000'],
            'social_links' => ['nullable', 'array'], 'social_links.*' => ['nullable', 'url', 'max:255'],
            'photo_path' => ['prohibited'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'sort_order' => ['sometimes', 'integer', 'min:0'], 'is_active' => ['sometimes', 'boolean'],
            'linkedin' => ['nullable', 'url', 'max:255'], 'instagram' => ['nullable', 'url', 'max:255'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array { return ['required' => 'حقل :attribute مطلوب.', 'string' => 'يجب أن يكون :attribute نصًا.', 'max' => 'تجاوز :attribute الحد المسموح.', 'url' => 'أدخل رابطًا صحيحًا.', 'prohibited' => 'قيمة صورة العضو غير صالحة.', 'integer' => 'يجب أن يكون :attribute رقمًا صحيحًا.', 'min' => 'قيمة :attribute أقل من الحد المسموح.']; }

    /** @return array<string, string> */
    public function attributes(): array { return ['name' => 'الاسم', 'role' => 'المسمى الوظيفي', 'bio' => 'النبذة', 'social_links' => 'روابط التواصل', 'sort_order' => 'ترتيب العرض']; }
}
