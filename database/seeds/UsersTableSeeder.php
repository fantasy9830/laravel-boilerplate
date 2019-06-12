<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminUser = User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'nickname' => 'Admin',
            'gender' => 'male',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $demoUser = User::create([
            'username' => 'demo',
            'name' => 'Demo',
            'nickname' => 'Demo',
            'gender' => 'male',
            'email' => 'demo@gmail.com',
            'password' => 'demo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // create roles
        $general = Role::create(['name' => 'general']);
        $admin = Role::create(['name' => 'admin']);

        // create permissions
        $readDashboard = Permission::create(['name' => 'read_dashboard']);
        $createDashboard = Permission::create(['name' => 'create_dashboard']);
        $editDashboard = Permission::create(['name' => 'edit_dashboard']);
        $deleteDashboard = Permission::create(['name' => 'delete_dashboard']);

        $readUsers = Permission::create(['name' => 'read_users']);
        $createUsers = Permission::create(['name' => 'create_users']);
        $editUsers = Permission::create(['name' => 'edit_users']);
        $deleteUsers = Permission::create(['name' => 'delete_users']);

        $readRoles = Permission::create(['name' => 'read_roles']);
        $createRoles = Permission::create(['name' => 'create_roles']);
        $editRoles = Permission::create(['name' => 'edit_roles']);
        $deleteRoles = Permission::create(['name' => 'delete_roles']);

        $readPermission = Permission::create(['name' => 'read_permission']);
        $createPermission = Permission::create(['name' => 'create_permission']);
        $editPermission = Permission::create(['name' => 'edit_permission']);
        $deletePermission = Permission::create(['name' => 'delete_permission']);

        $demoUser->assignRole($general);

        $adminUser->assignRole($general);
        $adminUser->assignRole($admin);

        // assign created permissions
        $admin->givePermissionTo($readDashboard);
        $admin->givePermissionTo($createDashboard);
        $admin->givePermissionTo($editDashboard);
        $admin->givePermissionTo($deleteDashboard);
        $admin->givePermissionTo($readUsers);
        $admin->givePermissionTo($createUsers);
        $admin->givePermissionTo($editUsers);
        $admin->givePermissionTo($deleteUsers);
        $admin->givePermissionTo($readRoles);
        $admin->givePermissionTo($createRoles);
        $admin->givePermissionTo($editRoles);
        $admin->givePermissionTo($deleteRoles);
        $admin->givePermissionTo($readPermission);
        $admin->givePermissionTo($createPermission);
        $admin->givePermissionTo($editPermission);
        $admin->givePermissionTo($deletePermission);

        $general->givePermissionTo($readDashboard);
        $general->givePermissionTo($createDashboard);
        $general->givePermissionTo($editDashboard);
        $general->givePermissionTo($deleteDashboard);
    }
}
