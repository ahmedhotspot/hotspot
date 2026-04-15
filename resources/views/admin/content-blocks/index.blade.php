@extends('layouts.admin')

@section('page_title', $isRtl ? 'محتوى الصفحات' : 'Page Content Blocks')

@section('content')
<div class="admin-card" style="margin-bottom:1rem;">
    <div class="card-head">
        <h2>{{ $isRtl ? 'اختر الصفحة' : 'Select Page' }}</h2>
        <a href="{{ route('admin.content-blocks.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة كتلة محتوى' : 'Add Content Block' }}
        </a>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
        @foreach($pages as $p)
            <a href="{{ route('admin.content-blocks.index', ['page' => $p]) }}"
               class="btn-admin {{ $p === $currentPage ? 'btn-admin-primary' : 'btn-admin-outline' }} btn-admin-sm">
                {{ ucfirst($p) }}
            </a>
        @endforeach
    </div>
</div>

@if($currentPage)
<form method="POST" action="{{ route('admin.content-blocks.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="page" value="{{ $currentPage }}">

    @foreach($blocks as $section => $sectionBlocks)
        <div class="admin-card">
            <div class="card-head">
                <h2><i class="fa-solid fa-layer-group"></i> {{ $section ?: ($isRtl ? 'عام' : 'General') }}</h2>
            </div>
            @foreach($sectionBlocks as $b)
                <div style="padding:.75rem;background:#f9fafb;border-radius:8px;margin-bottom:.75rem;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
                        <div>
                            <strong style="font-size:.9rem;">{{ $b->label ?? $b->key }}</strong>
                            <code style="margin-{{ $isRtl ? 'right' : 'left' }}:.5rem;font-size:.75rem;color:#6b7280;">{{ $b->page }}.{{ $b->section }}.{{ $b->key }}</code>
                            <span class="badge-pill badge-muted" style="margin-{{ $isRtl ? 'right' : 'left' }}:.5rem;">{{ $b->type }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.content-blocks.destroy', $b) }}" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')" style="margin:0;">
                            @csrf @method('DELETE')
                            <button class="btn-admin btn-admin-danger btn-admin-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>

                    @if($b->type === 'image')
                        @if(($b->value['path'] ?? null))
                            <img src="{{ asset($b->value['path']) }}" style="max-height:80px;border-radius:6px;margin-bottom:.5rem;background:#fff;padding:4px;">
                        @endif
                        <input type="file" name="image[{{ $b->id }}]" accept="image/*">
                    @elseif($b->type === 'html')
                        <div class="form-row">
                            <div class="form-field">
                                <label>عربي</label>
                                <textarea name="blocks[{{ $b->id }}][ar]" style="min-height:120px;">{{ $b->value['ar'] ?? '' }}</textarea>
                            </div>
                            <div class="form-field">
                                <label>English</label>
                                <textarea name="blocks[{{ $b->id }}][en]" style="min-height:120px;">{{ $b->value['en'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @else
                        <div class="form-row">
                            <div class="form-field">
                                <label>عربي</label>
                                <input type="text" name="blocks[{{ $b->id }}][ar]" value="{{ $b->value['ar'] ?? '' }}">
                            </div>
                            <div class="form-field">
                                <label>English</label>
                                <input type="text" name="blocks[{{ $b->id }}][en]" value="{{ $b->value['en'] ?? '' }}">
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach

    <div style="position:sticky;bottom:0;padding:1rem;background:white;border-top:1px solid var(--admin-border);margin-top:1rem;">
        <button type="submit" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-save"></i> {{ $isRtl ? 'حفظ كل التغييرات' : 'Save All Changes' }}
        </button>
    </div>
</form>
@else
    <div class="admin-card">
        <p style="color:#9ca3af;text-align:center;padding:2rem;">
            {{ $isRtl ? 'لا توجد كتل محتوى بعد. اضغط "إضافة كتلة محتوى" للبدء.' : 'No content blocks yet. Click "Add Content Block" to start.' }}
        </p>
    </div>
@endif
@endsection
