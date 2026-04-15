<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Header
        $header = [
            [['ar' => 'انواع التمويل',  'en' => 'Finance Types'],   '/services'],
            [['ar' => 'حاسبة التمويل',   'en' => 'Loan Calculator'], '/#calculator'],
            [['ar' => 'طلب تمويل',       'en' => 'Financing Request'], '/financing-request'],
            [['ar' => 'من نحن',         'en' => 'About Us'],         '/about'],
            [['ar' => 'اتصل بنا',       'en' => 'Contact Us'],       '/contact'],
            [['ar' => 'الأسئلة الشائعة', 'en' => 'FAQ'],              '/faq'],
        ];
        foreach ($header as $i => [$label, $url]) {
            MenuItem::updateOrCreate(
                ['location' => 'header', 'url' => $url],
                ['label' => $label, 'order' => $i + 1, 'is_active' => true]
            );
        }

        // Footer — Finance
        $finance = [
            [['ar' => 'تمويل شخصي',            'en' => 'Personal Finance'], '/services/personal'],
            [['ar' => 'تمويل السيارات',        'en' => 'Auto Finance'],     '/services/auto'],
            [['ar' => 'تمويل الرهن العقاري',   'en' => 'Mortgage Finance'], '/services/mortgage'],
            [['ar' => 'بطاقات الائتمان',       'en' => 'Credit Cards'],     '/services/credit-card'],
            [['ar' => 'تمويل الشركات الصغيرة', 'en' => 'SME Finance'],      '/services/sme'],
        ];
        foreach ($finance as $i => [$label, $url]) {
            MenuItem::updateOrCreate(
                ['location' => 'footer_finance', 'url' => $url],
                ['label' => $label, 'order' => $i + 1, 'is_active' => true]
            );
        }

        // Footer — Company
        $company = [
            [['ar' => 'من نحن',           'en' => 'About Us'],        '/about'],
            [['ar' => 'اتصل بنا',         'en' => 'Contact Us'],      '/contact'],
            [['ar' => 'سياسة الخصوصية',   'en' => 'Privacy Policy'],  '/privacy'],
            [['ar' => 'الشروط والأحكام', 'en' => 'Terms & Conditions'], '/terms'],
        ];
        foreach ($company as $i => [$label, $url]) {
            MenuItem::updateOrCreate(
                ['location' => 'footer_company', 'url' => $url],
                ['label' => $label, 'order' => $i + 1, 'is_active' => true]
            );
        }

        // Social links
        $socials = [
            ['twitter',   'https://twitter.com/',   'fa-brands fa-twitter'],
            ['linkedin',  'https://linkedin.com/',  'fa-brands fa-linkedin'],
            ['instagram', 'https://instagram.com/', 'fa-brands fa-instagram'],
        ];
        foreach ($socials as $i => [$platform, $url, $icon]) {
            SocialLink::updateOrCreate(['platform' => $platform], [
                'url' => $url, 'icon' => $icon, 'order' => $i + 1, 'is_active' => true,
            ]);
        }
    }
}
