@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isAr   = $isRtl;
    $heroBadge    = $siteSettings->get('hero.badge', block('home.hero.badge_default', $isAr ? 'مرخص من ساما' : 'SAMA Licensed'));
    $heroTitle1   = $siteSettings->get('hero.title_line_1', block('home.hero.title_line_1_default', $isAr ? 'قارن واحصل على' : 'Compare & Get the'));
    $heroTitle2   = $siteSettings->get('hero.title_line_2', block('home.hero.title_line_2_default', $isAr ? 'أفضل عروض التمويل' : 'Best Financing Offers'));
    $heroSubtitle = $siteSettings->get('hero.subtitle');
    $licenseNotice = $siteSettings->get('license_notice');
@endphp

@section('title', $siteSettings->get('site_name_'.$locale, config('app.name')))
@section('subtitle', $siteSettings->get('tagline', block('home.meta.tagline_default', $isAr ? 'قارن عروض التمويل' : 'Compare Financing Offers')))

@section('content')
<!-- Hero -->
<section class="hero-section" id="hero">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="container hero-container">
        <div class="hero-content animate-fade-in-up">
            <span class="badge badge-primary mb-3"><i class="fa-solid fa-bolt"></i> {{ $heroBadge }}</span>
            <h1 class="hero-title">
                {{ $heroTitle1 }} <br>
                <span class="text-gradient">{{ $heroTitle2 }}</span>
            </h1>
            <p class="hero-subtitle">{{ $heroSubtitle }}</p>
            <div class="hero-cta-group">
                <a href="#calculator" class="btn btn-primary btn-lg">
                    {{ block('home.hero.cta_compare', $isAr ? 'طلب تمويل' : 'Compare Offers') }} <i class="fa-solid fa-arrow-{{ $isAr ? 'left' : 'right' }}"></i>
                </a>
                <a href="#how-it-works" class="btn btn-outline btn-lg">
                    <i class="fa-solid fa-play"></i> {{ block('home.hero.cta_how', $isAr ? 'كيف يعمل؟' : 'How It Works') }}
                </a>
            </div>
            @if($trustMetrics->isNotEmpty())
                <div class="hero-trust-metrics mt-4">
                    @foreach($trustMetrics as $m)
                        <div class="metric"><strong>{{ $m->value }}</strong><span>{{ $m->label }}</span></div>
                        @if(!$loop->last)<div class="divider"></div>@endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="hero-image-wrapper animate-slide-in-right">
            <div class="glass-dashboard">
                <div class="dash-header">
                    <div class="dash-dots"><span></span><span></span><span></span></div>
                    <div class="dash-title">{{ block('home.hero_dash.title', $isAr ? 'مقارنة العروض' : 'Offer Comparison') }}</div>
                </div>
                <div class="dash-body">
                    @foreach($offers->take(2) as $o)
                        <div class="dash-card {{ $o->is_best ? 'primary-offer' : 'secondary-offer mt-3' }}">
                            <div class="card-top">
                                <div class="bank-logo"><i class="fa-solid fa-building-columns"></i> {{ $o->bank->name }}</div>
                                @if($o->is_best)
                                    <span class="badge-sm badge-success">{{ block('home.hero_dash.best_rate', $isAr ? 'أفضل سعر' : 'Best Rate') }}</span>
                                @endif
                            </div>
                            <div class="card-rates">
                                <div><small>{{ block('common.labels.amount', $isAr ? 'المبلغ' : 'Amount') }}</small><br><b>{{ number_format($o->max_amount) }} {{ block('common.labels.sar', $isAr ? 'ريال' : 'SAR') }}</b></div>
                                <div><small>{{ block('common.labels.rate', $isAr ? 'النسبة' : 'Rate') }}</small><br><b class="{{ $o->is_best ? 'text-primary' : '' }}">{{ $o->apr }}%</b></div>
                            </div>
                            <div class="card-bottom">
                                <span>{{ number_format($o->monthly_sample) }} {{ block('common.labels.sar_monthly', $isAr ? 'ريال / شهر' : 'SAR/mo') }}</span>
                                <button class="btn {{ $o->is_best ? 'btn-primary' : 'btn-outline' }} btn-xs">{{ block('home.hero_dash.apply', $isAr ? 'تقديم' : 'Apply') }}</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="floating-bubble bubble-1"><i class="fa-solid fa-check-circle text-success fs-lg"></i> {{ block('home.hero_dash.approved', $isAr ? 'تمت الموافقة' : 'Approved') }}</div>
            <div class="floating-bubble bubble-2"><i class="fa-solid fa-percent text-primary fs-lg"></i> {{ block('home.hero_dash.low_rates', $isAr ? 'نسب منخفضة' : 'Low Rates') }}</div>
        </div>
    </div>
