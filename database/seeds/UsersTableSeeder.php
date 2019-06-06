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
        $readUser = Permission::create(['name' => 'read_user']);
        $createUser = Permission::create(['name' => 'create_user']);
        $editUser = Permission::create(['name' => 'edit_user']);
        $deleteUser = Permission::create(['name' => 'delete_user']);

        $readRole = Permission::create(['name' => 'read_role']);
        $createRole = Permission::create(['name' => 'create_role']);
        $editRole = Permission::create(['name' => 'edit_role']);
        $deleteRole = Permission::create(['name' => 'delete_role']);

        $readPermission = Permission::create(['name' => 'read_permission']);
        $createPermission = Permission::create(['name' => 'create_permission']);
        $editPermission = Permission::create(['name' => 'edit_permission']);
        $deletePermission = Permission::create(['name' => 'delete_permission']);

        $demoUser->assignRole($general);

        $adminUser->assignRole($general);
        $adminUser->assignRole($admin);

        // assign created permissions
        $admin->givePermissionTo($readUser);
        $admin->givePermissionTo($createUser);
        $admin->givePermissionTo($editUser);
        $admin->givePermissionTo($deleteUser);
        $admin->givePermissionTo($readRole);
        $admin->givePermissionTo($createRole);
        $admin->givePermissionTo($editRole);
        $admin->givePermissionTo($deleteRole);
        $admin->givePermissionTo($readPermission);
        $admin->givePermissionTo($createPermission);
        $admin->givePermissionTo($editPermission);
        $admin->givePermissionTo($deletePermission);
    }
}
