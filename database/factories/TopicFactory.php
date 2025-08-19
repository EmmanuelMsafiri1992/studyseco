<?php
namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $topicName = fake()->sentence(3);
        return [
            'name' => $topicName,
            'slug' => Str::slug($topicName),
            'description' => fake()->paragraph(),
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
