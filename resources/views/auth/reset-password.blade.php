@extends('layouts.app')

@section('title', block('auth.reset.title_meta', $isRtl ? 'إعادة تعيين كلمة المرور' : 'Reset Password'))

@section('content')
<section class="page-header">
    <div class="container text-center" style="padding-top:3rem;">
        <span class="badge badge-primary mb-3">{{ block('auth.reset.badge', $isRtl ? 'استعادة الحساب' : 'Account Recovery') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">{{ block('auth.reset.hero_title', $isRtl ? 'إعادة تعيين كلمة المرور' : 'Reset Password') }}</h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('auth.reset.hero_subtitle', $isRtl ? 'أدخل كلمة المرور الجديدة لحسابك.' : 'Enter a new password for your account.') }}
        </p>
    </div>
</section>

<section class="login-section section">
    <div class="container">
        <div class="login-card" style="max-width: 500px; margin: 0 auto; background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 3rem;">
            <form method="POST" action="{{ route('password.update') }}" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <label for="email">{{ block('auth.common.email', $isRtl ? 'البريد الإلكتروني' : 'Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" class="modern-input" required autofocus>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-3">
                    <label for="password">{{ block('auth.reset.new_password', $isRtl ? 'كلمة المرور الجديدة' : 'New Password') }}</label>
                    <input type="password" id="password" name="password" class="modern-input" required>
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="input-group mb-4">
                    <label for="password_confirmation">{{ block('auth.common.confirm_password', $isRtl ? 'تأكيد كلمة المرور' : 'Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="modern-input" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    {{ block('auth.reset.submit', $isRtl ? 'إعادة تعيين كلمة المرور' : 'Reset Password') }}
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-primary fw-bold">{{ block('auth.common.back_to_login', $isRtl ? 'الرجوع لتسجيل الدخول' : 'Back to Sign In') }}</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
