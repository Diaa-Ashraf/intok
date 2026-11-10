<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->json('badge')->nullable()->after('summary');
            $table->json('category_label')->nullable()->after('badge');
            $table->json('level')->nullable()->after('category_label');
            $table->json('duration')->nullable()->after('level');
            $table->json('mode')->nullable()->after('duration');
            $table->json('target_audience')->nullable()->after('mode');
            $table->json('salary_range')->nullable()->after('target_audience');
            $table->json('whatsapp_message')->nullable()->after('salary_range');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropColumn([
                'badge',
                'category_label',
                'level',
                'duration',
                'mode',
                'target_audience',
                'salary_range',
                'whatsapp_message',
            ]);
        });
    }
};
