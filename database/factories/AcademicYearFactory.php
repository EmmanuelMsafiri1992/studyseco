<?php
namespace Database\Factories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicYearFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AcademicYear::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->year(),
            'start_date' => fake()->date('Y-m-d', '2023-01-01'),
            'end_date' => fake()->date('Y-m-d', '2024-12-31'),
            'is_active' => false,
        ];
    }
}
