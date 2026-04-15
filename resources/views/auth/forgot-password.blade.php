@extends('layouts.app')

@section('title', block('auth.forgot.title_meta', $isRtl ? 'نسيت كلمة المرور' : 'Forgot Password'))

@section('content')
<section class="page-header">
    <div class="container text-center" style="padding-top:3rem;">
        <span class="badge badge-primary mb-3">{{ block('auth.forgot.badge', $isRtl ? 'استعادة الحساب' : 'Account Recovery') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">{{ block('auth.forgot.hero_title', $isRtl ? 'نسيت كلمة المرور؟' : 'Forgot Password?') }}</h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('auth.forgot.hero_subtitle', $isRtl ? 'أدخل بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور.' : 'Enter your email and we will send you a reset link.') }}
        </p>
    </div>
</section>

<section class="login-section section">
    <div class="container">
        <div class="login-card" style="max-width: 500px; margin: 0 auto; background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 3rem;">
            @if(session('status'))
                <div class="alert alert-success" style="background:#e6f7ec;color:#0a6b2e;padding:.75rem 1rem;border-radius:var(--radius);margin-bottom:1rem;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf
                <div class="input-group mb-4">
                    <label for="email">{{ block('auth.common.email', $isRtl ? 'البريد الإلكتروني' : 'Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="modern-input" required autofocus>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    {{ block('auth.forgot.submit', $isRtl ? 'إرسال رابط الاستعادة' : 'Send Reset Link') }}
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-primary fw-bold">{{ block('auth.common.back_to_login', $isRtl ? 'الرجوع لتسجيل الدخول' : 'Back to Sign In') }}</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
