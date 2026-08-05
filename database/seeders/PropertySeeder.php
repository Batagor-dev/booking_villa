<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properties;
use App\Models\Facilities;
use App\Models\Destination;

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
                'map_link'       => '<iframe src="https://maps.google.com/maps?q=Jl.%20Kayu%20Aya%20No.%2088,%20Seminyak,%20Bali&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
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
                'map_link'       => '<iframe src="https://maps.google.com/maps?q=Jl.%20Pantai%20Suluban%20No.%2012,%20Uluwatu,%20Bali&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
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
                'map_link'       => '<iframe src="https://maps.google.com/maps?q=Jl.%20Raya%20Sayan%20No.%2045,%20Ubud,%20Bali&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
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
                'map_link'       => '<iframe src="https://maps.google.com/maps?q=Jl.%20Batu%20Bolong%20No.%20200,%20Canggu,%20Bali&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
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
                'map_link'       => '<iframe src="https://maps.google.com/maps?q=Kawasan%20Pariwisata%20Nusa%20Dua,%20Bali&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'status'         => true,
                'is_featured'    => true,
            ],
        ];

        foreach ($properties as $data) {
            $dest = Destination::where('name', $data['city'])->first();
            if ($dest) {
                $data['destination_id'] = $dest->id;
            }

            $property = Properties::updateOrCreate(['slug' => $data['slug']], $data);

            // Sync Facilities
            if (!empty($facilities)) {
                $property->facilities()->sync($facilities);
            }
        }
    }
}
