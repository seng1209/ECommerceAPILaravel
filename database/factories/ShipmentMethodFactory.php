<?php

namespace Database\Factories;

use App\Models\ShipmentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentMethod>
 */
class ShipmentMethodFactory extends Factory
{

    protected $model = ShipmentMethod::class;
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
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(0, 5),
            'description' => $this->faker->text(),
        ];
    }
}
