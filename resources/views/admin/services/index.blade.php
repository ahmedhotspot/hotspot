@extends('layouts.admin')

@section('page_title', $isRtl ? 'الخدمات' : 'Services')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الخدمات' : 'Services List' }}</h2>
        <a href="{{ route('admin.services.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة خدمة' : 'Add Service' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'الأيقونة' : 'Icon' }}</th>
            <th>{{ $isRtl ? 'العنوان' : 'Title' }}</th>
            <th>{{ $isRtl ? 'الرابط' : 'Slug' }}</th>
            <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($services as $service)
            <tr>
                <td>
                    @if($service->icon)
                        <i class="fa-solid {{ $service->icon }}" style="font-size:1.25rem;color:#0d6efd;"></i>
                    @endif
                </td>
                <td><strong>{{ $service->title }}</strong></td>
                <td><code>{{ $service->slug }}</code></td>
                <td>{{ $service->order }}</td>
                <td>
                    @if($service->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد خدمات بعد' : 'No services yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $services->links() }}</div>
</div>
@endsection
