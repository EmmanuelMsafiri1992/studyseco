<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Form;
use App\Models\Subject;
use App\Models\Term;
use App\Models\Topic;
use App\Models\User;
use App\Models\VideoLesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * This seeder populates the database with some initial, essential data.
 */
class CoreDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create an admin user and assign the 'admin' role
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'uuid' => Str::uuid(),
        ]);
        $admin->assignRole('admin');

        // Create a teacher user and assign the 'teacher' role
        $teacher = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'Example',
            'email' => 'teacher@example.com',
            'role' => 'teacher',
            'password' => Hash::make('password'),
            'uuid' => Str::uuid(),
        ]);
        $teacher->assignRole('teacher');

        // Create a student user and assign the 'student' role
        $student = User::create([
            'first_name' => 'Student',
            'last_name' => 'Example',
            'email' => 'student@example.com',
            'role' => 'student',
            'password' => Hash::make('password'),
            'uuid' => Str::uuid(),
        ]);
        $student->assignRole('student');

        // Create other users using the factory, which is now corrected
        User::factory()->count(10)->create();

        // Create academic years
        $academicYear = AcademicYear::factory()->create();

        // Create terms
        Term::factory()->count(3)->create([
            'academic_year_id' => $academicYear->id,
        ]);

        // Create forms
        $forms = Form::factory()->count(4)->create();

        // Create subjects and attach them to forms
        $subjects = Subject::factory()->count(5)->create();
        foreach ($subjects as $subject) {
            $subject->forms()->attach($forms->random(2));
        }

        // Create topics and video lessons
        foreach ($subjects as $subject) {
            foreach ($forms as $form) {
                // Ensure the form and subject are attached before creating topics
                if ($subject->forms()->where('forms.id', $form->id)->exists()) {
                    $topics = Topic::factory()->count(3)->create([
                        'subject_id' => $subject->id,
                        'form_id' => $form->id,
                        'teacher_id' => $teacher->id,
                    ]);

                    foreach ($topics as $topic) {
                        VideoLesson::factory()->count(2)->create([
                            'topic_id' => $topic->id,
                            'teacher_id' => $teacher->id,
                        ]);
                    }
                }
            }
        }
    }
}
