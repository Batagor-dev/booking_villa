<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::setValue([
            'title'       => 'Palma - Villa Management System',
            'author'      => 'Palma Team',
            'keyword'     => ['palma', 'villa', 'booking', 'resort', 'vacation', 'luxury', 'management'],
            'description' => 'Palma - Sistem Manajemen dan Pemesanan Villa Mewah & Resort Terpercaya.',
        ]);
    }
}