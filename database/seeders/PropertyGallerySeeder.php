<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properties;
use App\Models\PropertyGallery;

class PropertyGallerySeeder extends Seeder
{
    public function run()
    {
        $galleries = [
            'villa-azure-ocean-sanctuary' => [
                ['image_path' => 'property-galleries/gallery-1.jpg', 'caption' => 'Pemandangan Infinity Pool Tepi Pantai', 'sort' => 1],
                ['image_path' => 'property-galleries/gallery-2.jpg', 'caption' => 'Kamar Utama Master Bedroom Suite', 'sort' => 2],
                ['image_path' => 'property-galleries/gallery-3.jpg', 'caption' => 'Ruang Keluarga Modern Minimalis', 'sort' => 3],
                ['image_path' => 'property-galleries/gallery-4.jpg', 'caption' => 'Balkon Atas Pemandangan Sunset', 'sort' => 4],
                ['image_path' => 'property-galleries/gallery-5.jpg', 'caption' => 'Kamar Mandi Mewah Bathtub Marmer', 'sort' => 5],
            ],
            'villa-ocean-cliffview-retreat' => [
                ['image_path' => 'property-galleries/gallery-2.jpg', 'caption' => 'Pemandangan Laut 180 Derajat Uluwatu', 'sort' => 1],
                ['image_path' => 'property-galleries/gallery-1.jpg', 'caption' => 'Jacuzzi Outdoor Tepi Tebing', 'sort' => 2],
                ['image_path' => 'property-galleries/gallery-3.jpg', 'caption' => 'Kamar Tidur Utama Nuansa Kayu', 'sort' => 3],
                ['image_path' => 'property-galleries/gallery-4.jpg', 'caption' => 'Gazebo Santai Sore Hari', 'sort' => 4],
                ['image_path' => 'property-galleries/gallery-5.jpg', 'caption' => 'Area Makan Terbuka', 'sort' => 5],
            ],
            'villa-bamboo-jungle-sanctuary' => [
                ['image_path' => 'property-galleries/gallery-3.jpg', 'caption' => 'Kolam Renang Hutan Ubud', 'sort' => 1],
                ['image_path' => 'property-galleries/gallery-1.jpg', 'caption' => 'Arsitektur Bambu Unik khas Ubud', 'sort' => 2],
                ['image_path' => 'property-galleries/gallery-2.jpg', 'caption' => 'Kamar Tidur Kanopi Bambu', 'sort' => 3],
                ['image_path' => 'property-galleries/gallery-4.jpg', 'caption' => 'Balkon Lembah Sungai Ayung', 'sort' => 4],
                ['image_path' => 'property-galleries/gallery-5.jpg', 'caption' => 'Kamar Mandi Terbuka Nuansa Alam', 'sort' => 5],
            ],
            'villa-sunset-ricefield-breeze' => [
                ['image_path' => 'property-galleries/gallery-4.jpg', 'caption' => 'Kolam Renang & Pemandangan Sawah', 'sort' => 1],
                ['image_path' => 'property-galleries/gallery-1.jpg', 'caption' => 'Ruang Santai Sunken Lounge', 'sort' => 2],
                ['image_path' => 'property-galleries/gallery-2.jpg', 'caption' => 'Kamar Tidur Modern Minimalis Boho', 'sort' => 3],
                ['image_path' => 'property-galleries/gallery-3.jpg', 'caption' => 'Area Makan Dapur Terbuka', 'sort' => 4],
                ['image_path' => 'property-galleries/gallery-5.jpg', 'caption' => 'Teras Sunset Canggu', 'sort' => 5],
            ],
            'villa-royal-palms-estate' => [
                ['image_path' => 'property-galleries/gallery-5.jpg', 'caption' => 'Kolam Renang Utama Ukuran Olimpiade', 'sort' => 1],
                ['image_path' => 'property-galleries/gallery-1.jpg', 'caption' => 'Kamar Utama VVIP Suite Room', 'sort' => 2],
                ['image_path' => 'property-galleries/gallery-2.jpg', 'caption' => 'Taman Hijau & Gazebo Santai', 'sort' => 3],
                ['image_path' => 'property-galleries/gallery-3.jpg', 'caption' => 'Paviliun Spa & Relaksasi', 'sort' => 4],
                ['image_path' => 'property-galleries/gallery-4.jpg', 'caption' => 'Kamar Mandi Marmer Eksklusif', 'sort' => 5],
            ],
        ];

        foreach ($galleries as $slug => $items) {
            $property = Properties::where('slug', $slug)->first();
            if ($property) {
                // Clear existing galleries for clean seed
                PropertyGallery::where('property_id', $property->id)->delete();

                foreach ($items as $item) {
                    $property->galleries()->create($item);
                }
            }
        }
    }
}
