<?php

namespace Database\Seeders;

use App\Models\SaleDetail;
use Illuminate\Database\Seeder;

class SaleDetailSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        SaleDetail::truncate();
        SaleDetail::create([
            'sale_id'  => 1,
            'price'    => 1,
            'tax'      => 1,
            'quantity' => 1,
            'amount'   => 1,
        ]);
    }
}
