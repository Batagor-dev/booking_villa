<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuGroup;

class MenuGroupSeeder extends Seeder
{
    public function run()
    {
        MenuGroup::updateOrCreate(
            ['name' => 'Content Management'],
            [
                'permission_group_id' => 14,
                'sort'   => 1,
                'status' => 1,
            ]
        );

        MenuGroup::updateOrCreate(
            ['name' => 'Property Management'],
            [
                'permission_group_id' => 15,
                'sort'   => 2,
                'status' => 1,
            ]
        );

        MenuGroup::updateOrCreate(
            ['name' => 'Settings'],
            [
                'permission_group_id' => 16,
                'sort'   => 3,
                'status' => 1,
            ]
        );
    }
}
