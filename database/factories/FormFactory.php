<?php
namespace Database\Factories;

use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $level = fake()->numberBetween(1, 4);
        $formName = 'Form ' . $level;
        return [
            'name' => $formName,
            'slug' => Str::slug($formName),
            'description' => fake()->sentence(),
            'is_active' => true,
            'level' => $level,
        ];
    }
}
