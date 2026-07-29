<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissiongroups = [
            'User',                 // 1
            'Role',                 // 2
            'Permission Group',     // 3
            'Permission',           // 4
            'Menu',                 // 5
            'Menu Group',           // 6
            'Article Category',     // 7
            'Article',              // 8
            'Setting',              // 9
            'Banner',               // 10
            'Property Service',     // 11
            'Facility',             // 12
            'Property',             // 13
            'Content Management',   // 14
            'Property Management',  // 15
            'Settings',             // 16
            'Payment Method',       // 17
        ];

        foreach ($permissiongroups as $permissiongroup) {
            PermissionGroup::create([
                'name' => $permissiongroup
            ]);
        }

        $permissions = [
            'User Access-1',
            'User Detail-1',
            'User Create-1',
            'User Update-1',
            'User Banned-1',
            'User Role Create-1',
            'Role Access-2',
            'Role Detail-2',
            'Role Create-2',
            'Role Update-2',
            'Role Delete-2',
            'Permission Group Access-3',
            'Permission Group Create-3',
            'Permission Group Update-3',
            'Permission Group Delete-3',
            'Permission Access-4',
            'Permission Create-4',
            'Permission Update-4',
            'Permission Delete-4',
            'Menu Access-5',
            'Menu Create-5',
            'Menu Update-5',
            'Menu Delete-5',
            'Menu Group Access-6',
            'Menu Group Create-6',
            'Menu Group Update-6',
            'Menu Group Delete-6',
            'Article Category Access-7',
            'Article Category Create-7',
            'Article Category Update-7',
            'Article Category Delete-7',
            'Article Access-8',
            'Article Detail-8',
            'Article Create-8',
            'Article Update-8',
            'Article Delete-8',
            'Setting Access-9',
            'Setting Detail-9',
            'Setting Create-9',
            'Setting Update-9',
            'Setting Delete-9',
            'Banner Access-10',
            'Banner Detail-10',
            'Banner Create-10',
            'Banner Update-10',
            'Banner Delete-10',
            'Property Service Access-11',
            'Property Service Detail-11',
            'Property Service Create-11',
            'Property Service Update-11',
            'Property Service Delete-11',
            'Facility Access-12',
            'Facility Detail-12',
            'Facility Create-12',
            'Facility Update-12',
            'Facility Delete-12',
            'Property Access-13',
            'Property Detail-13',
            'Property Create-13',
            'Property Update-13',
            'Property Delete-13',
            'Content Management Access-14',
            'Property Management Access-15',
            'Settings Access-16',
            'Payment Method Access-17',
            'Payment Method Detail-17',
            'Payment Method Create-17',
            'Payment Method Update-17',
            'Payment Method Delete-17',
        ];

        foreach ($permissions as $permission) {
            $permission_array = explode("-", $permission);
            Permission::create([
                'name' => $permission_array[0],
                'permission_group_id' => $permission_array[1]
            ]);
        }

        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $superAdmin->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'User',
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo('Article Access');
        $role->givePermissionTo('Content Management Access');
    }
}
