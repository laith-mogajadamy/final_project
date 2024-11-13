<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\FoodItem;

class MealSeeder extends Seeder
{
    public function run()
    {
        // Ensure there are FoodItems to attach to Meals
        if (FoodItem::count() === 0) {
            FoodItem::factory(10)->create(); // Create 10 FoodItems if none exist
        }

        // Create Meals and attach random FoodItems to each
        Meal::factory(5)->create()->each(function ($meal) {
            // Attach 2 to 5 random FoodItems to each Meal
            $foodItems = FoodItem::inRandomOrder()->take(rand(2, 5))->pluck('id');
            $meal->foodItems()->attach($foodItems);
        });
    }
}
