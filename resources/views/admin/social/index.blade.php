@extends('layouts.admin')

@section('page_title', $isRtl ? 'روابط التواصل' : 'Social Links')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الروابط' : 'Social Links List' }}</h2>
        <a href="{{ route('admin.social.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة رابط' : 'Add Link' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'المنصة' : 'Platform' }}</th>
            <th>URL</th>
            <th>{{ $isRtl ? 'الأيقونة' : 'Icon' }}</th>
            <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($links as $link)
            <tr>
                <td><strong>{{ $link->platform }}</strong></td>
                <td><a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a></td>
                <td>@if($link->icon)<i class="fa-brands {{ $link->icon }}"></i> {{ $link->icon }}@endif</td>
                <td>{{ $link->order }}</td>
                <td>
                    @if($link->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.social.edit', $link) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.social.destroy', $link) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد روابط بعد' : 'No links yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $links->links() }}</div>
</div>
@endsection
