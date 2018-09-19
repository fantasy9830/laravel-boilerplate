<?php

use App\Auth\Models\Permission;
use App\Auth\Models\Role;
use App\Auth\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create users
        $demo = User::create([
            'name' => 'Demo',
            'username' => 'demo',
            'password' => '8888',
            'email' => 'Demo@gmail.com',
            'address' => 'Demo Address',
        ]);

        $demo2 = User::create([
            'name' => 'Demo2',
            'username' => 'demo2',
            'password' => '8888',
            'email' => 'Demo2@gmail.com',
            'address' => 'Demo2 Address',
        ]);

        // create permissions
		// API
		$permission1 = Permission::create([
			'name' => 'resource1',
			'action' => 'GET',
			'guard_name' => 'web',
			'display_name' => 'GET Resource1',
			'description' => 'permission description...',
        ]);

		// Web
		$permission2 = Permission::create([
			'name' => 'resource2',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read Resource2',
			'description' => 'permission description...',
        ]);
		$permission3 = Permission::create([
			'name' => 'resource3',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read Resource3',
			'description' => 'permission description...',
        ]);
		$permission4 = Permission::create([
			'name' => 'sidermenu1-1',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu1-1',
			'description' => 'SiderMenu1-1...',
        ]);
		$permission5 = Permission::create([
			'name' => 'sidermenu1-2',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu1-2',
			'description' => 'SiderMenu1-2...',
		]);
		$permission6 = Permission::create([
			'name' => 'sidermenu1-3-1',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu1-3-1',
			'description' => 'SiderMenu1-3-1...',
		]);
		$permission7 = Permission::create([
			'name' => 'sidermenu1-3-2',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu1-3-2',
			'description' => 'SiderMenu1-3-2...',
		]);
		$permission8 = Permission::create([
			'name' => 'sidermenu2-1',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu2-1',
			'description' => 'SiderMenu2-1...',
		]);
		$permission9 = Permission::create([
			'name' => 'sidermenu2-2',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu2-2',
			'description' => 'SiderMenu2-2...',
		]);
		$permission10 = Permission::create([
			'name' => 'sidermenu2-3',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu2-3',
			'description' => 'SiderMenu2-3...',
		]);
		$permission11 = Permission::create([
			'name' => 'sidermenu3',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu3',
			'description' => 'SiderMenu3...',
		]);
		$permission12 = Permission::create([

			'name' => 'sidermenu1',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu1',
			'description' => 'SiderMenu1...',
		]);
		$permission13 = Permission::create([
			'name' => 'sidermenu1-3',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu1-3',
			'description' => 'SiderMenu1-3...',
		]);
		$permission14 = Permission::create([
			'name' => 'sidermenu2',
			'action' => 'read',
			'guard_name' => 'web',
			'display_name' => 'Read sidermenu2',
			'description' => 'SiderMenu2...',
        ]);

        // create roles
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
            'display_name' => 'Admin',
            'description' => 'role description...',
        ]);

        $test = Role::create([
            'name' => 'test',
            'guard_name' => 'web',
            'display_name' => 'Test2',
            'description' => 'role description...',
        ]);

        // assign roles and permissions
        $admin->givePermissionTo($permission1);
        $admin->givePermissionTo($permission2);

        $demo->assignRole($admin);
        $demo->givePermissionTo($permission1);
        $demo->givePermissionTo($permission4);
        $demo->givePermissionTo($permission5);
        $demo->givePermissionTo($permission6);
        $demo->givePermissionTo($permission7);
        $demo->givePermissionTo($permission8);
        $demo->givePermissionTo($permission9);
        $demo->givePermissionTo($permission10);
        $demo->givePermissionTo($permission11);
        $demo->givePermissionTo($permission12);
        $demo->givePermissionTo($permission13);
        $demo->givePermissionTo($permission14);

        $demo2->assignRole($test);
        $demo2->givePermissionTo($permission1);
        $demo2->givePermissionTo($permission3);
        $demo2->givePermissionTo($permission4);
        $demo2->givePermissionTo($permission5);
        $demo2->givePermissionTo($permission6);
        $demo2->givePermissionTo($permission7);
        $demo2->givePermissionTo($permission12);
        $demo2->givePermissionTo($permission13);

    }
}
