<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Sale::truncate();
        Sale::create([
            'date'             => date('Y-m-d'),
            'total_quantity'   => 1,
            'grand_amount'     => 1,
            'discount_amount'  => 1,
            'tax_amount'       => 1,
            'final_amount'     => 1,
            'created_admin_id' => 1,
        ]);
    }
}
