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
        $permissionsByGroup = [
            'User' => [
                'User Access', 'User Detail', 'User Create', 'User Update', 'User Banned', 'User Role Create'
            ],
            'Role' => [
                'Role Access', 'Role Detail', 'Role Create', 'Role Update', 'Role Delete'
            ],
            'Permission Group' => [
                'Permission Group Access', 'Permission Group Create', 'Permission Group Update', 'Permission Group Delete'
            ],
            'Permission' => [
                'Permission Access', 'Permission Create', 'Permission Update', 'Permission Delete'
            ],
            'Menu' => [
                'Menu Access', 'Menu Create', 'Menu Update', 'Menu Delete'
            ],
            'Menu Group' => [
                'Menu Group Access', 'Menu Group Create', 'Menu Group Update', 'Menu Group Delete'
            ],
            'Article Category' => [
                'Article Category Access', 'Article Category Create', 'Article Category Update', 'Article Category Delete'
            ],
            'Article' => [
                'Article Access', 'Article Detail', 'Article Create', 'Article Update', 'Article Delete'
            ],
            'Setting' => [
                'Setting Access', 'Setting Detail', 'Setting Create', 'Setting Update', 'Setting Delete'
            ],
            'Property Service' => [
                'Property Service Access', 'Property Service Detail', 'Property Service Create', 'Property Service Update', 'Property Service Delete'
            ],
            'Facility' => [
                'Facility Access', 'Facility Detail', 'Facility Create', 'Facility Update', 'Facility Delete'
            ],
            'Property' => [
                'Property Access', 'Property Detail', 'Property Create', 'Property Update', 'Property Delete'
            ],
            'Content Management' => [
                'Content Management Access'
            ],
            'Property Management' => [
                'Property Management Access'
            ],
            'Settings' => [
                'Settings Access'
            ],
            'Payment Method' => [
                'Payment Method Access', 'Payment Method Detail', 'Payment Method Create', 'Payment Method Update', 'Payment Method Delete'
            ],
            'Booking' => [
                'Booking Access', 'Booking Detail', 'Booking Create', 'Booking Update', 'Booking Delete'
            ],
            'Destination' => [
                'Destination Access', 'Destination Detail', 'Destination Create', 'Destination Update', 'Destination Delete'
            ],
            'Promotion' => [
                'Promotion Access', 'Promotion Detail', 'Promotion Create', 'Promotion Update', 'Promotion Delete'
            ],
            'Review' => [
                'Review Access', 'Review Detail', 'Review Update', 'Review Delete'
            ],
            'Property Rule' => [
                'Property Rule Access', 'Property Rule Detail', 'Property Rule Create', 'Property Rule Update', 'Property Rule Delete'
            ],
        ];

        foreach ($permissionsByGroup as $groupName => $permissions) {
            $group = PermissionGroup::firstOrCreate([
                'name' => $groupName
            ]);

            foreach ($permissions as $permName) {
                Permission::firstOrCreate([
                    'name'       => $permName,
                    'guard_name' => 'web'
                ], [
                    'permission_group_id' => $group->id
                ]);
            }
        }

        $superAdmin = Role::firstOrCreate([
            'name'       => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $superAdmin->givePermissionTo(Permission::all());

        $role = Role::firstOrCreate([
            'name'       => 'User',
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo('Article Access');
        $role->givePermissionTo('Content Management Access');
    }
}
