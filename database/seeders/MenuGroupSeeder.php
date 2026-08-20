<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuGroup;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\Cache;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getPgId = function ($name) {
            return PermissionGroup::where('name', $name)->value('id');
        };

        $groups = [
            [
                'name'                => 'Booking & Reservation',
                'permission_group_id' => $getPgId('Booking & Reservation') ?? $getPgId('Booking'),
                'sort'                => 1,
                'status'              => 1,
            ],
            [
                'name'                => 'Property Management',
                'permission_group_id' => $getPgId('Property Management') ?? $getPgId('Property'),
                'sort'                => 2,
                'status'              => 1,
            ],
            [
                'name'                => 'Marketing & Promotion',
                'permission_group_id' => $getPgId('Marketing & Promotion') ?? $getPgId('Promotion'),
                'sort'                => 3,
                'status'              => 1,
            ],
            [
                'name'                => 'Content Management',
                'permission_group_id' => $getPgId('Content Management') ?? $getPgId('Article'),
                'sort'                => 4,
                'status'              => 1,
            ],
            [
                'name'                => 'Finance & Payment',
                'permission_group_id' => $getPgId('Finance & Payment') ?? $getPgId('Payment Method'),
                'sort'                => 5,
                'status'              => 1,
            ],
            [
                'name'                => 'Settings',
                'permission_group_id' => $getPgId('Settings') ?? $getPgId('Setting'),
                'sort'                => 6,
                'status'              => 1,
            ],
        ];

        foreach ($groups as $group) {
            MenuGroup::updateOrCreate(
                ['name' => $group['name']],
                $group
            );
        }

        Cache::forget('admin_sidebar_menus');
    }
}
