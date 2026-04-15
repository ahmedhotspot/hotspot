@extends('layouts.admin')

@section('page_title', $isRtl ? 'إضافة كتلة محتوى' : 'Add Content Block')

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ route('admin.content-blocks.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الصفحة' : 'Page' }} *</label>
                <input type="text" name="page" value="{{ old('page') }}" placeholder="about, home, contact..." required>
                @error('page')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'القسم' : 'Section' }}</label>
                <input type="text" name="section" value="{{ old('section') }}" placeholder="hero, vision, mission...">
            </div>
        </div>
        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'المفتاح' : 'Key' }} *</label>
                <input type="text" name="key" value="{{ old('key') }}" placeholder="title, text, badge..." required>
                @error('key')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'النوع' : 'Type' }} *</label>
                <select name="type">
                    <option value="text">{{ $isRtl ? 'نص قصير' : 'Text' }}</option>
                    <option value="html">{{ $isRtl ? 'HTML / نص طويل' : 'HTML / Long Text' }}</option>
                    <option value="image">{{ $isRtl ? 'صورة' : 'Image' }}</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'التسمية للأدمن' : 'Admin Label' }}</label>
                <input type="text" name="label" value="{{ old('label') }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الترتيب' : 'Order' }}</label>
                <input type="number" name="order" value="{{ old('order', 0) }}">
            </div>
        </div>
        <div style="display:flex;gap:.5rem;margin-top:1rem;">
            <button type="submit" class="btn-admin btn-admin-primary"><i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}</button>
            <a href="{{ route('admin.content-blocks.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
