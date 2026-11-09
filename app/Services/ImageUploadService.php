<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    public function storeWebp(UploadedFile $image, string $directory, int $maxWidth, int $maxHeight): string
    {
        $manager = new ImageManager(new Driver());
        $encoded = $manager->read($image->getPathname())->scaleDown($maxWidth, $maxHeight)->toWebp(quality: 82);
        $path = trim($directory, '/').'/'.Str::uuid().'.webp';
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}
