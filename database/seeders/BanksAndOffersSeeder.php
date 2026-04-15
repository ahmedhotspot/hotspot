<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BanksAndOffersSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['alrajhi', ['ar' => 'مصرف الراجحي', 'en' => 'Al Rajhi Bank'], 'assets/img/aleajhi.png'],
            ['riyad',   ['ar' => 'بنك الرياض',    'en' => 'Riyad Bank'],    'assets/img/riyad.png'],
            ['sab',     ['ar' => 'بنك ساب',       'en' => 'SAB'],           'assets/img/sab.jpg'],
        ];

        foreach ($banks as $i => [$slug, $name, $logo]) {
            Bank::updateOrCreate(['slug' => $slug], [
                'name' => $name, 'logo' => $logo, 'order' => $i + 1, 'is_active' => true,
            ]);
        }

        $personal = Service::where('slug', 'personal')->first();

        $offers = [
            ['alrajhi', 2.99, 2_500_000, 10_000, 1_850, ['ar' => 'موافقة فورية',       'en' => 'Instant Approval'], 'fa-bolt',  true],
            ['riyad',   3.15, 1_500_000, 10_000, 1_920, ['ar' => 'موافقة خلال 24 ساعة', 'en' => 'Approval in 24h'],  'fa-clock', false],
            ['sab',     3.40, 3_000_000, 10_000, 2_010, ['ar' => 'موافقة خلال 48 ساعة', 'en' => 'Approval in 48h'],  'fa-clock', false],
        ];

        foreach ($offers as $i => [$bankSlug, $apr, $max, $min, $monthly, $note, $icon, $isBest]) {
            $bank = Bank::where('slug', $bankSlug)->first();
            if (!$bank) continue;

            Offer::updateOrCreate(
                ['bank_id' => $bank->id, 'service_id' => $personal?->id],
                [
                    'apr'            => $apr,
                    'max_amount'     => $max,
                    'min_amount'     => $min,
                    'monthly_sample' => $monthly,
                    'max_term_years' => 5,
                    'approval_note'  => $note,
                    'approval_icon'  => $icon,
                    'is_best'        => $isBest,
                    'is_active'      => true,
                    'order'          => $i + 1,
                ]
            );
        }
    }
}
