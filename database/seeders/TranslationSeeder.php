<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properties;
use App\Models\Destination;
use App\Models\Facilities;
use App\Models\PropertyRule;
use App\Models\Promotion;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds for multilingual content (ID, EN, JA).
     */
    public function run(): void
    {
        // 1. Seed Property Translations
        $propertyTranslations = [
            'villa-azure-ocean-sanctuary' => [
                'en' => [
                    'name' => 'Villa Azure Ocean Sanctuary',
                    'description' => 'Luxury beachfront villa with direct access to Seminyak white sands. Featuring stunning sunset views, private infinity pool, and 24-hour dedicated butler service.',
                    'address' => 'Jl. Kayu Aya No. 88, Seminyak, Kuta, Badung, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・アジュール・オーシャン・サンクチュアリ',
                    'description' => 'スミニャックの白砂ビーチに直結した最高級ビーチフロントヴィラ。息をのむような夕日、プライベートインフィニティプール、24時間対応のバトラーサービスをお楽しみいただけます。',
                    'address' => 'バリ島 スミニャック カユアヤ通り 88番',
                ],
            ],
            'villa-ocean-cliffview-retreat' => [
                'en' => [
                    'name' => 'Villa Ocean Cliffview Retreat',
                    'description' => 'Perched high on the dramatic cliffs of Uluwatu with breathtaking 180-degree Indian Ocean panoramas. Features outdoor heated jacuzzi and tropical relaxation gazebo.',
                    'address' => 'Jl. Pantai Suluban No. 12, Uluwatu, Badung, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・オーシャン・クリフビュー・リトリート',
                    'description' => 'ウルワツの断崖に佇み、インド洋を180度見渡すパノラマビュー。屋外ジャグジーと熱帯の静けさに包まれたリラクゼーションガゼボを備えています。',
                    'address' => 'バリ島 ウルワツ スルバンビーチ通り 12番',
                ],
            ],
            'villa-bamboo-jungle-sanctuary' => [
                'en' => [
                    'name' => 'Villa Bamboo Jungle Sanctuary',
                    'description' => 'Serene mountain retreat nestled in the lush tropical rainforest of Ubud. Immerse in the soothing sounds of Ayung River and sweeping emerald valley views.',
                    'address' => 'Jl. Raya Sayan No. 45, Ubud, Gianyar, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・バンブー・ジャングル・サンクチュアリ',
                    'description' => 'ウブドの緑豊かな熱帯雨林に囲まれた静寂のリトリート。アユン川のせせらぎとバルコニーから広がる緑の渓谷美をご満喫ください。',
                    'address' => 'バリ島 ウブド サヤン通り 45番',
                ],
            ],
            'villa-sunset-ricefield-breeze' => [
                'en' => [
                    'name' => 'Villa Sunset Ricefield Breeze',
                    'description' => 'Bohemian-chic modern villa overlooking the scenic emerald rice paddies of Canggu. Minutes away from iconic beach clubs and vibrant cafes.',
                    'address' => 'Jl. Batu Bolong No. 200, Canggu, Badung, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・サンセット・ライフィールド・ブリーズ',
                    'description' => 'チャングーの美しい水田風景を望むボヘミアンシックなモダンヴィラ。人気のビーチクラブやカフェにもほど近い好立地です。',
                    'address' => 'バリ島 チャングー バトゥボロン通り 200番',
                ],
            ],
            'villa-royal-palms-estate' => [
                'en' => [
                    'name' => 'Villa Royal Palms Estate',
                    'description' => 'Grand architectural resort estate in exclusive Nusa Dua. Designed for large families and luxury VIP gatherings with private cinema, tennis court, and gourmet chef.',
                    'address' => 'Kawasan Pariwisata Nusa Dua Lot NW-1, Badung, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・ロイヤル・パームス・エステート',
                    'description' => '高級リゾート地ヌサドゥアに位置する壮大なリゾートエステート。プライベートシアター、テニスコート、専属シェフを備えた贅沢な空間です。',
                    'address' => 'バリ島 ヌサドゥア リゾートエリア NW-1',
                ],
            ],
            'villa-serenity-sanur-palms' => [
                'en' => [
                    'name' => 'Villa Serenity Sanur Palms',
                    'description' => 'Calm coastal haven just steps from the tranquil waters of Sanur Beach. Features traditional Balinese joglo pavilions and lush flowering gardens.',
                    'address' => 'Jl. Danau Tamblingan No. 50, Sanur, Denpasar, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・セレニティ・サヌール・パームス',
                    'description' => 'サヌールビーチの穏やかな海岸線からすぐの静かな隠れ家。伝統的なバリ様式のパビリオンと花々が咲き誇るトロピカルガーデンが魅力です。',
                    'address' => 'バリ島 サヌール ダナウタンブリンガン通り 50番',
                ],
            ],
            'villa-jimbaran-sunset-paradise' => [
                'en' => [
                    'name' => 'Villa Jimbaran Sunset Paradise',
                    'description' => 'Stunning sunset sanctuary overlooking the golden sands of Jimbaran Bay. Enjoy private seafood dining and sunset cocktails.',
                    'address' => 'Jl. Bukit Permai No. 18, Jimbaran, Badung, Bali',
                ],
                'ja' => [
                    'name' => 'ヴィラ・ジンバラン・サンセット・パラダイス',
                    'description' => 'ジンバラン湾の美しい夕日を一望できるサンセットサンクチュアリ。プライベートシーフードディナーやカクテルタイムをお楽しみいただけます。',
                    'address' => 'バリ島 ジンバラン ブキットペルマイ通り 18番',
                ],
            ],
        ];

        $properties = Properties::all();
        foreach ($properties as $property) {
            $slug = $property->slug;
            $tData = $propertyTranslations[$slug] ?? null;

            // ID
            $property->updateTranslation('id', [
                'name'        => $property->getRawOriginal('name'),
                'description' => $property->getRawOriginal('description'),
                'address'     => $property->getRawOriginal('address'),
            ]);

            // EN
            $property->updateTranslation('en', [
                'name'        => $tData['en']['name'] ?? ($property->getRawOriginal('name') . ' (Luxury Villa)'),
                'description' => $tData['en']['description'] ?? 'Experience luxury and unparalleled privacy amidst the breathtaking tropical beauty of Bali.',
                'address'     => $tData['en']['address'] ?? $property->getRawOriginal('address'),
            ]);

            // JA
            $property->updateTranslation('ja', [
                'name'        => $tData['ja']['name'] ?? ('ヴィラ・' . $property->getRawOriginal('name')),
                'description' => $tData['ja']['description'] ?? 'バリ島の息をのむような美しい熱帯自然に囲まれた最高級のプライベートヴィラ。',
                'address'     => $tData['ja']['address'] ?? $property->getRawOriginal('address'),
            ]);
        }

        // 2. Seed Destination Translations
        $destinations = Destination::all();
        foreach ($destinations as $dest) {
            $destName = $dest->getRawOriginal('name');
            $dest->updateTranslation('id', [
                'name'       => $destName,
                'attraction' => $dest->getRawOriginal('attraction') ?: 'Pusat gaya hidup, pantai indah, dan kuliner kelas dunia.',
            ]);

            $dest->updateTranslation('en', [
                'name'       => $destName,
                'attraction' => $this->translateDestToEn($destName),
            ]);

            $dest->updateTranslation('ja', [
                'name'       => $this->translateDestToJa($destName),
                'attraction' => $this->translateDestAttractionToJa($destName),
            ]);
        }

        // 3. Seed Facility Translations
        $facilities = Facilities::all();
        foreach ($facilities as $facility) {
            $facName = $facility->getRawOriginal('name');
            $facDesc = $facility->getRawOriginal('description');

            $facility->updateTranslation('id', [
                'name'        => $facName,
                'description' => $facDesc,
            ]);
            $facility->updateTranslation('en', [
                'name'        => $this->translateFacilityToEn($facName),
                'description' => $this->translateFacilityDescToEn($facName),
            ]);
            $facility->updateTranslation('ja', [
                'name'        => $this->translateFacilityToJa($facName),
                'description' => $this->translateFacilityDescToJa($facName),
            ]);
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
                'description' => $this->translateRuleDescToEn($ruleTitle),
            ]);

            $rule->updateTranslation('ja', [
                'title'       => $this->translateRuleTitleToJa($ruleTitle),
                'description' => $this->translateRuleDescToJa($ruleTitle),
            ]);
        }

        // 5. Seed Promotion Translations
        $promotions = Promotion::all();
        foreach ($promotions as $promo) {
            $promoName = $promo->getRawOriginal('name');
            $promoDesc = $promo->getRawOriginal('description');

            $promo->updateTranslation('id', [
                'name'        => $promoName,
                'description' => $promoDesc,
            ]);

            $promo->updateTranslation('en', [
                'name'        => $this->translatePromoNameToEn($promo->code ?? $promoName),
                'description' => $this->translatePromoDescToEn($promo->code ?? $promoName),
            ]);

            $promo->updateTranslation('ja', [
                'name'        => $this->translatePromoNameToJa($promo->code ?? $promoName),
                'description' => $this->translatePromoDescToJa($promo->code ?? $promoName),
            ]);
        }
    }

    private function translateDestToEn(string $name): string
    {
        $map = [
            'Seminyak' => 'Vibrant beach clubs, chic boutiques, and world-class culinary scene.',
            'Ubud'     => 'Serene tropical rainforest, emerald rice terraces, and authentic cultural center.',
            'Uluwatu'  => 'Dramatic ocean cliff views, famous surf breaks, and enchanting Kecak dance.',
            'Canggu'   => 'Relaxed boho atmosphere, trendy beach clubs, and vibrant cafe lifestyle.',
            'Nusa Dua' => 'Prestigious 5-star resort enclave with calm crystal-clear beaches.',
            'Sanur'    => 'Tranquil coastal sunrise haven with relaxed seaside promenade.',
            'Jimbaran' => 'Picturesque golden bay with romantic beachfront seafood dining.',
        ];
        return $map[$name] ?? 'Premier destination in Bali offering breathtaking nature and hospitality.';
    }

    private function translateDestToJa(string $name): string
    {
        $map = [
            'Seminyak' => 'スミニャック',
            'Ubud'     => 'ウブド',
            'Canggu'   => 'チャングー',
            'Uluwatu'  => 'ウルワツ',
            'Nusa Dua' => 'ヌサドゥア',
            'Sanur'    => 'サヌール',
            'Jimbaran' => 'ジンバラン',
        ];
        return $map[$name] ?? $name;
    }

    private function translateDestAttractionToJa(string $name): string
    {
        $map = [
            'Seminyak' => '人気のビーチクラブ、洗練されたブティック、世界各国のグルメが集まる人気エリア。',
            'Ubud'     => '熱帯雨林の自然美、美しいライステラス、バリ伝統芸術の中心地。',
            'Uluwatu'  => '迫力ある断崖絶壁、有名なサーフスポット、幻想的なケチャックダンス。',
            'Canggu'   => '開放的なボヘミアンスタイル、おしゃれなカフェ、ビーチクラブが並ぶトレンドエリア。',
            'Nusa Dua' => '穏やかな白砂ビーチが広がる高級5つ星リゾートエリア。',
            'Sanur'    => '美しい日の出と穏やかな海辺の遊歩道が魅力の静かなリゾート地。',
            'Jimbaran' => '黄金色に輝く夕日とビーチ沿いのロマンチックなシーフードダイニング。',
        ];
        return $map[$name] ?? '美しい自然とおもてなしが魅力のバリ島人気エリア。';
    }

    private function translateFacilityToEn(string $name): string
    {
        $map = [
            'Private Swimming Pool'   => 'Private Swimming Pool',
            'Free High-Speed Wi-Fi'   => 'Free High-Speed Wi-Fi',
            'Air Conditioning'        => 'Air Conditioning',
            'Fully Equipped Kitchen'  => 'Fully Equipped Kitchen',
            'Free Private Parking'    => 'Free Private Parking',
            'Fitness Center / Gym'    => 'Fitness Center / Gym',
            'Kolam Renang'            => 'Private Swimming Pool',
            'Wifi Gratis'             => 'High-Speed Wi-Fi',
            'Dapur Lengkap'           => 'Fully Equipped Kitchen',
            'Parkir Gratis'           => 'Free Private Parking',
            'AC'                      => 'Air Conditioning',
            'Sarapan'                 => 'Complimentary Breakfast',
            'Gym'                     => 'Fitness Center',
            'Spa'                     => 'Luxury Spa & Wellness',
        ];
        return $map[$name] ?? $name;
    }

    private function translateFacilityDescToEn(string $name): string
    {
        $map = [
            'Private Swimming Pool'   => 'Clean private swimming pool equipped with comfortable sun loungers.',
            'Free High-Speed Wi-Fi'   => 'Super-fast Wi-Fi access up to 100 Mbps throughout the entire villa area.',
            'Air Conditioning'        => 'Independent AC units in every bedroom and living space.',
            'Fully Equipped Kitchen'  => 'Complete kitchen setup with stove, refrigerator, microwave, and cookware.',
            'Free Private Parking'    => 'Secure on-site private parking area for cars and scooters.',
            'Fitness Center / Gym'    => 'Fully equipped fitness facility and modern workout gear.',
        ];
        return $map[$name] ?? 'Premium facility provided for your utmost comfort.';
    }

    private function translateFacilityToJa(string $name): string
    {
        $map = [
            'Private Swimming Pool'   => 'プライベートプール',
            'Free High-Speed Wi-Fi'   => '無料高速Wi-Fi',
            'Air Conditioning'        => 'エアコン完備',
            'Fully Equipped Kitchen'  => 'フルキッチン設備',
            'Free Private Parking'    => '無料専用駐車場',
            'Fitness Center / Gym'    => 'フィットネスジム',
            'Kolam Renang'            => 'プライベートプール',
            'Wifi Gratis'             => '高速Wi-Fi',
            'Dapur Lengkap'           => 'フルキッチン',
            'Parkir Gratis'           => '専用駐車場',
            'AC'                      => 'エアコン完備',
            'Sarapan'                 => '朝食サービス',
            'Gym'                     => 'フィットネスジム',
            'Spa'                     => 'スパ＆ウェルネス',
        ];
        return $map[$name] ?? $name;
    }

    private function translateFacilityDescToJa(string $name): string
    {
        $map = [
            'Private Swimming Pool'   => '清潔なプライベートプールと快適なサンラウンジャーを完備。',
            'Free High-Speed Wi-Fi'   => 'ヴィラ全域で利用可能な最大100Mbpsの超高速Wi-Fi。',
            'Air Conditioning'        => '各寝室およびリビングスペースにエアコンを完備。',
            'Fully Equipped Kitchen'  => 'コンロ、冷蔵庫、電子レンジ、調理器具が揃ったキッチン。',
            'Free Private Parking'    => '車やバイクを安全に停められる専用駐車場。',
            'Fitness Center / Gym'    => '充実したトレーニング器具を備えたフィットネス施設。',
        ];
        return $map[$name] ?? '快適なご滞在のための充実した設備。';
    }

    private function translateRuleTitleToEn(string $title): string
    {
        $map = [
            'Waktu Check-in & Check-out'           => 'Check-in & Check-out Schedule',
            'Kapasitas Maksimal Tamu'              => 'Maximum Guest Capacity',
            'Larangan Merokok & Barang Ilegal'     => 'No Smoking & Hazardous Goods Policy',
            'Jam Tenang (Quiet Hours)'             => 'Quiet Hours (22:00 - 07:00)',
            'Acara, Pesta & Retribusi (Event)'     => 'Events, Parties & Local Retribution Policy',
            'Hewan Peliharaan & Layanan Extra Bed' => 'Pet Policy & Extra Bed Service',
            'Uang Jaminan (Security Deposit)'      => 'Security Deposit Policy',
            'Kebijakan Pembatalan & Refunds'       => 'Cancellation & Refund Policy',
            'Dilarang Merokok'                     => 'No Smoking Inside',
            'Waktu Tenang'                         => 'Quiet Hours',
            'Hewan Peliharaan'                     => 'Pet Policy',
            'Check-in / Check-out'                 => 'Check-in & Check-out Schedule',
        ];
        return $map[$title] ?? $title;
    }

    private function translateRuleDescToEn(string $title): string
    {
        $map = [
            'Waktu Check-in & Check-out'           => 'Standard check-in starts at 14:00 WITA. Check-out is before 12:00 WITA noon.',
            'Kapasitas Maksimal Tamu'              => 'Guest capacity must strictly adhere to the villa capacity rules. Exceeding capacity requires prior approval.',
            'Larangan Merokok & Barang Ilegal'     => 'Smoking is prohibited inside bedrooms (indoor area). Illegal drugs, weapons, or hazardous items are strictly prohibited.',
            'Jam Tenang (Quiet Hours)'             => 'Neighborhood quiet hours apply from 22:00 - 07:00 WITA for the comfort and tranquility of the surroundings.',
            'Acara, Pesta & Retribusi (Event)'     => 'Special events or parties require management permit and compliance with local community (Banjar) regulations.',
            'Hewan Peliharaan & Layanan Extra Bed' => 'Pets and extra bed requests require prior approval and optional service fees.',
            'Uang Jaminan (Security Deposit)'      => 'An optional refundable security deposit may apply upon check-in and is fully refunded at check-out.',
            'Kebijakan Pembatalan & Refunds'       => 'Free cancellation up to 7 days before check-in. Cancellations within 7 days are charged 50%.',
            'Dilarang Merokok'                     => 'Smoking is strictly prohibited inside the bedrooms and enclosed areas.',
            'Waktu Tenang'                         => 'Please respect the quiet hours after 10:00 PM to maintain a tranquil atmosphere.',
            'Hewan Peliharaan'                     => 'Pets are not allowed without prior written confirmation from the villa management.',
            'Check-in / Check-out'                 => 'Standard check-in starts at 14:00 and check-out is before 12:00 noon.',
        ];
        return $map[$title] ?? 'Please observe the villa guidelines for a pleasant stay.';
    }

    private function translateRuleTitleToJa(string $title): string
    {
        $map = [
            'Waktu Check-in & Check-out'           => 'チェックイン / アウト時間',
            'Kapasitas Maksimal Tamu'              => '最大宿泊人数規定',
            'Larangan Merokok & Barang Ilegal'     => '全館禁煙・危険物持込禁止規約',
            'Jam Tenang (Quiet Hours)'             => 'クワイエットアワー (静粛時間)',
            'Acara, Pesta & Retribusi (Event)'     => 'イベント・パーティー開催規約',
            'Hewan Peliharaan & Layanan Extra Bed' => 'ペット同伴・エキストラベッド規約',
            'Uang Jaminan (Security Deposit)'      => 'デポジット (保証金) 規定',
            'Kebijakan Pembatalan & Refunds'       => 'キャンセルポリシー＆返金規約',
            'Dilarang Merokok'                     => '全館禁煙ポリシー',
            'Waktu Tenang'                         => 'クワイエットアワー (静粛時間)',
            'Hewan Peliharaan'                     => 'ペット同伴規約',
            'Check-in / Check-out'                 => 'チェックイン / アウト時間',
        ];
        return $map[$title] ?? $title;
    }

    private function translateRuleDescToJa(string $title): string
    {
        $map = [
            'Waktu Check-in & Check-out'           => 'チェックインは14:00以降、チェックアウトは12:00正午までとなります。',
            'Kapasitas Maksimal Tamu'              => '宿泊人数は規定の定員を遵守してください。定員を超える場合は事前確認が必要です。',
            'Larangan Merokok & Barang Ilegal'     => '室内は完全禁煙です。違法薬物、武器、危険物の持ち込みは固く禁止されています。',
            'Jam Tenang (Quiet Hours)'             => '周辺環境の静寂を守るため、午後10時から午前7時まではクワイエットアワーとなります。',
            'Acara, Pesta & Retribusi (Event)'     => 'パーティーやイベントの開催には事前承認および地域コミュニティ（バンジャール）の規定遵守が必要です。',
            'Hewan Peliharaan & Layanan Extra Bed' => 'ペットの同伴や追加ベッド（エキストラベッド）のご利用には事前承認および追加料金が発生します。',
            'Uang Jaminan (Security Deposit)'      => 'チェックイン時に保証金をお預かりし、チェックアウト時の確認後に全額ご返金いたします。',
            'Kebijakan Pembatalan & Refunds'       => 'チェックイン7日前までのキャンセルは無料です。7日以内のキャンセルには50%の手数料がかかります。',
            'Dilarang Merokok'                     => '寝室および屋内は完全禁煙です。喫煙は指定の屋外エリアをご利用ください。',
            'Waktu Tenang'                         => '静かな環境を守るため、午後10時以降はお静かにお過ごしください。',
            'Hewan Peliharaan'                     => '事前の書面による承認がない場合、ペットの同伴はお断りしております。',
            'Check-in / Check-out'                 => 'チェックインは14:00以降、チェックアウトは12:00正午までとなります。',
        ];
        return $map[$title] ?? '快適なご滞在のため、ヴィラの利用規約をお守りください。';
    }

    private function translatePromoNameToEn(string $code): string
    {
        $map = [
            'PALMAWEEKEND' => 'Weekend Luxury Escape',
            'WELCOMEPALMA' => 'New Member Welcome Bonus',
            'LONGSTAY25'   => 'Long Stay Sanctuary (25% OFF)',
            'REFER100'     => 'Referral Credit $100',
        ];
        return $map[$code] ?? 'Exclusive Villa Promotion';
    }

    private function translatePromoBadgeToEn(string $badge): string
    {
        $map = [
            'FLASH SALE WEEKEND'   => 'FLASH SALE WEEKEND',
            'KHUSUS MEMBER BARU'   => 'EXCLUSIVE FOR NEW MEMBERS',
            'LONG STAY SANCTUARY'  => 'LONG STAY SANCTUARY',
            'REFERRAL REWARD'      => 'REFERRAL REWARD',
        ];
        return $map[$badge] ?? $badge;
    }

    private function translatePromoDescToEn(string $code): string
    {
        $map = [
            'PALMAWEEKEND' => 'Weekend retreat in handpicked luxury villas in Seminyak & Uluwatu. Enjoy 40% discount plus complimentary VIP dinner and welcome drinks.',
            'WELCOMEPALMA' => 'Register your Palma account today and claim an instant 35% discount on your first booking with free VIP airport transfer.',
            'LONGSTAY25'   => 'Enjoy extended stays in Bali. The longer you stay, the more savings you enjoy per night.',
            'REFER100'     => 'Invite family and friends to stay at Palma and earn a $100 credit per booking.',
        ];
        return $map[$code] ?? 'Special limited-time promotional offer for your luxury getaway.';
    }

    private function translatePromoNameToJa(string $code): string
    {
        $map = [
            'PALMAWEEKEND' => '週末ラグジュアリー・エスケープ',
            'WELCOMEPALMA' => '新規会員様限定ウェルカム特典',
            'LONGSTAY25'   => 'ロングステイ・サンクチュアリ (25% OFF)',
            'REFER100'     => 'お友達紹介クレジット $100',
        ];
        return $map[$code] ?? '限定プロモーション';
    }

    private function translatePromoBadgeToJa(string $badge): string
    {
        $map = [
            'FLASH SALE WEEKEND'   => '週末タイムセール',
            'KHUSUS MEMBER BARU'   => '新規会員限定',
            'LONG STAY SANCTUARY'  => '長期滞在プラン',
            'REFERRAL REWARD'      => '紹介リワード',
        ];
        return $map[$badge] ?? $badge;
    }

    private function translatePromoDescToJa(string $code): string
    {
        $map = [
            'PALMAWEEKEND' => 'スミニャックとウルワツの厳選ラグジュアリーヴィラでの週末ステイ。40%割引に加え、無料VIPディナーとウェルカムドリンクをご提供。',
            'WELCOMEPALMA' => 'Palmaアカウントをご登録で、初回のヴィラご予約が35%割引＆無料VIP空港送迎付き。',
            'LONGSTAY25'   => 'バリ島での長期滞在をお得に。滞在日数が長くなるほど1泊あたりの宿泊料がお得になります。',
            'REFER100'     => 'ご友人やご家族をご紹介いただくと、1回のご予約につき$100分のクレジットを進呈。',
        ];
        return $map[$code] ?? '最高峰のヴィラ体験をお得にお楽しみいただける特別プロモーション。';
    }
}

