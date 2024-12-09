<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'phone' => $this->faker->unique()->phoneNumber(),
            'name'  => $this->faker->firstName(),
            'email' => $this->faker->email(),
        ];
    }
}
