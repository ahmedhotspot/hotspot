@extends('layouts.app')

@section('title', block('terms.hero.title_meta', $isRtl ? 'الشروط والأحكام' : 'Terms & Conditions'))

@section('content')
<section class="page-header">
    <div class="container">
        <span class="badge badge-primary mb-3">{{ block('terms.hero.badge', $isRtl ? 'قانوني' : 'Legal') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">
            {{ $page?->title ?? block('terms.hero.title', $isRtl ? 'الشروط والأحكام' : 'Terms & Conditions') }}
        </h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('terms.hero.subtitle', $isRtl
                ? 'يرجى قراءة هذه الشروط بعناية قبل استخدام منصتنا.'
                : 'Please read these terms carefully before using our platform.') }}
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
                    {{ block('terms.body.last_updated', $isRtl ? 'آخر تحديث: 1 أبريل 2026' : 'Last Updated: April 1, 2026') }}
                </p>

                <h2 class="h4 font-weight-bold mb-3">{{ block('terms.body.s1_title', $isRtl ? '1. قبول الشروط' : '1. Acceptance of Terms') }}</h2>
                <p>
                    {{ block('terms.body.s1_text', $isRtl
                        ? 'باستخدامك منصة هوت سبوت فإنك توافق على الالتزام بهذه الشروط والأحكام. هوت سبوت مرخصة من البنك المركزي السعودي (ساما).'
                        : 'By accessing or using the Hotspot platform, you agree to be bound by these Terms & Conditions. Hotspot is licensed by the Saudi Central Bank (SAMA).') }}
                </p>

                <h2 class="h4 font-weight-bold mb-3 mt-5">{{ block('terms.body.s2_title', $isRtl ? '2. الأهلية' : '2. Eligibility') }}</h2>
                <ul style="list-style: disc; padding-{{ $isRtl ? 'right' : 'left' }}: 1.5rem; line-height: 2;">
                    <li>{{ block('terms.body.s2_li1', $isRtl ? 'أن تكون 18 عامًا فأكثر.' : 'Be at least 18 years of age.') }}</li>
                    <li>{{ block('terms.body.s2_li2', $isRtl ? 'أن تكون مقيمًا في المملكة العربية السعودية بهوية وطنية أو إقامة صالحة.' : 'Be a resident of the Kingdom of Saudi Arabia with a valid national ID or Iqama.') }}</li>
                    <li>{{ block('terms.body.s2_li3', $isRtl ? 'أن يكون لديك مصدر دخل قابل للتحقق.' : 'Have a verifiable source of income.') }}</li>
                </ul>

                <h2 class="h4 font-weight-bold mb-3 mt-5">{{ block('terms.body.s3_title', $isRtl ? '3. خدمات المنصة' : '3. Platform Services') }}</h2>
                <p>
                    {{ block('terms.body.s3_text', $isRtl
                        ? 'هوت سبوت سوق رقمي يربط المستخدمين بعروض التمويل من البنوك والمؤسسات المالية المرخصة في السعودية.'
                        : 'Hotspot is a digital marketplace that connects users with financing offers from licensed banks and financial institutions in Saudi Arabia.') }}
                </p>

                <h2 class="h4 font-weight-bold mb-3 mt-5">{{ block('terms.body.s4_title', $isRtl ? '4. تواصل معنا' : '4. Contact Us') }}</h2>
                <ul style="list-style: none; padding-{{ $isRtl ? 'right' : 'left' }}: 0; line-height: 2;">
                    <li><i class="fa-solid fa-envelope text-primary"></i> <a href="mailto:{{ $siteSettings->get('contact_email', 'customercare@hotspot.sa') }}">{{ $siteSettings->get('contact_email', 'customercare@hotspot.sa') }}</a></li>
                    <li><i class="fa-solid fa-phone text-primary"></i> {{ $siteSettings->get('contact_phone', '800-245-0071') }}</li>
                </ul>
            @endif
        </div>
    </div>
</section>
@endsection
