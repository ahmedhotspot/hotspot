@extends('layouts.admin')

@section('page_title', ($isRtl ? 'طلب #' : 'Application #') . $application->id)

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'تفاصيل الطلب' : 'Application Details' }} #{{ $application->id }}</h2>
        <a href="{{ route('admin.applications.index') }}" class="btn-admin btn-admin-outline">
            <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i> {{ $isRtl ? 'رجوع' : 'Back' }}
        </a>
    </div>

    <div class="form-row">
        <div class="form-field"><label>{{ $isRtl ? 'الاسم الكامل' : 'Full Name' }}</label><div>{{ $application->full_name }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'الهوية' : 'National ID' }}</label><div>{{ $application->national_id }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'البريد' : 'Email' }}</label><div>{{ $application->email }}</div></div>
    </div>
    <div class="form-row">
        <div class="form-field"><label>{{ $isRtl ? 'الهاتف' : 'Phone' }}</label><div>{{ $application->phone }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'المدينة' : 'City' }}</label><div>{{ $application->city }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'جهة العمل' : 'Employer' }}</label><div>{{ $application->employer }}</div></div>
    </div>
    <div class="form-row">
        <div class="form-field"><label>{{ $isRtl ? 'القطاع' : 'Sector' }}</label><div>{{ $application->sector }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'الراتب' : 'Salary' }}</label><div>{{ number_format((float) $application->salary) }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'المبلغ' : 'Amount' }}</label><div>{{ number_format((float) $application->amount) }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'المدة (سنوات)' : 'Term (Years)' }}</label><div>{{ $application->term_years }}</div></div>
    </div>
    <div class="form-row">
        <div class="form-field"><label>{{ $isRtl ? 'البنك' : 'Bank' }}</label><div>{{ $application->bank?->name }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'الخدمة' : 'Service' }}</label><div>{{ $application->service?->title }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'العرض' : 'Offer' }}</label><div>{{ $application->offer?->title }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'المستخدم' : 'User' }}</label><div>{{ $application->user?->name }}</div></div>
    </div>
</div>

<div class="admin-card" style="margin-top:1rem;">
    <h3>{{ $isRtl ? 'تحديث الحالة' : 'Update Status' }}</h3>
    <form method="POST" action="{{ route('admin.applications.update', $application) }}">
        @csrf @method('PATCH')
        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الحالة' : 'Status' }}</label>
                <select name="status">
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ $application->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-field" style="margin-top:1rem;">
            <label>{{ $isRtl ? 'ملاحظات المشرف' : 'Admin Notes' }}</label>
            <textarea name="notes" style="min-height:150px;">{{ old('notes', $application->notes) }}</textarea>
        </div>
        <div style="margin-top:1rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection
