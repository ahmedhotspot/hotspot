@extends('layouts.app')

@section('title', $service->title)

@section('content')
<section class="service-detail-hero">
    <div class="container">
        <div class="hero-row">
            <div class="hero-text">
                <h1>{{ $service->title }}</h1>
                <p>{{ $service->description }}</p>
                <a href="{{ route('apply') }}" class="btn btn-primary">
                    {{ block('service.hero.cta_compare', $isRtl ? 'طلب تمويل الآن' : 'Compare Offers Now') }}
                </a>
            </div>
            <div class="hero-img">
                @if($service->icon)
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->title }}" />
                @else
                    <img src="{{ asset('Hotspot_Redesign/assets/img/services/PERSONAL_FINANCING.svg') }}" alt="{{ $service->title }}" />
                @endif
            </div>
        </div>
    </div>
</section>

<section class="service-detail-body">
    <div class="container">
        <div class="content-wrapper">
            <a href="{{ route('services.index') }}" class="back-to-services">
                <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
                {{ block('service.body.back', $isRtl ? 'العودة للخدمات' : 'Back to Services') }}
            </a>

            @if(!empty($service->long_description))
                <div class="prose">
                    {!! $service->long_description !!}
                </div>
            @else
                <h2>{{ block('service.body.why_title', $isRtl ? 'لماذا تختار هذا التمويل عبر هوت سبوت؟' : 'Why Choose This Financing Through Hotspot?') }}</h2>
                <p>{{ $service->description }}</p>
            @endif

            <h2>{{ block('service.body.offers_title', $isRtl ? 'العروض المتاحة' : 'Available Offers') }}</h2>

            @forelse($offers ?? [] as $offer)
                <div class="service-info-box" style="display:flex; gap:1.5rem; align-items:center; margin-bottom:1rem; flex-wrap:wrap;">
                    @if($offer->bank && $offer->bank->logo)
                        <img src="{{ asset($offer->bank->logo) }}" alt="{{ $offer->bank->name }}" style="width:80px; height:auto; object-fit:contain;">
                    @endif
                    <div style="flex:1; min-width:240px;">
                        <h3>{{ $offer->title }}</h3>
                        <p style="margin-bottom:0.5rem;">{{ $offer->bank?->name }}</p>
                        <div style="display:flex; gap:1.5rem; flex-wrap:wrap;">
                            <span><strong>{{ block('service.body.apr_label', $isRtl ? 'نسبة الفائدة:' : 'APR:') }}</strong> {{ $offer->apr }}%</span>
                            <span><strong>{{ block('service.body.max_label', $isRtl ? 'الحد الأقصى:' : 'Max Amount:') }}</strong> {{ number_format($offer->max_amount) }} {{ block('common.labels.sar_short', $isRtl ? 'ر.س' : 'SAR') }}</span>
                            <span><strong>{{ block('service.body.monthly_label', $isRtl ? 'القسط الشهري:' : 'Monthly:') }}</strong> {{ number_format($offer->monthly_sample) }} {{ block('common.labels.sar_short', $isRtl ? 'ر.س' : 'SAR') }}</span>
                        </div>
                    </div>
                    @if($offer->bank)
                        <a href="{{ route('apply', ['bank' => $offer->bank->slug]) }}" class="btn btn-primary">
                            {{ block('common.buttons.apply_now', $isRtl ? 'قدّم الآن' : 'Apply Now') }}
                        </a>
                    @endif
                </div>
            @empty
                <p class="text-muted">{{ block('service.body.no_offers', $isRtl ? 'لا توجد عروض متاحة حاليًا لهذه الخدمة.' : 'No offers available for this service at the moment.') }}</p>
            @endforelse

            <div class="text-center mt-5">
                <a href="{{ route('apply') }}" class="btn btn-primary btn-lg">
                    {{ block('service.body.apply_cta', $isRtl ? 'قدّم طلب تمويل' : 'Apply for Financing') }}
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
