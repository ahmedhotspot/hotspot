@extends('layouts.admin')

@section('page_title', $isRtl ? 'الأسئلة الشائعة' : 'FAQs')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة الأسئلة' : 'FAQs List' }}</h2>
        <a href="{{ route('admin.faqs.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة سؤال' : 'Add FAQ' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'التصنيف' : 'Category' }}</th>
            <th>{{ $isRtl ? 'السؤال' : 'Question' }}</th>
            <th>{{ $isRtl ? 'الترتيب' : 'Order' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($faqs as $faq)
            <tr>
                <td>{{ $faq->category }}</td>
                <td><strong>{{ $faq->question }}</strong></td>
                <td>{{ $faq->order }}</td>
                <td>
                    @if($faq->is_active)
                        <span class="badge-pill badge-success">{{ $isRtl ? 'نشط' : 'Active' }}</span>
                    @else
                        <span class="badge-pill badge-muted">{{ $isRtl ? 'معطل' : 'Inactive' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد أسئلة بعد' : 'No FAQs yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $faqs->links() }}</div>
</div>
@endsection
