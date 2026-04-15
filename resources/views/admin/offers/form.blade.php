@extends('layouts.admin')

@section('page_title', $offer->exists ? ($isRtl ? 'تعديل عرض' : 'Edit Offer') : ($isRtl ? 'إضافة عرض' : 'Add Offer'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $offer->exists ? route('admin.offers.update', $offer) : route('admin.offers.store') }}">
        @csrf
        @if($offer->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'البنك' : 'Bank' }} *</label>
                <select name="bank_id" required>
                    <option value="">--</option>
                    @foreach($banks as $bank)
                        <option value="{{ $bank->id }}" {{ old('bank_id', $offer->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                    @endforeach
                </select>
                @error('bank_id')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الخدمة' : 'Service' }} *</label>
                <select name="service_id" required>
                    <option value="">--</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $offer->service_id) == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                    @endforeach
                </select>
                @error('service_id')<div class="err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="lang-group" style="margin-bottom:1rem;">
            <div class="lang-tabs">
                <button type="button" class="lang-tab active" data-lang="ar">العربية</button>
                <button type="button" class="lang-tab" data-lang="en">English</button>
            </div>
            <div class="lang-pane active" data-lang="ar">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>العنوان (عربي) *</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $offer->getTranslations('title')['ar'] ?? '') }}" required>
                    @error('title_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>ملاحظة الموافقة (عربي)</label>
                    <textarea name="approval_note_ar">{{ old('approval_note_ar', $offer->getTranslations('approval_note')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $offer->getTranslations('title')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Approval Note (English)</label>
                    <textarea name="approval_note_en">{{ old('approval_note_en', $offer->getTranslations('approval_note')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>APR</label>
                <input type="number" step="0.01" name="apr" value="{{ old('apr', $offer->apr) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'أقصى مبلغ' : 'Max Amount' }}</label>
                <input type="number" step="0.01" name="max_amount" value="{{ old('max_amount', $offer->max_amount) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'أدنى مبلغ' : 'Min Amount' }}</label>
                <input type="number" step="0.01" name="min_amount" value="{{ old('min_amount', $offer->min_amount) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'القسط الشهري (عينة)' : 'Monthly Sample' }}</label>
                <input type="number" step="0.01" name="monthly_sample" value="{{ old('monthly_sample', $offer->monthly_sample) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'أقصى مدة (سنوات)' : 'Max Term (Years)' }}</label>
                <input type="number" name="max_term_years" value="{{ old('max_term_years', $offer->max_term_years) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'القطاع' : 'Sector' }}</label>
                <input type="text" name="sector" value="{{ old('sector', $offer->sector) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'أيقونة الموافقة' : 'Approval Icon' }}</label>
                <input type="text" name="approval_icon" value="{{ old('approval_icon', $offer->approval_icon) }}" placeholder="fa-check">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $offer->order ?? 0) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_best" value="0">
                    <input type="checkbox" name="is_best" value="1" {{ old('is_best', $offer->is_best ?? false) ? 'checked' : '' }}>
                    {{ $isRtl ? 'الأفضل' : 'Best' }}
                </label>
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $offer->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.offers.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
