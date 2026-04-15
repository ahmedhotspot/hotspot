<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class ContentBlocksSeeder extends Seeder
{
    public function run(): void
    {
        $blocks = $this->blocks();

        foreach ($blocks as $order => $b) {
            ContentBlock::updateOrCreate(
                ['page' => $b['page'], 'section' => $b['section'], 'key' => $b['key']],
                [
                    'type'  => $b['type'],
                    'value' => $b['value'],
                    'label' => $b['label'] ?? null,
                    'order' => $b['order'] ?? $order,
                ]
            );
        }

        ContentBlock::clearCache();
    }

    private function t(string $page, string $section, string $key, string $ar, string $en, string $label, string $type = 'text'): array
    {
        return [
            'page' => $page, 'section' => $section, 'key' => $key, 'type' => $type,
            'value' => ['ar' => $ar, 'en' => $en], 'label' => $label,
        ];
    }

    private function img(string $page, string $section, string $key, string $path, string $label): array
    {
        return [
            'page' => $page, 'section' => $section, 'key' => $key, 'type' => 'image',
            'value' => ['path' => $path], 'label' => $label,
        ];
    }

    private function blocks(): array
    {
        return [
            // ============ COMMON (shared) ============
            $this->t('common', 'buttons', 'apply_now', 'قدّم الآن', 'Apply Now', 'Apply Now button'),
            $this->t('common', 'buttons', 'learn_more', 'اعرف المزيد', 'Learn More', 'Learn More button'),
            $this->t('common', 'buttons', 'read_more', 'المزيد', 'More', 'More link'),
            $this->t('common', 'buttons', 'back_to_home', 'الرجوع للرئيسية', 'Back to Home', 'Back to home'),
            $this->t('common', 'labels', 'sar', 'ريال', 'SAR', 'SAR currency'),
            $this->t('common', 'labels', 'sar_short', 'ر.س', 'SAR', 'SAR short currency'),
            $this->t('common', 'labels', 'sar_monthly', 'ريال / شهر', 'SAR/mo', 'SAR per month'),
            $this->t('common', 'labels', 'amount', 'المبلغ', 'Amount', 'Amount label'),
            $this->t('common', 'labels', 'rate', 'النسبة', 'Rate', 'Rate label'),
            $this->t('common', 'labels', 'general', 'عام', 'General', 'General'),

            // ============ HOME ============
            $this->t('home', 'hero', 'cta_compare', 'قارن العروض', 'Compare Offers', 'Hero compare CTA'),
            $this->t('home', 'hero', 'cta_how', 'كيف يعمل؟', 'How It Works', 'Hero how-it-works CTA'),
            $this->t('home', 'hero_dash', 'title', 'مقارنة العروض', 'Offer Comparison', 'Dashboard title'),
            $this->t('home', 'hero_dash', 'best_rate', 'أفضل سعر', 'Best Rate', 'Best rate badge'),
            $this->t('home', 'hero_dash', 'apply', 'تقديم', 'Apply', 'Apply button small'),
            $this->t('home', 'hero_dash', 'approved', 'تمت الموافقة', 'Approved', 'Approved bubble'),
            $this->t('home', 'hero_dash', 'low_rates', 'نسب منخفضة', 'Low Rates', 'Low rates bubble'),

            $this->t('home', 'services', 'eyebrow', 'خدماتنا', 'Our Services', 'Services eyebrow'),
            $this->t('home', 'services', 'title', 'حلول تمويلية شاملة', 'Comprehensive Finance Solutions', 'Services title'),
            $this->t('home', 'services', 'subtitle', 'اكتشف مجموعة واسعة من خيارات التمويل المصممة لتلبية جميع احتياجاتك.', 'Explore a wide range of financing options tailored to all your needs.', 'Services subtitle'),

            $this->t('home', 'how', 'eyebrow', 'عملية بسيطة', 'Simple Process', 'How it works eyebrow'),
            $this->t('home', 'how', 'title', 'كيف يعمل هوت سبوت؟', 'How Hotspot Works', 'How it works title'),
            $this->t('home', 'how', 'subtitle', 'احصل على عرض التمويل المخصص لك في ثلاث خطوات بسيطة دون زيارة أي فرع.', 'Get your personalized financing offer in three simple steps, with no branch visits.', 'How it works subtitle'),

            $this->t('home', 'calc', 'title', 'احسب تمويلك', 'Calculate Your Loan', 'Calculator title'),
            $this->t('home', 'calc', 'subtitle', 'اضبط أشرطة التمرير لمعرفة ما يمكنك التأهل له اليوم.', 'Adjust the sliders to see what you qualify for today.', 'Calculator subtitle'),
            $this->t('home', 'calc', 'monthly_label', 'القسط الشهري التقديري', 'Estimated Monthly Payment', 'Monthly estimate label'),
            $this->t('home', 'calc', 'total_label', 'إجمالي مبلغ التمويل', 'Total Loan Amount', 'Total loan label'),
            $this->t('home', 'calc', 'apr_label', 'نسبة الربح (السنوية)', 'Profit Rate (APR)', 'APR label'),
            $this->t('home', 'calc', 'find_offers', 'ابحث عن عروض بهذا المبلغ', 'Find Offers for This Amount', 'Find offers button'),
            $this->t('home', 'calc', 'amount_label', 'مبلغ التمويل', 'Loan Amount', 'Loan amount label'),
            $this->t('home', 'calc', 'amount_min', '10 آلاف', '10K', 'Amount min'),
            $this->t('home', 'calc', 'amount_max', '2 مليون+', '2M+', 'Amount max'),
            $this->t('home', 'calc', 'term_label', 'المدة (بالسنوات)', 'Term (Years)', 'Term label'),
            $this->t('home', 'calc', 'years', 'سنوات', 'years', 'Years'),
            $this->t('home', 'calc', 'year_min', 'سنة واحدة', '1 year', 'Year min'),
            $this->t('home', 'calc', 'year_max', '25 سنة', '25 years', 'Year max'),

            $this->t('home', 'partners', 'badge', 'مرخص بالكامل من قبل البنك المركزي السعودي (ساما)', 'Fully Licensed by the Saudi Central Bank (SAMA)', 'Partners badge'),
            $this->t('home', 'partners', 'title', 'موثوق من قبل البنوك السعودية الرائدة', 'Trusted by Leading Saudi Banks', 'Partners title'),

            $this->t('home', 'offers', 'title', 'عروض التمويل المباشرة', 'Live Financing Offers', 'Offers title'),
            $this->t('home', 'offers', 'subtitle', 'قارن الأسعار والمدة والأقساط الشهرية فوراً.', 'Compare rates, terms, and monthly payments instantly.', 'Offers subtitle'),
            $this->t('home', 'offers', 'all_sectors', 'جميع القطاعات', 'All Sectors', 'All sectors'),
            $this->t('home', 'offers', 'government', 'القطاع الحكومي', 'Government', 'Government sector'),
            $this->t('home', 'offers', 'private', 'القطاع الخاص', 'Private', 'Private sector'),
            $this->t('home', 'offers', 'best_for_you', 'الخيار الأفضل لك', 'Best for You', 'Best for you badge'),
            $this->t('home', 'offers', 'rate_from', 'النسبة (تبدأ من)', 'Rate (from)', 'Rate from'),
            $this->t('home', 'offers', 'max_amount', 'أقصى مبلغ', 'Max Amount', 'Max amount'),
            $this->t('home', 'offers', 'monthly_100k', 'القسط الشهري (على 100ألف)', 'Monthly (on 100K)', 'Monthly 100k'),

            $this->t('home', 'articles', 'eyebrow', 'أدلة مالية', 'Financial Guides', 'Articles eyebrow'),
            $this->t('home', 'articles', 'title', 'اتخذ قرارات مستنيرة', 'Make Informed Decisions', 'Articles title'),
            $this->t('home', 'articles', 'subtitle', 'افهم مصطلحات ومتطلبات التمويل قبل التقديم.', 'Understand financing terms and requirements before applying.', 'Articles subtitle'),
            $this->t('home', 'articles', 'read_guide', 'اقرأ الدليل', 'Read Guide', 'Read guide'),

            $this->t('home', 'testimonials', 'title', 'يثق بها أكثر من 100 ألف مستخدم في المملكة', 'Trusted by 100K+ users in KSA', 'Testimonials title'),

            // ============ ABOUT ============
            $this->t('about', 'hero', 'badge', 'من نحن', 'About Us', 'About hero badge'),
            $this->t('about', 'hero', 'title', 'نُعيد تعريف التمويل في المملكة', 'Revolutionizing Financing in KSA', 'About hero title'),
            $this->t('about', 'hero', 'subtitle', 'منصة موحدة تُمكّن الأفراد والشركات من حلول مالية سريعة وشفافة.', 'A unified platform to empower individuals and businesses with fast, transparent financial solutions.', 'About hero subtitle'),

            $this->t('about', 'vision', 'title', 'رؤيتنا', 'Our Vision', 'Vision title'),
            $this->t('about', 'vision', 'text',
                'نسعى في هوت سبوت إلى إحداث ثورة في قطاع التمويل، وتمكين الأفراد والشركات من تحقيق جودة حياة وأداء أفضل بما يتماشى مع رؤية المملكة 2030.',
                'Our vision at Hotspot is to revolutionize the financing landscape. We aim to empower individuals & Businesses to secure a better quality of life & performance aligned with Saudi Vision 2030.',
                'Vision text', 'html'),
            $this->t('about', 'vision', 'established', 'تأسست 2024', 'ESTABLISHED 2024', 'Established'),

            $this->t('about', 'mission', 'title', 'مهمتنا', 'Our Mission', 'Mission title'),
            $this->t('about', 'mission', 'text',
                'مهمتنا تمكين الأفراد والشركات من خلال الوصول المريح إلى مجموعة واسعة من المنتجات والخدمات التمويلية.',
                'Our mission is to empower individuals and businesses by providing them with convenient access to a wide range of financing products and services.',
                'Mission text', 'html'),
            $this->t('about', 'mission', 'objective',
                'هدفنا تبسيط اتخاذ القرارات المالية عبر منصة سهلة الاستخدام.',
                'Our objective is to simplify the process of making financial choices via user-friendly platform.',
                'Mission objective'),
            $this->t('about', 'mission', 'link', 'التمكين الرقمي', 'DIGITAL EMPOWERMENT', 'Mission link'),

            $this->t('about', 'attributes', 'badge', 'سمات أساسية', 'CORE ATTRIBUTES', 'Attributes badge'),
            $this->t('about', 'attributes', 'title', 'الابتكار بسرعة الثقة.', 'Innovation at the Speed of Trust.', 'Attributes title'),
            $this->t('about', 'attributes', 'subtitle',
                'مصممة للتفاعلات المالية عالية الأداء، مع إعطاء الأولوية للشفافية واستقلالية المستخدم.',
                'Designed for high-performance financial interactions, prioritizing transparency and user autonomy.',
                'Attributes subtitle'),
            $this->t('about', 'attributes', 'innovation_title', 'ابتكار', 'Innovation', 'Innovation title'),
            $this->t('about', 'attributes', 'innovation_text', 'مقارنة فورية لعدة عروض من المؤسسات المالية.', 'Real-time comparison of the multiple offers received from financial institutions.', 'Innovation text'),
            $this->t('about', 'attributes', 'convenience_title', 'راحة', 'Convenience', 'Convenience title'),
            $this->t('about', 'attributes', 'convenience_text', 'تقديم طلبات التمويل أونلاين بموافقات فورية.', 'Seamless Online Financing Application with immediate and instant approvals.', 'Convenience text'),
            $this->t('about', 'attributes', 'accessibility_title', 'وصول', 'Accessibility', 'Accessibility title'),
            $this->t('about', 'attributes', 'accessibility_text', 'عروض فورية من مؤسسات مالية وبنوك متعددة في المملكة.', 'Instant Offers From Multiple Financial Institutions and Banks across the Kingdom.', 'Accessibility text'),

            $this->t('about', 'partners', 'badge', 'شبكة شركاء معتمدة من ساما', 'SAMA Regulated Partner Network', 'Partners badge'),
            $this->t('about', 'partners', 'title', 'شركاؤنا التقنيون', 'Our Technology Partners', 'Partners title'),
            $this->img('about', 'partners', 'image1', 'Hotspot_Redesign/assets/img/partners/elm.png', 'Partner logo 1 (ELM)'),
            $this->img('about', 'partners', 'image2', 'Hotspot_Redesign/assets/img/partners/nic.png', 'Partner logo 2 (NIC)'),
            $this->img('about', 'partners', 'image3', 'Hotspot_Redesign/assets/img/partners/scb.png', 'Partner logo 3 (SCB)'),
            $this->img('about', 'partners', 'image4', 'Hotspot_Redesign/assets/img/partners/tcc.png', 'Partner logo 4 (TCC)'),

            // ============ CONTACT ============
            $this->t('contact', 'hero', 'title_meta', 'اتصل بنا', 'Contact Us', 'Contact page title'),
            $this->t('contact', 'hero', 'badge', 'تواصل معنا', 'Contact Us', 'Contact hero badge'),
            $this->t('contact', 'hero', 'title', 'نحن هنا لمساعدتك', "We're Here to Help", 'Contact hero title'),
            $this->t('contact', 'hero', 'subtitle', 'نقدّر ملاحظاتك. تواصل معنا وأخبرنا كيف يمكننا خدمتك بشكل أفضل.', "We value your feedback. Get in touch and let us know how we can serve you better.", 'Contact hero subtitle'),

            $this->t('contact', 'info', 'visit_title', 'زر مقرّنا', 'Visit Our Studio', 'Visit title'),
            $this->t('contact', 'info', 'call_title', 'اتصل بنا', 'Call Us', 'Call title'),
            $this->t('contact', 'info', 'email_title', 'راسلنا', 'Email Us', 'Email title'),

            $this->t('contact', 'form', 'title', 'أرسل لنا رسالة', 'Send us a Message', 'Form title'),
            $this->t('contact', 'form', 'subtitle', 'سنرد عليك خلال 24 ساعة.', "We'll get back to you within 24 hours.", 'Form subtitle'),
            $this->t('contact', 'form', 'name_label', 'الاسم الكامل', 'Your Full Name', 'Name label'),
            $this->t('contact', 'form', 'name_placeholder', 'مثال: محمد أحمد', 'E.g. Julian Thorne', 'Name placeholder'),
            $this->t('contact', 'form', 'email_label', 'البريد الإلكتروني', 'Email Address', 'Email label'),
            $this->t('contact', 'form', 'inquiry_label', 'نوع الاستفسار', 'Inquiry Type', 'Inquiry label'),
            $this->t('contact', 'form', 'inquiry_general', 'استفسار عام', 'General Inquiry', 'Inquiry general'),
            $this->t('contact', 'form', 'inquiry_personal', 'تمويل شخصي', 'Personal Finance', 'Inquiry personal'),
            $this->t('contact', 'form', 'inquiry_auto', 'تمويل سيارات', 'Auto Finance', 'Inquiry auto'),
            $this->t('contact', 'form', 'inquiry_mortgage', 'تمويل عقاري', 'Mortgage', 'Inquiry mortgage'),
            $this->t('contact', 'form', 'inquiry_sme', 'تمويل الأعمال', 'Business/SME Finance', 'Inquiry SME'),
            $this->t('contact', 'form', 'message_label', 'رسالتك', 'Your Message', 'Message label'),
            $this->t('contact', 'form', 'message_placeholder', 'أخبرنا عن مشروعك أو رؤيتك...', 'Tell us about your project or vision...', 'Message placeholder'),
            $this->t('contact', 'form', 'legal_pre', 'بالضغط على إرسال، فإنك توافق على ', 'By clicking send, you agree to our ', 'Legal pre'),
            $this->t('contact', 'form', 'legal_link', 'سياسة الخصوصية', 'Privacy Policy', 'Privacy Policy link'),
            $this->t('contact', 'form', 'legal_post', ' وتوافق على أن نتواصل معك.', ' and consent to being contacted.', 'Legal post'),
            $this->t('contact', 'form', 'submit', 'إرسال الرسالة', 'Send Message', 'Submit button'),

            // ============ SERVICES (index) ============
            $this->t('services', 'hero', 'title_meta', 'الخدمات', 'Services', 'Services page title'),
            $this->t('services', 'hero', 'title', 'الخدمات', 'Services', 'Services hero title'),
            $this->t('services', 'hero', 'subtitle',
                'احصل على عروض تمويل مخصصة من أفضل المؤسسات المالية للتمويل العقاري والشخصي والسيارات والبطاقات الائتمانية.',
                'Get Custom financing offers from Top Financial Institutions for Mortgage Finance, Personal Loans, Auto Lease and Credit Cards.',
                'Services hero subtitle'),
            $this->t('services', 'list', 'empty', 'لا توجد خدمات متاحة حاليًا.', 'No services available at the moment.', 'Services empty'),

            // ============ SERVICE (show) ============
            $this->t('service', 'hero', 'cta_compare', 'قارن العروض الآن', 'Compare Offers Now', 'Compare offers CTA'),
            $this->t('service', 'body', 'back', 'العودة للخدمات', 'Back to Services', 'Back to services'),
            $this->t('service', 'body', 'why_title', 'لماذا تختار هذا التمويل عبر هوت سبوت؟', 'Why Choose This Financing Through Hotspot?', 'Why choose title'),
            $this->t('service', 'body', 'offers_title', 'العروض المتاحة', 'Available Offers', 'Available offers title'),
            $this->t('service', 'body', 'apr_label', 'نسبة الفائدة:', 'APR:', 'APR label'),
            $this->t('service', 'body', 'max_label', 'الحد الأقصى:', 'Max Amount:', 'Max amount label'),
            $this->t('service', 'body', 'monthly_label', 'القسط الشهري:', 'Monthly:', 'Monthly label'),
            $this->t('service', 'body', 'no_offers', 'لا توجد عروض متاحة حاليًا لهذه الخدمة.', 'No offers available for this service at the moment.', 'No offers'),
            $this->t('service', 'body', 'apply_cta', 'قدّم طلب تمويل', 'Apply for Financing', 'Apply CTA'),

            // ============ OFFER ============
            $this->t('offer', 'hero', 'instant_approval', 'موافقة فورية', 'Instant Approval', 'Instant approval'),
            $this->t('offer', 'body', 'back', 'العودة للعروض', 'Back to Offers', 'Back to offers'),
            $this->t('offer', 'body', 'about_title', 'عن البنك', 'About the Bank', 'About the bank'),
            $this->t('offer', 'body', 'about_fallback', 'أحد أبرز الشركاء الماليين في المملكة.', 'One of the leading financial partners in the Kingdom.', 'About fallback'),
            $this->t('offer', 'body', 'apr', 'نسبة الفائدة', 'APR', 'APR'),
            $this->t('offer', 'body', 'max_amount', 'الحد الأقصى', 'Max Amount', 'Max amount'),
            $this->t('offer', 'body', 'monthly', 'القسط الشهري', 'Monthly Payment', 'Monthly payment'),
            $this->t('offer', 'body', 'tenure', 'المدة', 'Tenure', 'Tenure'),
            $this->t('offer', 'body', 'no_offers', 'لا توجد عروض متاحة حاليًا.', 'No offers available at the moment.', 'No offers'),

            // ============ ARTICLE ============
            $this->t('article', 'body', 'back', 'العودة للأدلة المالية', 'Back to Financial Guides', 'Back to guides'),
            $this->t('article', 'body', 'empty', 'لا يوجد محتوى متاح لهذا المقال.', 'No content available for this article.', 'Empty content'),
            $this->t('article', 'body', 'calc_cta', 'جرّب حاسبة التمويل', 'Try the Finance Calculator', 'Calculator CTA'),
            $this->img('article', 'hero', 'fallback_image', 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1200&q=80', 'Article fallback hero image'),

            // ============ APPLY ============
            $this->t('apply', 'hero', 'title_meta', 'قدّم طلب تمويل', 'Apply for Financing', 'Apply page title'),
            $this->t('apply', 'hero', 'title', 'قدّم طلب تمويل', 'Apply for Financing', 'Apply hero title'),
            $this->t('apply', 'hero', 'subtitle', 'أكمل النموذج أدناه وسيتواصل معك أحد مستشارينا خلال 24 ساعة.', 'Complete the form below and one of our advisors will contact you within 24 hours.', 'Apply hero subtitle'),

            $this->t('apply', 'personal', 'title', 'المعلومات الشخصية', 'Personal Information', 'Personal info title'),
            $this->t('apply', 'personal', 'name_label', 'الاسم الكامل', 'Full Name', 'Name label'),
            $this->t('apply', 'personal', 'name_placeholder', 'أدخل اسمك الكامل', 'Enter your full name', 'Name placeholder'),
            $this->t('apply', 'personal', 'nid_label', 'رقم الهوية', 'National ID', 'National ID label'),
            $this->t('apply', 'personal', 'nid_placeholder', 'أدخل رقم هويتك', 'Enter your national ID number', 'National ID placeholder'),
            $this->t('apply', 'personal', 'phone_label', 'رقم الجوال', 'Mobile Number', 'Phone label'),
            $this->t('apply', 'personal', 'email_label', 'البريد الإلكتروني', 'Email', 'Email label'),
            $this->t('apply', 'personal', 'city_label', 'المدينة', 'City', 'City label'),
            $this->t('apply', 'personal', 'city_placeholder', 'الرياض', 'Riyadh', 'City placeholder'),

            $this->t('apply', 'employment', 'title', 'تفاصيل العمل', 'Employment Details', 'Employment title'),
            $this->t('apply', 'employment', 'employer_label', 'جهة العمل', 'Employer', 'Employer label'),
            $this->t('apply', 'employment', 'employer_placeholder', 'أدخل جهة عملك', 'Enter your employer name', 'Employer placeholder'),
            $this->t('apply', 'employment', 'sector_label', 'القطاع', 'Sector', 'Sector label'),
            $this->t('apply', 'employment', 'sector_select', 'اختر القطاع', 'Select your sector', 'Sector select'),
            $this->t('apply', 'employment', 'sector_government', 'حكومي', 'Government', 'Government'),
            $this->t('apply', 'employment', 'sector_private', 'خاص', 'Private', 'Private'),
            $this->t('apply', 'employment', 'sector_military', 'عسكري', 'Military', 'Military'),
            $this->t('apply', 'employment', 'sector_retired', 'متقاعد', 'Retired', 'Retired'),
            $this->t('apply', 'employment', 'salary_label', 'الراتب الشهري', 'Monthly Salary', 'Salary label'),
            $this->t('apply', 'employment', 'salary_placeholder', 'مثال: 10000', 'e.g. 10000', 'Salary placeholder'),

            $this->t('apply', 'financing', 'title', 'تفاصيل التمويل', 'Financing Details', 'Financing title'),
            $this->t('apply', 'financing', 'service_label', 'نوع التمويل', 'Financing Type', 'Service label'),
            $this->t('apply', 'financing', 'service_select', 'اختر نوع التمويل', 'Select financing type', 'Service select'),
            $this->t('apply', 'financing', 'bank_label', 'البنك', 'Bank', 'Bank label'),
            $this->t('apply', 'financing', 'bank_any', 'أي بنك', 'Any Bank', 'Any bank'),
            $this->t('apply', 'financing', 'amount_label', 'المبلغ المطلوب', 'Required Amount', 'Amount label'),
            $this->t('apply', 'financing', 'amount_placeholder', 'مثال: 500000', 'e.g. 500000', 'Amount placeholder'),
            $this->t('apply', 'financing', 'term_label', 'مدة السداد (سنوات)', 'Term (years)', 'Term label'),
            $this->t('apply', 'financing', 'term_placeholder', 'مثال: 5', 'e.g. 5', 'Term placeholder'),

            $this->t('apply', 'form', 'note', 'بياناتك محمية بالكامل ولن تتم مشاركتها مع أي جهة خارجية دون موافقتك.', 'Your data is fully protected and will not be shared with any third party without your consent.', 'Form note'),
            $this->t('apply', 'form', 'submit', 'إرسال الطلب', 'Submit Application', 'Submit button'),

            $this->t('apply', 'sidebar', 'why_title', 'لماذا هوت سبوت؟', 'Why Hotspot?', 'Why Hotspot title'),
            $this->t('apply', 'sidebar', 'why_sama', 'مرخّص من ساما', 'SAMA Licensed', 'SAMA licensed'),
            $this->t('apply', 'sidebar', 'why_partners', '+20 شريك بنكي', '20+ Banking Partners', 'Banking partners'),
            $this->t('apply', 'sidebar', 'why_instant', 'موافقات فورية', 'Instant Approvals', 'Instant approvals'),
            $this->t('apply', 'sidebar', 'why_fees', 'بدون رسوم', 'No Fees', 'No fees'),
            $this->t('apply', 'sidebar', 'help_title', 'تحتاج مساعدة؟', 'Need Help?', 'Help title'),

            // ============ FAQ ============
            $this->t('faq', 'hero', 'title_meta', 'الأسئلة الشائعة', 'FAQ', 'FAQ page title'),
            $this->t('faq', 'hero', 'badge', 'الأسئلة الشائعة', 'FAQ', 'FAQ badge'),
            $this->t('faq', 'hero', 'title', 'الأسئلة الشائعة', 'Frequently Asked Questions', 'FAQ hero title'),
            $this->t('faq', 'hero', 'subtitle', 'إجابات على أكثر الأسئلة شيوعًا حول منصتنا لمقارنة التمويل.', 'Find answers to common questions about our financing comparison platform and how we can help you.', 'FAQ hero subtitle'),
            $this->t('faq', 'list', 'empty', 'لا توجد أسئلة متاحة حاليًا.', 'No FAQs available at the moment.', 'FAQ empty'),
            $this->t('faq', 'cta', 'title', 'لا تزال لديك أسئلة؟', 'Still have questions?', 'FAQ CTA title'),
            $this->t('faq', 'cta', 'subtitle', 'لم تجد ما تبحث عنه؟ فريقنا هنا لمساعدتك.', "Can't find what you're looking for? Our team is here to help.", 'FAQ CTA subtitle'),
            $this->t('faq', 'cta', 'button', 'اتصل بنا', 'Contact Us', 'FAQ CTA button'),

            // ============ PRIVACY ============
            $this->t('privacy', 'hero', 'title_meta', 'سياسة الخصوصية', 'Privacy Policy', 'Privacy page title'),
            $this->t('privacy', 'hero', 'badge', 'قانوني', 'Legal', 'Legal badge'),
            $this->t('privacy', 'hero', 'title', 'سياسة الخصوصية', 'Privacy Policy', 'Privacy hero title'),
            $this->t('privacy', 'hero', 'subtitle', 'كيف نجمع ونستخدم ونحمي معلوماتك الشخصية.', 'How we collect, use, and protect your personal information.', 'Privacy subtitle'),
            $this->t('privacy', 'body', 'last_updated', 'آخر تحديث: 1 أبريل 2026', 'Last Updated: April 1, 2026', 'Last updated'),
            $this->t('privacy', 'body', 's1_title', '1. المقدمة', '1. Introduction', 'Section 1 title'),
            $this->t('privacy', 'body', 's1_text',
                'شركة هوت سبوت للتسويق الرقمي ("هوت سبوت"، "نحن") ملتزمة بحماية خصوصيتك. توضح هذه السياسة كيفية جمع واستخدام وحماية بياناتك عند استخدام منصتنا وتطبيقنا وخدماتنا. هوت سبوت مرخصة من البنك المركزي السعودي (ساما) وتلتزم بجميع أنظمة حماية البيانات في المملكة.',
                'Hotspot Digital Marketplace LLC ("Hotspot", "we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform, mobile application, and related services. Hotspot is licensed by the Saudi Central Bank (SAMA) and complies with all applicable data protection regulations in the Kingdom of Saudi Arabia.',
                'Section 1 text', 'html'),
            $this->t('privacy', 'body', 's2_title', '2. المعلومات التي نجمعها', '2. Information We Collect', 'Section 2 title'),
            $this->t('privacy', 'body', 's2_intro', 'قد نقوم بجمع أنواع المعلومات التالية:', 'We may collect the following types of information:', 'Section 2 intro'),
            $this->t('privacy', 'body', 's2_li1', 'المعلومات الشخصية: الاسم، رقم الهوية، تاريخ الميلاد، البريد، رقم الجوال، العنوان.', 'Personal Information: Full name, national ID, date of birth, email, phone, and address.', 'Section 2 li1'),
            $this->t('privacy', 'body', 's2_li2', 'المعلومات المالية: تفاصيل العمل، الراتب الشهري، السجل الائتماني.', 'Financial Information: Employment details, monthly salary, and credit history.', 'Section 2 li2'),
            $this->t('privacy', 'body', 's2_li3', 'بيانات الجهاز والاستخدام: عنوان IP، المتصفح، نظام التشغيل.', 'Device & Usage Data: IP address, browser type, operating system.', 'Section 2 li3'),
            $this->t('privacy', 'body', 's3_title', '3. كيفية استخدام المعلومات', '3. How We Use Your Information', 'Section 3 title'),
            $this->t('privacy', 'body', 's3_text',
                'نستخدم المعلومات للتحقق من هويتك، مطابقتك مع عروض التمويل المناسبة، التواصل معك، والامتثال للأنظمة واللوائح.',
                'We use the information to verify your identity, match you with financing offers, communicate with you, and comply with regulations.',
                'Section 3 text', 'html'),
            $this->t('privacy', 'body', 's4_title', '4. تواصل معنا', '4. Contact Us', 'Section 4 title'),

            // ============ TERMS ============
            $this->t('terms', 'hero', 'title_meta', 'الشروط والأحكام', 'Terms & Conditions', 'Terms page title'),
            $this->t('terms', 'hero', 'badge', 'قانوني', 'Legal', 'Legal badge'),
            $this->t('terms', 'hero', 'title', 'الشروط والأحكام', 'Terms & Conditions', 'Terms hero title'),
            $this->t('terms', 'hero', 'subtitle', 'يرجى قراءة هذه الشروط بعناية قبل استخدام منصتنا.', 'Please read these terms carefully before using our platform.', 'Terms subtitle'),
            $this->t('terms', 'body', 'last_updated', 'آخر تحديث: 1 أبريل 2026', 'Last Updated: April 1, 2026', 'Last updated'),
            $this->t('terms', 'body', 's1_title', '1. قبول الشروط', '1. Acceptance of Terms', 'Section 1 title'),
            $this->t('terms', 'body', 's1_text',
                'باستخدامك منصة هوت سبوت فإنك توافق على الالتزام بهذه الشروط والأحكام. هوت سبوت مرخصة من البنك المركزي السعودي (ساما).',
                'By accessing or using the Hotspot platform, you agree to be bound by these Terms & Conditions. Hotspot is licensed by the Saudi Central Bank (SAMA).',
                'Section 1 text', 'html'),
            $this->t('terms', 'body', 's2_title', '2. الأهلية', '2. Eligibility', 'Section 2 title'),
            $this->t('terms', 'body', 's2_li1', 'أن تكون 18 عامًا فأكثر.', 'Be at least 18 years of age.', 'Section 2 li1'),
            $this->t('terms', 'body', 's2_li2', 'أن تكون مقيمًا في المملكة العربية السعودية بهوية وطنية أو إقامة صالحة.', 'Be a resident of the Kingdom of Saudi Arabia with a valid national ID or Iqama.', 'Section 2 li2'),
            $this->t('terms', 'body', 's2_li3', 'أن يكون لديك مصدر دخل قابل للتحقق.', 'Have a verifiable source of income.', 'Section 2 li3'),
            $this->t('terms', 'body', 's3_title', '3. خدمات المنصة', '3. Platform Services', 'Section 3 title'),
            $this->t('terms', 'body', 's3_text',
                'هوت سبوت سوق رقمي يربط المستخدمين بعروض التمويل من البنوك والمؤسسات المالية المرخصة في السعودية.',
                'Hotspot is a digital marketplace that connects users with financing offers from licensed banks and financial institutions in Saudi Arabia.',
                'Section 3 text', 'html'),
            $this->t('terms', 'body', 's4_title', '4. تواصل معنا', '4. Contact Us', 'Section 4 title'),

            // ============ NAV ============
            $this->t('nav', 'account', 'dashboard', 'لوحة التحكم', 'Dashboard', 'Dashboard'),
            $this->t('nav', 'account', 'logout', 'تسجيل الخروج', 'Logout', 'Logout'),
            $this->t('nav', 'account', 'account', 'حسابي', 'Account', 'Account'),
            $this->t('nav', 'account', 'register', 'إنشاء حساب', 'Register', 'Register'),
            $this->t('nav', 'account', 'login', 'تسجيل الدخول', 'Login', 'Login'),

            // ============ FOOTER ============
            $this->t('footer', 'bottom', 'licensed_by', 'مرخص من', 'Licensed by', 'Licensed by'),
            $this->t('footer', 'brand', 'tagline_default', 'قارن عروض التمويل', 'Compare Financing Offers', 'Footer tagline fallback'),

            // ============ AUTH - COMMON ============
            $this->t('auth', 'common', 'email', 'البريد الإلكتروني', 'Email', 'Email label'),
            $this->t('auth', 'common', 'password', 'كلمة المرور', 'Password', 'Password label'),
            $this->t('auth', 'common', 'confirm_password', 'تأكيد كلمة المرور', 'Confirm Password', 'Confirm password label'),
            $this->t('auth', 'common', 'phone', 'رقم الجوال', 'Phone', 'Phone label'),
            $this->t('auth', 'common', 'back_to_login', 'الرجوع لتسجيل الدخول', 'Back to Sign In', 'Back to login link'),

            // ============ AUTH - LOGIN ============
            $this->t('auth', 'login', 'title_meta', 'تسجيل الدخول', 'Sign In', 'Login page meta title'),
            $this->t('auth', 'login', 'badge', 'تسجيل دخول آمن', 'Secure Sign In', 'Login hero badge'),
            $this->t('auth', 'login', 'hero_title', 'مرحباً بعودتك', 'Welcome Back', 'Login hero title'),
            $this->t('auth', 'login', 'hero_subtitle', 'ادخل إلى لوحة التحكم المخصصة لديك وتابع رحلتك نحو اتخاذ قرارات مالية أفضل.', 'Sign in to your personal dashboard and continue your journey to better financial decisions.', 'Login hero subtitle'),
            $this->t('auth', 'login', 'card_title', 'سجل دخولك إلى حسابك', 'Sign In to Your Account', 'Login card title'),
            $this->t('auth', 'login', 'card_subtitle', 'أدخل بياناتك للوصول إلى لوحة التحكم', 'Enter your credentials to access the dashboard', 'Login card subtitle'),
            $this->t('auth', 'login', 'password_placeholder', 'أدخل كلمة المرور', 'Enter your password', 'Password field placeholder'),
            $this->t('auth', 'login', 'remember', 'تذكرني', 'Remember me', 'Remember me checkbox'),
            $this->t('auth', 'login', 'forgot', 'نسيت كلمة المرور؟', 'Forgot password?', 'Forgot password link'),
            $this->t('auth', 'login', 'submit', 'تسجيل الدخول', 'Sign In', 'Login submit button'),
            $this->t('auth', 'login', 'no_account', 'ليس لديك حساب؟', "Don't have an account?", "No account prompt"),
            $this->t('auth', 'login', 'register_here', 'سجل هنا', 'Register here', 'Register here link'),

            // ============ AUTH - REGISTER ============
            $this->t('auth', 'register', 'title_meta', 'إنشاء حساب', 'Register', 'Register page meta title'),
            $this->t('auth', 'register', 'badge', 'انضم إلينا', 'Join Us', 'Register hero badge'),
            $this->t('auth', 'register', 'hero_title', 'أنشئ حسابك', 'Create Your Account', 'Register hero title'),
            $this->t('auth', 'register', 'hero_subtitle', 'سجل لتبدأ في مقارنة وتقديم طلبات التمويل.', 'Sign up to start comparing and applying for finance offers.', 'Register hero subtitle'),
            $this->t('auth', 'register', 'card_title', 'تسجيل حساب جديد', 'Register New Account', 'Register card title'),
            $this->t('auth', 'register', 'card_subtitle', 'أدخل بياناتك لإنشاء حساب.', 'Enter your details to create an account.', 'Register card subtitle'),
            $this->t('auth', 'register', 'full_name', 'الاسم الكامل', 'Full Name', 'Full name label'),
            $this->t('auth', 'register', 'submit', 'إنشاء الحساب', 'Create Account', 'Register submit button'),
            $this->t('auth', 'register', 'have_account', 'لديك حساب بالفعل؟', 'Already have an account?', 'Have account prompt'),
            $this->t('auth', 'register', 'sign_in_here', 'سجل الدخول', 'Sign In', 'Sign in here link'),

            // ============ AUTH - FORGOT PASSWORD ============
            $this->t('auth', 'forgot', 'title_meta', 'نسيت كلمة المرور', 'Forgot Password', 'Forgot password meta title'),
            $this->t('auth', 'forgot', 'badge', 'استعادة الحساب', 'Account Recovery', 'Forgot hero badge'),
            $this->t('auth', 'forgot', 'hero_title', 'نسيت كلمة المرور؟', 'Forgot Password?', 'Forgot hero title'),
            $this->t('auth', 'forgot', 'hero_subtitle', 'أدخل بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور.', 'Enter your email and we will send you a reset link.', 'Forgot hero subtitle'),
            $this->t('auth', 'forgot', 'submit', 'إرسال رابط الاستعادة', 'Send Reset Link', 'Forgot submit button'),

            // ============ AUTH - RESET PASSWORD ============
            $this->t('auth', 'reset', 'title_meta', 'إعادة تعيين كلمة المرور', 'Reset Password', 'Reset password meta title'),
            $this->t('auth', 'reset', 'badge', 'استعادة الحساب', 'Account Recovery', 'Reset hero badge'),
            $this->t('auth', 'reset', 'hero_title', 'إعادة تعيين كلمة المرور', 'Reset Password', 'Reset hero title'),
            $this->t('auth', 'reset', 'hero_subtitle', 'أدخل كلمة المرور الجديدة لحسابك.', 'Enter a new password for your account.', 'Reset hero subtitle'),
            $this->t('auth', 'reset', 'new_password', 'كلمة المرور الجديدة', 'New Password', 'New password label'),
            $this->t('auth', 'reset', 'submit', 'إعادة تعيين كلمة المرور', 'Reset Password', 'Reset submit button'),

            // ============ OFFER (split prefix/suffix) ============
            $this->t('offer', 'hero', 'prefix', 'عروض', 'Offers', 'Offer hero Arabic prefix (before bank name)'),
            $this->t('offer', 'hero', 'suffix', 'Offers', 'Offers', 'Offer hero English suffix (after bank name)'),
            $this->t('offer', 'body', 'tenure_prefix', 'حتى', 'Up to', 'Tenure prefix (Arabic)'),
            $this->t('offer', 'body', 'tenure_unit_ar', 'شهر', 'month', 'Tenure unit (Arabic)'),
            $this->t('offer', 'body', 'tenure_prefix_en', 'Up to', 'Up to', 'Tenure prefix (English)'),
            $this->t('offer', 'body', 'tenure_unit_en', 'months', 'months', 'Tenure unit (English)'),

            // ============ PLACEHOLDER ============
            $this->t('placeholder', 'hero', 'badge', 'قيد الإنشاء', 'Under Construction', 'Under construction badge'),
            $this->t('placeholder', 'hero', 'title', 'الصفحة قيد الإعداد', 'Page coming soon', 'Placeholder title'),
            $this->t('placeholder', 'hero', 'subtitle',
                'هذه الصفحة ستُبنى بالكامل من قاعدة البيانات في المرحلة التالية — كل المحتوى هيبقى قابل للتحكم من لوحة الأدمن.',
                'This page will be fully database-driven in the next phase — every block will be editable from the admin dashboard.',
                'Placeholder subtitle'),
            $this->t('placeholder', 'hero', 'back_home', 'الرجوع للرئيسية', 'Back to Home', 'Back to home link'),

            // ============ ARTICLE ============
            $this->t('article', 'meta', 'date_format_ar', 'j F Y', 'j F Y', 'Article date format (Arabic Carbon)'),
            $this->t('article', 'meta', 'date_format_en', 'F j, Y', 'F j, Y', 'Article date format (English Carbon)'),

            // ============ CONTACT ============
            $this->t('contact', 'info', 'address_default',
                'هوت سبوت للتسويق الرقمي، 2493 حي الصالحي 7326، الرياض، السعودية',
                'Hotspot Digital Marketplace LLC, 2493 Al Salhi Dist. 7326, Riyadh, SA',
                'Default contact address (fallback when settings empty)'),

            // ============ HOME (siteSettings fallbacks) ============
            $this->t('home', 'hero', 'badge_default', 'مرخص من ساما', 'SAMA Licensed', 'Home hero badge fallback'),
            $this->t('home', 'hero', 'title_line_1_default', 'قارن واحصل على', 'Compare & Get the', 'Home hero title line 1 fallback'),
            $this->t('home', 'hero', 'title_line_2_default', 'أفضل عروض التمويل', 'Best Financing Offers', 'Home hero title line 2 fallback'),
            $this->t('home', 'meta', 'tagline_default', 'قارن عروض التمويل', 'Compare Financing Offers', 'Home tagline fallback'),
        ];
    }
}
