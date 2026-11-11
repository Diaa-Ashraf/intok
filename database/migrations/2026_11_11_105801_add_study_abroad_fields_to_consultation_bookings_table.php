<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('consultation_bookings', function (Blueprint $table): void {
            $table->string('booking_type', 30)->default('general')->index()->after('service_id');
            $table->string('applicant_type', 30)->nullable()->index()->after('booking_type'); // student, parent
            $table->string('student_name', 150)->nullable()->after('applicant_type');
            $table->date('student_birth_date')->nullable()->after('student_name');
            $table->string('current_education_level', 100)->nullable()->after('student_birth_date');
            $table->string('target_education_level', 100)->nullable()->after('current_education_level');
            $table->string('qualification_year', 20)->nullable()->after('target_education_level');
            $table->string('destination_country', 100)->nullable()->index()->after('qualification_year');
            $table->string('has_applied_before', 20)->nullable()->after('destination_country'); // yes, no
            $table->string('preferred_contact_time', 150)->nullable()->after('has_applied_before');
            $table->dateTime('preferred_at')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('consultation_bookings', function (Blueprint $table): void {
            $table->dropColumn([
                'booking_type',
                'applicant_type',
                'student_name',
                'student_birth_date',
                'current_education_level',
                'target_education_level',
                'qualification_year',
                'destination_country',
                'has_applied_before',
                'preferred_contact_time',
            ]);
        });
    }
};
