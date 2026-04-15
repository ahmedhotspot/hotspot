@extends('layouts.admin')

@section('page_title', $page->exists ? ($isRtl ? 'تعديل صفحة' : 'Edit Page') : ($isRtl ? 'إضافة صفحة' : 'Add Page'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" enctype="multipart/form-data">
        @csrf
        @if($page->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الرابط (Slug)' : 'Slug' }} *</label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required>
                @error('slug')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published ?? false) ? 'checked' : '' }}>
                    {{ $isRtl ? 'منشور' : 'Published' }}
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
                    <input type="text" name="title_ar" value="{{ old('title_ar', $page->getTranslations('title')['ar'] ?? '') }}" required>
                    @error('title_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>المحتوى (عربي)</label>
                    <textarea name="content_ar" style="min-height:250px;">{{ old('content_ar', $page->getTranslations('content')['ar'] ?? '') }}</textarea>
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Meta Title (عربي)</label>
                    <input type="text" name="meta_title_ar" value="{{ old('meta_title_ar', $page->getTranslations('meta_title')['ar'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Meta Description (عربي)</label>
                    <textarea name="meta_description_ar">{{ old('meta_description_ar', $page->getTranslations('meta_description')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $page->getTranslations('title')['en'] ?? '') }}">
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Content (English)</label>
                    <textarea name="content_en" style="min-height:250px;">{{ old('content_en', $page->getTranslations('content')['en'] ?? '') }}</textarea>
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Meta Title (English)</label>
                    <input type="text" name="meta_title_en" value="{{ old('meta_title_en', $page->getTranslations('meta_title')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Meta Description (English)</label>
                    <textarea name="meta_description_en">{{ old('meta_description_en', $page->getTranslations('meta_description')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الصورة' : 'Image' }}</label>
                @if($page->image)
                    <div style="margin-bottom:.5rem;"><img src="{{ asset($page->image) }}" style="height:60px;background:#f9fafb;padding:8px;border-radius:6px;"></div>
                @endif
                <input type="file" name="image" accept="image/*">
                @error('image')<div class="err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.pages.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
