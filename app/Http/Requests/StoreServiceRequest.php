<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Service;
use Illuminate\Support\Str;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $slugs = $this->input('slug', []);
        if (is_array($slugs)) {
            if (empty($slugs['ar']) && !empty($this->input('title.ar'))) {
                $slugs['ar'] = Str::slug($this->input('title.ar'), '-', null);
            }
            if (empty($slugs['en'])) {
                $slugs['en'] = !empty($this->input('title.en'))
                    ? Str::slug($this->input('title.en'))
                    : (!empty($slugs['ar']) ? Str::slug($slugs['ar']) : 'service-'.time());
                if (empty($slugs['en'])) {
                    $slugs['en'] = 'service-'.time();
                }
            }
            if (empty($slugs['it'])) {
                $slugs['it'] = !empty($this->input('title.it'))
                    ? Str::slug($this->input('title.it'))
                    : $slugs['en'];
            }
            $this->merge(['slug' => $slugs]);
        }
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $service = $this->route('service');
        $ignoreId = $service instanceof Service ? $service->getKey() : null;
        $uniqueSlug = static fn (string $column) => Rule::unique('services', $column)->ignore($ignoreId);

        return [
            'slug' => ['required', 'array'],
            'slug.ar' => ['required', 'string', 'max:160', $uniqueSlug('slug_ar')],
            'slug.en' => ['nullable', 'string', 'max:160', $uniqueSlug('slug_en')],
            'slug.it' => ['nullable', 'string', 'max:160', $uniqueSlug('slug_it')],

            'title' => ['required', 'array'],
            'title.ar' => ['required', 'string', 'max:160'],
            'title.en' => ['nullable', 'string', 'max:160'],
            'title.it' => ['nullable', 'string', 'max:160'],

            'summary' => ['required', 'array'],
            'summary.ar' => ['required', 'string', 'max:1000'],
            'summary.en' => ['nullable', 'string', 'max:1000'],
            'summary.it' => ['nullable', 'string', 'max:1000'],

            'description' => ['required', 'array'],
            'description.ar' => ['required', 'string'],
            'description.en' => ['nullable', 'string'],
            'description.it' => ['nullable', 'string'],

            'badge' => ['nullable', 'array'],
            'badge.ar' => ['nullable', 'string', 'max:100'],
            'badge.en' => ['nullable', 'string', 'max:100'],
            'badge.it' => ['nullable', 'string', 'max:100'],

            'category_label' => ['nullable', 'array'],
            'category_label.ar' => ['nullable', 'string', 'max:100'],
            'category_label.en' => ['nullable', 'string', 'max:100'],
            'category_label.it' => ['nullable', 'string', 'max:100'],

            'level' => ['nullable', 'array'],
            'level.ar' => ['nullable', 'string', 'max:150'],
            'level.en' => ['nullable', 'string', 'max:150'],
            'level.it' => ['nullable', 'string', 'max:150'],

            'duration' => ['nullable', 'array'],
            'duration.ar' => ['nullable', 'string', 'max:100'],
            'duration.en' => ['nullable', 'string', 'max:100'],
            'duration.it' => ['nullable', 'string', 'max:100'],

            'mode' => ['nullable', 'array'],
            'mode.ar' => ['nullable', 'string', 'max:100'],
            'mode.en' => ['nullable', 'string', 'max:100'],
            'mode.it' => ['nullable', 'string', 'max:100'],

            'target_audience' => ['nullable', 'array'],
            'target_audience.ar' => ['nullable', 'string', 'max:255'],
            'target_audience.en' => ['nullable', 'string', 'max:255'],
            'target_audience.it' => ['nullable', 'string', 'max:255'],

            'salary_range' => ['nullable', 'array'],
            'salary_range.ar' => ['nullable', 'string', 'max:150'],
            'salary_range.en' => ['nullable', 'string', 'max:150'],
            'salary_range.it' => ['nullable', 'string', 'max:150'],

            'whatsapp_message' => ['nullable', 'array'],
            'whatsapp_message.ar' => ['nullable', 'string', 'max:255'],
            'whatsapp_message.en' => ['nullable', 'string', 'max:255'],
            'whatsapp_message.it' => ['nullable', 'string', 'max:255'],

            'features_text' => ['nullable', 'array'],
            'features_text.*' => ['nullable', 'string', 'max:5000'],

            'requirements_text' => ['nullable', 'array'],
            'requirements_text.*' => ['nullable', 'string', 'max:5000'],

            'steps_text' => ['nullable', 'array'],
            'steps_text.*' => ['nullable', 'string', 'max:5000'],

            'faqs_text' => ['nullable', 'array'],
            'faqs_text.*' => ['nullable', 'string', 'max:8000'],

            'seo_title' => ['nullable', 'array'],
            'seo_title.*' => ['nullable', 'string', 'max:100'],

            'seo_description' => ['nullable', 'array'],
            'seo_description.*' => ['nullable', 'string', 'max:255'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'title.ar.required' => 'عنوان الخدمة باللغة العربية مطلوب.',
            'summary.ar.required' => 'ملخص الخدمة باللغة العربية مطلوب.',
            'description.ar.required' => 'وصف الخدمة باللغة العربية مطلوب.',
            'slug.ar.required' => 'الرابط المختصر العربي مطلوب.',
            'array' => 'يجب أن يكون :attribute صحيحًا.',
            'string' => 'يجب أن يكون :attribute نصًا.',
            'max' => 'يجب ألا يتجاوز :attribute الحد المسموح.',
            'unique' => 'هذا الرابط مستخدم بالفعل لخدمة أخرى.',
            'image' => 'يجب رفع ملف صورة صالح.',
            'mimes' => 'امتداد الصورة يجب أن يكون jpg, jpeg, png, أو webp.',
            'integer' => 'يجب أن يكون :attribute رقمًا صحيحًا.',
            'min' => 'يجب ألا يقل :attribute عن :min.',
            'boolean' => 'قيمة :attribute غير صحيحة.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'slug' => 'الرابط المختصر',
            'slug.ar' => 'الرابط العربي',
            'title' => 'العنوان',
            'title.ar' => 'العنوان بالعربية',
            'summary' => 'الملخص',
            'summary.ar' => 'الملخص بالعربية',
            'description' => 'الوصف الكامل',
            'description.ar' => 'الوصف بالعربية',
            'badge' => 'الشارة الترويجية',
            'category_label' => 'تصنيف المسار',
            'level' => 'المستوى والمؤهل',
            'duration' => 'المدة التدريبية',
            'mode' => 'نظام الحضور',
            'target_audience' => 'الفئة المستهدفة',
            'salary_range' => 'العائد المالي والرواتب',
            'sort_order' => 'ترتيب العرض',
            'is_active' => 'حالة الخدمة',
        ];
    }
}
