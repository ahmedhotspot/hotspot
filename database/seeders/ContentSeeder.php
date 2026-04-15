<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Faq;
use App\Models\HowItWorksStep;
use App\Models\Testimonial;
use App\Models\TrustMetric;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Trust metrics
        $metrics = [
            [['ar' => '+20',         'en' => '+20'],   ['ar' => 'مصرف شريك',  'en' => 'Partner Banks']],
            [['ar' => '+1 مليار ريال', 'en' => '+1B SAR'], ['ar' => 'تم تمويلها', 'en' => 'Funded']],
            [['ar' => '+100 ألف',    'en' => '+100K'], ['ar' => 'مستخدم سعيد', 'en' => 'Happy Users']],
        ];
        foreach ($metrics as $i => [$value, $label]) {
            TrustMetric::updateOrCreate(
                ['order' => $i + 1],
                ['value' => $value, 'label' => $label, 'is_active' => true]
            );
        }

        // How It Works
        $steps = [
            ['fa-id-card',    ['ar' => '1. تحقق من الأهلية',   'en' => '1. Check Eligibility'], ['ar' => 'أدخل بياناتك الأساسية واترك نظامنا يتحقق من ملفك المالي بشكل آمن وفوري.', 'en' => 'Enter your basic info and let our system verify your profile safely and instantly.']],
            ['fa-list-check', ['ar' => '2. قارن العروض',       'en' => '2. Compare Offers'],    ['ar' => 'شاهد عروض التمويل المعتمدة مسبقاً من عدة بنوك شريكة مرتبة حسب أفضل الأسعار.', 'en' => 'See pre-approved offers from multiple partner banks ranked by the best rates.']],
            ['fa-handshake',  ['ar' => '3. احصل على الموافقة', 'en' => '3. Get Approved'],      ['ar' => 'اختر العرض المفضل لديك، وأكمل الطلب الرقمي، واحصل على التمويل!', 'en' => 'Pick your favorite offer, complete the digital application, and get funded.']],
        ];
        foreach ($steps as $i => [$icon, $title, $desc]) {
            HowItWorksStep::updateOrCreate(
                ['order' => $i + 1],
                ['icon' => $icon, 'title' => $title, 'description' => $desc, 'is_active' => true]
            );
        }

        // Articles
        $articles = [
            ['apr',          ['ar' => 'المصطلحات',   'en' => 'Glossary'], ['ar' => 'ما هو معدل الربح السنوي ولماذا يهم؟',         'en' => 'What Is APR and Why It Matters?'],       ['ar' => 'معدل النسبة السنوية هو العامل الأكثر أهمية عند مقارنة التمويل. تعلم كيف يتم حسابه.', 'en' => 'APR is the most important factor when comparing loans. Learn how it is calculated.'], 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=500&q=80'],
            ['mortgage',     ['ar' => 'الرهن العقاري','en' => 'Mortgage'], ['ar' => 'متطلبات شراء المنزل لأول مرة في السعودية',     'en' => 'First-Time Home Buyer Requirements in KSA'], ['ar' => 'قائمة كاملة بالمستندات ومعايير الأهلية لتأمين الرهن العقاري الأول الخاص بك.',       'en' => 'A complete checklist of documents and eligibility criteria for your first mortgage.'], 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=500&q=80'],
            ['credit-score', ['ar' => 'استراتيجية',   'en' => 'Strategy'], ['ar' => 'كيفية تحسين درجة الائتمان الخاصة بك',          'en' => 'How to Improve Your Credit Score'],       ['ar' => 'خطوات بسيطة لتعزيز ملفك الائتماني والتأهل لأفضل أسعار الفائدة من كبرى البنوك.',  'en' => 'Simple steps to boost your credit profile and qualify for the best rates.'], 'https://images.unsplash.com/photo-1574169208507-84376144848b?w=500&q=80'],
        ];
        foreach ($articles as $i => [$slug, $cat, $title, $excerpt, $img]) {
            Article::updateOrCreate(['slug' => $slug], [
                'category'     => $cat,
                'title'        => $title,
                'excerpt'      => $excerpt,
                'content'      => $excerpt,
                'image'        => $img,
                'order'        => $i + 1,
                'is_featured'  => true,
                'published_at' => now(),
            ]);
        }

        // Testimonials
        $reviews = [
            ['A', 5.0, ['ar' => 'أحمد الغامدي', 'en' => 'Ahmed Al-Ghamdi'], ['ar' => 'الرياض', 'en' => 'Riyadh'], ['ar' => 'وفر علي حرفياً أياماً من زيارة فروع البنوك. كانت المقارنة فورية ووجدت سعر تمويل سيارة أقل بـ 1% مما عرضه علي البنك الذي أتعامل معه!', 'en' => 'Literally saved me days of branch visits. Comparison was instant — I found an auto rate 1% lower than my own bank!']],
            ['S', 5.0, ['ar' => 'سارة العتيبي',  'en' => 'Sarah Al-Otaibi'], ['ar' => 'جدة',    'en' => 'Jeddah'], ['ar' => 'الواجهة نظيفة وسهلة الاستخدام للغاية. أحببت أنها أظهرت بوضوح إجمالي الربح حتى عرفت بالضبط ما كنت أوافق عليه.', 'en' => 'Clean, easy-to-use interface. I loved that it showed total profit clearly so I knew exactly what I was signing up for.']],
            ['F', 4.5, ['ar' => 'فيصل ر.',      'en' => 'Faisal R.'],       ['ar' => 'الدمام', 'en' => 'Dammam'], ['ar' => 'تطبيق ممتاز! التمكن من رؤية العروض التي أتأهل لها بالفعل بناءً على راتبي منعني من إضاعة الوقت في التقديم للبنوك الخاطئة.', 'en' => 'Excellent app! Seeing offers I actually qualify for based on my salary saved me from applying to the wrong banks.']],
        ];
        foreach ($reviews as $i => [$initial, $stars, $name, $city, $text]) {
            Testimonial::updateOrCreate(
                ['order' => $i + 1],
                ['initial' => $initial, 'stars' => $stars, 'name' => $name, 'city' => $city, 'text' => $text, 'is_active' => true]
            );
        }

        // FAQs (seed a few starter ones)
        $faqs = [
            ['general', ['ar' => 'كيف تعمل منصة هوت سبوت؟',             'en' => 'How does the Hotspot platform work?'], ['ar' => 'تتيح لك مقارنة عروض التمويل من عدة بنوك ومؤسسات تمويلية مرخصة، ثم التقديم مباشرة للعرض الأنسب.', 'en' => 'It lets you compare financing offers from several licensed banks and finance companies, then apply directly to the best-fit offer.']],
            ['general', ['ar' => 'هل الخدمة مجانية؟',                    'en' => 'Is the service free?'],                 ['ar' => 'نعم، المقارنة مجانية تماماً. نحصل على عمولة من شركائنا عند إتمام التمويل.',                  'en' => 'Yes, comparison is completely free. We earn a commission from our partners on funded deals.']],
            ['eligibility', ['ar' => 'ما هي شروط التأهل للتمويل الشخصي؟', 'en' => 'What are the eligibility rules for personal finance?'], ['ar' => 'تختلف من بنك لآخر، وتعتمد عادة على الراتب وجهة العمل والسجل الائتماني.',                     'en' => 'Rules vary per bank and usually depend on salary, employer, and credit record.']],
        ];
        foreach ($faqs as $i => [$cat, $q, $a]) {
            Faq::updateOrCreate(
                ['order' => $i + 1, 'category' => $cat],
                ['question' => $q, 'answer' => $a, 'is_active' => true]
            );
        }
    }
}
