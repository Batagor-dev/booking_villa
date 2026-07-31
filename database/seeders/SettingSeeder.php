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
            'title'       => 'Villa Management System',
            'author'      => 'Techarea Production',
            'keyword'     => ['villa', 'booking', 'resort', 'vacation', 'luxury', 'management'],
            'description' => 'Sistem Manajemen dan Pemesanan Villa Mewah & Resort Terpercaya.',
        ]);
    }
}