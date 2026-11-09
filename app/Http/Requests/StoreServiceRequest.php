<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Service;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $service = $this->route('service');
        $ignoreId = $service instanceof Service ? $service->getKey() : null;
        $uniqueSlug = static fn (string $column) => Rule::unique('services', $column)->ignore($ignoreId);

        return [
            'slug' => ['required', 'array'], 'slug.ar' => ['required', 'string', 'max:160', $uniqueSlug('slug_ar')],
            'slug.en' => ['required', 'string', 'max:160', $uniqueSlug('slug_en')], 'slug.it' => ['required', 'string', 'max:160', $uniqueSlug('slug_it')],
            'title' => ['required', 'array'], 'title.ar' => ['required', 'string', 'max:160'],
            'title.en' => ['required', 'string', 'max:160'], 'title.it' => ['required', 'string', 'max:160'],
            'summary' => ['required', 'array'], 'summary.ar' => ['required', 'string', 'max:500'],
            'summary.en' => ['required', 'string', 'max:500'], 'summary.it' => ['required', 'string', 'max:500'],
            'description' => ['required', 'array'], 'description.ar' => ['required', 'string'],
            'description.en' => ['required', 'string'], 'description.it' => ['required', 'string'],
            'features_text' => ['nullable', 'array'], 'features_text.*' => ['nullable', 'string', 'max:3000'],
            'requirements_text' => ['nullable', 'array'], 'requirements_text.*' => ['nullable', 'string', 'max:3000'],
            'steps_text' => ['nullable', 'array'], 'steps_text.*' => ['nullable', 'string', 'max:3000'],
            'faqs_text' => ['nullable', 'array'], 'faqs_text.*' => ['nullable', 'string', 'max:5000'],
            'seo_title' => ['nullable', 'array'], 'seo_title.*' => ['nullable', 'string', 'max:70'],
            'seo_description' => ['nullable', 'array'], 'seo_description.*' => ['nullable', 'string', 'max:180'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'sort_order' => ['sometimes', 'integer', 'min:0'], 'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return ['required' => 'حقل :attribute مطلوب.', 'array' => 'يجب أن يكون :attribute صحيحًا.', 'string' => 'يجب أن يكون :attribute نصًا.', 'max' => 'يجب ألا يتجاوز :attribute الحد المسموح.', 'unique' => 'هذا الرابط مستخدم من قبل.', 'image' => 'يجب رفع ملف صورة صحيح.', 'mimes' => 'امتداد الصورة غير مدعوم.', 'integer' => 'يجب أن يكون :attribute رقمًا صحيحًا.', 'min' => 'يجب ألا يقل :attribute عن :min.', 'boolean' => 'قيمة :attribute غير صحيحة.'];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return ['slug' => 'الرابط المختصر', 'title' => 'العنوان', 'summary' => 'الملخص', 'description' => 'الوصف', 'sort_order' => 'ترتيب العرض', 'is_active' => 'حالة الخدمة'];
    }
}
