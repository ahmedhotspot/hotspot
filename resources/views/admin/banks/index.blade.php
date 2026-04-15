@extends('layouts.admin')

@section('page_title', $isRtl ? 'البنوك' : 'Banks')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة البنوك' : 'Banks List' }}</h2>
        <a href="{{ route('admin.banks.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة بنك' : 'Add Bank' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'الشعار' : 'Logo' }}</th>
            <th>{{ $isRtl ? 'الاسم' : 'Name' }}</th>
            <th>{{ $isRtl ? 'الرابط' : 'Slug' }}</th>
            <th>{{ $isRtl ? 'العروض' : 'Offers' }}</th>
            <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($banks as $bank)
            <tr>
                <td>
                    @if($bank->logo)
                        <img src="{{ asset($bank->logo) }}" alt="" style="width:48px;height:48px;object-fit:contain;background:#f9fafb;border-radius:6px;padding:4px;">
                    @else
                        <div style="width:48px;height:48px;background:#f3f4f6;border-radius:6px;display:grid;place-items:center;color:#9ca3af;"><i class="fa-solid fa-building-columns"></i></div>
                    @endif
                </td>
                <td><strong>{{ $bank->name }}</strong></td>
                <td><code>{{ $bank->slug }}</code></td>
                <td>{{ $bank->offers()->count() }}</td>
                <td>{{ $bank->order }}</td>
                <td>
                    @if($bank->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.banks.edit', $bank) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.banks.destroy', $bank) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد بنوك بعد' : 'No banks yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $banks->links() }}</div>
</div>
@endsection
