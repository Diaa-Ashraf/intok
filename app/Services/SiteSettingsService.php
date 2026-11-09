<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SiteSettingsService
{
    public function __construct(private readonly ImageUploadService $images) {}

    /** @return array<string, mixed> */
    public function all(): array
    {
        return Cache::remember('site.settings', 3600, fn (): array => SiteSetting::query()->select(['key', 'value'])->get()->mapWithKeys(fn (SiteSetting $setting): array => [$setting->key => $setting->value])->all());
    }

    /** @param array<string, mixed> $settings */
    public function save(array $settings): void
    {
        $current = $this->all();
        $newFiles = [];
        $fileFields = [
            'logo' => ['logo_path', 'site', 900, 400],
            'favicon' => ['favicon_path', 'site', 256, 256],
            'hero_scene_1_img' => ['hero_scene_1_img', 'site/hero', 1600, 1200],
            'hero_scene_2_img' => ['hero_scene_2_img', 'site/hero', 1600, 1200],
            'hero_scene_3_img' => ['hero_scene_3_img', 'site/hero', 1600, 1200],
            'hero_scene_4_img' => ['hero_scene_4_img', 'site/hero', 1600, 1200],
            'live_slide_1_img' => ['live_slide_1_img', 'site/slider', 1920, 1080],
            'live_slide_2_img' => ['live_slide_2_img', 'site/slider', 1920, 1080],
            'live_slide_3_img' => ['live_slide_3_img', 'site/slider', 1920, 1080],
            'live_slide_4_img' => ['live_slide_4_img', 'site/slider', 1920, 1080],
        ];

        foreach ($fileFields as $field => [$key, $directory, $width, $height]) {
            $upload = $settings[$field] ?? null;
            unset($settings[$field]);
            if ($upload instanceof UploadedFile) {
                $path = $this->images->storeWebp($upload, $directory, $width, $height);
                $newFiles[$key] = $path;
                $settings[$key] = $path;
            }
        }
        if (isset($settings['social_links']) && is_array($settings['social_links'])) {
            $settings['social_links'] = array_filter($settings['social_links'], static fn (mixed $url): bool => is_string($url) && $url !== '');
        }
        try {
            DB::transaction(function () use ($settings): void {
                foreach ($settings as $key => $value) SiteSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
            });
        } catch (\Throwable $exception) {
            foreach ($newFiles as $path) Storage::disk('public')->delete($path);
            throw $exception;
        }
        Cache::forget('site.settings');
        foreach ($newFiles as $key => $path) {
            $oldPath = data_get($current, $key);
            if (is_string($oldPath) && $oldPath !== $path) Storage::disk('public')->delete($oldPath);
        }
    }
}
