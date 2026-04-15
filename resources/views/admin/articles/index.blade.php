@extends('layouts.admin')

@section('page_title', $isRtl ? 'المقالات' : 'Articles')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'قائمة المقالات' : 'Articles List' }}</h2>
        <a href="{{ route('admin.articles.create') }}" class="btn-admin btn-admin-primary">
            <i class="fa-solid fa-plus"></i> {{ $isRtl ? 'إضافة مقال' : 'Add Article' }}
        </a>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'العنوان' : 'Title' }}</th>
            <th>{{ $isRtl ? 'التصنيف' : 'Category' }}</th>
            <th>{{ $isRtl ? 'تاريخ النشر' : 'Published At' }}</th>
            <th>{{ $isRtl ? 'مميز' : 'Featured' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($articles as $article)
            <tr>
                <td><strong>{{ $article->title }}</strong></td>
                <td>{{ $article->category }}</td>
                <td>{{ $article->published_at?->format('Y-m-d H:i') }}</td>
                <td>
                    @if($article->is_featured)
                        <span class="badge-pill badge-success"><i class="fa-solid fa-star"></i></span>
                    @else
                        <span class="badge-pill badge-muted">-</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد مقالات بعد' : 'No articles yet' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $articles->links() }}</div>
</div>
@endsection
