@extends('layouts.admin')

@section('page_title', $link->exists ? ($isRtl ? 'تعديل رابط' : 'Edit Link') : ($isRtl ? 'إضافة رابط' : 'Add Link'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $link->exists ? route('admin.social.update', $link) : route('admin.social.store') }}">
        @csrf
        @if($link->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'المنصة' : 'Platform' }}</label>
                <input type="text" name="platform" value="{{ old('platform', $link->platform) }}" placeholder="Twitter, Facebook...">
            </div>
            <div class="form-field">
                <label>URL *</label>
                <input type="url" name="url" value="{{ old('url', $link->url) }}" required>
                @error('url')<div class="err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'أيقونة (FontAwesome Brand)' : 'Icon (FontAwesome Brand)' }}</label>
                <input type="text" name="icon" value="{{ old('icon', $link->icon) }}" placeholder="fa-twitter">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', $link->order ?? 0) }}">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $link->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.social.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
