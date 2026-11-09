<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->string('slug_ar', 160)->nullable()->index();
            $table->string('slug_en', 160)->nullable()->index();
            $table->string('slug_it', 160)->nullable()->index();
        });

        foreach (DB::table('services')->select(['id', 'slug'])->get() as $service) {
            $slugs = json_decode((string) $service->slug, true) ?: [];
            DB::table('services')->where('id', $service->id)->update([
                'slug_ar' => $slugs['ar'] ?? null,
                'slug_en' => $slugs['en'] ?? null,
                'slug_it' => $slugs['it'] ?? null,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropIndex(['slug_ar']);
            $table->dropIndex(['slug_en']);
            $table->dropIndex(['slug_it']);
            $table->dropColumn(['slug_ar', 'slug_en', 'slug_it']);
        });
    }
};
