@extends('layouts.app')

@section('title', $page?->meta_title ?? $page?->title ?? block('about.hero.badge', $isRtl ? 'من نحن' : 'About Us'))
@section('description', $page?->meta_description ?? block('about.hero.subtitle', $isRtl
    ? 'منصة موحدة تُمكّن الأفراد والشركات من حلول مالية سريعة وشفافة.'
    : 'A unified platform to empower individuals and businesses with fast, transparent financial solutions.'))

@section('content')
<section class="page-header">
    <div class="container">
        <span class="badge badge-primary mb-3">{{ block('about.hero.badge', $isRtl ? 'من نحن' : 'About Us') }}</span>
        <h1 class="font-weight-bold" style="font-size: clamp(2rem, 5vw, 3rem); line-height: 1.2;">
            {{ $page?->title ?? block('about.hero.title', $isRtl ? 'نُعيد تعريف التمويل في المملكة' : 'Revolutionizing Financing in KSA') }}
        </h1>
        <p class="text-muted" style="max-width: 640px; margin: 1rem auto 0; font-size: clamp(1rem, 2.2vw, 1.15rem); line-height: 1.7;">
            {{ block('about.hero.subtitle', $isRtl
                ? 'منصة موحدة تُمكّن الأفراد والشركات من حلول مالية سريعة وشفافة.'
                : 'A unified platform to empower individuals and businesses with fast, transparent financial solutions.') }}
        </p>
    </div>
</section>

@if($page && $page->content)
    <section class="section bg-white">
        <div class="container" style="max-width: 900px;">
            <div class="prose">
                {!! $page->content !!}
            </div>
            @if($page->image)
                <div class="text-center mt-5">
                    <img src="{{ asset($page->image) }}" alt="{{ $page->title }}" style="max-width: 100%; border-radius: var(--radius-lg);">
                </div>
            @endif
        </div>
    </section>
@endif

