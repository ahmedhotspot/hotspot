@extends('layouts.app')

@section('title', block('faq.hero.title_meta', $isRtl ? 'الأسئلة الشائعة' : 'FAQ'))

@section('content')
<section class="page-header">
    <div class="container">
        <span class="badge badge-primary mb-3">{{ block('faq.hero.badge', $isRtl ? 'الأسئلة الشائعة' : 'FAQ') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">
            {{ $page?->title ?? block('faq.hero.title', $isRtl ? 'الأسئلة الشائعة' : 'Frequently Asked Questions') }}
        </h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('faq.hero.subtitle', $isRtl
                ? 'إجابات على أكثر الأسئلة شيوعًا حول منصتنا لمقارنة التمويل.'
                : 'Find answers to common questions about our financing comparison platform and how we can help you.') }}
        </p>
    </div>
</section>

<section class="faq-section section">
    <div class="container">
        @forelse($faqs ?? [] as $category => $items)
            <div class="faq-category">
                <div class="faq-category-header">
                    <span class="material-symbols-outlined">help</span>
                    <h2>{{ $category ?: block('common.labels.general', $isRtl ? 'عام' : 'General') }}</h2>
                </div>

                <div class="faq-list">
                    @foreach($items as $faq)
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>{{ $faq->question }}</span>
                                <i class="fa-solid fa-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-answer">
                                <div>{!! $faq->answer !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center" style="padding: 3rem 0;">
                <p class="text-muted">
                    {{ block('faq.list.empty', $isRtl ? 'لا توجد أسئلة متاحة حاليًا.' : 'No FAQs available at the moment.') }}
                </p>
            </div>
        @endforelse

        <div class="faq-cta">
            <h3>{{ block('faq.cta.title', $isRtl ? 'لا تزال لديك أسئلة؟' : 'Still have questions?') }}</h3>
            <p class="text-muted">
                {{ block('faq.cta.subtitle', $isRtl ? 'لم تجد ما تبحث عنه؟ فريقنا هنا لمساعدتك.' : "Can't find what you're looking for? Our team is here to help.") }}
            </p>
            <a href="{{ url('/contact') }}" class="btn btn-primary">{{ block('faq.cta.button', $isRtl ? 'اتصل بنا' : 'Contact Us') }}</a>
        </div>
    </div>
</section>
@endsection
