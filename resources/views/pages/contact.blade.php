@extends('layouts.app')

@section('title', block('contact.hero.title_meta', $isRtl ? 'اتصل بنا' : 'Contact Us'))

@section('content')
<section class="page-header">
    <div class="container">
        <span class="badge badge-primary mb-3">{{ block('contact.hero.badge', $isRtl ? 'تواصل معنا' : 'Contact Us') }}</span>
        <h1 class="font-weight-bold" style="font-size: 3rem;">
            {{ $page?->title ?? block('contact.hero.title', $isRtl ? 'نحن هنا لمساعدتك' : "We're Here to Help") }}
        </h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            {{ block('contact.hero.subtitle', $isRtl
                ? 'نقدّر ملاحظاتك. تواصل معنا وأخبرنا كيف يمكننا خدمتك بشكل أفضل.'
                : "We value your feedback. Get in touch and let us know how we can serve you better.") }}
        </p>
    </div>
</section>

<section class="contact-section section">
    <div class="container contact-container">
        <div class="contact-card" data-aos="fade-up">
            <div class="contact-sidebar">
                <div class="contact-info-list">
                    <div class="contact-info-item">
                        <div class="icon-box"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="contact-info-content">
                            <h4>{{ block('contact.info.visit_title', $isRtl ? 'زر مقرّنا' : 'Visit Our Studio') }}</h4>
                            <p>{{ $siteSettings->get($isRtl ? 'contact_address_ar' : 'contact_address_en', block('contact.info.address_default', $isRtl ? 'هوت سبوت للتسويق الرقمي، 2493 حي الصالحي 7326، الرياض، السعودية' : 'Hotspot Digital Marketplace LLC, 2493 Al Salhi Dist. 7326, Riyadh, SA')) }}</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="icon-box"><i class="fa-solid fa-phone"></i></div>
                        <div class="contact-info-content">
                            <h4>{{ block('contact.info.call_title', $isRtl ? 'اتصل بنا' : 'Call Us') }}</h4>
                            <p>{{ $siteSettings->get('contact_phone', '+966 800 245 0071') }}</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="icon-box"><i class="fa-solid fa-envelope"></i></div>
                        <div class="contact-info-content">
                            <h4>{{ block('contact.info.email_title', $isRtl ? 'راسلنا' : 'Email Us') }}</h4>
                            <p>{{ $siteSettings->get('contact_email', 'customercare@hotspot.sa') }}</p>
                        </div>
                    </div>
                </div>

                <div class="contact-map-preview">
                    <iframe src="https://maps.google.com/maps?q=24.7895597,46.7357167&hl={{ $currentLocale }}&z=15&output=embed" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

                <div class="contact-socials">
                    @foreach($socialLinks ?? [] as $social)
                        <a href="{{ $social->url ?? '#' }}"><i class="{{ $social->icon ?? 'fa-brands fa-link' }}"></i></a>
                    @endforeach
                </div>
            </div>

            <div class="contact-body">
                <div class="contact-form-title">
                    <h3 class="h4 font-weight-bold mb-1">{{ block('contact.form.title', $isRtl ? 'أرسل لنا رسالة' : 'Send us a Message') }}</h3>
                    <p class="text-muted small">{{ block('contact.form.subtitle', $isRtl ? 'سنرد عليك خلال 24 ساعة.' : "We'll get back to you within 24 hours.") }}</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <form action="{{ url('/contact') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="contact-form-grid">
                        <div class="input-group">
                            <label for="name">{{ block('contact.form.name_label', $isRtl ? 'الاسم الكامل' : 'Your Full Name') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="modern-input" placeholder="{{ block('contact.form.name_placeholder', $isRtl ? 'مثال: محمد أحمد' : 'E.g. Julian Thorne') }}" required>
                        </div>
                        <div class="input-group">
                            <label for="email">{{ block('contact.form.email_label', $isRtl ? 'البريد الإلكتروني' : 'Email Address') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="modern-input" placeholder="name@example.com" required>
                        </div>
                        <div class="input-group full-width">
                            <label for="inquiry">{{ block('contact.form.inquiry_label', $isRtl ? 'نوع الاستفسار' : 'Inquiry Type') }}</label>
                            <select id="inquiry" name="inquiry" class="modern-input">
                                <option value="general">{{ block('contact.form.inquiry_general', $isRtl ? 'استفسار عام' : 'General Inquiry') }}</option>
                                <option value="personal">{{ block('contact.form.inquiry_personal', $isRtl ? 'تمويل شخصي' : 'Personal Finance') }}</option>
                                <option value="auto">{{ block('contact.form.inquiry_auto', $isRtl ? 'تمويل سيارات' : 'Auto Finance') }}</option>
                                <option value="mortgage">{{ block('contact.form.inquiry_mortgage', $isRtl ? 'تمويل عقاري' : 'Mortgage') }}</option>
                                <option value="sme">{{ block('contact.form.inquiry_sme', $isRtl ? 'تمويل الأعمال' : 'Business/SME Finance') }}</option>
                            </select>
                        </div>
                        <div class="input-group full-width">
                            <label for="message">{{ block('contact.form.message_label', $isRtl ? 'رسالتك' : 'Your Message') }}</label>
                            <textarea id="message" name="message" class="modern-input" placeholder="{{ block('contact.form.message_placeholder', $isRtl ? 'أخبرنا عن مشروعك أو رؤيتك...' : 'Tell us about your project or vision...') }}" required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <p class="contact-legal">
                        {{ block('contact.form.legal_pre', $isRtl ? 'بالضغط على إرسال، فإنك توافق على ' : 'By clicking send, you agree to our ') }}
                        <a href="{{ url('/privacy') }}">{{ block('contact.form.legal_link', $isRtl ? 'سياسة الخصوصية' : 'Privacy Policy') }}</a>
                        {{ block('contact.form.legal_post', $isRtl ? ' وتوافق على أن نتواصل معك.' : ' and consent to being contacted.') }}
                    </p>

                    <button type="submit" class="btn-submit">
                        {{ block('contact.form.submit', $isRtl ? 'إرسال الرسالة' : 'Send Message') }} <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
