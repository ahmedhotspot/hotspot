@extends('layouts.admin')

@section('page_title', $item->exists ? ($isRtl ? 'تعديل عنصر' : 'Edit Item') : ($isRtl ? 'إضافة عنصر' : 'Add Item'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $item->exists ? route('admin.menus.update', $item) : route('admin.menus.store') }}">
        @csrf
        @if($item->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الموقع' : 'Location' }} *</label>
                <select name="location" required>
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ old('location', $item->location) === $loc ? 'selected' : '' }}>{{ str_replace('_',' ',$loc) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الأصل' : 'Parent' }}</label>
                <select name="parent_id">
                    <option value="">-- {{ $isRtl ? 'لا يوجد' : 'None' }} --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $item->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="lang-group" style="margin-bottom:1rem;">
            <div class="lang-tabs">
                <button type="button" class="lang-tab active" data-lang="ar">العربية</button>
                <button type="button" class="lang-tab" data-lang="en">English</button>
            </div>
            <div class="lang-pane active" data-lang="ar">
                <div class="form-field">
                    <label>التسمية (عربي) *</label>
                    <input type="text" name="label_ar" value="{{ old('label_ar', $item->getTranslations('label')['ar'] ?? '') }}" required>
                    @error('label_ar')<div class="err">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="lang-pane" data-lang="en">
                <div class="form-field">
                    <label>Label (English)</label>
                    <input type="text" name="label_en" value="{{ old('label_en', $item->getTranslations('label')['en'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>URL</label>
                <input type="text" name="url" value="{{ old('url', $item->url) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الهدف' : 'Target' }}</label>
                <select name="target">
                    <option value="_self" {{ old('target', $item->target) === '_self' ? 'selected' : '' }}>_self</option>
                    <option value="_blank" {{ old('target', $item->target) === '_blank' ? 'selected' : '' }}>_blank</option>
                </select>
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'أيقونة' : 'Icon' }}</label>
                <input type="text" name="icon" value="{{ old('icon', $item->icon) }}" placeholder="fa-home">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $item->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.menus.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
