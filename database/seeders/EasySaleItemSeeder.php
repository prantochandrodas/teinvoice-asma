<?php

namespace Database\Seeders;

use App\Models\EasySaleItem;
use Illuminate\Database\Seeder;

class EasySaleItemSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        EasySaleItem::truncate();

        EasySaleItem::factory(50)->create();

    }

}
