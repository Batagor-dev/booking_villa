<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properties;
use App\Models\PropertySettings;

class PropertySettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            'villa-azure-ocean-sanctuary' => [
                'phone'     => '+62 811-385-9001',
                'email'     => 'reservation@villaazure-seminyak.com',
                'currency'  => 'IDR',
                'latitude'  => -8.6834164,
                'longitude' => 115.1541315,
            ],
            'villa-ocean-cliffview-retreat' => [
                'phone'     => '+62 812-390-8822',
                'email'     => 'info@oceancliffview-uluwatu.com',
                'currency'  => 'IDR',
                'latitude'  => -8.8149114,
                'longitude' => 115.0858163,
            ],
            'villa-bamboo-jungle-sanctuary' => [
                'phone'     => '+62 813-8900-1122',
                'email'     => 'stay@bamboojungle-ubud.com',
                'currency'  => 'IDR',
                'latitude'  => -8.5068537,
                'longitude' => 115.2624793,
            ],
            'villa-sunset-ricefield-breeze' => [
                'phone'     => '+62 819-0822-4411',
                'email'     => 'hello@ricefieldbreeze-canggu.com',
                'currency'  => 'IDR',
                'latitude'  => -8.6502391,
                'longitude' => 115.1328956,
            ],
            'villa-royal-palms-estate' => [
                'phone'     => '+62 811-9988-7766',
                'email'     => 'concierge@royalpalms-nusadua.com',
                'currency'  => 'IDR',
                'latitude'  => -8.7963282,
                'longitude' => 115.2223841,
            ],
        ];

        foreach ($settings as $slug => $settingData) {
            $property = Properties::where('slug', $slug)->first();
            if ($property) {
                PropertySettings::updateOrCreate(
                    ['property_id' => $property->id],
                    $settingData
                );
            }
        }
    }
}
