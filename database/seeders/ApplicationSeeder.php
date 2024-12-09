<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;

class ApplicationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Application::truncate();
        Application::create([
            'name'           => 'STITBD',
            'email'          => 'stitbd@gmail.com',
            'contact_number' => '0123456789',
            'address'        => 'Dhaka',
            'photo'          => '1596912424CM7ItJztFMvv3gN82536.png',
            'favicon'        => '1596912424CM7ItJztFMvv3gN82536.png',
            'admin_id'       => 1,
        ]);
    }
}
