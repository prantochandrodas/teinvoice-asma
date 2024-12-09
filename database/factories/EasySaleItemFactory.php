<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EasySaleItemFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'item_id'          => 0,
            'created_admin_id' => 1,
        ];
    }
}
