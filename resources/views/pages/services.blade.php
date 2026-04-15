@extends('layouts.app')

@section('title', block('services.hero.title_meta', $isRtl ? 'الخدمات' : 'Services'))

@section('content')
<section class="page-header">
    <div class="container">
        <h1 class="font-weight-bold" style="font-size: 3rem;">
            {{ block('services.hero.title', $isRtl ? 'الخدمات' : 'Services') }}
        </h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('services.hero.subtitle', $isRtl
                ? 'احصل على عروض تمويل مخصصة من أفضل المؤسسات المالية للتمويل العقاري والشخصي والسيارات والبطاقات الائتمانية.'
                : 'Get Custom financing offers from Top Financial Institutions for Mortgage Finance, Personal Loans, Auto Lease and Credit Cards.') }}
        </p>
    </div>
</section>

@forelse($services ?? [] as $index => $service)
    <section class="service-feature {{ $index % 2 === 0 ? 'bg-white' : 'bg-light' }}" id="{{ $service->slug }}">
        <div class="container">
            <div class="row align-items-center">
                @if($index % 2 === 0)
                    <div class="col-lg-6 order-2 order-lg-1 service-content" data-aos="fade-right">
                        <h2>{{ $service->title }}</h2>
                        <p class="service-description">{{ $service->description }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary">
                            {{ block('common.buttons.learn_more', $isRtl ? 'اعرف المزيد' : 'Learn More') }}
                            <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                        </a>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 service-image-wrapper" data-aos="fade-left">
                        @if($service->icon)
                            <img src="{{ asset($service->icon) }}" alt="{{ $service->title }}" class="service-image">
                        @else
                            <img src="{{ asset('Hotspot_Redesign/assets/img/services/PERSONAL_FINANCING.svg') }}" alt="{{ $service->title }}" class="service-image">
                        @endif
                    </div>
                @else
                    <div class="col-lg-6 service-image-wrapper" data-aos="fade-right">
                        @if($service->icon)
                            <img src="{{ asset($service->icon) }}" alt="{{ $service->title }}" class="service-image">
                        @else
                            <img src="{{ asset('Hotspot_Redesign/assets/img/services/AUTO_FINANCING.svg') }}" alt="{{ $service->title }}" class="service-image">
                        @endif
                    </div>
                    <div class="col-lg-6 service-content" data-aos="fade-left">
                        <h2>{{ $service->title }}</h2>
                        <p class="service-description">{{ $service->description }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary">
                            {{ block('common.buttons.learn_more', $isRtl ? 'اعرف المزيد' : 'Learn More') }}
                            <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@empty
    <section class="section">
        <div class="container text-center">
            <p class="text-muted">{{ block('services.list.empty', $isRtl ? 'لا توجد خدمات متاحة حاليًا.' : 'No services available at the moment.') }}</p>
        </div>
    </section>
@endforelse
@endsection
