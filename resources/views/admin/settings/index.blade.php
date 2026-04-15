@extends('layouts.admin')

@section('page_title', $isRtl ? 'الإعدادات' : 'Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    @foreach($groups as $groupName => $settings)
        <div class="admin-card" style="margin-bottom:1rem;">
            <h2 style="text-transform:capitalize;">{{ str_replace('_',' ',$groupName) }}</h2>

            @foreach($settings as $setting)
                @php
                    $key = $setting->key;
                    $label = $setting->label ?: $key;
                    $value = $setting->value;
                    $decoded = is_string($value) && str_starts_with($value, '{') ? json_decode($value, true) : null;
                @endphp

                <div class="form-field" style="margin-bottom:1rem;">
                    <label><strong>{{ $label }}</strong> <small style="color:#6b7280;">({{ $key }})</small></label>

                    @if($setting->is_translatable)
                        <div class="lang-group">
                            <div class="lang-tabs">
                                <button type="button" class="lang-tab active" data-lang="ar">العربية</button>
                                <button type="button" class="lang-tab" data-lang="en">English</button>
                            </div>
                            <div class="lang-pane active" data-lang="ar">
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $key }}_ar">{{ $decoded['ar'] ?? '' }}</textarea>
                                @else
                                    <input type="text" name="{{ $key }}_ar" value="{{ $decoded['ar'] ?? '' }}">
                                @endif
                            </div>
                            <div class="lang-pane" data-lang="en">
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $key }}_en">{{ $decoded['en'] ?? '' }}</textarea>
                                @else
                                    <input type="text" name="{{ $key }}_en" value="{{ $decoded['en'] ?? '' }}">
                                @endif
                            </div>
                        </div>
                    @elseif($setting->type === 'textarea')
                        <textarea name="{{ $key }}">{{ $value }}</textarea>
                    @elseif($setting->type === 'number')
                        <input type="number" name="{{ $key }}" value="{{ $value }}">
                    @elseif($setting->type === 'email')
                        <input type="email" name="{{ $key }}" value="{{ $value }}">
                    @elseif($setting->type === 'url')
                        <input type="url" name="{{ $key }}" value="{{ $value }}">
                    @elseif($setting->type === 'boolean')
                        <label class="form-check">
                            <input type="hidden" name="{{ $key }}" value="0">
                            <input type="checkbox" name="{{ $key }}" value="1" {{ $value ? 'checked' : '' }}>
                            {{ $isRtl ? 'مفعل' : 'Enabled' }}
                        </label>
                    @elseif($setting->type === 'image')
                        @if($value)
                            <div style="margin-bottom:.5rem;"><img src="{{ asset($value) }}" style="height:60px;background:#f9fafb;padding:8px;border-radius:6px;"></div>
                        @endif
                        <input type="file" name="{{ $key }}" accept="image/*">
                    @else
                        <input type="text" name="{{ $key }}" value="{{ $value }}">
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="admin-card">
        <button type="submit" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ كل الإعدادات' : 'Save all settings' }}
        </button>
    </div>
</form>
@endsection
