<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FoodItem;

class FoodItemFactory extends Factory
{
    protected $model = FoodItem::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category' => $this->faker->randomElement(['Appetizer', 'Main Course', 'Dessert']),
            'stock' => $this->faker->numberBetween(1, 100),
            'exdate' => $this->faker->dateTimeBetween('now', '+2 years'), // Expiry date between now and 2 years
            'photo' => $this->faker->imageUrl(640, 480, 'food', true, 'FoodItem'), // Generate a placeholder image URL
        ];
    }
}
