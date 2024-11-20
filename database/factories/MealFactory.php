<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    protected $model = Meal::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'stock' => $this->faker->numberBetween(1, 50), // Stock between 1 and 50
            'photo' => $this->faker->imageUrl(640, 480, 'meals', true, 'Meal'),
        ];
    }
}
