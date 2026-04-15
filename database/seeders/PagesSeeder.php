<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['about',    ['ar' => 'من نحن',         'en' => 'About Us'],         ['ar' => '<p>شركة هوت سبوت منصة سعودية مرخصة من ساما لمقارنة عروض التمويل من أفضل البنوك.</p>', 'en' => '<p>Hotspot is a SAMA-licensed Saudi platform for comparing finance offers from top banks.</p>']],
            ['contact',  ['ar' => 'اتصل بنا',       'en' => 'Contact Us'],       ['ar' => '<p>نحن هنا للإجابة على أي استفسار. تواصل معنا عبر النموذج أدناه.</p>', 'en' => '<p>We\'re here to answer any question. Reach out via the form below.</p>']],
            ['privacy',  ['ar' => 'سياسة الخصوصية',  'en' => 'Privacy Policy'],  ['ar' => '<p>نلتزم بحماية بياناتك الشخصية وفقاً لأنظمة المملكة العربية السعودية.</p>', 'en' => '<p>We protect your personal data in accordance with Saudi regulations.</p>']],
            ['terms',    ['ar' => 'الشروط والأحكام', 'en' => 'Terms & Conditions'], ['ar' => '<p>باستخدامك للمنصة فأنت توافق على الشروط والأحكام التالية.</p>', 'en' => '<p>By using the platform you agree to the following terms and conditions.</p>']],
            ['faq',      ['ar' => 'الأسئلة الشائعة',  'en' => 'FAQ'],              ['ar' => '<p>أسئلة يسألها عملاؤنا بشكل متكرر.</p>', 'en' => '<p>Questions our customers frequently ask.</p>']],
        ];

        foreach ($pages as [$slug, $title, $content]) {
            Page::updateOrCreate(['slug' => $slug], [
                'title' => $title, 'content' => $content, 'is_published' => true,
            ]);
        }
    }
}
