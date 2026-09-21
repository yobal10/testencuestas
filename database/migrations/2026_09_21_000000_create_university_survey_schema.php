<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 30)->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('dean_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('academic_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 30)->unique();
            $table->string('slug')->unique();
            $table->string('degree_level', 40)->default('pregrado');
            $table->unsignedTinyInteger('duration_semesters')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['faculty_id', 'is_active']);
        });

        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 30)->unique();
            $table->date('starts_on');
            $table->date('ends_on');
            $table->string('status', 20)->default('planned');
            $table->timestamps();
        });

        Schema::create('academic_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('academic_programs')->cascadeOnDelete();
            $table->string('code', 30);
            $table->string('name');
            $table->unsignedTinyInteger('semester_level')->nullable();
            $table->decimal('credits', 4, 1)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['program_id', 'code']);
            $table->index(['program_id', 'is_active']);
        });

        Schema::create('university_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('faculty_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('academic_programs')->nullOnDelete();
            $table->string('member_type', 30)->default('student');
            $table->string('institutional_code', 50)->nullable()->unique();
            $table->string('phone', 30)->nullable();
            $table->string('status', 20)->default('active');
            $table->json('profile_data')->nullable();
            $table->timestamps();

            $table->index(['member_type', 'status']);
        });

        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('academic_period_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('faculty_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('academic_programs')->nullOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('academic_courses')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('survey_type', 40)->default('institutional');
            $table->string('audience', 20)->default('all');
            $table->string('status', 20)->default('draft');
            $table->boolean('is_anonymous')->default(false);
            $table->timestamp('opens_at')->nullable();
            $table->timestamp('closes_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'survey_type']);
            $table->index(['faculty_id', 'program_id', 'course_id']);
        });

        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->string('question_type', 30)->default('rating');
            $table->text('prompt');
            $table->text('help_text')->nullable();
            $table->boolean('is_required')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('options')->nullable();
            $table->timestamps();

            $table->index(['survey_id', 'sort_order']);
        });

        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->foreignId('respondent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->uuid('response_token')->unique();
            $table->timestamp('submitted_at')->nullable();
            $table->string('status', 20)->default('in_progress');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['survey_id', 'respondent_id']);
            $table->index(['survey_id', 'status']);
        });

        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('survey_responses')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('survey_questions')->cascadeOnDelete();
            $table->text('answer_text')->nullable();
            $table->decimal('answer_numeric', 8, 2)->nullable();
            $table->json('answer_data')->nullable();
            $table->timestamps();

            $table->unique(['response_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
        Schema::dropIfExists('survey_responses');
        Schema::dropIfExists('survey_questions');
        Schema::dropIfExists('surveys');
        Schema::dropIfExists('university_members');
        Schema::dropIfExists('academic_courses');
        Schema::dropIfExists('academic_periods');
        Schema::dropIfExists('academic_programs');
        Schema::dropIfExists('faculties');
    }
};
