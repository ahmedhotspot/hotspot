@extends('layouts.admin')

@section('page_title', $isRtl ? 'آراء العملاء' : 'Testimonials')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الآراء' : 'Testimonials List' }}</h2>
        <a href="{{ route('admin.testimonials.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة رأي' : 'Add Testimonial' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th></th>
            <th>{{ $isRtl ? 'الاسم' : 'Name' }}</th>
            <th>{{ $isRtl ? 'المدينة' : 'City' }}</th>
            <th>{{ $isRtl ? 'النجوم' : 'Stars' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($testimonials as $t)
            <tr>
                <td>
                    @if($t->avatar)
                        <img src="{{ asset($t->avatar) }}" style="width:42px;height:42px;border-radius:50%;object-fit:cover;">
                    @else
                        <div style="width:42px;height:42px;border-radius:50%;background:#e5e7eb;display:grid;place-items:center;font-weight:700;">{{ $t->initial }}</div>
                    @endif
                </td>
                <td><strong>{{ $t->name }}</strong></td>
                <td>{{ $t->city }}</td>
                <td>{{ $t->stars }}</td>
                <td>
                    @if($t->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد آراء بعد' : 'No testimonials yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $testimonials->links() }}</div>
</div>
@endsection
