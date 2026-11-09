<?php

namespace App\Http\Requests;

use App\Models\SitePage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSitePageRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->hasRole('Admin') === true; }

    public function rules(): array
    {
        $page = $this->route('page');
        $id = $page instanceof SitePage ? $page->getKey() : null;
        $kindRules = ['required', Rule::in(['page', 'about', 'privacy', 'terms'])];
        if ($this->input('kind') !== 'page') $kindRules[] = Rule::unique('site_pages', 'kind')->ignore($id);
        return [
            'kind' => $kindRules,
            'slug' => ['required', 'array'],
            ...collect(['ar', 'en', 'it'])->mapWithKeys(fn (string $locale): array => ['slug.'.$locale => ['required', 'string', 'max:160', Rule::unique('site_pages', 'slug_'.$locale)->ignore($id)]])->all(),
            'title' => ['required', 'array'],
            ...collect(['ar', 'en', 'it'])->mapWithKeys(fn (string $locale): array => ['title.'.$locale => ['required', 'string', 'max:180']])->all(),
            'content' => ['required', 'array'],
            ...collect(['ar', 'en', 'it'])->mapWithKeys(fn (string $locale): array => ['content.'.$locale => ['required', 'string', 'max:30000']])->all(),
            'seo_title' => ['nullable', 'array'], 'seo_title.*' => ['nullable', 'string', 'max:70'],
            'seo_description' => ['nullable', 'array'], 'seo_description.*' => ['nullable', 'string', 'max:180'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array { return ['required' => 'حقل :attribute مطلوب.', 'string' => 'يجب أن يكون :attribute نصًا.', 'array' => 'أدخل القيم حسب اللغة.', 'unique' => 'هذا الرابط مستخدم من قبل.', 'max' => 'تجاوز :attribute الحد المسموح.', 'in' => 'نوع الصفحة غير صالح.']; }
    public function attributes(): array { return ['slug' => 'الرابط', 'title' => 'العنوان', 'content' => 'المحتوى', 'seo_title' => 'عنوان SEO', 'seo_description' => 'وصف SEO']; }
}
