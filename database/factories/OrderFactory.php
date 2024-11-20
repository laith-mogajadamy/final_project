<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Create a new user or associate an existing one
            'total_price' => $this->faker->randomFloat(2, 20, 500), // Total price between 20 and 500
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']), // Random status
        ];
    }
}
