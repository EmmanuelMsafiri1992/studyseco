<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// File: 2023_08_15_000003_create_user_profiles_table.php

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('school_name', 200)->nullable();
            $table->text('qualification')->nullable();
            $table->integer('experience_years')->nullable();
            $table->json('subjects_of_interest')->nullable();
            $table->enum('preferred_language', ['english', 'chichewa'])->default('english');
            $table->string('timezone', 50)->default('Africa/Blantyre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
