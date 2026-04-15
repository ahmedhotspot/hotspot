@php
    $locale    = app()->getLocale();
    $altLocale = $locale === 'ar' ? 'en' : 'ar';
    $logoKey   = $locale === 'ar' ? 'logo_ar' : 'logo_en';
    $logo      = $siteSettings->get($logoKey, 'assets/img/logo_ar.png');
@endphp
<nav class="navbar" id="navbar">
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset($logo) }}" alt="{{ $siteSettings->get('site_name_'.$locale, config('app.name')) }}" class="logo-img">
        </a>

        @php $ctaItem = $headerMenu->firstWhere('url', '/financing-request'); @endphp

        <div class="nav-links">
            @foreach($headerMenu as $item)
                @continue($item->url === '/financing-request')
                <a href="{{ $item->url }}" class="nav-link"
                   @if($item->target !== '_self') target="{{ $item->target }}" @endif>
                    {{ $item->label }}
                </a>
            @endforeach
        </div>

        <div class="nav-actions">
            <a href="{{ route('locale.switch', $altLocale) }}" class="lang-btn">
                {{ $altLocale === 'ar' ? 'العربية' : 'English' }}
            </a>
            @if($ctaItem)
                <a href="{{ $ctaItem->url }}" class="nav-link-cta">
                    <i class="fa-solid fa-bolt"></i>
                    {{ $ctaItem->label }}
                </a>
            @endif
            @auth
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-user"></i>
                        {{ auth()->user()->name }} <i class="fa-solid fa-chevron-down fs-sm"></i>
                    </button>
                    <div class="dropdown-menu">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ url('/admin') }}" class="dropdown-item">
                                <i class="fa-solid fa-gauge"></i> {{ block('nav.account.dashboard', $isRtl ? 'لوحة التحكم' : 'Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-gauge"></i> {{ block('nav.account.my_dashboard', $isRtl ? 'حسابي وطلباتي' : 'My Dashboard') }}
                            </a>
                            <a href="{{ route('client.profile') }}" class="dropdown-item">
                                <i class="fa-solid fa-user"></i> {{ block('nav.account.profile', $isRtl ? 'بياناتي' : 'My Profile') }}
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item" style="background:none;border:0;width:100%;text-align:{{ $isRtl ? 'right' : 'left' }};cursor:pointer;">
                                <i class="fa-solid fa-right-from-bracket"></i> {{ block('nav.account.logout', $isRtl ? 'تسجيل الخروج' : 'Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm">
                        {{ block('nav.account.account', $isRtl ? 'حسابي' : 'Account') }} <i class="fa-solid fa-chevron-down fs-sm"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('register') }}" class="dropdown-item">{{ block('nav.account.register', $isRtl ? 'إنشاء حساب' : 'Register') }}</a>
                        <a href="{{ route('login') }}" class="dropdown-item">{{ block('nav.account.login', $isRtl ? 'تسجيل الدخول' : 'Login') }}</a>
                    </div>
                </div>
            @endauth
        </div>

        <button class="mobile-menu-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>
