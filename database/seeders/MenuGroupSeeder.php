<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuGroup;

class MenuGroupSeeder extends Seeder
{
    public function run()
    {
        MenuGroup::firstOrCreate(
            ['name' => 'Content Management'],
            [
                'sort'   => 1,
                'status' => 1,
            ]
        );

        MenuGroup::firstOrCreate(
            ['name' => 'Property Management'],
            [
                'sort'   => 2,
                'status' => 1,
            ]
        );

        MenuGroup::firstOrCreate(
            ['name' => 'Settings'],
            [
                'sort'   => 3,
                'status' => 1,
            ]
        );
    }
}

