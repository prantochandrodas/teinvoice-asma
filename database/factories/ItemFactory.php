<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'code'             => $this->faker->unique()->name(),
            'name'             => $this->faker->unique()->name(),
            'price'            => 100,
            'created_admin_id' => 1,
        ];
    }
}
