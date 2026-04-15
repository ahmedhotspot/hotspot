@extends('layouts.client')

@include('client.financing-request._home_theme')

@section('title', ln('Payment Failed', 'فشل الدفع'))
@section('page_title', ln('Payment Failed', 'فشل الدفع'))

@section('content')
<div class="client-card" style="text-align:center; padding: 2.5rem 1.5rem;">
    <div style="font-size: 5rem; color: var(--c-danger); margin-bottom: 1rem;">
        <i class="fa-solid fa-circle-xmark"></i>
    </div>

    <h2 style="margin: 0 0 .5rem;">{{ ln('Payment Failed', 'فشل الدفع') }}</h2>
    <p style="color: var(--c-muted); max-width: 700px; margin: 0 auto 1.5rem;">
        {{ ln('An error occurred during payment. We will contact you shortly through customer service.', 'حدث خطأ أثناء عملية الدفع، وسيتم التواصل معك من قبل خدمة العملاء.') }}
    </p>

    @if($req && $req->id)
        <div style="background:#f9fafb; padding:1rem; border-radius:8px; max-width:700px; margin:0 auto 1.5rem; text-align:start;">
            <div><strong>{{ ln('Request Number', 'رقم الطلب') }}:</strong> {{ $req->request_number }}</div>
            <div><strong>{{ ln('Status', 'الحالة') }}:</strong> {{ $req->payment_status }}</div>
        </div>
    @endif

    <div style="display:flex; justify-content:center; gap:.75rem; flex-wrap:wrap;">
        <a href="{{ route('client.financing-request.create') }}" class="btn-c btn-c-primary">
            {{ ln('Create New Request', 'إنشاء طلب جديد') }}
        </a>
        <a href="{{ route('client.dashboard') }}" class="btn-c btn-c-outline">
            {{ ln('Back to Dashboard', 'العودة للوحة التحكم') }}
        </a>
    </div>
</div>
@endsection
