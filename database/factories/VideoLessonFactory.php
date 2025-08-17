<?php
namespace Database\Factories;

use App\Models\VideoLesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VideoLessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VideoLesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = fake()->sentence(5);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'video_url' => 'https://www.youtube.com/watch?v=' . Str::random(11),
            'duration' => fake()->numberBetween(300, 1800), // In seconds
            'is_premium' => fake()->boolean(),
            'preview_url' => 'https://www.youtube.com/watch?v=' . Str::random(11),
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
