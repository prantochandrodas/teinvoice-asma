<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username'       => $this->faker->unique()->name(),
            'email'          => $this->faker->unique()->safeEmail(),
            'phone'          => $this->faker->unique()->phoneNumber(),
            'password'       => bcrypt('12345'), // password
            'first_name'     => $this->faker->firstName(),
            'last_name'      => $this->faker->lastName(),
            'store_password' => '12345',
            'address'        => $this->faker->address(),
            'remember_token' => Str::random(10),
        ];
    }
}
