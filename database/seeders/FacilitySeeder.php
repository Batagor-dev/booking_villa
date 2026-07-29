<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facilities;

class FacilitySeeder extends Seeder
{
    public function run()
    {
        $facilities = [
            [
                'name'        => 'Private Swimming Pool',
                'category'    => 'Outdoor',
                'description' => 'Kolam renang pribadi bersih dengan sunbed santai.',
                'icon'        => 'ri-drop-line',
                'sort'        => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Free High-Speed Wi-Fi',
                'category'    => 'General',
                'description' => 'Akses Wi-Fi super cepat hingga 100 Mbps di seluruh area villa.',
                'icon'        => 'ri-wifi-line',
                'sort'        => 2,
                'status'      => true,
            ],
            [
                'name'        => 'Air Conditioning',
                'category'    => 'Room',
                'description' => 'AC di setiap kamar tidur dan ruang keluarga.',
                'icon'        => 'ri-temp-cold-line',
                'sort'        => 3,
                'status'      => true,
            ],
            [
                'name'        => 'Fully Equipped Kitchen',
                'category'    => 'Room',
                'description' => 'Dapur lengkap dengan kompor, kulkas, microwave, dan alat masak.',
                'icon'        => 'ri-restaurant-2-line',
                'sort'        => 4,
                'status'      => true,
            ],
            [
                'name'        => 'Free Private Parking',
                'category'    => 'General',
                'description' => 'Area parkir pribadi aman untuk mobil dan sepeda motor.',
                'icon'        => 'ri-parking-box-line',
                'sort'        => 5,
                'status'      => true,
            ],
            [
                'name'        => 'Fitness Center / Gym',
                'category'    => 'General',
                'description' => 'Fasilitas pusat kebugaran dan alat olahraga lengkap.',
                'icon'        => 'ri-football-line',
                'sort'        => 6,
                'status'      => true,
            ],
        ];

        foreach ($facilities as $facility) {
            Facilities::create($facility);
        }
    }
}
