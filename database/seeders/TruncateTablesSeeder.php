<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A seeder to truncate all tables before a fresh seed.
 * This is useful for development and testing.
 */
class TruncateTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        Schema::disableForeignKeyConstraints();

        // List of tables to truncate
        $tablesToTruncate = [
            'users',
            'user_profiles',
            'academic_years',
            'forms',
            'terms',
            'subjects',
            'form_subjects',
            'topics',
            'video_lessons',
            'lesson_attachments',
            'live_sessions',
            'live_session_participants',
            'subscription_plans',
            'subject_pricing',
            'student_subscriptions',
            'payment_methods',
            'payments',
            'quizzes',
            'quiz_questions',
            'quiz_question_options',
            'quiz_attempts',
            'quiz_answers',
            'assignments',
            'assignment_submissions',
            'assignment_files',
            'student_progress',
            'lesson_progress',
            'student_grades',
            'forum_categories',
            'forum_topics',
            'forum_posts',
            'forum_likes',
            'private_messages',
            'notifications',
            'system_settings',
            'activity_logs',
            'achievements',
            'user_achievements',
            'email_queue', // Correct table name
            'personal_access_tokens',
            'failed_jobs',
            'roles',
            'permissions',
            'model_has_roles',
            'role_has_permissions',
        ];

        foreach ($tablesToTruncate as $table) {
            DB::table($table)->truncate();
        }

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }
}
