@extends('layouts.admin')

@section('page_title', $isRtl ? 'مكتبة الوسائط' : 'Media Library')

@section('content')
<div class="admin-card">
    <h2>{{ $isRtl ? 'رفع ملفات' : 'Upload Files' }}</h2>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-field">
                <label>{{ $isRtl ? 'اختر الملفات' : 'Choose Files' }}</label>
                <input type="file" name="files[]" multiple required>
            </div>
            <div class="form-field" style="display:flex;align-items:flex-end;">
                <button type="submit" class="btn-admin btn-admin-primary">
                    <i class="fa-solid fa-upload"></i> {{ $isRtl ? 'رفع' : 'Upload' }}
                </button>
            </div>
        </div>
    </form>
</div>

<div class="admin-card" style="margin-top:1rem;">
    <h2>{{ $isRtl ? 'الملفات' : 'Files' }}</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(180px, 1fr));gap:1rem;margin-top:1rem;">
        @forelse($media as $file)
            <div style="border:1px solid #e6e9f0;border-radius:8px;overflow:hidden;background:#fff;">
                <div style="aspect-ratio:1;background:#f9fafb;display:grid;place-items:center;overflow:hidden;">
                    @if(str_starts_with($file->mime_type ?? '', 'image/'))
                        <img src="{{ $file->url }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <i class="fa-solid fa-file" style="font-size:2.5rem;color:#9ca3af;"></i>
                    @endif
                </div>
                <div style="padding:.5rem;font-size:.8rem;">
                    <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $file->original_name }}">{{ $file->original_name }}</div>
                    <div style="color:#6b7280;">{{ number_format(($file->size ?? 0) / 1024, 1) }} KB</div>
                    <div style="display:flex;gap:.25rem;margin-top:.5rem;">
                        <a href="{{ $file->url }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fa-solid fa-eye"></i></a>
                        <form method="POST" action="{{ route('admin.media.destroy', $file) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                            @csrf @method('DELETE')
                            <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد ملفات' : 'No files uploaded' }}</div>
        @endforelse
    </div>
    <div style="margin-top:1rem;">{{ $media->links() }}</div>
</div>
@endsection
