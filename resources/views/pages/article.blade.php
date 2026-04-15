@extends('layouts.app')

@section('title', $article->title)

@push('styles')
<style>
    .article-detail-hero {
        position: relative;
        height: 400px;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
    }
    .article-detail-hero img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .article-detail-hero .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.2));
    }
    .article-detail-hero .hero-content {
        position: relative;
        z-index: 2;
        padding: 3rem 0;
        color: white;
        width: 100%;
    }
    .article-detail-hero .hero-content .badge-cat {
        background: var(--primary-color);
        color: white;
        padding: 0.35rem 1rem;
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }
    .article-detail-hero .hero-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }
    .article-detail-hero .hero-content .meta {
        display: flex;
        gap: 1.5rem;
        font-size: 0.9rem;
        opacity: 0.85;
    }
    .article-body { padding: 4rem 0; }
    .article-body .content-wrapper { max-width: 800px; margin: 0 auto; }
</style>
@endpush

@section('content')
<section class="article-detail-hero">
    @if($article->image)
        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
    @else
        <img src="{{ block('article.hero.fallback_image', 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1200&q=80') }}" alt="{{ $article->title }}">
    @endif
    <div class="overlay"></div>
    <div class="container hero-content">
        @if(!empty($article->category))
            <span class="badge-cat">{{ $article->category }}</span>
        @endif
        <h1>{{ $article->title }}</h1>
        <div class="meta">
            @if(!empty($article->author))
                <span><i class="fa-regular fa-user"></i> {{ $article->author }}</span>
            @endif
            @if($article->published_at)
                <span>
                    <i class="fa-regular fa-calendar"></i>
                    {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat($isRtl ? block('article.meta.date_format_ar', 'j F Y') : block('article.meta.date_format_en', 'F j, Y')) }}
                </span>
            @endif
        </div>
    </div>
</section>

<section class="article-body">
    <div class="container">
        <div class="content-wrapper">
            <a href="{{ url('/') }}" class="back-link">
                <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
                {{ block('article.body.back', $isRtl ? 'العودة للأدلة المالية' : 'Back to Financial Guides') }}
            </a>

            @if($article->content)
                {!! $article->content !!}
            @else
                <p class="text-muted">{{ block('article.body.empty', $isRtl ? 'لا يوجد محتوى متاح لهذا المقال.' : 'No content available for this article.') }}</p>
            @endif

            <div class="text-center mt-5">
                <a href="{{ route('apply') }}" class="btn btn-primary btn-lg">
                    {{ block('article.body.calc_cta', $isRtl ? 'جرّب حاسبة التمويل' : 'Try the Finance Calculator') }}
                    <i class="fa-solid fa-calculator"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
