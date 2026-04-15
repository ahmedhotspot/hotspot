@extends('layouts.admin')

@section('page_title', $isRtl ? 'الصفحات' : 'Pages')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الصفحات' : 'Pages List' }}</h2>
        <a href="{{ route('admin.pages.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة صفحة' : 'Add Page' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'العنوان' : 'Title' }}</th>
            <th>{{ $isRtl ? 'الرابط' : 'Slug' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td><strong>{{ $page->title }}</strong></td>
                <td><code>{{ $page->slug }}</code></td>
                <td>
                    @if($page->is_published)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'منشور' : 'Published' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'مسودة' : 'Draft' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد صفحات بعد' : 'No pages yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $pages->links() }}</div>
</div>
@endsection
