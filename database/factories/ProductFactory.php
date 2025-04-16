<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => $this->faker->imageUrl(),
            'image_name' => $this->faker->word(),
            'product_name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1, 10000),
            'brand_id' => $this->faker->numberBetween(1, 3),
            'category_id' => $this->faker->numberBetween(1, 3),
            'description' => $this->faker->text(),
        ];
    }
}
