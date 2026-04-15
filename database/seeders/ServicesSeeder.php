<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['personal',    'fa-user-tie',    'icon-personal',  ['ar' => 'تمويل شخصي',            'en' => 'Personal Finance'], ['ar' => 'حلول تمويلية مرنة تناسب احتياجاتك الشخصية',     'en' => 'Flexible financing solutions tailored to your personal needs']],
            ['auto',        'fa-car',         'icon-auto',      ['ar' => 'تمويل السيارات',        'en' => 'Auto Finance'],     ['ar' => 'اختر سيارتك واحصل على أفضل عروض التمويل',       'en' => 'Pick your car and get the best financing offers']],
            ['mortgage',    'fa-house',       'icon-mortgage',  ['ar' => 'تمويل الرهن العقاري',   'en' => 'Mortgage Finance'], ['ar' => 'تملّك منزل أحلامك بأفضل الشروط التمويلية',      'en' => 'Own your dream home with the best financing terms']],
            ['credit-card', 'fa-credit-card', 'icon-credit',    ['ar' => 'بطاقة الائتمان',        'en' => 'Credit Card'],      ['ar' => 'بطاقات ائتمان بمزايا حصرية تناسب أسلوب حياتك',  'en' => 'Credit cards with exclusive benefits to match your lifestyle']],
            ['sme',         'fa-briefcase',   'icon-sme',       ['ar' => 'تمويل الشركات الصغيرة', 'en' => 'SME Finance'],      ['ar' => 'نمِّ أعمالك مع حلول تمويلية مصممة للشركات',     'en' => 'Grow your business with financing solutions built for companies']],
        ];

        foreach ($items as $i => [$slug, $icon, $iconClass, $title, $desc]) {
            Service::updateOrCreate(['slug' => $slug], [
                'title'       => $title,
                'description' => $desc,
                'icon'        => $icon,
                'icon_class'  => $iconClass,
                'order'       => $i + 1,
                'is_active'   => true,
            ]);
        }
    }
}
