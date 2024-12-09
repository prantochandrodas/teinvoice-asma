<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Item::truncate();
        Item::create([
            'code'             => '1001',
            'name'             => 'New Item',
            'price'            => 200,
            'created_admin_id' => 1,
        ]);
    }
}
