<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // General
            ['general', 'site_name_ar', 'هوت سبوت للتمويل', 'text', 'اسم الموقع (عربي)', false, 1],
            ['general', 'site_name_en', 'Hotspot Finance', 'text', 'Site Name (EN)', false, 2],
            ['general', 'logo_ar', 'assets/img/logo_ar.png', 'image', 'الشعار (عربي)', false, 3],
            ['general', 'logo_en', 'assets/img/logo_ar.png', 'image', 'Logo (EN)', false, 4],
            ['general', 'favicon', 'assets/img/favicon.ico', 'image', 'الأيقونة المفضلة', false, 5],
            ['general', 'tagline', json_encode(['ar' => 'قارن عروض التمويل', 'en' => 'Compare Financing Offers'], JSON_UNESCAPED_UNICODE), 'text', 'العبارة التعريفية', true, 6],

            // Contact
            ['contact', 'email', 'Customercare@hotspot.sa', 'text', 'البريد الإلكتروني', false, 1],
            ['contact', 'phone', '8002450071', 'text', 'رقم الهاتف', false, 2],
            ['contact', 'phone_display', '800-245-0071', 'text', 'الهاتف للعرض', false, 3],
            ['contact', 'address', json_encode([
                'ar' => 'شركة هوت سبوت لسوق المنتجات الرقمية، 2493 السلي، 7326، الرياض، المملكة العربية السعودية',
                'en' => 'Hotspot Digital Products Marketplace, 2493 Al Sulay, 7326, Riyadh, Saudi Arabia',
            ], JSON_UNESCAPED_UNICODE), 'textarea', 'العنوان', true, 4],

            // Hero
            ['hero', 'badge', json_encode(['ar' => 'مرخص من ساما وموافقات فورية', 'en' => 'SAMA-Licensed · Instant Approvals'], JSON_UNESCAPED_UNICODE), 'text', 'شارة الهيرو', true, 1],
            ['hero', 'title_line_1', json_encode(['ar' => 'قارن واحصل على', 'en' => 'Compare & Get the'], JSON_UNESCAPED_UNICODE), 'text', 'عنوان السطر 1', true, 2],
            ['hero', 'title_line_2', json_encode(['ar' => 'أفضل عروض التمويل', 'en' => 'Best Financing Offers'], JSON_UNESCAPED_UNICODE), 'text', 'عنوان السطر 2', true, 3],
            ['hero', 'subtitle', json_encode([
                'ar' => 'احصل على أفضل عروض التمويل من أفضل البنوك وشركات التمويل بناءً على سجلك الائتماني من خلال موافقة فورية من شركائنا.',
                'en' => 'Get the best financing offers from top banks and finance companies based on your credit profile, with instant approval from our partners.',
            ], JSON_UNESCAPED_UNICODE), 'textarea', 'العنوان الفرعي', true, 4],

            // Apps & regulator
            ['app', 'google_play_url', 'https://play.google.com/store/apps/details?id=com.hotspotfin.client', 'text', 'رابط Google Play', false, 1],
            ['app', 'app_store_url',   'https://apps.apple.com/sa/app/hotspotfin/id6466173356', 'text', 'رابط App Store', false, 2],
            ['regulator', 'sama_logo', 'assets/img/central-bank.png', 'image', 'شعار ساما', false, 1],
            ['regulator', 'license_notice', json_encode([
                'ar' => 'الترخيص الرسمي: شركة هوت سبوت حاصلة على ترخيص من البنك المركزي السعودي للهوت سبوت في قطاع التمويل والأنشطة المساندة.',
                'en' => 'Official Licensing: Hotspot is licensed by the Saudi Central Bank for financing and ancillary activities.',
            ], JSON_UNESCAPED_UNICODE), 'textarea', 'نص الترخيص', true, 2],
        ];

        foreach ($data as [$group, $key, $value, $type, $label, $translatable, $order]) {
            Setting::updateOrCreate(
                ['key' => $key],
                compact('group', 'value', 'type', 'label', 'order') + ['is_translatable' => $translatable]
            );
        }
    }
}
