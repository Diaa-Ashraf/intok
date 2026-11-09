<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Admin') === true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            // Core Identity
            'site_name' => ['required', 'array'],
            'site_name.*' => ['required', 'string', 'max:120'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tagline' => ['required', 'array'],
            'tagline.*' => ['required', 'string', 'max:250'],

            // Hero Section
            'hero_badge' => ['nullable', 'array'],
            'hero_badge.*' => ['nullable', 'string', 'max:200'],
            'hero_title' => ['required', 'array'],
            'hero_title.*' => ['required', 'string', 'max:250'],
            'hero_text' => ['required', 'array'],
            'hero_text.*' => ['required', 'string', 'max:1000'],
            'hero_cta' => ['required', 'array'],
            'hero_cta.*' => ['required', 'string', 'max:100'],
            'hero_secondary_cta' => ['nullable', 'array'],
            'hero_secondary_cta.*' => ['nullable', 'string', 'max:100'],
            'hero_stat_1_val' => ['nullable', 'string', 'max:50'],
            'hero_stat_1_lbl' => ['nullable', 'array'],
            'hero_stat_1_lbl.*' => ['nullable', 'string', 'max:150'],
            'hero_stat_2_val' => ['nullable', 'string', 'max:50'],
            'hero_stat_2_lbl' => ['nullable', 'array'],
            'hero_stat_2_lbl.*' => ['nullable', 'string', 'max:150'],
            'hero_stat_3_val' => ['nullable', 'string', 'max:50'],
            'hero_stat_3_lbl' => ['nullable', 'array'],
            'hero_stat_3_lbl.*' => ['nullable', 'string', 'max:150'],
            'robot_quotes' => ['nullable', 'array'],
            'robot_quotes.*' => ['nullable', 'string', 'max:300'],

            // Services Section
            'services_badge' => ['nullable', 'array'],
            'services_badge.*' => ['nullable', 'string', 'max:150'],
            'services_title' => ['nullable', 'array'],
            'services_title.*' => ['nullable', 'string', 'max:150'],
            'services_subtitle' => ['nullable', 'array'],
            'services_subtitle.*' => ['nullable', 'string', 'max:600'],

            // Live Slider Section
            'live_slider_badge' => ['nullable', 'array'],
            'live_slider_badge.*' => ['nullable', 'string', 'max:150'],
            'live_slider_title' => ['nullable', 'array'],
            'live_slider_title.*' => ['nullable', 'string', 'max:150'],
            'live_slider_subtitle' => ['nullable', 'array'],
            'live_slider_subtitle.*' => ['nullable', 'string', 'max:600'],

            // Finder Console
            'finder_title' => ['nullable', 'array'],
            'finder_title.*' => ['nullable', 'string', 'max:150'],
            'finder_step1_label' => ['nullable', 'array'],
            'finder_step1_label.*' => ['nullable', 'string', 'max:150'],
            'finder_step2_label' => ['nullable', 'array'],
            'finder_step2_label.*' => ['nullable', 'string', 'max:150'],
            'finder_step3_label' => ['nullable', 'array'],
            'finder_step3_label.*' => ['nullable', 'string', 'max:150'],
            'finder_btn_text' => ['nullable', 'array'],
            'finder_btn_text.*' => ['nullable', 'string', 'max:150'],

            // Why Choose Us Section
            'why_badge' => ['nullable', 'array'],
            'why_badge.*' => ['nullable', 'string', 'max:150'],
            'why_title' => ['nullable', 'array'],
            'why_title.*' => ['nullable', 'string', 'max:150'],
            'why_subtitle' => ['nullable', 'array'],
            'why_subtitle.*' => ['nullable', 'string', 'max:600'],
            'why_bento_dsu_title' => ['nullable', 'array'],
            'why_bento_dsu_title.*' => ['nullable', 'string', 'max:200'],
            'why_bento_dsu_desc' => ['nullable', 'array'],
            'why_bento_dsu_desc.*' => ['nullable', 'string', 'max:1000'],
            'why_bento_callcenter_title' => ['nullable', 'array'],
            'why_bento_callcenter_title.*' => ['nullable', 'string', 'max:200'],
            'why_bento_callcenter_desc' => ['nullable', 'array'],
            'why_bento_callcenter_desc.*' => ['nullable', 'string', 'max:1000'],
            'why_bento_trans_title' => ['nullable', 'array'],
            'why_bento_trans_title.*' => ['nullable', 'string', 'max:200'],
            'why_bento_trans_desc' => ['nullable', 'array'],
            'why_bento_trans_desc.*' => ['nullable', 'string', 'max:1000'],
            'why_bento_reception_title' => ['nullable', 'array'],
            'why_bento_reception_title.*' => ['nullable', 'string', 'max:200'],
            'why_bento_reception_desc' => ['nullable', 'array'],
            'why_bento_reception_desc.*' => ['nullable', 'string', 'max:1000'],
            'why_bento_languages_title' => ['nullable', 'array'],
            'why_bento_languages_title.*' => ['nullable', 'string', 'max:200'],
            'why_bento_languages_desc' => ['nullable', 'array'],
            'why_bento_languages_desc.*' => ['nullable', 'string', 'max:1000'],
            'why_bento_mentorship_title' => ['nullable', 'array'],
            'why_bento_mentorship_title.*' => ['nullable', 'string', 'max:200'],
            'why_bento_mentorship_desc' => ['nullable', 'array'],
            'why_bento_mentorship_desc.*' => ['nullable', 'string', 'max:1000'],

            // Roadmap Section
            'roadmap_badge' => ['nullable', 'array'],
            'roadmap_badge.*' => ['nullable', 'string', 'max:150'],
            'roadmap_title' => ['nullable', 'array'],
            'roadmap_title.*' => ['nullable', 'string', 'max:150'],
            'roadmap_subtitle' => ['nullable', 'array'],
            'roadmap_subtitle.*' => ['nullable', 'string', 'max:600'],
            'roadmap_step1_title' => ['nullable', 'array'],
            'roadmap_step1_title.*' => ['nullable', 'string', 'max:150'],
            'roadmap_step1_desc' => ['nullable', 'array'],
            'roadmap_step1_desc.*' => ['nullable', 'string', 'max:600'],
            'roadmap_step2_title' => ['nullable', 'array'],
            'roadmap_step2_title.*' => ['nullable', 'string', 'max:150'],
            'roadmap_step2_desc' => ['nullable', 'array'],
            'roadmap_step2_desc.*' => ['nullable', 'string', 'max:600'],
            'roadmap_step3_title' => ['nullable', 'array'],
            'roadmap_step3_title.*' => ['nullable', 'string', 'max:150'],
            'roadmap_step3_desc' => ['nullable', 'array'],
            'roadmap_step3_desc.*' => ['nullable', 'string', 'max:600'],
            'roadmap_step4_title' => ['nullable', 'array'],
            'roadmap_step4_title.*' => ['nullable', 'string', 'max:150'],
            'roadmap_step4_desc' => ['nullable', 'array'],
            'roadmap_step4_desc.*' => ['nullable', 'string', 'max:600'],

            // Final CTA Banner
            'cta_badge' => ['nullable', 'array'],
            'cta_badge.*' => ['nullable', 'string', 'max:150'],
            'cta_title' => ['nullable', 'array'],
            'cta_title.*' => ['nullable', 'string', 'max:250'],
            'cta_subtitle' => ['nullable', 'array'],
            'cta_subtitle.*' => ['nullable', 'string', 'max:800'],
            'cta_btn_primary' => ['nullable', 'array'],
            'cta_btn_primary.*' => ['nullable', 'string', 'max:120'],
            'cta_btn_secondary' => ['nullable', 'array'],
            'cta_btn_secondary.*' => ['nullable', 'string', 'max:120'],

            // Footer & SEO & Contacts
            'footer_text' => ['nullable', 'array'],
            'footer_text.*' => ['nullable', 'string', 'max:600'],
            'footer_copyright' => ['nullable', 'array'],
            'footer_copyright.*' => ['nullable', 'string', 'max:250'],
            'contact_phone' => ['required', 'string', 'max:30'],
            'whatsapp_number' => ['required', 'regex:/^\+?[0-9]{8,16}$/'],
            'contact_email' => ['nullable', 'email', 'max:120'],
            'map_embed' => ['nullable', 'url', 'regex:/^https:\/\/www\.google\.com\/maps\/embed(?:\?|\/)/', 'max:2000'],
            'social_links' => ['nullable', 'array:facebook,instagram,tiktok,linkedin,youtube'],
            'social_links.*' => ['nullable', 'url', 'max:255'],
            'ga4_id' => ['nullable', 'regex:/^G-[A-Z0-9]+$/'],
            'search_console_tag' => ['nullable', 'string', 'max:200'],
            'default_seo_title' => ['nullable', 'array'],
            'default_seo_title.*' => ['nullable', 'string', 'max:100'],
            'default_seo_description' => ['nullable', 'array'],
            'default_seo_description.*' => ['nullable', 'string', 'max:250'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'required_without' => 'أكمل قيمة :attribute لكل لغة.',
            'string' => 'يجب أن يكون :attribute نصًا.',
            'max' => 'تجاوز :attribute الحد المسموح.',
            'url' => 'الرابط في :attribute غير صالح.',
            'regex' => 'قيمة :attribute غير صالحة.',
            'array' => 'أدخل قيم :attribute حسب اللغة.',
            'image' => 'يجب رفع صورة صحيحة.',
            'mimes' => 'صيغة الصورة غير مدعومة.',
        ];
    }
}
