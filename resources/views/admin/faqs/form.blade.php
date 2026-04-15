@extends('layouts.admin')

@section('page_title', $faq->exists ? ($isRtl ? 'تعديل سؤال' : 'Edit FAQ') : ($isRtl ? 'إضافة سؤال' : 'Add FAQ'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
        @csrf
        @if($faq->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'التصنيف' : 'Category' }}</label>
                <input type="text" name="category" value="{{ old('category', $faq->category) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $faq->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}>
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
                    <label>السؤال (عربي) *</label>
                    <input type="text" name="question_ar" value="{{ old('question_ar', $faq->getTranslations('question')['ar'] ?? '') }}" required>
                    @error('question_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="form-field">
                    <label>الإجابة (عربي)</label>
                    <textarea name="answer_ar" style="min-height:200px;">{{ old('answer_ar', $faq->getTranslations('answer')['ar'] ?? '') }}</textarea>
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field" style="margin-bottom:1rem;">
                    <label>Question (English)</label>
                    <input type="text" name="question_en" value="{{ old('question_en', $faq->getTranslations('question')['en'] ?? '') }}">
                </div>
                <div class="form-field">
                    <label>Answer (English)</label>
                    <textarea name="answer_en" style="min-height:200px;">{{ old('answer_en', $faq->getTranslations('answer')['en'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
