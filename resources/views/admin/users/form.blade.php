@extends('layouts.admin')

@section('page_title', $user->exists ? ($isRtl ? 'تعديل مستخدم' : 'Edit User') : ($isRtl ? 'إضافة مستخدم' : 'Add User'))

@section('content')
<div class="admin-card">
    <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if($user->exists) @method('PUT') @endif

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الاسم' : 'Name' }} *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'البريد' : 'Email' }} *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'الهاتف' : 'Phone' }}</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'الدور' : 'Role' }} *</label>
                <select name="role" required>
                    @foreach(['user', 'admin', 'super_admin'] as $r)
                        <option value="{{ $r }}" {{ old('role', $user->role ?? 'user') === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'اللغة' : 'Locale' }}</label>
                <select name="locale">
                    <option value="ar" {{ old('locale', $user->locale ?? 'ar') === 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="en" {{ old('locale', $user->locale) === 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'كلمة المرور' : 'Password' }} {{ $user->exists ? '' : '*' }}</label>
                <input type="password" name="password" {{ $user->exists ? '' : 'required' }}>
                @if($user->exists)<small style="color:#6b7280;">{{ $isRtl ? 'اتركها فارغة للاحتفاظ بالحالية' : 'Leave blank to keep current' }}</small>@endif
                @error('password')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
                <label>{{ $isRtl ? 'تأكيد كلمة المرور' : 'Confirm Password' }}</label>
                <input type="password" name="password_confirmation">
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <label class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                    {{ $isRtl ? 'نشط' : 'Active' }}
                </label>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin btn-admin-primary">
                <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ' : 'Save' }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-outline">{{ $isRtl ? 'إلغاء' : 'Cancel' }}</a>
        </div>
    </form>
</div>
@endsection
