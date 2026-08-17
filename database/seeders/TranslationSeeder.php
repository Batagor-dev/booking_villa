<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properties;
use App\Models\Destination;
use App\Models\Facilities;
use App\Models\PropertyRule;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds for multilingual content (ID, EN, JA).
     */
    public function run(): void
    {
        // 1. Seed Property Translations
        $properties = Properties::all();
        foreach ($properties as $property) {
            // Indonesia (ID) - ensure exists
            $property->updateTranslation('id', [
                'name'        => $property->getRawOriginal('name') ?: 'Villa Mewah Bali',
                'description' => $property->getRawOriginal('description') ?: 'Nikmati kemewahan dan privasi terbaik dengan pemandangan alam tropis Bali yang memesona.',
                'address'     => $property->getRawOriginal('address') ?: 'Jl. Sunset Road, Seminyak, Bali',
            ]);

            // English (EN)
            $property->updateTranslation('en', [
                'name'        => $this->translateToEn($property->getRawOriginal('name')),
                'description' => 'Experience ultimate luxury and unparalleled privacy amidst the breathtaking tropical beauty of Bali. Featuring private pool, spacious living areas, and bespoke concierge service.',
                'address'     => $property->getRawOriginal('address') ?: 'Sunset Road Blvd, Seminyak, Bali',
            ]);

            // Japanese (JA)
            $property->updateTranslation('ja', [
                'name'        => $this->translateToJa($property->getRawOriginal('name')),
                'description' => 'バリ島の息をのむような美しい熱帯自然に囲まれた最高級のプライベートヴィラ。プライベートプール、広々としたリビング、充実したコンシェルジュサービスをお楽しみいただけます。',
                'address'     => $property->getRawOriginal('address') ?: 'バリ島 スミニャック サンセットロード',
            ]);
        }

        // 2. Seed Destination Translations
        $destinations = Destination::all();
        foreach ($destinations as $dest) {
            $dest->updateTranslation('id', [
                'name'       => $dest->getRawOriginal('name'),
                'attraction' => $dest->getRawOriginal('attraction') ?: 'Pusat gaya hidup, pantai indah, dan kuliner kelas dunia.',
            ]);

            $dest->updateTranslation('en', [
                'name'       => $dest->getRawOriginal('name'),
                'attraction' => 'Lifestyle hub, stunning beaches, vibrant beach clubs, and world-class dining.',
            ]);

            $dest->updateTranslation('ja', [
                'name'       => $this->translateDestToJa($dest->getRawOriginal('name')),
                'attraction' => '美しいビーチ、人気のビーチクラブ、洗練されたダイニングが集まる人気エリア。',
            ]);
        }

        // 3. Seed Facility Translations
        $facilities = Facilities::all();
        foreach ($facilities as $facility) {
            $facName = $facility->getRawOriginal('name');
            $facility->updateTranslation('id', ['name' => $facName]);
            $facility->updateTranslation('en', ['name' => $this->translateFacilityToEn($facName)]);
            $facility->updateTranslation('ja', ['name' => $this->translateFacilityToJa($facName)]);
        }

        // 4. Seed Property Rule Translations
        $rules = PropertyRule::all();
        foreach ($rules as $rule) {
            $ruleTitle = $rule->getRawOriginal('title');
            $ruleDesc = $rule->getRawOriginal('description');

            $rule->updateTranslation('id', [
                'title'       => $ruleTitle,
                'description' => $ruleDesc,
            ]);

            $rule->updateTranslation('en', [
                'title'       => $this->translateRuleTitleToEn($ruleTitle),
                'description' => 'Please respect the villa community and quiet hours after 10 PM. No unauthorized parties allowed.',
            ]);

            $rule->updateTranslation('ja', [
                'title'       => $this->translateRuleTitleToJa($ruleTitle),
                'description' => '午後10時以降はお静かにお過ごしください。無許可のパーティーや喫煙は禁止されています。',
            ]);
        }
    }

    private function translateToEn(string $name): string
    {
        return str_ireplace(
            ['Mawar', 'Melati', 'Pantai', 'Surgawi', 'Indah', 'Cahaya'],
            ['Rose Luxury Villa', 'Jasmine Sanctuary', 'Coastal Haven', 'Paradise Haven', 'Serene Breeze', 'Lumina Estate'],
            $name
        ) . ' (Exclusive)';
    }

    private function translateToJa(string $name): string
    {
        return 'ヴィラ・' . str_ireplace(
            ['Villa ', 'Villa', 'Mawar', 'Melati', 'Pantai', 'Surgawi', 'Indah'],
            ['', '', 'ローズ', 'ジャスミン', 'オーシャン', 'パラダイス', 'セレニティ'],
            $name
        ) . ' リゾート';
    }

    private function translateDestToJa(string $name): string
    {
        $map = [
            'Seminyak' => 'スミニャック',
            'Ubud' => 'ウブド',
            'Canggu' => 'チャングー',
            'Uluwatu' => 'ウルワツ',
            'Nusa Dua' => 'ヌサドゥア',
            'Sanur' => 'サヌール',
            'Jimbaran' => 'ジンバラン',
        ];
        return $map[$name] ?? $name;
    }

    private function translateFacilityToEn(string $name): string
    {
        $map = [
            'Kolam Renang' => 'Private Swimming Pool',
            'Wifi Gratis' => 'High-Speed Wi-Fi',
            'Dapur Lengkap' => 'Fully Equipped Kitchen',
            'Parkir Gratis' => 'Free Private Parking',
            'AC' => 'Air Conditioning',
            'Sarapan' => 'Complimentary Breakfast',
            'Gym' => 'Fitness Center',
            'Spa' => 'Luxury Spa & Wellness',
        ];
        return $map[$name] ?? $name;
    }

    private function translateFacilityToJa(string $name): string
    {
        $map = [
            'Kolam Renang' => 'プライベートプール',
            'Wifi Gratis' => '高速Wi-Fi',
            'Dapur Lengkap' => 'フルキッチン',
            'Parkir Gratis' => '専用駐車場',
            'AC' => 'エアコン完備',
            'Sarapan' => '朝食サービス',
            'Gym' => 'フィットネスジム',
            'Spa' => 'スパ＆ウェルネス',
        ];
        return $map[$name] ?? $name;
    }

    private function translateRuleTitleToEn(string $title): string
    {
        $map = [
            'Dilarang Merokok' => 'No Smoking Inside',
            'Waktu Tenang' => 'Quiet Hours',
            'Hewan Peliharaan' => 'Pet Policy',
            'Check-in / Check-out' => 'Check-in & Check-out Schedule',
        ];
        return $map[$title] ?? $title;
    }

    private function translateRuleTitleToJa(string $title): string
    {
        $map = [
            'Dilarang Merokok' => '全館禁煙',
            'Waktu Tenang' => 'クワイエットアワー (静粛時間)',
            'Hewan Peliharaan' => 'ペット同伴について',
            'Check-in / Check-out' => 'チェックイン / アウト時間',
        ];
        return $map[$title] ?? $title;
    }
}
