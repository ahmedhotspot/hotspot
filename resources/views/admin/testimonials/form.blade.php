@extends('layouts.admin')

@section('page_title', $testimonial->exists ? ($isRtl ? 'تعديل رأي' : 'Edit Testimonial') : ($isRtl ? 'إضافة رأي' : 'Add Testimonial'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" enctype="multipart/form-data">
        @csrf
        @if($testimonial->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'النجوم' : 'Stars' }}</label>
                <input type="number" step="0.5" min="0" max="5" name="stars" value="{{ old('stars', $testimonial->stars ?? 5) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الحرف الأول' : 'Initial' }}</label>
                <input type="text" name="initial" maxlength="4" value="{{ old('initial', $testimonial->initial) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $testimonial->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
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
                    <label>الاسم (عربي) *</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $testimonial->getTranslations('name')['ar'] ?? '') }}" required>
                    @error('name_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>المدينة (عربي)</label>
                    <input type="text" name="city_ar" value="{{ old('city_ar', $testimonial->getTranslations('city')['ar'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>النص (عربي)</label>
                    <textarea name="text_ar">{{ old('text_ar', $testimonial->getTranslations('text')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Name (English)</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $testimonial->getTranslations('name')['en'] ?? '') }}">
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>City (English)</label>
                    <input type="text" name="city_en" value="{{ old('city_en', $testimonial->getTranslations('city')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Text (English)</label>
                    <textarea name="text_en">{{ old('text_en', $testimonial->getTranslations('text')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الصورة' : 'Avatar' }}</label>
                @if($testimonial->avatar)
                    <div style="margin-bottom:.5rem;"><img src="{{ asset($testimonial->avatar) }}" style="height:60px;border-radius:50%;"></div>
                @endif
                <input type="file" name="avatar" accept="image/*">
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
