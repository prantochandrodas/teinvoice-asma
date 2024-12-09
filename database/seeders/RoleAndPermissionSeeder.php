<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\Schema;

class RoleAndPermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /*
        TRUNCATE role_has_permissions;
        TRUNCATE model_has_roles;
        TRUNCATE model_has_permissions;
        TRUNCATE roles;
        TRUNCATE permissions;
         */
        Schema::disableForeignKeyConstraints();

        \DB::table('role_has_permissions')->truncate();
        \DB::table('model_has_roles')->truncate();
        \DB::table('model_has_permissions')->truncate();
        \DB::table('roles')->truncate();
        \DB::table('permissions')->truncate();

        Schema::enableForeignKeyConstraints();

        // Create Role
        $roleSuperAdmin = Role::create([
            'name'       => 'Super Admin',
            'guard_name' => 'admin',
        ]);

        // $roleUser       = Role::create(['name' => 'user', 'guard_name' => 'admin']);

        // Permission List In Array
        $permissions = [
            // Dashboard
            [
                'group_name'  => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                ],
            ],

            // Application
            [
                'group_name'  => 'application',
                'permissions' => [
                    'application.view',
                    'application.edit',
                ],
            ],

            // Admin
            [
                'group_name'  => 'admin',
                'permissions' => [
                    'admin.list',
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.updateStatus',
                ],
            ],

            // Role
            [
                'group_name'  => 'role',
                'permissions' => [
                    'role.list',
                    'role.create',
                    'role.edit',
                    'role.delete',
                ],
            ],

            // Country
            [
                'group_name'  => 'item',
                'permissions' => [
                    'item.list',
                    'item.create',
                    'item.view',
                    'item.edit',
                    'item.delete',
                    'item.updateStatus',
                ],
            ],


            // Customer User
            [
                'group_name'  => 'customer',
                'permissions' => [
                    'customer.list',
                    'customer.create',
                    'customer.view',
                    'customer.edit',
                    'customer.delete',
                    'customer.updateStatus',
                ],
            ],

        ];

        // Assign Permission
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];

            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permission = Permission::create([
                    'guard_name' => 'admin',
                    'name'       => $permissions[$i]['permissions'][$j],
                    'group_name' => $permissionGroup,
                ]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }

        }

        $admin          = Admin::find(1);
        $roleSuperAdmin = Role::find(1);
        $admin->assignRole($roleSuperAdmin);

    }

}