</section>

<!-- Services -->
@if($services->isNotEmpty())
<section class="services-grid-section" id="services">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-primary fw-bold">{{ block('home.services.eyebrow', $isAr ? 'خدماتنا' : 'Our Services') }}</span>
            <h2>{{ block('home.services.title', $isAr ? 'حلول تمويلية شاملة' : 'Comprehensive Finance Solutions') }}</h2>
            <p class="text-muted">{{ block('home.services.subtitle', $isAr ? 'اكتشف مجموعة واسعة من خيارات التمويل المصممة لتلبية جميع احتياجاتك.' : 'Explore a wide range of financing options tailored to all your needs.') }}</p>
        </div>
        <div class="services-grid">
            @foreach($services as $s)
                <a href="{{ route('services.show', $s->slug) }}" class="service-card-link">
                    <div class="service-card-item">
                        <div class="service-icon {{ $s->icon_class }}"><i class="fa-solid {{ $s->icon }}"></i></div>
                        <h3>{{ $s->title }}</h3>
                        <p>{{ $s->description }}</p>
                        <span class="card-arrow">{{ block('common.buttons.read_more', $isAr ? 'المزيد' : 'More') }} <i class="fa-solid fa-arrow-{{ $isAr ? 'left' : 'right' }}"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- License Banner -->
@if($licenseNotice)
<section class="sama-banner py-4" style="background: var(--primary-light); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container text-center">
        <p class="mb-0 fw-medium text-primary">
            <i class="fa-solid fa-shield-halved me-2"></i>
            {{ $licenseNotice }}
        </p>
    </div>
</section>
@endif

<!-- How It Works -->
@if($steps->isNotEmpty())
<section class="how-it-works bg-white section" id="how-it-works">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-primary fw-bold">{{ block('home.how.eyebrow', $isAr ? 'عملية بسيطة' : 'Simple Process') }}</span>
            <h2>{{ block('home.how.title', $isAr ? 'كيف يعمل هوت سبوت؟' : 'How Hotspot Works') }}</h2>
            <p class="text-muted">{{ block('home.how.subtitle', $isAr ? 'احصل على عرض التمويل المخصص لك في ثلاث خطوات بسيطة دون زيارة أي فرع.' : 'Get your personalized financing offer in three simple steps, with no branch visits.') }}</p>
        </div>
        <div class="steps-container">
            @foreach($steps as $i => $step)
                <div class="step-card animate-fade-in-up" style="animation-delay: 0.{{ $i + 1 }}s">
                    <div class="step-icon"><i class="fa-solid {{ $step->icon }}"></i></div>
                    <h3>{{ $step->title }}</h3>
                    <p>{{ $step->description }}</p>
                </div>
                @if(!$loop->last)
                    <div class="step-arrow"><i class="fa-solid fa-chevron-{{ $isAr ? 'left' : 'right' }}"></i></div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Calculator -->
