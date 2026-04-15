@extends('layouts.app')

@section('title', $bank->name)

@section('content')
<section class="offer-detail-hero">
    <div class="container">
        <div class="bank-header">
            @if($bank->logo)
                <img src="{{ asset($bank->logo) }}" alt="{{ $bank->name }}" />
            @endif
            <div>
                <h1>
                    @if($isRtl)
                        {{ block('offer.hero.prefix', 'عروض') }} {{ $bank->name }}
                    @else
                        {{ $bank->name }} {{ block('offer.hero.suffix', 'Offers') }}
                    @endif
                </h1>
                <span class="text-success">
                    <i class="fa-solid fa-bolt"></i>
                    {{ block('offer.hero.instant_approval', $isRtl ? 'موافقة فورية' : 'Instant Approval') }}
                </span>
            </div>
        </div>
    </div>
</section>

<section class="offer-detail-body">
    <div class="container">
        <a href="{{ route('home') }}" class="back-to-services">
            <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
            {{ block('offer.body.back', $isRtl ? 'العودة للعروض' : 'Back to Offers') }}
        </a>

        <div class="content-wrapper">
            <h2>{{ block('offer.body.about_title', $isRtl ? 'عن البنك' : 'About the Bank') }}</h2>
            <p>{{ $bank->description ?? block('offer.body.about_fallback', $isRtl ? 'أحد أبرز الشركاء الماليين في المملكة.' : 'One of the leading financial partners in the Kingdom.') }}</p>

            @php
                $groupedOffers = ($offers ?? collect())->groupBy(fn($o) => $o->service?->title ?? block('common.labels.general', $isRtl ? 'عام' : 'General'));
            @endphp

            @forelse($groupedOffers as $serviceName => $serviceOffers)
                <h2 class="mt-5">{{ $serviceName }}</h2>

                @foreach($serviceOffers as $offer)
                    <div class="offer-stats-grid" style="margin-bottom:2rem;">
                        <div class="offer-stat-card highlight">
                            <span>{{ block('offer.body.apr', $isRtl ? 'نسبة الفائدة' : 'APR') }}</span>
                            <strong>{{ $offer->apr }}%</strong>
                        </div>
                        <div class="offer-stat-card">
                            <span>{{ block('offer.body.max_amount', $isRtl ? 'الحد الأقصى' : 'Max Amount') }}</span>
                            <strong>{{ number_format($offer->max_amount) }} {{ block('common.labels.sar_short', $isRtl ? 'ر.س' : 'SAR') }}</strong>
                        </div>
                        <div class="offer-stat-card">
                            <span>{{ block('offer.body.monthly', $isRtl ? 'القسط الشهري' : 'Monthly Payment') }}</span>
                            <strong>{{ number_format($offer->monthly_sample) }} {{ block('common.labels.sar_short', $isRtl ? 'ر.س' : 'SAR') }}</strong>
                        </div>
                        <div class="offer-stat-card">
                            <span>{{ block('offer.body.tenure', $isRtl ? 'المدة' : 'Tenure') }}</span>
                            <strong>
                                @if($isRtl)
                                    {{ block('offer.body.tenure_prefix', 'حتى') }} {{ $offer->max_tenure ?? 60 }} {{ block('offer.body.tenure_unit_ar', 'شهر') }}
                                @else
                                    {{ block('offer.body.tenure_prefix_en', 'Up to') }} {{ $offer->max_tenure ?? 60 }} {{ block('offer.body.tenure_unit_en', 'months') }}
                                @endif
                            </strong>
                        </div>
                    </div>

                    @if(!empty($offer->description))
                        <p>{{ $offer->description }}</p>
                    @endif

                    <div class="text-center mb-5">
                        <a href="{{ route('apply', ['bank' => $bank->slug]) }}" class="btn btn-primary btn-lg">
                            {{ block('common.buttons.apply_now', $isRtl ? 'قدّم الآن' : 'Apply Now') }}
                            <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                        </a>
                    </div>
                @endforeach
            @empty
                <p class="text-muted">{{ block('offer.body.no_offers', $isRtl ? 'لا توجد عروض متاحة حاليًا.' : 'No offers available at the moment.') }}</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
