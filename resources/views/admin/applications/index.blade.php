@extends('layouts.admin')

@section('page_title', $isRtl ? 'الطلبات' : 'Applications')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الطلبات' : 'Applications List' }}</h2>
        <form method="GET" style="display:flex;gap:.5rem;">
            <select name="status" onchange="this.form.submit()">
                <option value="">{{ $isRtl ? 'كل الحالات' : 'All statuses' }}</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ $currentStatus === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ $isRtl ? 'الاسم' : 'Name' }}</th>
            <th>{{ $isRtl ? 'البنك' : 'Bank' }}</th>
            <th>{{ $isRtl ? 'الخدمة' : 'Service' }}</th>
            <th>{{ $isRtl ? 'المبلغ' : 'Amount' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th>{{ $isRtl ? 'التاريخ' : 'Date' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($applications as $app)
            <tr>
                <td>{{ $app->id }}</td>
                <td><strong>{{ $app->full_name }}</strong></td>
                <td>{{ $app->bank?->name }}</td>
                <td>{{ $app->service?->title }}</td>
                <td>{{ number_format((float) $app->amount) }}</td>
                <td><span class="badge-pill">{{ $app->status }}</span></td>
                <td>{{ $app->created_at?->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.applications.show', $app) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.applications.destroy', $app) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد طلبات' : 'No applications' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $applications->links() }}</div>
</div>
@endsection
