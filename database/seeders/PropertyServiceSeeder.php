<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyServices;

class PropertyServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name'        => 'Airport Transfer',
                'category'    => 'Transport',
                'price'       => 250000,
                'price_type'  => 'per_stay',
                'description' => 'Penjemputan dan pengantaran dari/ke bandara dengan mobil VIP AC.',
                'icon'        => 'ri-car-line',
                'sort'        => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Floating Breakfast',
                'category'    => 'F&B',
                'price'       => 150000,
                'price_type'  => 'per_person',
                'description' => 'Sarapan terapung mewah di private pool villa.',
                'icon'        => 'ri-restaurant-line',
                'sort'        => 2,
                'status'      => true,
            ],
            [
                'name'        => 'Traditional Massage & Spa',
                'category'    => 'Wellness',
                'price'       => 200000,
                'price_type'  => 'per_hour',
                'description' => 'Layanan pijat tradisional Bali langsung di kamar villa.',
                'icon'        => 'ri-spa-line',
                'sort'        => 3,
                'status'      => true,
            ],
            [
                'name'        => 'Scooter Rental',
                'category'    => 'Transport',
                'price'       => 85000,
                'price_type'  => 'per_item',
                'description' => 'Sewa motor matik kondisi prima termasuk 2 helm.',
                'icon'        => 'ri-motorbike-line',
                'sort'        => 4,
                'status'      => true,
            ],
        ];

        foreach ($services as $service) {
            PropertyServices::create($service);
        }
    }
}
