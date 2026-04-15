@extends('layouts.client')

@section('page_title', ($isRtl ? 'تفاصيل الطلب' : 'Request Details') . ' #' . $application->id)

@section('content')
    @php
        $statusColors = [
            'new'       => ['#e0e7ff', '#4338ca'],
            'reviewing' => ['#fef3c7', '#a16207'],
            'approved'  => ['#dcfce7', '#166534'],
            'rejected'  => ['#fee2e2', '#991b1b'],
            'completed' => ['#dbeafe', '#1d4ed8'],
        ];
        $statusLabelsAr = [
            'new' => 'جديد', 'reviewing' => 'قيد المراجعة',
            'approved' => 'موافق', 'rejected' => 'مرفوض', 'completed' => 'مكتمل',
        ];
        [$bg, $fg] = $statusColors[$application->status] ?? ['#f3f4f6', '#4b5563'];
        $label = $isRtl ? ($statusLabelsAr[$application->status] ?? $application->status) : ucfirst($application->status);
    @endphp

    <div style="margin-bottom:1rem;">
        <a href="{{ route('client.dashboard') }}" class="btn-c btn-c-outline btn-c-sm">
            <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
            {{ $isRtl ? 'العودة للوحة التحكم' : 'Back to Dashboard' }}
        </a>
    </div>

    <div class="client-card">
        <div class="card-head">
            <h2>{{ $isRtl ? 'طلب رقم' : 'Request' }} #{{ $application->id }}</h2>
            <span class="badge-pill" style="background: {{ $bg }}; color: {{ $fg }}; padding:.4rem 1rem;">{{ $label }}</span>
        </div>

        <div class="info-grid">
            @foreach([
                ['k' => $isRtl ? 'تاريخ التقديم' : 'Submitted',    'v' => $application->created_at->format('Y-m-d H:i')],
                ['k' => $isRtl ? 'الخدمة' : 'Service',             'v' => $application->service->name ?? '—'],
                ['k' => $isRtl ? 'البنك'  : 'Bank',                'v' => $application->bank->name ?? '—'],
                ['k' => $isRtl ? 'العرض'  : 'Offer',               'v' => $application->offer->title ?? '—'],
                ['k' => $isRtl ? 'الاسم الكامل' : 'Full Name',     'v' => $application->full_name ?? '—'],
                ['k' => $isRtl ? 'رقم الهوية' : 'National ID',     'v' => $application->national_id ?? '—'],
                ['k' => $isRtl ? 'البريد'  : 'Email',              'v' => $application->email ?? '—'],
                ['k' => $isRtl ? 'الجوال'  : 'Phone',              'v' => $application->phone ?? '—'],
                ['k' => $isRtl ? 'المدينة' : 'City',               'v' => $application->city ?? '—'],
                ['k' => $isRtl ? 'جهة العمل' : 'Employer',         'v' => $application->employer ?? '—'],
                ['k' => $isRtl ? 'القطاع'  : 'Sector',             'v' => $application->sector ?? '—'],
                ['k' => $isRtl ? 'الراتب'  : 'Salary',             'v' => $application->salary ? number_format($application->salary) : '—'],
                ['k' => $isRtl ? 'مبلغ التمويل' : 'Amount',        'v' => $application->amount ? number_format($application->amount) : '—'],
                ['k' => $isRtl ? 'مدة السداد (سنوات)' : 'Term (years)', 'v' => $application->term_years ?? '—'],
            ] as $row)
                <div class="info-item">
                    <div class="k">{{ $row['k'] }}</div>
                    <div class="v">{{ $row['v'] }}</div>
                </div>
            @endforeach
        </div>

        @if($application->notes)
            <div style="margin-top:1.5rem; padding:1rem; background:#f8f9fa; border-radius:8px;">
                <div class="k" style="color:#6b7280; font-size:.8rem; margin-bottom:.3rem;">{{ $isRtl ? 'ملاحظات' : 'Notes' }}</div>
                <div>{{ $application->notes }}</div>
            </div>
        @endif
    </div>
@endsection
