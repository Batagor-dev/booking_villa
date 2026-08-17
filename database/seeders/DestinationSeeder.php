<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name'       => 'Seminyak',
                'slug'       => 'seminyak',
                'tags'       => 'Beach Club, Kuliner, Belanja',
                'attraction' => 'Sunset spektakuler & gaya hidup pantai mewah.',
                'image_path' => 'destination-images/seminyak.jpg',
                'sort'       => 1,
                'status'     => true,
            ],
            [
                'name'       => 'Ubud',
                'slug'       => 'ubud',
                'tags'       => 'Hutan Tropis, Sawah Siring, Seni & Spa',
                'attraction' => 'Ketenangan alam tropis & pusat kebudayaan autentik Bali.',
                'image_path' => 'destination-images/ubud.jpg',
                'sort'       => 2,
                'status'     => true,
            ],
            [
                'name'       => 'Uluwatu',
                'slug'       => 'uluwatu',
                'tags'       => 'Tebing Laut, Pura Uluwatu, Surfing',
                'attraction' => 'Pemandangan tebing samudra & pertunjukan Tari Kecak.',
                'image_path' => 'destination-images/uluwatu.jpg',
                'sort'       => 3,
                'status'     => true,
            ],
            [
                'name'       => 'Canggu',
                'slug'       => 'canggu',
                'tags'       => 'Kafe Estetik, Echo Beach, Surfing',
                'attraction' => 'Gaya hidup santai, olahraga air & spot nongkrong modern.',
                'image_path' => 'destination-images/canggu.jpg',
                'sort'       => 4,
                'status'     => true,
            ],
            [
                'name'       => 'Nusa Dua',
                'slug'       => 'nusa-dua',
                'tags'       => 'Resort Bintang 5, Waterblow, Pasir Putih',
                'attraction' => 'Kawasan resort eksklusif dengan pantai tenang nan berseri.',
                'image_path' => 'destination-images/nusa-dua.jpg',
                'sort'       => 5,
                'status'     => true,
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(
                ['slug' => $dest['slug']],
                $dest
            );
        }
    }
}
