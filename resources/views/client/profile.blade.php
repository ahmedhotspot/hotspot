@extends('layouts.client')

@section('page_title', $isRtl ? 'بياناتي الشخصية' : 'My Profile')

@section('content')
    <div class="client-card" style="max-width: 640px;">
        <div class="card-head">
            <h2>{{ $isRtl ? 'تعديل البيانات الشخصية' : 'Edit Profile' }}</h2>
        </div>

        <form method="POST" action="{{ route('client.profile.update') }}">
            @csrf

            <div class="form-row full">
                <div class="form-field">
                    <label for="name">{{ $isRtl ? 'الاسم الكامل' : 'Full Name' }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="err">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row full">
                <div class="form-field">
                    <label>{{ $isRtl ? 'البريد الإلكتروني' : 'Email' }}</label>
                    <input type="email" value="{{ $user->email }}" disabled>
                    <div style="color:#6b7280; font-size:.8rem; margin-top:.3rem;">
                        {{ $isRtl ? 'لا يمكن تغيير البريد الإلكتروني.' : 'Email cannot be changed.' }}
                    </div>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-field">
                    <label for="phone">{{ $isRtl ? 'رقم الجوال' : 'Phone' }}</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="05xxxxxxxx">
                    @error('phone')<div class="err">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn-c btn-c-primary">
                <i class="fa-solid fa-save"></i>
                {{ $isRtl ? 'حفظ التغييرات' : 'Save Changes' }}
            </button>
        </form>
    </div>
@endsection
