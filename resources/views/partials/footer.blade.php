@php
    $locale   = app()->getLocale();
    $logoKey  = $locale === 'ar' ? 'logo_ar' : 'logo_en';
    $logo     = $siteSettings->get($logoKey, 'assets/img/logo_ar.png');
    $isAr     = $locale === 'ar';
    $siteName = $siteSettings->get('site_name_'.$locale, config('app.name'));
@endphp
<footer class="footer section pb-0">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="logo mb-3">
                    <img src="{{ asset($logo) }}" alt="{{ $siteName }}" class="logo-img">
                </a>
                <p class="text-muted mt-3">
                    {{ $siteSettings->get('tagline', block('footer.brand.tagline_default', $isAr ? 'قارن عروض التمويل' : 'Compare Financing Offers')) }}
                </p>

                @php
                    $playUrl  = $siteSettings->get('google_play_url');
                    $storeUrl = $siteSettings->get('app_store_url');
                @endphp
                @if($playUrl || $storeUrl)
                    <div class="footer-app-links mt-4">
                        <p>{{ __('Download App') }}</p>
                        <div class="app-btn-container">
                            @if($playUrl)
                                <a href="{{ $playUrl }}" class="app-store-btn" target="_blank" rel="noopener">
                                    <img src="{{ asset('assets/img/social/android.png') }}" alt="Google Play">
                                </a>
                            @endif
                            @if($storeUrl)
                                <a href="{{ $storeUrl }}" class="app-store-btn" target="_blank" rel="noopener">
                                    <img src="{{ asset('assets/img/social/ios.png') }}" alt="App Store">
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if($socialLinks->isNotEmpty())
                    <div class="social-links mt-4">
                        @foreach($socialLinks as $s)
                            <a href="{{ $s->url }}" target="_blank" rel="noopener"><i class="{{ $s->icon }}"></i></a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="footer-links">
                <h4>{{ __('Finance') }}</h4>
                <ul>
                    @foreach($footerFinance as $item)
                        <li><a href="{{ $item->url }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-links">
                <h4>{{ __('Company') }}</h4>
                <ul>
                    @foreach($footerCompany as $item)
                        <li><a href="{{ $item->url }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-links">
                <h4>{{ __('Contact') }}</h4>
                <ul class="contact-ul">
                    @php $email = $siteSettings->get('email'); @endphp
                    @if($email)
                        <li><i class="fa-solid fa-envelope text-primary"></i> <a href="mailto:{{ $email }}">{{ $email }}</a></li>
                    @endif
                    @php $phone = $siteSettings->get('phone'); $phoneDisplay = $siteSettings->get('phone_display', $phone); @endphp
                    @if($phone)
                        <li><i class="fa-solid fa-phone text-primary"></i> <a href="tel:{{ $phone }}">{{ $phoneDisplay }}</a></li>
                    @endif
                    @php $address = $siteSettings->get('address'); @endphp
                    @if($address)
                        <li class="d-flex gap-2">
                            <i class="fa-solid fa-location-dot text-primary mt-1"></i>
                            <span>{{ $address }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container d-flex justify-content-between align-items-center flex-wrap gap-4">
                <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ __('All rights reserved') }}.</p>
                @php $samaLogo = $siteSettings->get('sama_logo'); @endphp
                @if($samaLogo)
                    <div class="footer-regulator">
                        <span>{{ block('footer.bottom.licensed_by', $isAr ? 'مرخص من' : 'Licensed by') }}</span>
                        <img src="{{ asset($samaLogo) }}" alt="SAMA" class="sama-logo">
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>
