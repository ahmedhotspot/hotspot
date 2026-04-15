@extends('layouts.admin')

@section('page_title', $isRtl ? 'القوائم' : 'Menus')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'عناصر القوائم' : 'Menu Items' }}</h2>
        <a href="{{ route('admin.menus.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة عنصر' : 'Add Item' }}
        </a>
    </div>

    @php $grouped = $items->getCollection()->groupBy('location'); @endphp

    @foreach($locations as $loc)
        <h3 style="margin-top:1.5rem;text-transform:capitalize;">{{ str_replace('_',' ',$loc) }}</h3>
        <table class="admin-table">
            <thead>
            <tr>
                <th>{{ $isRtl ? 'التسمية' : 'Label' }}</th>
                <th>URL</th>
                <th>{{ $isRtl ? 'الأصل' : 'Parent' }}</th>
                <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
                <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($grouped[$loc] ?? [] as $item)
                <tr>
                    <td>@if($item->icon)<i class="fa-solid {{ $item->icon }}"></i>@endif <strong>{{ $item->label }}</strong></td>
                    <td><code>{{ $item->url }}</code></td>
                    <td>{{ $item->parent?->label }}</td>
                    <td>{{ $item->order }}</td>
                    <td>
                        @if($item->is_active)
                            <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                        @else
                            <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.menus.edit', $item) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.menus.destroy', $item) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                            @csrf @method('DELETE')
                            <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:1rem;">{{ $isRtl ? 'لا توجد عناصر' : 'No items' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    @endforeach
    <div style="margin-top:1rem;">{{ $items->links() }}</div>
</div>
@endsection
