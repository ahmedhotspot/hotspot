@extends('layouts.client')

@section('page_title', $isRtl ? 'طلب تمويل جديد' : 'New Finance Request')

@push('styles')
<style>
    .stepper-nav {
        display: flex; gap: .5rem; flex-wrap: wrap;
        background: white;
        border: 1px solid var(--c-border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.25rem;
    }
    .stepper-nav .step {
        flex: 1; min-width: 140px;
        padding: .85rem 1rem;
        border-radius: 8px;
        background: var(--c-bg);
        text-align: center;
        font-size: .85rem; font-weight: 700;
        color: var(--c-muted);
        border: 2px solid transparent;
        display: flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .stepper-nav .step.active {
        background: #dbeafe; color: #1d4ed8; border-color: #1d4ed8;
    }
    .stepper-nav .step.done {
        background: #dcfce7; color: #166534; border-color: #16a34a;
    }
    .stepper-nav .step .n {
        display: inline-grid; place-items: center;
        width: 26px; height: 26px; border-radius: 50%;
        background: white; color: var(--c-muted);
        font-size: .8rem;
    }
    .stepper-nav .step.active .n { background: #1d4ed8; color: white; }
    .stepper-nav .step.done .n { background: #16a34a; color: white; }

    .step-panel { display: none; }
    .step-panel.active { display: block; }

    .form-section {
        background: white;
        border: 1px solid var(--c-border);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .form-section-head {
        padding-bottom: 1rem; margin-bottom: 1.25rem;
        border-bottom: 1px solid var(--c-border);
    }
    .form-section-head h3 { margin: 0 0 .25rem; font-size: 1.05rem; font-weight: 800; }
    .form-section-head p { margin: 0; color: var(--c-muted); font-size: .85rem; }

    .required-star::after { content: ' *'; color: var(--c-danger); }

    .guarantee-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
    .guarantee-card {
        border: 2px dashed var(--c-border); border-radius: 10px;
        padding: 1.25rem; cursor: pointer; transition: all .15s;
        display: flex; align-items: center; gap: .75rem;
    }
    .guarantee-card:hover { border-color: var(--c-primary); background: #f8faff; }
    .guarantee-card.checked { border-color: var(--c-primary); background: #eff6ff; }
    .guarantee-card input { display: none; }
    .guarantee-card i { font-size: 1.75rem; color: var(--c-primary); }
    .guarantee-card .t { font-weight: 800; display: block; }
    .guarantee-card .s { font-size: .8rem; color: var(--c-muted); }

    .sub-fields {
        margin-top: 1rem; padding: 1rem;
        background: #f8fafc; border-radius: 8px;
        display: none;
    }
    .sub-fields.open { display: block; }

    .docs-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
    .doc-field {
        padding: 1rem; background: #f8fafc;
        border: 1px dashed var(--c-border); border-radius: 8px;
    }
    .doc-field label { font-weight: 700; display: block; margin-bottom: .4rem; font-size: .85rem; }

    .review-group { margin-bottom: 1.25rem; }
    .review-group h4 {
        font-size: .95rem; font-weight: 800; color: var(--c-text);
        margin: 0 0 .6rem; padding-bottom: .4rem;
        border-bottom: 1px solid var(--c-border);
    }
    .review-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: .75rem; }
    .review-item {
        padding: .6rem .8rem; background: #f8fafc; border-radius: 6px;
    }
    .review-item .k { color: var(--c-muted); font-size: .75rem; }
    .review-item .v { font-weight: 700; font-size: .9rem; word-break: break-word; }

    .offer-card {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 1.25rem; border: 2px solid var(--c-border);
        border-radius: 10px; cursor: pointer; transition: all .15s;
        margin-bottom: .75rem;
    }
    .offer-card:hover { border-color: var(--c-primary); }
    .offer-card.selected { border-color: var(--c-primary); background: #eff6ff; }
    .offer-card input { display: none; }

    .stepper-actions {
        display: flex; justify-content: space-between; gap: .75rem;
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
    <div style="margin-bottom:1rem;">
        <a href="{{ route('client.dashboard') }}" class="btn-c btn-c-outline btn-c-sm">
            <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
            {{ $isRtl ? 'العودة للوحة التحكم' : 'Back to Dashboard' }}
        </a>
    </div>

    <div class="stepper-nav" id="stepperNav">
        @php
            $stepLabels = [
                1 => $isRtl ? 'معلومات العمل'   : 'Business Info',
                2 => $isRtl ? 'المستندات'       : 'Documents',
                3 => $isRtl ? 'ضمان التمويل'    : 'Guarantee',
                4 => $isRtl ? 'مراجعة الطلب'    : 'Review',
                5 => $isRtl ? 'اختيار العرض'    : 'Choose Offer',
            ];
        @endphp
        @foreach($stepLabels as $n => $lbl)
            <div class="step {{ $n === 1 ? 'active' : '' }}" data-step="{{ $n }}">
                <span class="n">{{ $n }}</span>
                <span>{{ $lbl }}</span>
            </div>
        @endforeach
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-{{ $isRtl ? 'right' : 'left' }}:1.25rem;">
                @foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('client.financing.store') }}" enctype="multipart/form-data" id="financingForm">
        @csrf

        {{-- ================= STEP 1: BUSINESS INFO ================= --}}
        <div class="step-panel active" data-panel="1">
            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'المنتج / القطاع' : 'Product / Industry' }}</h3>
                    <p>{{ $isRtl ? 'اختر القطاع الرئيسي والقطاع الفرعي.' : 'Select main industry and sub-industry.' }}</p>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'القطاع (المنتج)' : 'Industry (Product)' }}</label>
                        <select name="industry_id" id="industrySelect" required>
                            <option value="">{{ $isRtl ? 'اختر القطاع' : 'Select Industry' }}</option>
                            @foreach ($apiIndustries as $ind)
                                <option value="{{ $ind['id'] }}"
                                    data-name-ar="{{ $ind['name_ar'] ?? '' }}"
                                    data-name-en="{{ $ind['name_en'] ?? '' }}"
                                    data-subs='@json($ind["sub_industries"] ?? [], JSON_UNESCAPED_UNICODE)'
                                    {{ old('industry_id') == $ind['id'] ? 'selected' : '' }}>
                                    {{ $isRtl ? ($ind['name_ar'] ?: $ind['name_en']) : ($ind['name_en'] ?: $ind['name_ar']) }}
                                </option>
                            @endforeach
                        </select>
                        @if(empty($apiIndustries))
                            <div class="err">{{ $isRtl ? 'تعذّر جلب القطاعات من الـ API.' : 'Could not fetch industries from API.' }}</div>
                        @endif
                    </div>

                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'القطاع الفرعي' : 'Sub-Industry' }}</label>
                        <select name="sub_industry_id" id="subIndustrySelect" required disabled>
                            <option value="">{{ $isRtl ? 'اختر القطاع الفرعي' : 'Select Sub-Industry' }}</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="industry_name" id="industryName">
                <input type="hidden" name="sub_industry_name" id="subIndustryName">

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'مبلغ التمويل' : 'Requested Amount' }}</label>
                        <input type="number" step="0.01" min="1" name="amount" value="{{ old('amount') }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'مدة السداد (سنوات)' : 'Term (years)' }}</label>
                        <input type="number" min="1" max="30" name="term_years" value="{{ old('term_years', 5) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'بيانات المنشأة والعنوان' : 'Business & Address' }}</h3>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'الاسم الكامل' : 'Full Name' }}</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->name) }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'رقم الهوية' : 'National ID' }}</label>
                        <input type="text" name="national_id" value="{{ old('national_id') }}" maxlength="10" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label>{{ $isRtl ? 'رقم الإقامة' : 'Residence Number' }}</label>
                        <input type="text" name="residence_number" value="{{ old('residence_number') }}">
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'المدينة' : 'City' }}</label>
                        <input type="text" name="city" value="{{ old('city') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'اسم الشارع' : 'Street Name' }}</label>
                        <input type="text" name="street_name" value="{{ old('street_name') }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'الرمز البريدي' : 'Postal Code' }}</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'اسم الحي' : 'District Name' }}</label>
                        <input type="text" name="district_name" value="{{ old('district_name') }}" required>
                    </div>
                    <div class="form-field">
                        <label>{{ $isRtl ? 'الرمز الإضافي' : 'Additional Code' }}</label>
                        <input type="text" name="additional_code" value="{{ old('additional_code') }}">
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-field">
                        <label>{{ $isRtl ? 'وصف الموقع' : 'Location Description' }}</label>
                        <input type="text" name="location_description" value="{{ old('location_description') }}">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'معلومات التواصل' : 'Contact Information' }}</h3>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'جوال 1' : 'Mobile 1' }}</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="form-field">
                        <label>{{ $isRtl ? 'جوال 2' : 'Mobile 2' }}</label>
                        <input type="tel" name="mobile_2" value="{{ old('mobile_2') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label>{{ $isRtl ? 'هاتف 1' : 'Phone 1' }}</label>
                        <input type="tel" name="phone_1" value="{{ old('phone_1') }}">
                    </div>
                    <div class="form-field">
                        <label>{{ $isRtl ? 'هاتف 2' : 'Phone 2' }}</label>
                        <input type="tel" name="phone_2" value="{{ old('phone_2') }}">
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'بريد التواصل' : 'Contact Email' }}</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'معلومات السجل التجاري' : 'Commercial Registration' }}</h3>
                </div>

                <div class="form-row full">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'الشكل القانوني' : 'Legal Form' }}</label>
                        <input type="text" name="legal_form" value="{{ old('legal_form') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'الاسم التجاري' : 'Commercial Name' }}</label>
                        <input type="text" name="commercial_name" value="{{ old('commercial_name') }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'رقم السجل التجاري' : 'Commercial Registration' }}</label>
                        <input type="text" name="commercial_registration" value="{{ old('commercial_registration') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'مدينة السجل' : 'Registration City' }}</label>
                        <input type="text" name="commercial_city" value="{{ old('commercial_city') }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'تاريخ انتهاء السجل (هجري)' : 'License Expiry (Hijri)' }}</label>
                        <input type="text" name="license_expiry_hijri" value="{{ old('license_expiry_hijri') }}" placeholder="dd/mm/yyyy" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'تاريخ السجل (هجري)' : 'Establishment Date (Hijri)' }}</label>
                        <input type="text" name="establishment_date_hijri" value="{{ old('establishment_date_hijri') }}" placeholder="dd/mm/yyyy" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'بيانات صاحب الشركة' : 'Company Owner Information' }}</h3>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'اسم المالك' : 'Owner Name' }}</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', $user->name) }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'رقم بطاقة الهوية' : 'ID Card Number' }}</label>
                        <input type="text" name="owner_id_number" value="{{ old('owner_id_number') }}" maxlength="10" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'الجنسية' : 'Nationality' }}</label>
                        <input type="text" name="nationality" value="{{ old('nationality', $isRtl ? 'سعودي' : 'Saudi') }}" required>
                    </div>
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'تاريخ الميلاد' : 'Date of Birth' }}</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-field">
                        <label class="required-star">{{ $isRtl ? 'تاريخ صلاحية بطاقة الهوية' : 'ID Card Expiry Date' }}</label>
                        <input type="text" name="id_expiry_date" value="{{ old('id_expiry_date') }}" placeholder="dd/mm/yyyy" required>
                    </div>
                </div>
            </div>

            <div class="stepper-actions">
                <span></span>
                <button type="button" class="btn-c btn-c-primary" data-next>
                    {{ $isRtl ? 'التالي' : 'Next' }}
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            </div>
        </div>

        {{-- ================= STEP 2: DOCUMENTS ================= --}}
        <div class="step-panel" data-panel="2">
            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'المستندات المطلوبة' : 'Required Documents' }}</h3>
                    <p>{{ $isRtl ? 'يرجى رفع المستندات (PDF/صور/Word، حد أقصى 5 ميجا لكل ملف).' : 'Upload documents (PDF/images/Word, 5MB max each).' }}</p>
                </div>

                <div class="docs-list">
                    @foreach([
                        'id_copy'            => $isRtl ? 'صورة الهوية' : 'ID Copy',
                        'commercial_reg_doc' => $isRtl ? 'السجل التجاري' : 'Commercial Registration',
                        'bank_statement'     => $isRtl ? 'كشف حساب بنكي' : 'Bank Statement',
                        'financial_report'   => $isRtl ? 'القوائم المالية' : 'Financial Statements',
                        'property_deed'      => $isRtl ? 'صك العقار' : 'Property Deed',
                        'other_doc'          => $isRtl ? 'مستندات أخرى' : 'Other Documents',
                    ] as $key => $lbl)
                        <div class="doc-field">
                            <label>{{ $lbl }}</label>
                            <input type="file" name="documents[{{ $key }}]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="stepper-actions">
                <button type="button" class="btn-c btn-c-outline" data-prev>
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
                    {{ $isRtl ? 'السابق' : 'Previous' }}
                </button>
                <button type="button" class="btn-c btn-c-primary" data-next>
                    {{ $isRtl ? 'التالي' : 'Next' }}
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            </div>
        </div>

        {{-- ================= STEP 3: GUARANTEE ================= --}}
        <div class="step-panel" data-panel="3">
            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'ضمان التمويل' : 'Financing Guarantee' }}</h3>
                    <p>{{ $isRtl ? 'يمكنك اختيار أكثر من نوع ضمان.' : 'You can select multiple guarantee types.' }}</p>
                </div>

                <div class="guarantee-grid">
                    @foreach([
                        ['key' => 'real_estate', 'icon' => 'fa-house',      'title_ar' => 'عقار',  'title_en' => 'Real Estate', 'sub_ar' => 'أرض، تجاري، سكني', 'sub_en' => 'Land, Commercial, Residential'],
                        ['key' => 'stocks',      'icon' => 'fa-chart-line', 'title_ar' => 'أسهم',  'title_en' => 'Stocks',      'sub_ar' => 'عدد الأسهم',        'sub_en' => 'Number of shares'],
                        ['key' => 'other',       'icon' => 'fa-briefcase',  'title_ar' => 'أخرى',  'title_en' => 'Other',       'sub_ar' => 'ضمانات إضافية',     'sub_en' => 'Additional guarantees'],
                    ] as $g)
                        @php $checked = in_array($g['key'], (array) old('guarantee_types', [])); @endphp
                        <label class="guarantee-card {{ $checked ? 'checked' : '' }}" data-guarantee="{{ $g['key'] }}">
                            <input type="checkbox" name="guarantee_types[]" value="{{ $g['key'] }}" {{ $checked ? 'checked' : '' }}>
                            <i class="fa-solid {{ $g['icon'] }}"></i>
                            <span>
                                <span class="t">{{ $isRtl ? $g['title_ar'] : $g['title_en'] }}</span>
                                <span class="s">{{ $isRtl ? $g['sub_ar'] : $g['sub_en'] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="sub-fields" data-sub="real_estate">
                    <div class="form-row">
                        <div class="form-field">
                            <label>{{ $isRtl ? 'نوع العقار' : 'Property Type' }}</label>
                            <input type="text" name="guarantee_details[real_estate_type]" value="{{ old('guarantee_details.real_estate_type') }}">
                        </div>
                        <div class="form-field">
                            <label>{{ $isRtl ? 'القيمة التقديرية' : 'Estimated Value' }}</label>
                            <input type="number" step="0.01" name="guarantee_details[real_estate_value]" value="{{ old('guarantee_details.real_estate_value') }}">
                        </div>
                    </div>
                </div>

                <div class="sub-fields" data-sub="stocks">
                    <div class="form-row">
                        <div class="form-field">
                            <label>{{ $isRtl ? 'عدد الأسهم' : 'Number of Shares' }}</label>
                            <input type="number" name="guarantee_details[stocks_count]" value="{{ old('guarantee_details.stocks_count') }}">
                        </div>
                        <div class="form-field">
                            <label>{{ $isRtl ? 'اسم الشركة' : 'Company Name' }}</label>
                            <input type="text" name="guarantee_details[stocks_company]" value="{{ old('guarantee_details.stocks_company') }}">
                        </div>
                    </div>
                </div>

                <div class="sub-fields" data-sub="other">
                    <div class="form-row full">
                        <div class="form-field">
                            <label>{{ $isRtl ? 'تفاصيل الضمان' : 'Guarantee Details' }}</label>
                            <textarea name="guarantee_details[other_details]" rows="3">{{ old('guarantee_details.other_details') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'ملاحظات إضافية' : 'Additional Notes' }}</h3>
                </div>
                <div class="form-field">
                    <textarea name="notes" rows="3" placeholder="{{ $isRtl ? 'أي معلومات إضافية تودّ إضافتها…' : 'Any additional info…' }}">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="stepper-actions">
                <button type="button" class="btn-c btn-c-outline" data-prev>
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
                    {{ $isRtl ? 'السابق' : 'Previous' }}
                </button>
                <button type="button" class="btn-c btn-c-primary" data-next>
                    {{ $isRtl ? 'مراجعة الطلب' : 'Review Request' }}
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            </div>
        </div>

        {{-- ================= STEP 4: REVIEW ================= --}}
        <div class="step-panel" data-panel="4">
            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'مراجعة بيانات الطلب' : 'Review Your Request' }}</h3>
                    <p>{{ $isRtl ? 'راجع كل البيانات قبل الانتقال لاختيار العرض.' : 'Review all data before choosing an offer.' }}</p>
                </div>

                <div id="reviewContent"></div>
            </div>

            <div class="stepper-actions">
                <button type="button" class="btn-c btn-c-outline" data-prev>
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
                    {{ $isRtl ? 'تعديل البيانات' : 'Edit Data' }}
                </button>
                <button type="button" class="btn-c btn-c-primary" data-next>
                    {{ $isRtl ? 'اختيار العرض' : 'Choose Offer' }}
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            </div>
        </div>

        {{-- ================= STEP 5: CHOOSE OFFER ================= --}}
        <div class="step-panel" data-panel="5">
            <div class="form-section">
                <div class="form-section-head">
                    <h3>{{ $isRtl ? 'اختر العرض المناسب' : 'Choose the Right Offer' }}</h3>
                    <p>{{ $isRtl ? 'اختر عرضاً أو تجاوز الخطوة وسيختار لك مستشارونا الأنسب.' : 'Pick an offer or skip — our advisors will suggest the best fit.' }}</p>
                </div>

                @if($offers->count())
                    @foreach($offers as $offer)
                        <label class="offer-card" data-offer="{{ $offer->id }}">
                            <input type="radio" name="offer_id" value="{{ $offer->id }}">
                            <div>
                                <div style="font-weight:800; font-size:1rem;">{{ $offer->title ?? ($offer->name ?? '—') }}</div>
                                <div style="color:#6b7280; font-size:.85rem;">
                                    {{ optional($offer->bank)->name ?? ($isRtl ? 'بنك' : 'Bank') }}
                                </div>
                            </div>
                            <i class="fa-solid fa-circle-check" style="font-size:1.25rem; color:#16a34a; opacity:0;"></i>
                        </label>
                    @endforeach
                @else
                    <div class="empty">
                        <i class="fa-solid fa-gift"></i>
                        <p>{{ $isRtl ? 'لا توجد عروض متاحة حالياً. سيتواصل معك فريقنا بأفضل العروض.' : 'No offers available right now. Our team will reach out with the best options.' }}</p>
                    </div>
                @endif
            </div>

            <div class="stepper-actions">
                <button type="button" class="btn-c btn-c-outline" data-prev>
                    <i class="fa-solid fa-arrow-{{ $isRtl ? 'right' : 'left' }}"></i>
                    {{ $isRtl ? 'السابق' : 'Previous' }}
                </button>
                <button type="submit" class="btn-c btn-c-primary">
                    <i class="fa-solid fa-paper-plane"></i>
                    {{ $isRtl ? 'إرسال الطلب' : 'Submit Request' }}
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    const isRtl = {{ $isRtl ? 'true' : 'false' }};
    const lang  = '{{ app()->getLocale() }}';
    const form  = document.getElementById('financingForm');
    const nav   = document.getElementById('stepperNav');
    const panels = form.querySelectorAll('.step-panel');
    const steps  = nav.querySelectorAll('.step');
    let current = 1;
    const total = panels.length;

    function show(step) {
        panels.forEach(p => p.classList.toggle('active', +p.dataset.panel === step));
        steps.forEach(s => {
            const n = +s.dataset.step;
            s.classList.toggle('active', n === step);
            s.classList.toggle('done',   n < step);
        });
        current = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        if (step === 4) buildReview();
    }

    function validateStep(step) {
        const panel = form.querySelector('.step-panel[data-panel="' + step + '"]');
        const required = panel.querySelectorAll('[required]');
        for (const el of required) {
            if (!el.value || (el.type === 'checkbox' && !el.checked)) {
                el.focus();
                el.style.borderColor = '#dc2626';
                setTimeout(() => { el.style.borderColor = ''; }, 2500);
                alert(isRtl ? 'يرجى تعبئة جميع الحقول المطلوبة.' : 'Please fill in all required fields.');
                return false;
            }
        }
        return true;
    }

    form.querySelectorAll('[data-next]').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!validateStep(current)) return;
            if (current < total) show(current + 1);
        });
    });
    form.querySelectorAll('[data-prev]').forEach(btn => {
        btn.addEventListener('click', () => { if (current > 1) show(current - 1); });
    });

    // --- Industry cascade (API) ---
    const indSel = document.getElementById('industrySelect');
    const subSel = document.getElementById('subIndustrySelect');
    const indName = document.getElementById('industryName');
    const subName = document.getElementById('subIndustryName');
    const oldSub = @json((string) old('sub_industry_id'));

    function populateSubs() {
        const opt = indSel.options[indSel.selectedIndex];
        subSel.innerHTML = '<option value="">' + (isRtl ? 'اختر القطاع الفرعي' : 'Select Sub-Industry') + '</option>';
        subSel.disabled = true;
        indName.value = '';
        if (!opt || !opt.value) return;
        indName.value = opt.getAttribute('data-name-' + lang) || opt.textContent.trim();
        let subs = [];
        try { subs = JSON.parse(opt.getAttribute('data-subs') || '[]'); } catch (e) {}
        subs.forEach(s => {
            const o = document.createElement('option');
            o.value = s.id;
            o.dataset.nameAr = s.name_ar || '';
            o.dataset.nameEn = s.name_en || '';
            o.textContent = isRtl ? (s.name_ar || s.name_en) : (s.name_en || s.name_ar);
            if (String(oldSub) === String(s.id)) o.selected = true;
            subSel.appendChild(o);
        });
        subSel.disabled = subs.length === 0;
        updateSubName();
    }

    function updateSubName() {
        const o = subSel.options[subSel.selectedIndex];
        subName.value = o ? (o.dataset['name' + (lang === 'ar' ? 'Ar' : 'En')] || o.textContent.trim()) : '';
    }

    indSel.addEventListener('change', populateSubs);
    subSel.addEventListener('change', updateSubName);
    if (indSel.value) populateSubs();

    // --- Guarantee cascade ---
    document.querySelectorAll('.guarantee-card input').forEach(chk => {
        const card = chk.closest('.guarantee-card');
        const key  = card.dataset.guarantee;
        const sub  = document.querySelector('.sub-fields[data-sub="' + key + '"]');
        const sync = () => {
            card.classList.toggle('checked', chk.checked);
            if (sub) sub.classList.toggle('open', chk.checked);
        };
        chk.addEventListener('change', sync);
        sync();
    });

    // --- Offer selection ---
    document.querySelectorAll('.offer-card input').forEach(r => {
        r.addEventListener('change', () => {
            document.querySelectorAll('.offer-card').forEach(c => {
                c.classList.remove('selected');
                const icon = c.querySelector('.fa-circle-check'); if (icon) icon.style.opacity = '0';
            });
            if (r.checked) {
                const card = r.closest('.offer-card');
                card.classList.add('selected');
                const icon = card.querySelector('.fa-circle-check'); if (icon) icon.style.opacity = '1';
            }
        });
    });

    // --- Build review (step 4) ---
    const reviewMap = [
        { section: isRtl ? 'المنتج / القطاع' : 'Product / Industry', rows: [
            { label: isRtl ? 'القطاع' : 'Industry',            getter: () => indName.value || textOf('industrySelect') },
            { label: isRtl ? 'القطاع الفرعي' : 'Sub-Industry', getter: () => subName.value || textOf('subIndustrySelect') },
            { label: isRtl ? 'المبلغ' : 'Amount',              field: 'amount' },
            { label: isRtl ? 'المدة (سنوات)' : 'Term (years)', field: 'term_years' },
        ]},
        { section: isRtl ? 'بيانات المنشأة' : 'Business', rows: [
            { label: isRtl ? 'الاسم الكامل' : 'Full Name',    field: 'full_name' },
            { label: isRtl ? 'رقم الهوية' : 'National ID',    field: 'national_id' },
            { label: isRtl ? 'رقم الإقامة' : 'Residence No.', field: 'residence_number' },
            { label: isRtl ? 'المدينة' : 'City',              field: 'city' },
            { label: isRtl ? 'الشارع' : 'Street',             field: 'street_name' },
            { label: isRtl ? 'الرمز البريدي' : 'Postal Code', field: 'postal_code' },
            { label: isRtl ? 'الحي' : 'District',             field: 'district_name' },
            { label: isRtl ? 'الرمز الإضافي' : 'Additional Code', field: 'additional_code' },
            { label: isRtl ? 'وصف الموقع' : 'Location',      field: 'location_description' },
        ]},
        { section: isRtl ? 'التواصل' : 'Contact', rows: [
            { label: isRtl ? 'جوال 1' : 'Mobile 1', field: 'phone' },
            { label: isRtl ? 'جوال 2' : 'Mobile 2', field: 'mobile_2' },
            { label: isRtl ? 'هاتف 1' : 'Phone 1',  field: 'phone_1' },
            { label: isRtl ? 'هاتف 2' : 'Phone 2',  field: 'phone_2' },
            { label: isRtl ? 'البريد' : 'Email',    field: 'email' },
        ]},
        { section: isRtl ? 'السجل التجاري' : 'Commercial Registration', rows: [
            { label: isRtl ? 'الشكل القانوني' : 'Legal Form',          field: 'legal_form' },
            { label: isRtl ? 'الاسم التجاري' : 'Commercial Name',      field: 'commercial_name' },
            { label: isRtl ? 'رقم السجل' : 'Registration No.',         field: 'commercial_registration' },
            { label: isRtl ? 'مدينة السجل' : 'Registration City',      field: 'commercial_city' },
            { label: isRtl ? 'انتهاء السجل (هجري)' : 'License Expiry', field: 'license_expiry_hijri' },
            { label: isRtl ? 'تاريخ السجل (هجري)' : 'Establishment',   field: 'establishment_date_hijri' },
        ]},
        { section: isRtl ? 'المالك' : 'Owner', rows: [
            { label: isRtl ? 'اسم المالك' : 'Owner Name',       field: 'owner_name' },
            { label: isRtl ? 'رقم البطاقة' : 'ID Card Number',  field: 'owner_id_number' },
            { label: isRtl ? 'الجنسية' : 'Nationality',         field: 'nationality' },
            { label: isRtl ? 'تاريخ الميلاد' : 'Date of Birth', field: 'birth_date' },
            { label: isRtl ? 'انتهاء الهوية' : 'ID Expiry',     field: 'id_expiry_date' },
        ]},
    ];

    function textOf(id) {
        const el = document.getElementById(id);
        if (!el) return '';
        if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.textContent?.trim() || '';
        return el.value;
    }
    function valOf(name) {
        const el = form.querySelector('[name="' + name + '"]');
        return el ? (el.value || '') : '';
    }

    function buildReview() {
        const host = document.getElementById('reviewContent');
        let html = '';
        reviewMap.forEach(sec => {
            html += '<div class="review-group"><h4>' + escape(sec.section) + '</h4><div class="review-grid">';
            sec.rows.forEach(r => {
                const v = r.getter ? r.getter() : valOf(r.field);
                html += '<div class="review-item"><div class="k">' + escape(r.label) + '</div><div class="v">' + escape(v || '—') + '</div></div>';
            });
            html += '</div></div>';
        });

        // Guarantees
        const gTypes = Array.from(form.querySelectorAll('input[name="guarantee_types[]"]:checked')).map(c => c.value);
        const gLabels = { real_estate: isRtl ? 'عقار' : 'Real Estate', stocks: isRtl ? 'أسهم' : 'Stocks', other: isRtl ? 'أخرى' : 'Other' };
        html += '<div class="review-group"><h4>' + (isRtl ? 'الضمان' : 'Guarantee') + '</h4><div class="review-grid">';
        html += '<div class="review-item"><div class="k">' + (isRtl ? 'الأنواع' : 'Types') + '</div><div class="v">' + escape(gTypes.map(t => gLabels[t] || t).join(', ') || '—') + '</div></div>';
        html += '</div></div>';

        // Documents
        const docInputs = form.querySelectorAll('input[type="file"][name^="documents["]');
        html += '<div class="review-group"><h4>' + (isRtl ? 'المستندات' : 'Documents') + '</h4><div class="review-grid">';
        docInputs.forEach(inp => {
            const lbl = inp.closest('.doc-field').querySelector('label').textContent.trim();
            const file = inp.files && inp.files[0] ? inp.files[0].name : (isRtl ? 'لم يُرفع' : 'Not uploaded');
            html += '<div class="review-item"><div class="k">' + escape(lbl) + '</div><div class="v">' + escape(file) + '</div></div>';
        });
        html += '</div></div>';

        // Notes
        const notes = valOf('notes');
        if (notes) html += '<div class="review-group"><h4>' + (isRtl ? 'ملاحظات' : 'Notes') + '</h4><div class="review-item"><div class="v">' + escape(notes) + '</div></div></div>';

        host.innerHTML = html;
    }

    function escape(s) {
        return String(s ?? '').replace(/[&<>"']/g, c => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[c]));
    }
})();
</script>
@endpush
