<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Customer::truncate();
        Customer::create([
            'phone'            => '0655165655',
            'name'             => 'New Customer',
            'email'            => 'asdfl@gmail.com',
            'created_admin_id' => 1,
        ]);
    }
}
