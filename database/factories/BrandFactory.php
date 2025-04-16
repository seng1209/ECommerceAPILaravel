<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Brand>
 */
class BrandFactory extends Factory
{

    protected $model = Brand::class;
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
            'brand' => $this->faker->company(),
            'description' => $this->faker->text(),
        ];
    }
}
