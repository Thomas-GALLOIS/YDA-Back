<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => $this->faker->unique()->numberBetween($min = 1, $max = 5),
            'name' => $this->faker->firstname(),
            'price' => ('8'),
        ];
    }
}
