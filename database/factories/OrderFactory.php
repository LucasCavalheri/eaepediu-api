<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
            'total_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'customer_id' => Customer::factory(),
            'restaurant_id' => Restaurant::factory(),
        ];
    }
}
