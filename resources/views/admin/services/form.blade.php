@extends('layouts.admin')

@section('page_title', $service->exists ? ($isRtl ? 'تعديل خدمة' : 'Edit Service') : ($isRtl ? 'إضافة خدمة' : 'Add Service'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf
        @if($service->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الرابط (Slug)' : 'Slug' }} *</label>
                <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" required>
                @error('slug')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $service->order ?? 0) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'أيقونة (FontAwesome)' : 'Icon (FontAwesome)' }}</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="fa-car">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'Icon Class' : 'Icon Class' }}</label>
                <input type="text" name="icon_class" value="{{ old('icon_class', $service->icon_class) }}">
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
                    <input type="text" name="title_ar" value="{{ old('title_ar', $service->getTranslations('title')['ar'] ?? '') }}" required>
                    @error('title_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>الوصف (عربي)</label>
                    <textarea name="description_ar">{{ old('description_ar', $service->getTranslations('description')['ar'] ?? '') }}</textarea>
                </div>
                <div class="form-field">
                    <label>الوصف المطوّل (عربي)</label>
                    <textarea name="long_description_ar" style="min-height:200px;">{{ old('long_description_ar', $service->getTranslations('long_description')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $service->getTranslations('title')['en'] ?? '') }}">
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Description (English)</label>
                    <textarea name="description_en">{{ old('description_en', $service->getTranslations('description')['en'] ?? '') }}</textarea>
                </div>
                <div class="form-field">
                    <label>Long Description (English)</label>
                    <textarea name="long_description_en" style="min-height:200px;">{{ old('long_description_en', $service->getTranslations('long_description')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الصورة' : 'Image' }}</label>
                @if($service->image)
                    <div style="margin-bottom:.5rem;"><img src="{{ asset($service->image) }}" style="height:60px;background:#f9fafb;padding:8px;border-radius:6px;"></div>
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.services.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
