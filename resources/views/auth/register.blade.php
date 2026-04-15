@extends('layouts.app')

@section('title', block('auth.register.title_meta', $isRtl ? 'إنشاء حساب' : 'Register') . ' | ' . ($siteSettings->get('site_name_'.app()->getLocale(), config('app.name'))))

@section('content')
<section class="page-header">
    <div class="container text-center" style="padding-top:3rem;">
        <span class="badge badge-primary mb-3">{{ block('auth.register.badge', $isRtl ? 'انضم إلينا' : 'Join Us') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">{{ block('auth.register.hero_title', $isRtl ? 'أنشئ حسابك' : 'Create Your Account') }}</h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('auth.register.hero_subtitle', $isRtl ? 'سجل لتبدأ في مقارنة وتقديم طلبات التمويل.' : 'Sign up to start comparing and applying for finance offers.') }}
        </p>
    </div>
</section>

<section class="login-section section">
    <div class="container">
        <div class="login-card" style="max-width: 520px; margin: 0 auto; background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 3rem;">
            <div class="login-header text-center mb-4">
                <h2 class="h4 font-weight-bold mb-2">{{ block('auth.register.card_title', $isRtl ? 'تسجيل حساب جديد' : 'Register New Account') }}</h2>
                <p class="text-muted">{{ block('auth.register.card_subtitle', $isRtl ? 'أدخل بياناتك لإنشاء حساب.' : 'Enter your details to create an account.') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="login-form" novalidate>
                @csrf

                <div class="input-group mb-3">
                    <label for="name">{{ block('auth.register.full_name', $isRtl ? 'الاسم الكامل' : 'Full Name') }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="modern-input" required autofocus>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-3">
                    <label for="email">{{ block('auth.common.email', $isRtl ? 'البريد الإلكتروني' : 'Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="modern-input" placeholder="your@email.com" required>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-3">
                    <label for="phone">{{ block('auth.common.phone', $isRtl ? 'رقم الجوال' : 'Phone') }}</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="modern-input" placeholder="05xxxxxxxx">
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-3">
                    <label for="password">{{ block('auth.common.password', $isRtl ? 'كلمة المرور' : 'Password') }}</label>
                    <input type="password" id="password" name="password" class="modern-input" required>
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-4">
                    <label for="password_confirmation">{{ block('auth.common.confirm_password', $isRtl ? 'تأكيد كلمة المرور' : 'Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="modern-input" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    {{ block('auth.register.submit', $isRtl ? 'إنشاء الحساب' : 'Create Account') }} <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>

                <div class="text-center">
                    <p class="text-muted mb-0">
                        {{ block('auth.register.have_account', $isRtl ? 'لديك حساب بالفعل؟' : 'Already have an account?') }}
                        <a href="{{ route('login') }}" class="text-primary fw-bold">{{ block('auth.register.sign_in_here', $isRtl ? 'سجل الدخول' : 'Sign In') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
