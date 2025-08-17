<?php
namespace Database\Factories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Term::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Term ' . fake()->unique()->numberBetween(1, 3),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
