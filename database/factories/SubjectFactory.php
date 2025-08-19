<?php
namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subjectName = fake()->unique()->randomElement(['Mathematics', 'English', 'Physical Science', 'Biology', 'History', 'Geography']);
        return [
            'name' => $subjectName,
            'slug' => Str::slug($subjectName),
            'description' => fake()->paragraph(),
            'is_active' => true,
            'code' => fake()->unique()->regexify('[A-Z]{3}'),
            'subject_code' => fake()->unique()->regexify('[A-Z]{3}[0-9]{3}'),
        ];
    }
}
