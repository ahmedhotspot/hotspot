@extends('layouts.admin')

@section('page_title', $isRtl ? 'مقاييس الثقة' : 'Trust Metrics')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة المقاييس' : 'Trust Metrics List' }}</h2>
        <a href="{{ route('admin.trust-metrics.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة مقياس' : 'Add Metric' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'القيمة' : 'Value' }}</th>
            <th>{{ $isRtl ? 'التسمية' : 'Label' }}</th>
            <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($metrics as $metric)
            <tr>
                <td><strong>{{ $metric->value }}</strong></td>
                <td>{{ $metric->label }}</td>
                <td>{{ $metric->order }}</td>
                <td>
                    @if($metric->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.trust-metrics.edit', $metric) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.trust-metrics.destroy', $metric) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد مقاييس بعد' : 'No metrics yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $metrics->links() }}</div>
</div>
@endsection
