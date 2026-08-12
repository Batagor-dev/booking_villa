<?php

namespace Database\Seeders;

use App\Models\PropertyRule;
use Illuminate\Database\Seeder;

class PropertyRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            // General / All Property Rules
            [
                'title' => 'Waktu Check-in & Check-out',
                'property_type' => 'all',
                'icon' => 'ri-time-line',
                'description' => 'Check-in mulai pukul 14:00 WITA. Check-out maksimal pukul 12:00 WITA.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Kapasitas Maksimal Tamu',
                'property_type' => 'all',
                'icon' => 'ri-team-line',
                'description' => 'Kapasitas tamu menginap wajib sesuai ketentuan. Melebihi kapasitas wajib dikonfirmasi terlebih dahulu.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Larangan Merokok & Barang Ilegal',
                'property_type' => 'all',
                'icon' => 'ri-forbid-2-line',
                'description' => 'Dilarang merokok di dalam kamar (area indoor). Dilarang membawa obat terlarang, senjata, atau barang berbahaya.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Jam Tenang (Quiet Hours)',
                'property_type' => 'all',
                'icon' => 'ri-moon-line',
                'description' => 'Jam tenang lingkungan berlaku pukul 22:00 - 07:00 WITA demi kenyamanan lingkungan sekitar.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Acara, Pesta & Retribusi (Event)',
                'property_type' => 'Villa',
                'icon' => 'ri-service-line',
                'description' => 'Pesta/acara khusus wajib berizin pengelola dan memenuhi ketentuan retribusi adat/lingkungan (Banjar).',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Hewan Peliharaan & Layanan Extra Bed',
                'property_type' => 'all',
                'icon' => 'ri-parent-line',
                'description' => 'Hewan peliharaan dan permintaan kasur tambahan (Extra Bed) memerlukan persetujuan dan biaya opsional.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Uang Jaminan (Security Deposit)',
                'property_type' => 'all',
                'icon' => 'ri-wallet-3-line',
                'description' => 'Deposit kerusakan opsional dapat diberlakukan saat check-in dan dikembalikan utuh saat check-out.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'title' => 'Kebijakan Pembatalan & Refunds',
                'property_type' => 'all',
                'icon' => 'ri-file-shield-2-line',
                'description' => 'Pembatalan gratis hingga 7 hari sebelum check-in. Pembatalan < 7 hari dikenakan biaya 50%.',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($rules as $rule) {
            PropertyRule::updateOrCreate(
                ['title' => $rule['title']],
                $rule
            );
        }
    }
}
