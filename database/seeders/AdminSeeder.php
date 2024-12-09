<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Admin::truncate();
        $admin = Admin::create(
            [
                'username'       => 'Admin',
                'email'          => 'admin@gmail.com',
                'phone'          => '0123456789',
                'password'       => bcrypt('12345'),
                'first_name'     => 'Admin',
                'last_name'      => 'Admin',
                'store_password' => '12345',
                'address'        => '12345',
                'remember_token' => Str::random(10),
            ],
        );

        Admin::create([
                'username'       => 'shaokat',
                'email'          => 'shaokat71@gmail.com',
                'phone'          => '01757769498',
                'password'       => bcrypt('12345'),
                'first_name'     => 'Shaokat',
                'last_name'      => 'Hossain',
                'store_password' => '12345',
                'address'        => '12345',
                'remember_token' => Str::random(10),
            ],
        );

        $role = Role::first();

        $admin->assignRole($role);

        // Admin::factory(10)->create();
    }
}
