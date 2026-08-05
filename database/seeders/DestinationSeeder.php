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
                'image_path' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=75',
                'sort'       => 1,
                'status'     => true,
            ],
            [
                'name'       => 'Ubud',
                'slug'       => 'ubud',
                'tags'       => 'Hutan Tropis, Sawah Siring, Seni & Spa',
                'attraction' => 'Ketenangan alam tropis & pusat kebudayaan autentik Bali.',
                'image_path' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=600&q=75',
                'sort'       => 2,
                'status'     => true,
            ],
            [
                'name'       => 'Uluwatu',
                'slug'       => 'uluwatu',
                'tags'       => 'Tebing Laut, Pura Uluwatu, Surfing',
                'attraction' => 'Pemandangan tebing samudra & pertunjukan Tari Kecak.',
                'image_path' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=75',
                'sort'       => 3,
                'status'     => true,
            ],
            [
                'name'       => 'Canggu',
                'slug'       => 'canggu',
                'tags'       => 'Kafe Estetik, Echo Beach, Surfing',
                'attraction' => 'Gaya hidup santai, olahraga air & spot nongkrong modern.',
                'image_path' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=600&q=75',
                'sort'       => 4,
                'status'     => true,
            ],
            [
                'name'       => 'Nusa Dua',
                'slug'       => 'nusa-dua',
                'tags'       => 'Resort Bintang 5, Waterblow, Pasir Putih',
                'attraction' => 'Kawasan resort eksklusif dengan pantai tenang nan berseri.',
                'image_path' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=75',
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
