<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name'           => 'Bank Transfer BCA',
                'type'           => 'Bank Transfer',
                'provider'       => 'Bank BCA',
                'account_number' => '8830192831',
                'account_name'   => 'PT Villa Indonesia',
                'note'           => 'Silakan transfer tepat sesuai total tagihan hingga 3 digit terakhir.',
                'is_active'      => true,
            ],
            [
                'name'           => 'Bank Transfer Mandiri',
                'type'           => 'Bank Transfer',
                'provider'       => 'Bank Mandiri',
                'account_number' => '1370019283741',
                'account_name'   => 'PT Villa Indonesia',
                'note'           => 'Silakan sertakan nomor reservasi pada catatan transfer.',
                'is_active'      => true,
            ],
            [
                'name'           => 'QRIS Standar',
                'type'           => 'qris',
                'provider'       => 'QRIS Nasional',
                'account_name'   => 'PT Villa Indonesia',
                'note'           => 'Scan kode QRIS menggunakan aplikasi e-wallet (GoPay, OVO, Dana, LinkAja) atau m-Banking.',
                'is_active'      => true,
            ],
            [
                'name'           => 'Cash / Tunai Saat Check-in',
                'type'           => 'cash',
                'provider'       => 'Cash',
                'account_number' => '8830192831',
                'account_name'   => 'PT Villa Indonesia',
                'note'           => 'Wajib transfer DP (Down Payment) ke rekening BCA di atas terlebih dahulu untuk konfirmasi reservasi.',
                'is_active'      => true,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                $method
            );
        }
    }
}
