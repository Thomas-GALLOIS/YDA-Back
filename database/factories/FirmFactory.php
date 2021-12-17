<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class FirmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->text(),
            'name' => $this->faker->firstname(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email()
        ];
    }
}
