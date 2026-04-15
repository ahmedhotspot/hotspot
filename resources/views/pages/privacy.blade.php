@extends('layouts.app')

@section('title', block('privacy.hero.title_meta', $isRtl ? 'سياسة الخصوصية' : 'Privacy Policy'))

@section('content')
<section class="page-header">
    <div class="container">
        <span class="badge badge-primary mb-3">{{ block('privacy.hero.badge', $isRtl ? 'قانوني' : 'Legal') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">
            {{ $page?->title ?? block('privacy.hero.title', $isRtl ? 'سياسة الخصوصية' : 'Privacy Policy') }}
        </h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('privacy.hero.subtitle', $isRtl
                ? 'كيف نجمع ونستخدم ونحمي معلوماتك الشخصية.'
                : 'How we collect, use, and protect your personal information.') }}
        </p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width: 800px;">
        <div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 3rem;">
            @if($page && $page->content)
                {!! $page->content !!}
            @else
                <p class="text-muted mb-4">
                    {{ block('privacy.body.last_updated', $isRtl ? 'آخر تحديث: 1 أبريل 2026' : 'Last Updated: April 1, 2026') }}
                </p>

                <h2 class="h4 font-weight-bold mb-3">{{ block('privacy.body.s1_title', $isRtl ? '1. المقدمة' : '1. Introduction') }}</h2>
                <p>
                    {{ block('privacy.body.s1_text', $isRtl
                        ? 'شركة هوت سبوت للتسويق الرقمي ("هوت سبوت"، "نحن") ملتزمة بحماية خصوصيتك. توضح هذه السياسة كيفية جمع واستخدام وحماية بياناتك عند استخدام منصتنا وتطبيقنا وخدماتنا. هوت سبوت مرخصة من البنك المركزي السعودي (ساما) وتلتزم بجميع أنظمة حماية البيانات في المملكة.'
                        : 'Hotspot Digital Marketplace LLC ("Hotspot", "we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform, mobile application, and related services. Hotspot is licensed by the Saudi Central Bank (SAMA) and complies with all applicable data protection regulations in the Kingdom of Saudi Arabia.') }}
                </p>

                <h2 class="h4 font-weight-bold mb-3 mt-5">{{ block('privacy.body.s2_title', $isRtl ? '2. المعلومات التي نجمعها' : '2. Information We Collect') }}</h2>
                <p>{{ block('privacy.body.s2_intro', $isRtl ? 'قد نقوم بجمع أنواع المعلومات التالية:' : 'We may collect the following types of information:') }}</p>
                <ul style="list-style: disc; padding-{{ $isRtl ? 'right' : 'left' }}: 1.5rem; line-height: 2;">
                    <li>{{ block('privacy.body.s2_li1', $isRtl ? 'المعلومات الشخصية: الاسم، رقم الهوية، تاريخ الميلاد، البريد، رقم الجوال، العنوان.' : 'Personal Information: Full name, national ID, date of birth, email, phone, and address.') }}</li>
                    <li>{{ block('privacy.body.s2_li2', $isRtl ? 'المعلومات المالية: تفاصيل العمل، الراتب الشهري، السجل الائتماني.' : 'Financial Information: Employment details, monthly salary, and credit history.') }}</li>
                    <li>{{ block('privacy.body.s2_li3', $isRtl ? 'بيانات الجهاز والاستخدام: عنوان IP، المتصفح، نظام التشغيل.' : 'Device & Usage Data: IP address, browser type, operating system.') }}</li>
                </ul>

                <h2 class="h4 font-weight-bold mb-3 mt-5">{{ block('privacy.body.s3_title', $isRtl ? '3. كيفية استخدام المعلومات' : '3. How We Use Your Information') }}</h2>
                <p>
                    {{ block('privacy.body.s3_text', $isRtl
                        ? 'نستخدم المعلومات للتحقق من هويتك، مطابقتك مع عروض التمويل المناسبة، التواصل معك، والامتثال للأنظمة واللوائح.'
                        : 'We use the information to verify your identity, match you with financing offers, communicate with you, and comply with regulations.') }}
                </p>

                <h2 class="h4 font-weight-bold mb-3 mt-5">{{ block('privacy.body.s4_title', $isRtl ? '4. تواصل معنا' : '4. Contact Us') }}</h2>
                <ul style="list-style: none; padding-{{ $isRtl ? 'right' : 'left' }}: 0; line-height: 2;">
                    <li><i class="fa-solid fa-envelope text-primary"></i> <a href="mailto:{{ $siteSettings->get('contact_email', 'customercare@hotspot.sa') }}">{{ $siteSettings->get('contact_email', 'customercare@hotspot.sa') }}</a></li>
                    <li><i class="fa-solid fa-phone text-primary"></i> {{ $siteSettings->get('contact_phone', '800-245-0071') }}</li>
                </ul>
            @endif
        </div>
    </div>
</section>
@endsection
