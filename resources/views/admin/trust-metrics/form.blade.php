@extends('layouts.admin')

@section('page_title', $metric->exists ? ($isRtl ? 'تعديل مقياس' : 'Edit Metric') : ($isRtl ? 'إضافة مقياس' : 'Add Metric'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $metric->exists ? route('admin.trust-metrics.update', $metric) : route('admin.trust-metrics.store') }}">
        @csrf
        @if($metric->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $metric->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $metric->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div class="lang-group" style="margin-bottom:1rem;">
            <div class="lang-tabs">
                <button type="button" class="lang-tab active" data-lang="ar">العربية</button>
                <button type="button" class="lang-tab" data-lang="en">English</button>
            </div>
            <div class="lang-pane active" data-lang="ar">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>القيمة (عربي) *</label>
                    <input type="text" name="value_ar" value="{{ old('value_ar', $metric->getTranslations('value')['ar'] ?? '') }}" required placeholder="+50,000">
                    @error('value_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>التسمية (عربي) *</label>
                    <input type="text" name="label_ar" value="{{ old('label_ar', $metric->getTranslations('label')['ar'] ?? '') }}" required>
                    @error('label_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Value (English)</label>
                    <input type="text" name="value_en" value="{{ old('value_en', $metric->getTranslations('value')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Label (English)</label>
                    <input type="text" name="label_en" value="{{ old('label_en', $metric->getTranslations('label')['en'] ?? '') }}">
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.trust-metrics.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
