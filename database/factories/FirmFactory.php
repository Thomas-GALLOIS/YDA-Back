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
            'address' => $this->faker->streetAddress(),
            'name' => $this->faker->firstname(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'visit_day_1' => 'mardi',
            'time_1' => 8,

            "title" => $this->faker->lastname(),
            "news" => $this->faker->text(),
            "image" => "5e5cb18c230d1682ae0ebe34abfdf341.jpg"
        ];
    }
}
