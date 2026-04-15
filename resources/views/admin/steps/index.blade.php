@extends('layouts.admin')

@section('page_title', $isRtl ? 'كيف تعمل الخطوات' : 'How It Works Steps')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الخطوات' : 'Steps List' }}</h2>
        <a href="{{ route('admin.steps.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة خطوة' : 'Add Step' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'الأيقونة' : 'Icon' }}</th>
            <th>{{ $isRtl ? 'العنوان' : 'Title' }}</th>
            <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($steps as $step)
            <tr>
                <td>@if($step->icon)<i class="fa-solid {{ $step->icon }}" style="font-size:1.25rem;color:#0d6efd;"></i>@endif</td>
                <td><strong>{{ $step->title }}</strong></td>
                <td>{{ $step->order }}</td>
                <td>
                    @if($step->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.steps.edit', $step) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.steps.destroy', $step) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد خطوات بعد' : 'No steps yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $steps->links() }}</div>
</div>
@endsection