<section class="vision-mission-section section bg-white">
    <div class="container">
        <div class="about-grid">
            <div class="about-card about-card-vision" data-aos="fade-right">
                <span class="material-symbols-outlined">visibility</span>
                <h2>{{ block('about.vision.title', $isRtl ? 'رؤيتنا' : 'Our Vision') }}</h2>
                <p>
                    {{ block('about.vision.text', $isRtl
                        ? 'نسعى في هوت سبوت إلى إحداث ثورة في قطاع التمويل، وتمكين الأفراد والشركات من تحقيق جودة حياة وأداء أفضل بما يتماشى مع رؤية المملكة 2030.'
                        : 'Our vision at Hotspot is to revolutionize the financing landscape. We aim to empower individuals & Businesses to secure a better quality of life & performance aligned with Saudi Vision 2030.') }}
                </p>
                <div class="about-card-footer">
                    <span class="card-established">{{ block('about.vision.established', $isRtl ? 'تأسست 2024' : 'ESTABLISHED 2024') }}</span>
                </div>
            </div>

            <div class="about-card about-card-mission" data-aos="fade-left">
                <span class="material-symbols-outlined">rocket_launch</span>
                <h2>{{ block('about.mission.title', $isRtl ? 'مهمتنا' : 'Our Mission') }}</h2>
                <p>
                    {{ block('about.mission.text', $isRtl
                        ? 'مهمتنا تمكين الأفراد والشركات من خلال الوصول المريح إلى مجموعة واسعة من المنتجات والخدمات التمويلية.'
                        : 'Our mission is to empower individuals and businesses by providing them with convenient access to a wide range of financing products and services.') }}
                </p>
                <div class="about-card-footer">
                    <p style="margin-bottom: 0; font-weight: 500; font-size: 0.95rem;">
                        {{ block('about.mission.objective', $isRtl
                            ? 'هدفنا تبسيط اتخاذ القرارات المالية عبر منصة سهلة الاستخدام.'
                            : 'Our objective is to simplify the process of making financial choices via user-friendly platform.') }}
                    </p>
                    <a href="{{ route('contact') }}" class="about-link">
                        {{ block('about.mission.link', $isRtl ? 'التمكين الرقمي' : 'DIGITAL EMPOWERMENT') }}
                        <span class="material-symbols-outlined" style="font-size: 1.2rem; margin:0;">{{ $isRtl ? 'arrow_back' : 'arrow_forward' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="attributes-section section">
    <div class="container">
        <div class="attributes-header">
            <div>
                <span class="badge badge-primary mb-3">{{ block('about.attributes.badge', $isRtl ? 'سمات أساسية' : 'CORE ATTRIBUTES') }}</span>
                <h2 class="font-weight-bold">
                    {{ block('about.attributes.title', $isRtl ? 'الابتكار بسرعة الثقة.' : 'Innovation at the Speed of Trust.') }}
                </h2>
            </div>
            <p>
                {{ block('about.attributes.subtitle', $isRtl
                    ? 'مصممة للتفاعلات المالية عالية الأداء، مع إعطاء الأولوية للشفافية واستقلالية المستخدم.'
                    : 'Designed for high-performance financial interactions, prioritizing transparency and user autonomy.') }}
            </p>
        </div>

        <div class="attribute-grid">
            <div class="attribute-card" data-aos="fade-up" data-aos-delay="100">
                <span class="material-symbols-outlined">dynamic_form</span>
                <h3>{{ block('about.attributes.innovation_title', $isRtl ? 'ابتكار' : 'Innovation') }}</h3>
                <p>{{ block('about.attributes.innovation_text', $isRtl ? 'مقارنة فورية لعدة عروض من المؤسسات المالية.' : 'Real-time comparison of the multiple offers received from financial institutions.') }}</p>
                <div class="attribute-bar"></div>
            </div>
            <div class="attribute-card" data-aos="fade-up" data-aos-delay="200">
                <span class="material-symbols-outlined">touch_app</span>
                <h3>{{ block('about.attributes.convenience_title', $isRtl ? 'راحة' : 'Convenience') }}</h3>
                <p>{{ block('about.attributes.convenience_text', $isRtl ? 'تقديم طلبات التمويل أونلاين بموافقات فورية.' : 'Seamless Online Financing Application with immediate and instant approvals.') }}</p>
                <div class="attribute-bar"></div>
            </div>
            <div class="attribute-card" data-aos="fade-up" data-aos-delay="300">
                <span class="material-symbols-outlined">public</span>
                <h3>{{ block('about.attributes.accessibility_title', $isRtl ? 'وصول' : 'Accessibility') }}</h3>
                <p>{{ block('about.attributes.accessibility_text', $isRtl ? 'عروض فورية من مؤسسات مالية وبنوك متعددة في المملكة.' : 'Instant Offers From Multiple Financial Institutions and Banks across the Kingdom.') }}</p>
                <div class="attribute-bar"></div>
            </div>
        </div>
    </div>
</section>

<section class="partners-footer-section section bg-white">
    <div class="container text-center">
        <span class="badge badge-success mb-3">
            <i class="fa-solid fa-shield-halved"></i>
            {{ block('about.partners.badge', $isRtl ? 'شبكة شركاء معتمدة من ساما' : 'SAMA Regulated Partner Network') }}
        </span>
        <h2 class="mb-5">{{ block('about.partners.title', $isRtl ? 'شركاؤنا التقنيون' : 'Our Technology Partners') }}</h2>
        <div class="our-partners-grid">
            <div class="partner-item"><img src="{{ asset(block('about.partners.image1', 'Hotspot_Redesign/assets/img/partners/elm.png')) }}" alt="ELM"></div>
            <div class="partner-item"><img src="{{ asset(block('about.partners.image2', 'Hotspot_Redesign/assets/img/partners/nic.png')) }}" alt="NIC"></div>
            <div class="partner-item"><img src="{{ asset(block('about.partners.image3', 'Hotspot_Redesign/assets/img/partners/scb.png')) }}" alt="SCB"></div>
            <div class="partner-item"><img src="{{ asset(block('about.partners.image4', 'Hotspot_Redesign/assets/img/partners/tcc.png')) }}" alt="TCC"></div>
        </div>
    </div>
</section>
@endsection
