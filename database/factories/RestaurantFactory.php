<?php

namespace Database\Factories;

use App\Models\Owner;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'subdomain' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'name' => $this->faker->name(),
            'address' => '{}',
            'color' => '{}',
            'opening_hours' => '{}',
            'photo_url' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'owner_id' => Owner::factory(),
        ];
    }
}
