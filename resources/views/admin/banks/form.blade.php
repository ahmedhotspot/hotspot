@extends('layouts.admin')

@section('page_title', $bank->exists ? ($isRtl ? 'تعديل بنك' : 'Edit Bank') : ($isRtl ? 'إضافة بنك' : 'Add Bank'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $bank->exists ? route('admin.banks.update', $bank) : route('admin.banks.store') }}" enctype="multipart/form-data">
        @csrf
        @if($bank->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الرابط (Slug)' : 'Slug' }} *</label>
                <input type="text" name="slug" value="{{ old('slug', $bank->slug) }}" required>
                @error('slug')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $bank->order ?? 0) }}">
            </div>
        </div>

        <div class="lang-group" style="margin-bottom:1rem;">
            <div class="lang-tabs">
                <button type="button" class="lang-tab active" data-lang="ar">العربية</button>
                <button type="button" class="lang-tab" data-lang="en">English</button>
            </div>
            <div class="lang-pane active" data-lang="ar">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>الاسم (عربي) *</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $bank->getTranslations('name')['ar'] ?? '') }}" required>
                    @error('name_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>الوصف (عربي)</label>
                    <textarea name="description_ar">{{ old('description_ar', $bank->getTranslations('description')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Name (English)</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $bank->getTranslations('name')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Description (English)</label>
                    <textarea name="description_en">{{ old('description_en', $bank->getTranslations('description')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الشعار' : 'Logo' }}</label>
                @if($bank->logo)
                    <div style="margin-bottom:.5rem;"><img src="{{ asset($bank->logo) }}" style="height:60px;background:#f9fafb;padding:8px;border-radius:6px;"></div>
                @endif
                <input type="file" name="logo" accept="image/*">
                @error('logo')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bank->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.banks.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
