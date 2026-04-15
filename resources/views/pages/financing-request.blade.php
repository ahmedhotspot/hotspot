@extends('layouts.app')

@section('title', block('financing.hero.title', $isRtl ? 'طلب تمويل' : 'Financing Request'))
@section('description', block('financing.hero.subtitle', $isRtl
    ? 'قدّم طلبك في أقل من دقيقة وسيتواصل معك أحد مستشارينا.'
    : 'Submit your request in under a minute and an advisor will contact you.'))

@section('content')
<section class="financing-request-page">
    <div class="container">
        <div class="fr-wrapper">
            <div class="fr-intro" data-aos="fade-{{ $isRtl ? 'left' : 'right' }}">
                <span class="badge badge-primary mb-3">
                    <i class="fa-solid fa-bolt"></i>
                    {{ block('financing.hero.badge', $isRtl ? 'سريع وآمن' : 'Fast & Secure') }}
                </span>
                <h1>{{ block('financing.hero.title', $isRtl ? 'قدّم طلب تمويلك الآن' : 'Submit Your Financing Request') }}</h1>
                <p class="fr-subtitle">
                    {{ block('financing.hero.subtitle', $isRtl
                        ? 'املأ البيانات الأساسية وسيقوم فريقنا بالتواصل معك خلال 24 ساعة لاستكمال الإجراءات.'
                        : 'Fill in the basic details and our team will reach out within 24 hours to complete the process.') }}
                </p>

                <ul class="fr-highlights">
                    <li><i class="fa-solid fa-shield-halved"></i> {{ $isRtl ? 'بياناتك محمية بالكامل' : 'Your data is fully protected' }}</li>
                    <li><i class="fa-solid fa-clock"></i> {{ $isRtl ? 'رد خلال 24 ساعة' : 'Response within 24 hours' }}</li>
                    <li><i class="fa-solid fa-building-columns"></i> {{ $isRtl ? 'شراكات مع أكبر البنوك' : 'Partnered with top banks' }}</li>
                    <li><i class="fa-solid fa-circle-check"></i> {{ $isRtl ? 'بدون رسوم خفية' : 'No hidden fees' }}</li>
                </ul>
            </div>

            <div class="fr-card" data-aos="fade-{{ $isRtl ? 'right' : 'left' }}">
                @if(session('success'))
                    <div class="alert alert-success mb-3">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul style="margin:0; padding-{{ $isRtl ? 'right' : 'left' }}:1.25rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('financing-request.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="full_name">
                            <i class="fa-solid fa-user"></i>
                            {{ $isRtl ? 'الاسم الكامل' : 'Full Name' }}
                        </label>
                        <input type="text" id="full_name" name="full_name"
                               value="{{ old('full_name') }}"
                               placeholder="{{ $isRtl ? 'أدخل اسمك الكامل' : 'Enter your full name' }}"
                               required autocomplete="name" />
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <i class="fa-solid fa-mobile-screen"></i>
                            {{ $isRtl ? 'رقم الجوال' : 'Mobile Number' }}
                        </label>
                        <input type="tel" id="phone" name="phone"
                               value="{{ old('phone') }}"
                               inputmode="tel" pattern="05[0-9]{8}" maxlength="10"
                               placeholder="05XXXXXXXX"
                               required autocomplete="tel" dir="ltr" />
                    </div>

                    <div class="form-group">
                        <label for="national_id">
                            <i class="fa-solid fa-id-card"></i>
                            {{ $isRtl ? 'رقم الهوية' : 'National ID' }}
                        </label>
                        <input type="text" id="national_id" name="national_id"
                               value="{{ old('national_id') }}"
                               inputmode="numeric" pattern="[0-9]{10}" maxlength="10"
                               placeholder="{{ $isRtl ? '10 أرقام' : '10 digits' }}"
                               required dir="ltr" />
                    </div>

                    <div class="form-group">
                        <label for="service_id">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            {{ $isRtl ? 'نوع التمويل' : 'Financing Type' }}
                        </label>
                        <select id="service_id" name="service_id" required>
                            <option value="" disabled {{ old('service_id') ? '' : 'selected' }}>
                                {{ $isRtl ? 'اختر نوع التمويل' : 'Select financing type' }}
                            </option>
                            @foreach($services as $svc)
                                <option value="{{ $svc->id }}" {{ (string) old('service_id') === (string) $svc->id ? 'selected' : '' }}>
                                    {{ $svc->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fr-submit">
                        <span>{{ $isRtl ? 'إرسال الطلب' : 'Submit Request' }}</span>
                        <i class="fa-solid fa-{{ $isRtl ? 'arrow-left' : 'arrow-right' }}"></i>
                    </button>

                    <p class="fr-privacy">
                        <i class="fa-solid fa-lock"></i>
                        {{ $isRtl
                            ? 'بإرسالك الطلب فأنت توافق على سياسة الخصوصية الخاصة بنا.'
                            : 'By submitting, you agree to our privacy policy.' }}
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