<section class="calculator-section section" id="calculator">
    <div class="container">
        <div class="calculator-wrapper">
            <div class="calc-sidebar">
                <h2 class="mb-2 text-white">{{ block('home.calc.title', $isAr ? 'احسب تمويلك' : 'Calculate Your Loan') }}</h2>
                <p class="text-white opacity-75 mb-4">{{ block('home.calc.subtitle', $isAr ? 'اضبط أشرطة التمرير لمعرفة ما يمكنك التأهل له اليوم.' : 'Adjust the sliders to see what you qualify for today.') }}</p>

                <div class="calc-results-card">
                    <div class="result-row"><span>{{ block('home.calc.monthly_label', $isAr ? 'القسط الشهري التقديري' : 'Estimated Monthly Payment') }}</span><h3 id="res-monthly">2,450 {{ block('common.labels.sar', $isAr ? 'ريال' : 'SAR') }}</h3></div>
                    <hr>
                    <div class="result-row"><span>{{ block('home.calc.total_label', $isAr ? 'إجمالي مبلغ التمويل' : 'Total Loan Amount') }}</span><h4 id="res-total">100,000 {{ block('common.labels.sar', $isAr ? 'ريال' : 'SAR') }}</h4></div>
                    <div class="result-row mt-2"><span>{{ block('home.calc.apr_label', $isAr ? 'نسبة الربح (السنوية)' : 'Profit Rate (APR)') }}</span><h4 id="res-apr" class="text-primary">2.99%</h4></div>
                    <button class="btn btn-primary w-100 mt-4">{{ block('home.calc.find_offers', $isAr ? 'ابحث عن عروض بهذا المبلغ' : 'Find Offers for This Amount') }}</button>
                </div>
            </div>

            <div class="calc-main">
                <div class="finance-type-tabs">
                    @foreach($services->take(3) as $i => $s)
                        <button class="tab-btn {{ $i === 0 ? 'active' : '' }}" data-type="{{ $s->slug }}">
                            <i class="fa-solid {{ $s->icon }}"></i> {{ $s->title }}
                        </button>
                    @endforeach
                </div>

                <div class="calc-form">
                    <div class="slider-group">
                        <div class="slider-header">
                            <label>{{ block('home.calc.amount_label', $isAr ? 'مبلغ التمويل' : 'Loan Amount') }}</label>
                            <span class="val-display"><span id="val-amount">100,000</span> {{ block('common.labels.sar', $isAr ? 'ريال' : 'SAR') }}</span>
                        </div>
                        <input type="range" id="slider-amount" min="10000" max="2000000" step="5000" value="100000" class="modern-slider">
                        <div class="slider-labels"><span>{{ block('home.calc.amount_min', $isAr ? '10 آلاف' : '10K') }}</span><span>{{ block('home.calc.amount_max', $isAr ? '2 مليون+' : '2M+') }}</span></div>
                    </div>
                    <div class="slider-group">
                        <div class="slider-header">
                            <label>{{ block('home.calc.term_label', $isAr ? 'المدة (بالسنوات)' : 'Term (Years)') }}</label>
                            <span class="val-display"><span id="val-years">5</span> {{ block('home.calc.years', $isAr ? 'سنوات' : 'years') }}</span>
                        </div>
                        <input type="range" id="slider-years" min="1" max="25" step="1" value="5" class="modern-slider">
                        <div class="slider-labels"><span>{{ block('home.calc.year_min', $isAr ? 'سنة واحدة' : '1 year') }}</span><span>{{ block('home.calc.year_max', $isAr ? '25 سنة' : '25 years') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partner Banks -->
@if($banks->isNotEmpty())
<section class="partners-section section bg-white" id="partners">
    <div class="container text-center">
        <span class="badge badge-success mb-3"><i class="fa-solid fa-shield-halved"></i> {{ block('home.partners.badge', $isAr ? 'مرخص بالكامل من قبل البنك المركزي السعودي (ساما)' : 'Fully Licensed by the Saudi Central Bank (SAMA)') }}</span>
        <h2 class="mb-5">{{ block('home.partners.title', $isAr ? 'موثوق من قبل البنوك السعودية الرائدة' : 'Trusted by Leading Saudi Banks') }}</h2>
        <div class="swiper clients-swiper">
            <div class="swiper-wrapper align-items-center justify-content-center gap-6" style="display:flex; flex-wrap:wrap;">
                @foreach($banks as $b)
                    @if($b->logo)
                        <div class="partner-logo"><img src="{{ asset($b->logo) }}" alt="{{ $b->name }}"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Offers -->
@if($offers->isNotEmpty())
<section class="comparison-section section" id="compare" style="background-color: var(--bg-main)">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>{{ block('home.offers.title', $isAr ? 'عروض التمويل المباشرة' : 'Live Financing Offers') }}</h2>
            <p class="text-muted">{{ block('home.offers.subtitle', $isAr ? 'قارن الأسعار والمدة والأقساط الشهرية فوراً.' : 'Compare rates, terms, and monthly payments instantly.') }}</p>
        </div>

        <div class="filters-bar mb-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">
                <div class="filter-tabs d-flex gap-2">
                    <button class="btn btn-primary btn-sm">{{ block('home.offers.all_sectors', $isAr ? 'جميع القطاعات' : 'All Sectors') }}</button>
                    <button class="btn btn-outline btn-sm">{{ block('home.offers.government', $isAr ? 'القطاع الحكومي' : 'Government') }}</button>
                    <button class="btn btn-outline btn-sm">{{ block('home.offers.private', $isAr ? 'القطاع الخاص' : 'Private') }}</button>
                </div>
            </div>
        </div>

        <div class="offers-list">
            @foreach($offers as $o)
                <div class="offer-card {{ $o->is_best ? 'best-offer' : ($loop->first ? '' : 'mt-4') }}">
                    @if($o->is_best)
                        <div class="offer-badge"><i class="fa-solid fa-star"></i> {{ block('home.offers.best_for_you', $isAr ? 'الخيار الأفضل لك' : 'Best for You') }}</div>
                    @endif
                    <div class="offer-grid">
                        <div class="offer-bank">
                            @if($o->bank->logo)
                                <img src="{{ asset($o->bank->logo) }}" alt="{{ $o->bank->name }}">
                            @endif
                            <div>
                                <h5>{{ $o->bank->name }}</h5>
                                <span class="{{ $o->is_best ? 'text-success' : 'text-muted' }}">
                                    <i class="fa-solid {{ $o->approval_icon }}"></i> {{ $o->approval_note }}
                                </span>
                            </div>
                        </div>
                        <div class="offer-detail"><small>{{ block('home.offers.rate_from', $isAr ? 'النسبة (تبدأ من)' : 'Rate (from)') }}</small><h4>{{ $o->apr }}%</h4></div>
                        <div class="offer-detail"><small>{{ block('home.offers.max_amount', $isAr ? 'أقصى مبلغ' : 'Max Amount') }}</small><h4>{{ number_format($o->max_amount) }} {{ block('common.labels.sar', $isAr ? 'ريال' : 'SAR') }}</h4></div>
                        <div class="offer-detail {{ $o->is_best ? 'highlight-detail' : '' }}"><small>{{ block('home.offers.monthly_100k', $isAr ? 'القسط الشهري (على 100ألف)' : 'Monthly (on 100K)') }}</small><h4>{{ number_format($o->monthly_sample) }} {{ block('common.labels.sar', $isAr ? 'ريال' : 'SAR') }}</h4></div>
                        <div class="offer-action">
                            <a href="{{ route('apply') }}?bank={{ $o->bank->slug }}" class="btn btn-primary w-100">{{ __('Apply Now') }}</a>
                            <a href="{{ route('offers.show', $o->bank->slug) }}" class="btn btn-outline w-100 btn-sm">{{ __('Details') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Articles -->
@if($articles->isNotEmpty())
<section class="education-section section" id="education" style="background-color: var(--bg-main)">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="text-primary fw-bold">{{ block('home.articles.eyebrow', $isAr ? 'أدلة مالية' : 'Financial Guides') }}</span>
            <h2>{{ block('home.articles.title', $isAr ? 'اتخذ قرارات مستنيرة' : 'Make Informed Decisions') }}</h2>
            <p class="text-muted">{{ block('home.articles.subtitle', $isAr ? 'افهم مصطلحات ومتطلبات التمويل قبل التقديم.' : 'Understand financing terms and requirements before applying.') }}</p>
        </div>
        <div class="article-grid">
            @foreach($articles as $a)
                <a href="{{ route('articles.show', $a->slug) }}" class="article-card">
                    <div class="article-img">
                        @if($a->image)<img src="{{ str_starts_with($a->image, 'http') ? $a->image : asset($a->image) }}" alt="Article">@endif
                        @if($a->category)<div class="article-category">{{ $a->category }}</div>@endif
                    </div>
                    <div class="article-content">
                        <h3>{{ $a->title }}</h3>
                        <p>{{ $a->excerpt }}</p>
                        <span class="read-more">{{ block('home.articles.read_guide', $isAr ? 'اقرأ الدليل' : 'Read Guide') }} <i class="fa-solid fa-arrow-{{ $isAr ? 'left' : 'right' }}"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Testimonials -->
@if($testimonials->isNotEmpty())
<section class="testimonials-section bg-white section" id="testimonials">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>{{ block('home.testimonials.title', $isAr ? 'يثق بها أكثر من 100 ألف مستخدم في المملكة' : 'Trusted by 100K+ users in KSA') }}</h2>
        </div>
        <div class="testimonials-grid">
            @foreach($testimonials as $r)
                <div class="review-card">
                    <div class="review-stars">
                        @for($i = 0; $i < floor((float) $r->stars); $i++)<i class="fa-solid fa-star"></i>@endfor
                        @if(((float) $r->stars) - floor((float) $r->stars) >= 0.5)<i class="fa-solid fa-star-half-stroke"></i>@endif
                    </div>
                    <p class="review-text">"{{ $r->text }}"</p>
                    <div class="reviewer">
                        <div class="reviewer-avatar">{{ $r->initial }}</div>
                        <div>
                            <strong>{{ $r->name }}</strong>
                            <span>{{ $r->city }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
