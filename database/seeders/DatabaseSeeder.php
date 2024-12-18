<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();
        $this->call(AdminSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(EasySaleItemSeeder::class);
    }
}
