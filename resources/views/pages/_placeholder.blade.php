@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container text-center" style="padding: 4rem 0;">
        <span class="badge badge-primary mb-3"><i class="fa-solid fa-hammer"></i> {{ block('placeholder.badge', $isRtl ? 'قيد الإنشاء' : 'Under Construction') }}</span>
        <h1 class="mb-3">{{ $title ?? block('placeholder.title', $isRtl ? 'الصفحة قيد الإعداد' : 'Page coming soon') }}</h1>
        <p class="text-muted mb-4" style="max-width: 640px; margin: 0 auto;">
            {{ block('placeholder.subtitle', $isRtl
                ? 'هذه الصفحة ستُبنى بالكامل من قاعدة البيانات في المرحلة التالية — كل المحتوى هيبقى قابل للتحكم من لوحة الأدمن.'
                : 'This page will be fully database-driven in the next phase — every block will be editable from the admin dashboard.') }}
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
            {{ block('placeholder.back_home', $isRtl ? 'الرجوع للرئيسية' : 'Back to Home') }}
        </a>
    </div>
</section>
@endsection
