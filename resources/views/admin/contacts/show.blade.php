@extends('layouts.admin')

@section('page_title', ($isRtl ? 'رسالة #' : 'Message #') . $contact->id)

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'تفاصيل الرسالة' : 'Message Details' }} #{{ $contact->id }}</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn-admin btn-admin-outline">
            <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i> {{ $isRtl ? 'رجوع' : 'Back' }}
        </a>
    </div>

    <div class="form-row">
        <div class="form-field"><label>{{ $isRtl ? 'الاسم' : 'Name' }}</label><div>{{ $contact->name }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'البريد' : 'Email' }}</label><div>{{ $contact->email }}</div></div>
        <div class="form-field"><label>{{ $isRtl ? 'الهاتف' : 'Phone' }}</label><div>{{ $contact->phone }}</div></div>
    </div>
    <div class="form-field" style="margin-top:1rem;">
        <label>{{ $isRtl ? 'الموضوع' : 'Subject' }}</label>
        <div>{{ $contact->subject }}</div>
    </div>
    <div class="form-field" style="margin-top:1rem;">
        <label>{{ $isRtl ? 'الرسالة' : 'Message' }}</label>
        <div style="background:#f9fafb;padding:1rem;border-radius:6px;white-space:pre-wrap;">{{ $contact->message }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top:1rem;">
    <h3>{{ $isRtl ? 'تحديث' : 'Update' }}</h3>
    <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
        @csrf @method('PATCH')
        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الحالة' : 'Status' }}</label>
                <select name="status">
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ $contact->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-field" style="margin-top:1rem;">
            <label>{{ $isRtl ? 'ملاحظات المشرف' : 'Admin Notes' }}</label>
            <textarea name="admin_notes" style="min-height:150px;">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
        </div>
        <div style="margin-top:1rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection
