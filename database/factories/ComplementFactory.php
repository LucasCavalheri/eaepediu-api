<?php

namespace Database\Factories;

use App\Models\Complement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Complement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'image_url' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'product_id' => Product::factory(),
        ];
    }
}
