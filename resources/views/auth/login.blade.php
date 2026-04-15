@extends('layouts.app')

@section('title', block('auth.login.title_meta', $isRtl ? 'تسجيل الدخول' : 'Sign In') . ' | ' . ($siteSettings->get('site_name_'.app()->getLocale(), config('app.name'))))

@section('content')
<section class="page-header">
    <div class="container text-center" style="padding-top:3rem;">
        <span class="badge badge-primary mb-3">{{ block('auth.login.badge', $isRtl ? 'تسجيل دخول آمن' : 'Secure Sign In') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">{{ block('auth.login.hero_title', $isRtl ? 'مرحباً بعودتك' : 'Welcome Back') }}</h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('auth.login.hero_subtitle', $isRtl ? 'ادخل إلى لوحة التحكم المخصصة لديك وتابع رحلتك نحو اتخاذ قرارات مالية أفضل.' : 'Sign in to your personal dashboard and continue your journey to better financial decisions.') }}
        </p>
    </div>
</section>

<section class="login-section section">
    <div class="container">
        <div class="login-card" style="max-width: 500px; margin: 0 auto; background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 3rem;">
            <div class="login-header text-center mb-4">
                <h2 class="h4 font-weight-bold mb-2">{{ block('auth.login.card_title', $isRtl ? 'سجل دخولك إلى حسابك' : 'Sign In to Your Account') }}</h2>
                <p class="text-muted">{{ block('auth.login.card_subtitle', $isRtl ? 'أدخل بياناتك للوصول إلى لوحة التحكم' : 'Enter your credentials to access the dashboard') }}</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success" style="background:#e6f7ec;color:#0a6b2e;padding:.75rem 1rem;border-radius:var(--radius);margin-bottom:1rem;">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form" novalidate>
                @csrf

                <div class="input-group mb-3">
                    <label for="email">{{ block('auth.common.email', $isRtl ? 'البريد الإلكتروني' : 'Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="modern-input" placeholder="your@email.com" required autofocus>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-3">
                    <label for="password">{{ block('auth.common.password', $isRtl ? 'كلمة المرور' : 'Password') }}</label>
                    <input type="password" id="password" name="password" class="modern-input" placeholder="{{ block('auth.login.password_placeholder', $isRtl ? 'أدخل كلمة المرور' : 'Enter your password') }}" required>
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" value="1">
                        <span class="checkmark"></span>
                        {{ block('auth.login.remember', $isRtl ? 'تذكرني' : 'Remember me') }}
                    </label>
                    <a href="{{ route('password.request') }}" class="text-primary" style="font-size: 0.9rem;">
                        {{ block('auth.login.forgot', $isRtl ? 'نسيت كلمة المرور؟' : 'Forgot password?') }}
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    {{ block('auth.login.submit', $isRtl ? 'تسجيل الدخول' : 'Sign In') }} <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>

                <div class="text-center">
                    <p class="text-muted mb-0">
                        {{ block('auth.login.no_account', $isRtl ? 'ليس لديك حساب؟' : "Don't have an account?") }}
                        <a href="{{ route('register') }}" class="text-primary fw-bold">{{ block('auth.login.register_here', $isRtl ? 'سجل هنا' : 'Register here') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
