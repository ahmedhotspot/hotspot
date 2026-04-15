@extends('layouts.admin')

@section('page_title', $article->exists ? ($isRtl ? 'تعديل مقال' : 'Edit Article') : ($isRtl ? 'إضافة مقال' : 'Add Article'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf
        @if($article->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الرابط (Slug)' : 'Slug' }} *</label>
                <input type="text" name="slug" value="{{ old('slug', $article->slug) }}" required>
                @error('slug')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الكاتب' : 'Author' }}</label>
                <select name="author_id">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('author_id', $article->author_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'تاريخ النشر' : 'Published At' }}</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $article->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                    {{ $isRtl ? 'مميز' : 'Featured' }}
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
                    <input type="text" name="title_ar" value="{{ old('title_ar', $article->getTranslations('title')['ar'] ?? '') }}" required>
                    @error('title_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>التصنيف (عربي)</label>
                    <input type="text" name="category_ar" value="{{ old('category_ar', $article->getTranslations('category')['ar'] ?? '') }}">
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>المقتطف (عربي)</label>
                    <textarea name="excerpt_ar">{{ old('excerpt_ar', $article->getTranslations('excerpt')['ar'] ?? '') }}</textarea>
                </div>
                <div class="form-field">
                    <label>المحتوى (عربي)</label>
                    <textarea name="content_ar" style="min-height:300px;">{{ old('content_ar', $article->getTranslations('content')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $article->getTranslations('title')['en'] ?? '') }}">
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Category (English)</label>
                    <input type="text" name="category_en" value="{{ old('category_en', $article->getTranslations('category')['en'] ?? '') }}">
                </div>
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Excerpt (English)</label>
                    <textarea name="excerpt_en">{{ old('excerpt_en', $article->getTranslations('excerpt')['en'] ?? '') }}</textarea>
                </div>
                <div class="form-field">
                    <label>Content (English)</label>
                    <textarea name="content_en" style="min-height:300px;">{{ old('content_en', $article->getTranslations('content')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الصورة' : 'Image' }}</label>
                @if($article->image)
                    <div style="margin-bottom:.5rem;"><img src="{{ asset($article->image) }}" style="height:80px;background:#f9fafb;padding:8px;border-radius:6px;"></div>
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
