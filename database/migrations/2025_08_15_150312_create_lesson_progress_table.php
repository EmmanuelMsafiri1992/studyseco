<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('video_lessons')->onDelete('cascade');
            $table->integer('watch_time_seconds')->default(0);
            $table->decimal('completion_percentage', 5, 2)->default(0);
            $table->boolean('is_completed')->default(false);
            $table->dateTime('first_watched_at')->nullable();
            $table->dateTime('last_watched_at')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
    }
};
