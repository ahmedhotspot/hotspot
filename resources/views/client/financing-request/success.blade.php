@extends('layouts.client')

@include('client.financing-request._home_theme')

@section('title', ln('Request Submitted Successfully', 'تم تقديم الطلب بنجاح'))
@section('page_title', ln('Success', 'تم بنجاح'))

@section('content')
<div class="client-card" style="text-align:center; padding: 2.5rem 1.5rem;">
    <div style="font-size: 5rem; color: var(--c-success); margin-bottom: 1rem;">
        <i class="fa-solid fa-circle-check"></i>
    </div>

    <h1 style="margin: 0 0 .5rem;">{{ ln('Your request has been submitted successfully!', 'تم تقديم طلبك بنجاح!') }}</h1>
    <p style="color: var(--c-muted); max-width: 700px; margin: 0 auto 2rem;">
        {{ ln('Thank you for submitting your financing request. Your request will be reviewed and we will get back to you as soon as possible.', 'شكراً لك على تقديم طلب التمويل. سيتم مراجعة طلبك والرد عليك في أقرب وقت ممكن.') }}
    </p>

    <div class="info-grid" style="max-width: 700px; margin: 0 auto 2rem; text-align:start;">
        <div class="info-item">
            <div class="k">{{ ln('Request Number', 'رقم الطلب') }}</div>
            <div class="v">#{{ $request->request_number }}</div>
        </div>
        <div class="info-item">
            <div class="k">{{ ln('Status', 'حالة الطلب') }}</div>
            <div class="v">{{ $request->status_label }}</div>
        </div>
        <div class="info-item">
            <div class="k">{{ ln('Client Name', 'اسم العميل') }}</div>
            <div class="v">{{ $request->client_name }}</div>
        </div>
        <div class="info-item">
            <div class="k">{{ ln('Submission Date', 'تاريخ التقديم') }}</div>
            <div class="v">{{ $request->created_at->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    <div style="display:flex; justify-content:center; gap:.75rem; flex-wrap:wrap;">
        <a href="{{ route('client.financing-request.show', $request->id) }}" class="btn-c btn-c-primary">
            <i class="fa-solid fa-eye"></i> {{ ln('View Request Details', 'عرض تفاصيل الطلب') }}
        </a>
        <a href="{{ route('client.financing-request.index') }}" class="btn-c btn-c-outline">
            <i class="fa-solid fa-list"></i> {{ ln('All Requests', 'جميع الطلبات') }}
        </a>
        <a href="{{ route('client.dashboard') }}" class="btn-c btn-c-outline">
            <i class="fa-solid fa-house"></i> {{ ln('Back to Home', 'العودة للرئيسية') }}
        </a>
    </div>
</div>
@endsection
