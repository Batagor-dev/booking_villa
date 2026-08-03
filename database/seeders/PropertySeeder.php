<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properties;
use App\Models\Facilities;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $facilities = Facilities::pluck('id')->toArray();

        $properties = [
            [
                'name'           => 'Villa Azure Ocean Sanctuary',
                'slug'           => 'villa-azure-ocean-sanctuary',
                'code'           => 'VAO',
                'type'           => 'Villa',
                'price'          => 4500000.00,
                'bedrooms'       => 5,
                'capacity'       => 10,
                'rating'         => 4.95,
                'city'           => 'Seminyak',
                'province'       => 'Bali',
                'postal_code'    => '80361',
                'address'        => 'Jl. Kayu Aya No. 88, Seminyak, Kuta, Badung, Bali',
                'main_image'     => 'property-covers/villa-1.jpg',
                'description'    => 'Villa mewah tepi pantai dengan akses langsung ke pasir putih Seminyak. Menawarkan pemandangan sunset memukau, infinity pool pribadi, dan pelayanan butler 24 jam.',
                'map_link'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.0261331776955!2d115.1541315!3d-8.6834164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd24752dfaa1585%3A0xe54d306b3a09e0eb!2sSeminyak%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'status'         => true,
                'is_featured'    => true,
            ],
            [
                'name'           => 'Villa Ocean Cliffview Retreat',
                'slug'           => 'villa-ocean-cliffview-retreat',
                'code'           => 'VOC',
                'type'           => 'Villa',
                'price'          => 6500000.00,
                'bedrooms'       => 4,
                'capacity'       => 8,
                'rating'         => 4.90,
                'city'           => 'Uluwatu',
                'province'       => 'Bali',
                'postal_code'    => '80364',
                'address'        => 'Jl. Pantai Suluban No. 12, Uluwatu, Badung, Bali',
                'main_image'     => 'property-covers/villa-2.jpg',
                'description'    => 'Berada di atas tebing Uluwatu dengan pemandangan Samudra Hindia 180 derajat. Dilengkapi jacuzzi outdoor dan gazebo santai bernuansa tropis.',
                'map_link'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.868741348123!2d115.0858163!3d-8.8149114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd25d48a6042129%3A0x6b306b2512a673c!2sUluwatu%2C%20Pecatu%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'status'         => true,
                'is_featured'    => true,
            ],
            [
                'name'           => 'Villa Bamboo Jungle Sanctuary',
                'slug'           => 'villa-bamboo-jungle-sanctuary',
                'code'           => 'VBJ',
                'type'           => 'Villa',
                'price'          => 3200000.00,
                'bedrooms'       => 3,
                'capacity'       => 6,
                'rating'         => 4.88,
                'city'           => 'Ubud',
                'province'       => 'Bali',
                'postal_code'    => '80571',
                'address'        => 'Jl. Raya Sayan No. 45, Ubud, Gianyar, Bali',
                'main_image'     => 'property-covers/villa-3.jpg',
                'description'    => 'Peristirahatan tenang di tengah hutan tropis Ubud. Nikmati suara aliran sungai Ayung dan pemandangan lembah hijau dari balkon kamar Anda.',
                'map_link'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.7176412154!2d115.2624793!3d-8.5068537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d739f22c9e3%3A0x4030bfb47d3e790!2sUbud%2C%20Gianyar%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'status'         => true,
                'is_featured'    => false,
            ],
            [
                'name'           => 'Villa Sunset Ricefield Breeze',
                'slug'           => 'villa-sunset-ricefield-breeze',
                'code'           => 'VSR',
                'type'           => 'Villa',
                'price'          => 4100000.00,
                'bedrooms'       => 4,
                'capacity'       => 8,
                'rating'         => 4.85,
                'city'           => 'Canggu',
                'province'       => 'Bali',
                'postal_code'    => '80351',
                'address'        => 'Jl. Batu Bolong No. 200, Canggu, Badung, Bali',
                'main_image'     => 'property-covers/villa-4.jpg',
                'description'    => 'Villa gaya modern boho dengan hamparan pemandangan sawah hijau Canggu. Dekat dengan beach club ternama dan kafe hits Canggu.',
                'map_link'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.372551412015!2d115.1328956!3d-8.6502391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23882bbd51381%3A0x600f16298517c24a!2sCanggu%2C%20Kuta%20Utara%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'status'         => true,
                'is_featured'    => true,
            ],
            [
                'name'           => 'Villa Royal Palms Estate',
                'slug'           => 'villa-royal-palms-estate',
                'code'           => 'VRP',
                'type'           => 'Resort',
                'price'          => 8500000.00,
                'bedrooms'       => 6,
                'capacity'       => 12,
                'rating'         => 4.98,
                'city'           => 'Nusa Dua',
                'province'       => 'Bali',
                'postal_code'    => '80363',
                'address'        => 'Kawasan Pariwisata Nusa Dua Lot 5, Nusa Dua, Badung, Bali',
                'main_image'     => 'property-covers/villa-5.jpg',
                'description'    => 'Villa super eksklusif seluas 1.500 m² di kawasan Nusa Dua. Memiliki kolam renang privat terbesar, lapangan tenis pribadi, dan spa paviliun.',
                'map_link'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.084124589012!2d115.2223841!3d-8.7963282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd243da7893dbdb%3A0x9d0cf3b85ab1904e!2sNusa%20Dua%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'status'         => true,
                'is_featured'    => true,
            ],
        ];

        foreach ($properties as $data) {
            $property = Properties::create($data);

            // Sync Facilities
            if (!empty($facilities)) {
                $property->facilities()->sync($facilities);
            }
        }
    }
}
