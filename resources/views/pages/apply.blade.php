@extends('layouts.app')

@section('title', block('apply.hero.title_meta', $isRtl ? 'قدّم طلب تمويل' : 'Apply for Financing'))

@section('content')
<section class="apply-hero">
    <div class="container">
        <div class="apply-header">
            <img src="{{ asset('Hotspot_Redesign/assets/img/logo_en.jpg') }}" alt="Hotspot Logo" />
            <div class="apply-header-text">
                <h1>{{ block('apply.hero.title', $isRtl ? 'قدّم طلب تمويل' : 'Apply for Financing') }}</h1>
                <p>
                    {{ block('apply.hero.subtitle', $isRtl
                        ? 'أكمل النموذج أدناه وسيتواصل معك أحد مستشارينا خلال 24 ساعة.'
                        : 'Complete the form below and one of our advisors will contact you within 24 hours.') }}
                </p>
            </div>
        </div>
    </div>
</section>

<section class="apply-form-section">
    <div class="container">
        <div class="apply-form-wrapper">
            <div class="apply-layout">
                <form action="{{ url('/apply') }}" method="POST" class="form-card">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul style="margin:0; padding-{{ $isRtl ? 'right' : 'left' }}:1.25rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif

                    <h2><span class="step-num">1</span>{{ block('apply.personal.title', $isRtl ? 'المعلومات الشخصية' : 'Personal Information') }}</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">{{ block('apply.personal.name_label', $isRtl ? 'الاسم الكامل' : 'Full Name') }}</label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="{{ block('apply.personal.name_placeholder', $isRtl ? 'أدخل اسمك الكامل' : 'Enter your full name') }}" required />
                        </div>
                        <div class="form-group">
                            <label for="national_id">{{ block('apply.personal.nid_label', $isRtl ? 'رقم الهوية' : 'National ID') }}</label>
                            <input type="text" id="national_id" name="national_id" value="{{ old('national_id') }}" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" placeholder="{{ block('apply.personal.nid_placeholder', $isRtl ? 'أدخل رقم هويتك' : 'Enter your national ID number') }}" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">{{ block('apply.personal.phone_label', $isRtl ? 'رقم الجوال' : 'Mobile Number') }}</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" inputmode="tel" pattern="05[0-9]{8}" maxlength="10" placeholder="05XXXXXXXX" required />
                        </div>
                        <div class="form-group">
                            <label for="email">{{ block('apply.personal.email_label', $isRtl ? 'البريد الإلكتروني' : 'Email') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">{{ block('apply.personal.city_label', $isRtl ? 'المدينة' : 'City') }}</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}" placeholder="{{ block('apply.personal.city_placeholder', $isRtl ? 'الرياض' : 'Riyadh') }}" required />
                        </div>
                    </div>

                    <h2><span class="step-num">2</span>{{ block('apply.employment.title', $isRtl ? 'تفاصيل العمل' : 'Employment Details') }}</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="employer">{{ block('apply.employment.employer_label', $isRtl ? 'جهة العمل' : 'Employer') }}</label>
                            <input type="text" id="employer" name="employer" value="{{ old('employer') }}" placeholder="{{ block('apply.employment.employer_placeholder', $isRtl ? 'أدخل جهة عملك' : 'Enter your employer name') }}" required />
                        </div>
                        <div class="form-group">
                            <label for="sector">{{ block('apply.employment.sector_label', $isRtl ? 'القطاع' : 'Sector') }}</label>
                            <select id="sector" name="sector" required>
                                <option value="" disabled {{ old('sector') ? '' : 'selected' }}>
                                    {{ block('apply.employment.sector_select', $isRtl ? 'اختر القطاع' : 'Select your sector') }}
                                </option>
                                <option value="government" {{ old('sector') === 'government' ? 'selected' : '' }}>{{ block('apply.employment.sector_government', $isRtl ? 'حكومي' : 'Government') }}</option>
                                <option value="private" {{ old('sector') === 'private' ? 'selected' : '' }}>{{ block('apply.employment.sector_private', $isRtl ? 'خاص' : 'Private') }}</option>
                                <option value="military" {{ old('sector') === 'military' ? 'selected' : '' }}>{{ block('apply.employment.sector_military', $isRtl ? 'عسكري' : 'Military') }}</option>
                                <option value="retired" {{ old('sector') === 'retired' ? 'selected' : '' }}>{{ block('apply.employment.sector_retired', $isRtl ? 'متقاعد' : 'Retired') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="salary">{{ block('apply.employment.salary_label', $isRtl ? 'الراتب الشهري' : 'Monthly Salary') }}</label>
                            <input type="number" id="salary" name="salary" value="{{ old('salary') }}" min="0" step="100" placeholder="{{ block('apply.employment.salary_placeholder', $isRtl ? 'مثال: 10000' : 'e.g. 10000') }}" required />
                        </div>
                    </div>

                    <h2><span class="step-num">3</span>{{ block('apply.financing.title', $isRtl ? 'تفاصيل التمويل' : 'Financing Details') }}</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="service_id">{{ block('apply.financing.service_label', $isRtl ? 'نوع التمويل' : 'Financing Type') }}</label>
                            <select id="service_id" name="service_id" required>
                                <option value="" disabled {{ old('service_id') ? '' : 'selected' }}>
                                    {{ block('apply.financing.service_select', $isRtl ? 'اختر نوع التمويل' : 'Select financing type') }}
                                </option>
                                @foreach($services ?? [] as $svc)
                                    <option value="{{ $svc->id }}" {{ (string) old('service_id') === (string) $svc->id ? 'selected' : '' }}>
                                        {{ $svc->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bank_id">{{ block('apply.financing.bank_label', $isRtl ? 'البنك' : 'Bank') }}</label>
                            <select id="bank_id" name="bank_id">
                                <option value="">{{ block('apply.financing.bank_any', $isRtl ? 'أي بنك' : 'Any Bank') }}</option>
                                @foreach($banks ?? [] as $bk)
                                    @php
                                        $selected = (string) old('bank_id') === (string) $bk->id
                                            || (!old('bank_id') && $bank && $bk->slug === $bank);
                                    @endphp
                                    <option value="{{ $bk->id }}" {{ $selected ? 'selected' : '' }}>
                                        {{ $bk->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="amount">{{ block('apply.financing.amount_label', $isRtl ? 'المبلغ المطلوب' : 'Required Amount') }}</label>
                            <input type="number" id="amount" name="amount" value="{{ old('amount') }}" min="1000" step="1000" placeholder="{{ block('apply.financing.amount_placeholder', $isRtl ? 'مثال: 500000' : 'e.g. 500000') }}" required />
                        </div>
                        <div class="form-group">
                            <label for="term_years">{{ block('apply.financing.term_label', $isRtl ? 'مدة السداد (سنوات)' : 'Term (years)') }}</label>
                            <input type="number" id="term_years" name="term_years" value="{{ old('term_years') }}" min="1" max="30" placeholder="{{ block('apply.financing.term_placeholder', $isRtl ? 'مثال: 5' : 'e.g. 5') }}" required />
                        </div>
                    </div>

                    <p class="form-note">
                        <i class="fa-solid fa-shield-halved"></i>
                        {{ block('apply.form.note', $isRtl
                            ? 'بياناتك محمية بالكامل ولن تتم مشاركتها مع أي جهة خارجية دون موافقتك.'
                            : 'Your data is fully protected and will not be shared with any third party without your consent.') }}
                    </p>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        {{ block('apply.form.submit', $isRtl ? 'إرسال الطلب' : 'Submit Application') }}
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>

                <aside>
                    <div class="apply-sidebar-card">
                        <h4>{{ block('apply.sidebar.why_title', $isRtl ? 'لماذا هوت سبوت؟' : 'Why Hotspot?') }}</h4>
                        <ul>
                            <li><i class="fa-solid fa-check-circle"></i> {{ block('apply.sidebar.why_sama', $isRtl ? 'مرخّص من ساما' : 'SAMA Licensed') }}</li>
                            <li><i class="fa-solid fa-check-circle"></i> {{ block('apply.sidebar.why_partners', $isRtl ? '+20 شريك بنكي' : '20+ Banking Partners') }}</li>
                            <li><i class="fa-solid fa-check-circle"></i> {{ block('apply.sidebar.why_instant', $isRtl ? 'موافقات فورية' : 'Instant Approvals') }}</li>
                            <li><i class="fa-solid fa-check-circle"></i> {{ block('apply.sidebar.why_fees', $isRtl ? 'بدون رسوم' : 'No Fees') }}</li>
                        </ul>
                    </div>
                    <div class="apply-sidebar-card">
                        <h4>{{ block('apply.sidebar.help_title', $isRtl ? 'تحتاج مساعدة؟' : 'Need Help?') }}</h4>
                        <ul>
                            <li><i class="fa-solid fa-phone"></i> {{ $siteSettings->get('contact_phone', '800-245-0071') }}</li>
                            <li><i class="fa-solid fa-envelope"></i> {{ $siteSettings->get('contact_email', 'Customercare@hotspot.sa') }}</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
