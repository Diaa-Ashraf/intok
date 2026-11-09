<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('client_registrations', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150);
            $table->string('phone', 30)->index();
            $table->string('email')->nullable()->index();
            $table->string('country', 120);
            $table->string('education_level', 120);
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('locale', 2)->index();
            $table->string('status', 20)->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_registrations');
    }
};
