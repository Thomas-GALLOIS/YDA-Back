<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => "en cours",
            'total' => $this->faker->floatval(),
            'comments' => $this->faker->lastname(),
            'note_admin' => $this->faker->text(),
        ];
    }
}
