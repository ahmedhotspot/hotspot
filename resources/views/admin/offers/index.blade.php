@extends('layouts.admin')

@section('page_title', $isRtl ? 'العروض' : 'Offers')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة العروض' : 'Offers List' }}</h2>
        <a href="{{ route('admin.offers.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة عرض' : 'Add Offer' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'البنك' : 'Bank' }}</th>
            <th>{{ $isRtl ? 'الخدمة' : 'Service' }}</th>
            <th>{{ $isRtl ? 'العنوان' : 'Title' }}</th>
            <th>APR</th>
            <th>{{ $isRtl ? 'أقصى مبلغ' : 'Max Amount' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($offers as $offer)
            <tr>
                <td>{{ $offer->bank?->name }}</td>
                <td>{{ $offer->service?->title }}</td>
                <td><strong>{{ $offer->title }}</strong></td>
                <td>{{ $offer->apr }}</td>
                <td>{{ number_format((float) $offer->max_amount) }}</td>
                <td>
                    @if($offer->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.offers.edit', $offer) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.offers.destroy', $offer) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد عروض بعد' : 'No offers yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $offers->links() }}</div>
</div>
@endsection
