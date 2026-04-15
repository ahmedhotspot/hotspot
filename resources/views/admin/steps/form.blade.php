@extends('layouts.admin')

@section('page_title', $step->exists ? ($isRtl ? 'تعديل خطوة' : 'Edit Step') : ($isRtl ? 'إضافة خطوة' : 'Add Step'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $step->exists ? route('admin.steps.update', $step) : route('admin.steps.store') }}">
        @csrf
        @if($step->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'أيقونة (FontAwesome)' : 'Icon (FontAwesome)' }}</label>
                <input type="text" name="icon" value="{{ old('icon', $step->icon) }}" placeholder="fa-file-signature">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $step->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $step->is_active ?? true) ? 'checked' : '' }}>
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
                    <label>العنوان (عربي) *</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $step->getTranslations('title')['ar'] ?? '') }}" required>
                    @error('title_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>الوصف (عربي)</label>
                    <textarea name="description_ar">{{ old('description_ar', $step->getTranslations('description')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $step->getTranslations('title')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Description (English)</label>
                    <textarea name="description_en">{{ old('description_en', $step->getTranslations('description')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.steps.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
