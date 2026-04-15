@extends('layouts.client')

@include('client.financing-request._home_theme')

@section('title', ln('Submit Financing Request', 'تقديم طلب تمويل'))
@section('page_title', ln('Financing Request', 'طلب التمويل'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .stepper.stepper-links * { box-sizing: border-box; }
        .stepper.stepper-links { background:#FFF; border-radius:16px; padding:50px 30px; box-shadow:0 0 30px 0 rgba(82,63,105,.08); }
        .stepper-nav-wrapper { width:100%; }
        .stepper-nav { display:flex; justify-content:center; align-items:center; width:100%; max-width:1000px; margin:0 auto; padding:0; }
        .stepper-item-wrapper { flex:0 0 auto; }
        .stepper-line-wrapper { flex:1; display:flex; align-items:center; padding:0 10px; }
        .stepper-item { display:flex; flex-direction:column; align-items:center; position:relative; }
        .stepper-circle { width:45px; height:45px; border-radius:50%; background:#E5E7EB; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px; color:#9CA3AF; transition:.3s; margin-bottom:10px; }
        .stepper-check { display:none; }
        .stepper-line { width:100%; height:2px; background:#D1D5DB; transition:.3s; }
        .stepper-label { text-align:center; max-width:140px; }
        .stepper-step { font-size:9px; letter-spacing:.5px; color:#9CA3AF; text-transform:uppercase; font-weight:600; margin-bottom:5px; }
        .stepper-title { font-weight:600; font-size:12px; color:#374151; margin:0 0 3px; line-height:1.2; }
        .stepper-status { font-size:10px; color:#9CA3AF; margin-top:3px; font-weight:500; }
        .stepper-item.completed .stepper-circle { background:#10B981; }
        .stepper-item.completed .stepper-number { display:none; }
        .stepper-item.completed .stepper-check { display:block; font-size:20px; color:#fff; }
        .stepper-item.completed .stepper-step,
        .stepper-item.completed .stepper-title,
        .stepper-item.completed .stepper-status { color:#10B981; font-weight:600; }
        .stepper-item-wrapper:has(.stepper-item.completed)+.stepper-line-wrapper .stepper-line { background:#10B981; }
        .stepper-item.current .stepper-circle { background:#0EA5E9; box-shadow:0 0 0 6px rgba(14,165,233,.15); }
        .stepper-item.current .stepper-number { color:#fff; }
        .stepper-item.current .stepper-step,
        .stepper-item.current .stepper-title,
        .stepper-item.current .stepper-status { color:#0EA5E9; font-weight:600; }
        .card.card-flush { border-radius:12px; box-shadow:0 0 30px 0 rgba(82,63,105,.05); border:1px solid #EFF2F5; }
        .form-control-solid, .form-select-solid { background:#F9F9F9; border:1px solid #E4E6EF; }
        .form-control-solid:focus, .form-select-solid:focus { background:#FFF; border-color:#0EA5E9; box-shadow:0 0 0 .25rem rgba(14,165,233,.1); }
        .offer-row { cursor:pointer; transition:.3s; }
        .offer-row:hover { background:#F0F9FF !important; }
        .offer-row.selected { background:#E0F2FE !important; border-left:4px solid #0EA5E9; }
        .offer-radio { width:22px !important; height:22px !important; cursor:pointer !important; }
        .table-responsive { border-radius:10px; overflow:hidden; }
        [data-kt-stepper-element="content"]:not(.current) { display:none; }
        .status-icon { font-size:20px; color:#9CA3AF; }
        .required:after { content:" *"; color:#dc3545; }
        @media (max-width:768px){ .stepper-nav{flex-direction:column;gap:30px;} .stepper-line-wrapper{display:none;} .stepper-item-wrapper{width:100%;} }

        /* ====== PROFESSIONAL POLISH (Hotspot red theme) ====== */
        :root {
            --hs-primary:#FF4040; --hs-primary-dark:#D32F2F; --hs-primary-light:#FFEDED;
            --hs-gradient:linear-gradient(135deg,#FF4040 0%,#FF6B6B 100%);
            --hs-border:#e6e9f0; --hs-text:#1e2333; --hs-muted:#6b7280;
        }
        .fr-page { max-width:1240px; margin:0 auto; }
        .fr-page-head {
            background:var(--hs-gradient); color:#fff; border-radius:14px;
            padding:1.5rem 1.75rem; margin-bottom:1.25rem;
            display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem;
            box-shadow:0 10px 25px -10px rgba(255,64,64,.35);
        }
        .fr-page-head h1 { margin:0 0 .25rem; font-size:1.4rem; font-weight:800; }
        .fr-page-head p  { margin:0; opacity:.92; font-size:.9rem; }
        .fr-page-head .badge-step { background:rgba(255,255,255,.2); color:#fff; padding:.5rem 1rem; border-radius:999px; font-weight:700; font-size:.85rem; backdrop-filter:blur(4px); }

        /* Stepper card outer wrap */
        .stepper.stepper-links {
            border-radius:18px !important;
            padding:36px 28px !important;
            box-shadow:0 4px 28px rgba(20,30,60,.06) !important;
            border:1px solid #eef0f5 !important;
        }

        /* Stepper accent → red theme */
        .stepper-item.current .stepper-circle { background:var(--hs-primary) !important; box-shadow:0 0 0 6px rgba(255,64,64,.15) !important; }
        .stepper-item.current .stepper-step,
        .stepper-item.current .stepper-title,
        .stepper-item.current .stepper-status { color:var(--hs-primary) !important; }

        /* Hide old form title wrapping card — replaced by fr-page-head */
        #kt_financing_form > .card { background:transparent !important; border:0 !important; box-shadow:none !important; }
        #kt_financing_form > .card > .card-header { display:none !important; }
        #kt_financing_form > .card > .card-body { padding:0 !important; }

        /* Section cards */
        .card.card-flush {
            border-radius:14px !important;
            border:1px solid #eef0f5 !important;
            box-shadow:0 1px 3px rgba(20,30,60,.04) !important;
            background:#fff !important;
            margin-bottom:1.1rem !important;
        }
        .card.card-flush .card-header {
            border-bottom:1px solid #eef0f5;
            padding:1rem 1.25rem !important;
            background:#fafbff;
            border-radius:14px 14px 0 0;
        }
        .card.card-flush .card-title h3 {
            margin:0; font-size:1rem; font-weight:700; color:var(--hs-text);
            display:flex; align-items:center; gap:.55rem;
        }
        .card.card-flush .card-title h3:before {
            content:""; width:4px; height:18px;
            background:var(--hs-gradient); border-radius:3px;
        }
        .card.card-flush .card-body { padding:1.25rem !important; }

        /* Tighten Bootstrap field gaps inside the form */
        #kt_financing_form .row.g-9 { --bs-gutter-x:1rem !important; --bs-gutter-y:1rem !important; }
        #kt_financing_form .row.g-5 { --bs-gutter-x:.85rem !important; --bs-gutter-y:.85rem !important; }
        #kt_financing_form .mb-7 { margin-bottom:1rem !important; }
        #kt_financing_form .mb-10 { margin-bottom:1.25rem !important; }
        #kt_financing_form .pb-10 { padding-bottom:.85rem !important; }
        #kt_financing_form .pt-7  { padding-top:.85rem !important; }
        #kt_financing_form .pt-6  { padding-top:.85rem !important; }
        #kt_financing_form .pt-15 { padding-top:1.25rem !important; }
        #kt_financing_form .fv-row { margin-bottom:0; }
        #kt_financing_form .fv-row label { margin-bottom:.35rem !important; }

        /* Inputs polish */
        .form-control-solid, .form-select-solid, .form-control, .form-select {
            background:#fafbff !important;
            border:1px solid #e4e6ef !important;
            border-radius:9px !important;
            padding:.6rem .85rem !important;
            font-size:.92rem !important;
            min-height:42px;
            transition:all .15s;
        }
        .form-control-solid:focus, .form-select-solid:focus, .form-control:focus, .form-select:focus {
            background:#fff !important;
            border-color:var(--hs-primary) !important;
            box-shadow:0 0 0 .2rem rgba(255,64,64,.12) !important;
            outline:none;
        }
        .fs-6.fw-bold, label.required { font-size:.83rem !important; color:#374151 !important; font-weight:600 !important; margin-bottom:.4rem !important; }
        .required:after { color:var(--hs-primary) !important; }

        /* Buttons */
        .btn { border-radius:9px !important; font-weight:600; transition:all .15s; }
        .btn-lg { padding:.65rem 1.6rem !important; font-size:.95rem !important; }
        .btn-primary {
            background:var(--hs-gradient) !important;
            border:0 !important;
            box-shadow:0 4px 14px -4px rgba(255,64,64,.45);
        }
        .btn-primary:hover { filter:brightness(.96); transform:translateY(-1px); box-shadow:0 6px 18px -4px rgba(255,64,64,.55); }
        .btn-outline-primary { color:var(--hs-primary) !important; border:1.5px solid var(--hs-primary) !important; background:#fff !important; }
        .btn-outline-primary:hover { background:var(--hs-primary) !important; color:#fff !important; }
        .btn-success { background:#16a34a !important; border:0 !important; box-shadow:0 4px 14px -4px rgba(22,163,74,.45); }

        /* Action footer bar */
        .fr-actions {
            position:sticky; bottom:0; z-index:5;
            background:#fff; border:1px solid #eef0f5;
            border-radius:14px; padding:.9rem 1.1rem; margin-top:1.5rem;
            box-shadow:0 -2px 14px rgba(20,30,60,.05);
            display:flex; align-items:center; justify-content:space-between; gap:.75rem; flex-wrap:wrap;
        }
        .fr-actions .hint { color:var(--hs-muted); font-size:.82rem; display:flex; align-items:center; gap:.4rem; }
        .fr-actions .hint i { color:var(--hs-primary); }
        .fr-actions .btn-grp { display:flex; gap:.5rem; align-items:center; }

        /* Tables (offers) */
        .table-responsive { border:1px solid #eef0f5; }
        .table thead th { background:#fafbff !important; font-size:.78rem; text-transform:uppercase; letter-spacing:.04em; color:var(--hs-muted); border-bottom:1px solid #eef0f5; }
        .offer-row.selected { background:var(--hs-primary-light) !important; border-{{ $isRtl ?? true ? 'right' : 'left' }}:4px solid var(--hs-primary) !important; }
        .offer-row:hover { background:#fafbff !important; }

        /* Alert restyle */
        .alert.alert-danger {
            background:#fef2f2 !important; color:#991b1b !important; border:1px solid #fecaca !important;
            border-radius:10px; padding:1rem 1.15rem;
        }
        .alert.alert-danger ul { padding-{{ $isRtl ?? true ? 'right' : 'left' }}:1.2rem; margin:0; }

        @media (max-width:768px) {
            .fr-page-head { padding:1.15rem 1.25rem; }
            .fr-page-head h1 { font-size:1.15rem; }
            .stepper.stepper-links { padding:24px 16px !important; }
            .fr-actions { flex-direction:column; align-items:stretch; }
            .fr-actions .btn-grp { justify-content:space-between; }
            .fr-actions .btn { flex:1; }
        }
    </style>
@endpush

@php
    $saCities = ['الرياض','جدة','مكة المكرمة','المدينة المنورة','الدمام','الخبر','الظهران','الطائف','تبوك','بريدة','عنيزة','خميس مشيط','حائل','نجران','الجبيل','ينبع','أبها','عرعر','سكاكا','القطيف','الأحساء','جيزان','الباحة','رابغ','حفر الباطن','الخرج'];
    $legalForms = ['مؤسسة فردية','شركة ذات مسؤولية محدودة','شركة مساهمة','شركة مساهمة مبسطة','شركة تضامن','شركة توصية بسيطة','شركة شخص واحد'];
@endphp
@section('content')
<div class="fr-page">

    <div class="fr-page-head">
        <div>
            <h1><i class="fa-solid fa-file-signature" style="margin-{{ $isRtl ?? true ? 'left' : 'right' }}:.5rem;"></i>{{ ln('New Financing Request', 'طلب تمويل جديد') }}</h1>
            <p>{{ ln('Complete the steps below to submit your application.', 'أكمل الخطوات التالية لتقديم طلبك بسهولة.') }}</p>
        </div>
        <div class="badge-step" id="fr_head_badge"><i class="fa-regular fa-circle-dot"></i> {{ ln('Step', 'المرحلة') }} <span id="fr_head_step">1</span> / 5</div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> {{ ln('Please fix the following:', 'الرجاء تصحيح الأخطاء التالية:') }}</strong>
            <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('client.financing-request.store') }}" method="POST" enctype="multipart/form-data" id="kt_financing_form" class="form" novalidate>
        @csrf

        <div class="card">
            <div class="card-header">
                <div class="card-title"><h2>{{ ln('Client Financing Request Form', 'نموذج طلب التمويل للعميل') }}</h2></div>
            </div>

            <div class="card-body">
                <div class="stepper stepper-links d-flex flex-column" id="kt_financing_stepper" data-kt-stepper="true" data-kt-stepper-clickable="false">

                    @php
                        $steps = [
                            1 => ['label_en' => 'STEP 1', 'label_ar' => 'المرحلة الأولى',  'title_en' => 'Business Information', 'title_ar' => 'معلومات العمل'],
                            2 => ['label_en' => 'STEP 2', 'label_ar' => 'المرحلة الثانية', 'title_en' => 'Required Documents',   'title_ar' => 'المستندات المطلوبة'],
                            3 => ['label_en' => 'STEP 3', 'label_ar' => 'المرحلة الثالثة', 'title_en' => 'Financing Guarantee',  'title_ar' => 'ضمان التمويل'],
                            4 => ['label_en' => 'STEP 4', 'label_ar' => 'المرحلة الرابعة', 'title_en' => 'Review Request',       'title_ar' => 'مراجعة الطلب'],
                            5 => ['label_en' => 'STEP 5', 'label_ar' => 'المرحلة الخامسة', 'title_en' => 'Choose Offer',         'title_ar' => 'اختر العرض'],
                        ];
                    @endphp

                    <div class="stepper-nav-wrapper mb-10">
                        <div class="stepper-nav">
                            @foreach ($steps as $index => $step)
                                <div class="stepper-item-wrapper">
                                    <div class="stepper-item {{ $index === 1 ? 'current' : '' }}" data-kt-stepper-element="nav">
                                        <div class="stepper-circle">
                                            <span class="stepper-number">{{ $index }}</span>
                                            <span class="stepper-check">✓</span>
                                        </div>
                                        <div class="stepper-label">
                                            <div class="stepper-step">{{ ln($step['label_en'], $step['label_ar']) }}</div>
                                            <h3 class="stepper-title">{{ ln($step['title_en'], $step['title_ar']) }}</h3>
                                            <div class="stepper-status">{{ $index === 1 ? ln('In Progress', 'قيد التنفيذ') : ln('Pending', 'معلق') }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if ($index < count($steps))
                                    <div class="stepper-line-wrapper"><div class="stepper-line"></div></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="mx-auto w-100" style="max-width: 1000px;">

                        {{-- STEP 1 --}}
                        <div class="current" data-kt-stepper-element="content">
                            <div class="row g-9">
                                <div class="col-12 fv-row">
                                    <div class="card card-flush">
                                        <div class="card-header pt-7"><h3 class="card-title">{{ ln('Business Information', 'معلومات العمل') }}</h3></div>
                                        <div class="card-body pt-6">
                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Product', 'المنتج') }}</label>
                                                    <select class="form-select form-select-solid" name="product_id" id="product_id" required>
                                                        <option value="">{{ ln('Select Product', 'اختر المنتج') }}</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product['id'] }}" data-subproducts="{{ json_encode($product['sub_products'] ?? []) }}">
                                                                {{ ln($product['name'], $product['name_ar']) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Sub-Product', 'المنتج الفرعي') }}</label>
                                                    <select class="form-select form-select-solid" name="sub_product_id" id="sub_product_id" required disabled>
                                                        <option value="">{{ ln('Select Sub-Product', 'اختر المنتج الفرعي') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('National ID', 'رقم الهوية') }}</label>
                                                    <input type="text" inputmode="numeric" pattern="\d{10}" minlength="10" maxlength="10" class="form-control form-control-solid" name="national_id" value="{{ old('national_id', $user->national_id ?? '') }}" required title="{{ ln('National ID must be exactly 10 digits','رقم الهوية يجب أن يكون 10 أرقام بالضبط') }}" />
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Street Name', 'اسم الشارع') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="street_name" value="{{ old('street_name') }}" required />
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('City', 'المدينة') }}</label>
                                                    <select class="form-select form-select-solid" name="city" required>
                                                        <option value="">{{ ln('Select City','اختر المدينة') }}</option>
                                                        @foreach ($saCities as $c)
                                                            <option value="{{ $c }}" {{ old('city')===$c ? 'selected' : '' }}>{{ $c }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Postal Code', 'الرمز البريدي') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="postal_code" value="{{ old('postal_code') }}" required />
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('District Name', 'اسم الحي') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="district_name" value="{{ old('district_name') }}" required />
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Additional Code', 'الرمز الإضافي') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="additional_code" value="{{ old('additional_code') }}" required />
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Location Description', 'وصف الموقع') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="location_description" value="{{ old('location_description') }}" required />
                                                </div>
                                            </div>

                                            <hr class="my-10">
                                            <h4 class="fw-bolder mb-7">{{ ln('Contact Information', 'معلومات الاتصال') }}</h4>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Mobile 1', 'جوال 1') }}</label>
                                                    <input type="tel" class="form-control form-control-solid" name="mobile_1" value="{{ old('mobile_1', $user->phone ?? '') }}" required />
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="fs-6 fw-bold mb-2">{{ ln('Mobile 2', 'جوال 2') }}</label>
                                                    <input type="tel" class="form-control form-control-solid" name="mobile_2" value="{{ old('mobile_2') }}" />
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-12 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Contact Email', 'بريد التواصل') }}</label>
                                                    <input type="email" class="form-control form-control-solid" name="category_1" value="{{ old('category_1', $user->email ?? '') }}" required />
                                                </div>
                                            </div>

                                            <hr class="my-10">
                                            <h4 class="fw-bolder mb-7">{{ ln('Commercial Registration', 'معلومات السجل التجاري') }}</h4>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-12 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Legal Form', 'الشكل القانوني') }}</label>
                                                    <select class="form-select form-select-solid" name="legal_form" required>
                                                        <option value="">{{ ln('Select Legal Form','اختر الشكل القانوني') }}</option>
                                                        @foreach ($legalForms as $lf)
                                                            <option value="{{ $lf }}" {{ old('legal_form')===$lf ? 'selected' : '' }}>{{ $lf }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Commercial Name', 'الاسم التجاري') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="commercial_name" value="{{ old('commercial_name') }}" required />
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Commercial Registration Number', 'رقم السجل التجاري') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="commercial_registration" value="{{ old('commercial_registration') }}" required />
                                                </div>
                                            </div>

                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('City', 'المدينة') }}</label>
                                                    <select class="form-select form-select-solid" name="city_2" required>
                                                        <option value="">{{ ln('Select City','اختر المدينة') }}</option>
                                                        @foreach ($saCities as $c)
                                                            <option value="{{ $c }}" {{ old('city_2')===$c ? 'selected' : '' }}>{{ $c }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('License Expiry Date', 'تاريخ انتهاء السجل التجاري') }}</label>
                                                    <input type="text" class="form-control form-control-solid datepicker" name="license_expiry_date_hijri" value="{{ old('license_expiry_date_hijri') }}" placeholder="dd/mm/yyyy" required />
                                                </div>
                                            </div>

                                            <div class="mb-7 fv-row">
                                                <label class="required fs-6 fw-bold mb-2">{{ ln('Establishment Date (Hijri)', 'تاريخ السجل التجاري (هجري)') }}</label>
                                                <input type="text" class="form-control form-control-solid datepicker" name="establishment_date_hijri" value="{{ old('establishment_date_hijri') }}" placeholder="dd/mm/yyyy" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 fv-row">
                                    <div class="card card-flush">
                                        <div class="card-header pt-7"><h3 class="card-title">{{ ln('Company Owner Information', 'معلومات صاحب الشركة') }}</h3></div>
                                        <div class="card-body pt-6">
                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Owner Name', 'اسم المالك') }}</label>
                                                    <input type="text" class="form-control form-control-solid" name="owner_name" value="{{ old('owner_name', $user->name ?? '') }}" required />
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('ID Card Number', 'رقم بطاقة الهوية') }}</label>
                                                    <input type="text" inputmode="numeric" pattern="\d{10}" minlength="10" maxlength="10" class="form-control form-control-solid" name="owner_id_number" value="{{ old('owner_id_number', $user->national_id ?? '') }}" required title="{{ ln('ID must be exactly 10 digits','رقم الهوية يجب أن يكون 10 أرقام بالضبط') }}" />
                                                </div>
                                            </div>
                                            <div class="row g-9 mb-7">
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Nationality', 'الجنسية') }}</label>
                                                    <select class="form-select form-select-solid" name="nationality" required>
                                                        <option value="">{{ ln('Select Nationality','اختر الجنسية') }}</option>
                                                        <option value="سعودي"      {{ old('nationality')==='سعودي' ? 'selected' : '' }}>{{ ln('Saudi','سعودي') }}</option>
                                                        <option value="غير سعودي" {{ old('nationality')==='غير سعودي' ? 'selected' : '' }}>{{ ln('Non-Saudi','غير سعودي') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Date of Birth', 'تاريخ الميلاد') }}</label>
                                                    <input type="text" class="form-control form-control-solid datepicker" name="birth_date" value="{{ old('birth_date') }}" placeholder="dd/mm/yyyy" required />
                                                </div>
                                            </div>
                                            <div class="row g-9 mb-7">
                                                <div class="col-md-12 fv-row">
                                                    <label class="required fs-6 fw-bold mb-2">{{ ln('Mobile Number (without zero)', 'رقم الجوال') }}</label>
                                                    <input type="tel" class="form-control form-control-solid" name="mobile_without_zero" value="{{ old('mobile_without_zero', ltrim($user->phone ?? '', '0')) }}" required />
                                                </div>
                                            </div>
                                            <div class="mb-7 fv-row">
                                                <label class="required fs-6 fw-bold mb-2">{{ ln('ID Card Expiry Date', 'تاريخ انتهاء بطاقة الهوية') }}</label>
                                                <input type="text" class="form-control form-control-solid datepicker" name="id_expiry_date" value="{{ old('id_expiry_date') }}" placeholder="dd/mm/yyyy" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- STEP 2 --}}
                        <div data-kt-stepper-element="content">
                            @include('client.financing-request.file_documents')
                        </div>

                        {{-- STEP 3 --}}
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10"><h2 class="fw-bolder">{{ ln('Financing Guarantee', 'ضمان التمويل') }}</h2></div>
                                <div class="fv-row mb-10">
                                    <label class="form-label required">{{ ln('Guarantee Type', 'نوع الضمان') }}</label>
                                    <div class="text-muted fs-7 mb-5">{{ ln('You can select multiple guarantee types', 'يمكنك اختيار أكثر من نوع ضمان') }}</div>

                                    <div class="row g-5" id="guarantee_types_container">
                                        @foreach ([
                                            ['real_estate', 'guarantee_real_estate', ln('Real Estate', 'عقار')],
                                            ['stocks', 'guarantee_stocks', ln('Stocks', 'أسهم')],
                                            ['promissory_note', 'guarantee_promissory', ln('Promissory Note', 'سند لأمر')],
                                            ['cash_deposit', 'guarantee_cash', ln('Cash Deposit', 'وديعة نقدية')],
                                        ] as $g)
                                            <div class="col-md-6">
                                                <input type="checkbox" class="btn-check guarantee-type-checkbox" name="guarantee_types[]" value="{{ $g[0] }}" id="{{ $g[1] }}" />
                                                <label class="btn btn-outline-primary p-7 d-flex align-items-center h-100 w-100" for="{{ $g[1] }}">
                                                    <span class="fw-bolder fs-4">{{ $g[2] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="guarantee_details_container"></div>

                                <div class="fv-row mb-10">
                                    <label class="form-label">{{ ln('Coverage Percentage (optional)', 'نسبة تغطية الضمان (اختياري)') }}</label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" class="form-control form-control-solid" name="coverage_percentage" min="0" max="100" step="0.01" />
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- STEP 4 --}}
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10"><h2 class="fw-bolder">{{ ln('Review Your Request', 'مراجعة طلبك') }}</h2></div>
                                <div class="card card-flush">
                                    <div class="card-body">
                                        <div id="review_container">
                                            <div class="mb-8"><h4 class="fw-bolder mb-4">{{ ln('Business Information', 'معلومات العمل') }}</h4><div class="row g-6" id="review_business"></div></div>
                                            <hr class="my-10">
                                            <div class="mb-8"><h4 class="fw-bolder mb-4">{{ ln('Contact Information', 'معلومات الاتصال') }}</h4><div class="row g-6" id="review_contact"></div></div>
                                            <hr class="my-10">
                                            <div class="mb-8"><h4 class="fw-bolder mb-4">{{ ln('Commercial Registration', 'معلومات السجل التجاري') }}</h4><div class="row g-6" id="review_cr"></div></div>
                                            <hr class="my-10">
                                            <div class="mb-8"><h4 class="fw-bolder mb-4">{{ ln('Owner Information', 'معلومات المالك') }}</h4><div class="row g-6" id="review_owner"></div></div>
                                            <hr class="my-10">
                                            <div class="mb-8"><h4 class="fw-bolder mb-4">{{ ln('Uploaded Documents', 'الملفات المرفوعة') }}</h4><div id="review_docs"></div></div>
                                            <hr class="my-10">
                                            <div class="mb-0"><h4 class="fw-bolder mb-4">{{ ln('Financing Guarantee', 'ضمان التمويل') }}</h4><div id="review_guarantee"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-primary mt-8">
                                    {{ ln('If you need to edit anything, click Previous to go back and update your data.', 'إذا احتجت تعديل أي بيانات اضغط "السابق" للرجوع والتعديل.') }}
                                </div>
                            </div>
                        </div>

                        {{-- STEP 5 --}}
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10"><h2 class="fw-bolder">{{ ln('Choose Your Financing Offer', 'اختر عرض التمويل المناسب') }}</h2></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>{{ ln('Select', 'اختر') }}</th>
                                                <th>{{ ln('Bank', 'البنك') }}</th>
                                                <th>{{ ln('Annual Rate', 'المعدل السنوي') }}</th>
                                                <th>{{ ln('Tenure (Months)', 'المدة (شهر)') }}</th>
                                                <th>{{ ln('Monthly Installment', 'القسط الشهري') }}</th>
                                                <th>{{ ln('Financing Amount', 'مبلغ التمويل') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="offer-row" data-offer-id="1">
                                                <td><input class="form-check-input offer-radio" type="radio" name="selected_offer_id" value="1" required /></td>
                                                <td>Riyad Bank</td>
                                                <td>1.79%</td>
                                                <td>60</td>
                                                <td>1,987.39</td>
                                                <td>91,230.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="fr-actions">
                        <div class="hint">
                            <i class="fa-solid fa-shield-halved"></i>
                            {{ ln('Your data is encrypted and shared only with the chosen lender.', 'بياناتك مشفّرة ولا تُرسل إلا للممول المختار.') }}
                        </div>
                        <div class="btn-grp">
                            <button type="button" class="btn btn-lg btn-outline-primary" data-kt-stepper-action="previous">
                                <i class="fa-solid fa-arrow-{{ $isRtl ?? true ? 'right' : 'left' }}"></i>
                                {{ ln('Previous', 'السابق') }}
                            </button>
                            <button type="submit" id="submit_hint" class="btn btn-lg btn-primary d-none">{{ ln('Submit your request now', 'إرسال طلبك الآن') }}</button>
                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next" id="kt_stepper_next">
                                {{ ln('Continue', 'متابعة') }}
                                <i class="fa-solid fa-arrow-{{ $isRtl ?? true ? 'left' : 'right' }}"></i>
                            </button>
                            <button type="submit" class="btn btn-lg btn-success d-none" data-kt-stepper-action="submit" id="kt_financing_submit">
                                <i class="fa-solid fa-paper-plane"></i> {{ ln('Submit Request', 'إرسال الطلب') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
"use strict";

// Minimal KTStepper polyfill for plain Bootstrap project (Metronic-compatible)
class KTStepper {
    constructor(el) {
        this.el = el;
        this.currentIndex = 1;
        this.events = {};
        this.contents = el.querySelectorAll('[data-kt-stepper-element="content"]');
        this.totalSteps = this.contents.length;
        this._render();
    }
    on(name, cb) { (this.events[name] = this.events[name] || []).push(cb); }
    _emit(name) { (this.events[name] || []).forEach(cb => cb(this)); }
    getCurrentStepIndex() { return this.currentIndex; }
    getTotalStepsNumber() { return this.totalSteps; }
    _render() {
        this.contents.forEach((c, i) => c.classList.toggle('current', (i + 1) === this.currentIndex));
    }
    goNext() { if (this.currentIndex < this.totalSteps) { this.currentIndex++; this._render(); } }
    goPrevious() { if (this.currentIndex > 1) { this.currentIndex--; this._render(); } }
}

document.addEventListener("DOMContentLoaded", function () {
    const stepperEl = document.querySelector("#kt_financing_stepper");
    const form = document.getElementById("kt_financing_form");
    const stepper = new KTStepper(stepperEl);

    stepperEl.querySelectorAll('[data-kt-stepper-element="nav"]').forEach(nav => {
        nav.style.cursor = "default";
        nav.addEventListener("click", e => { e.preventDefault(); e.stopPropagation(); }, true);
    });

    const guaranteeCheckboxes = document.querySelectorAll(".guarantee-type-checkbox");
    const guaranteeDetailsContainer = document.getElementById("guarantee_details_container");
    const productSelect = document.getElementById("product_id");
    const subProductSelect = document.getElementById("sub_product_id");
    const docsWrapper = document.getElementById("required_documents_wrapper");
    const isArabic = (document.documentElement.getAttribute('dir') === 'rtl') || ("{{ app()->getLocale() }}" === "ar");
    const nextBtn = document.getElementById("kt_stepper_next");
    const submitBtn = document.getElementById("kt_financing_submit");
    const submitHint = document.getElementById("submit_hint");

    function updateActionButtons(stepIndex) {
        if (stepIndex === 5) {
            nextBtn?.classList.add("d-none");
            submitBtn?.classList.remove("d-none");
            submitHint?.classList.remove("d-none");
        } else {
            nextBtn?.classList.remove("d-none");
            submitBtn?.classList.add("d-none");
            submitHint?.classList.add("d-none");
        }
    }

    function updateStepperUI(activeStep) {
        const steps = stepperEl.querySelectorAll('[data-kt-stepper-element="nav"]');
        steps.forEach((s, i) => {
            const n = i + 1;
            const status = s.querySelector(".stepper-status");
            s.classList.remove("current", "completed");
            if (n < activeStep) { s.classList.add("completed"); status.textContent = isArabic ? "مكتمل" : "Completed"; }
            else if (n === activeStep) { s.classList.add("current"); status.textContent = isArabic ? "قيد التنفيذ" : "In Progress"; }
            else { status.textContent = isArabic ? "معلق" : "Pending"; }
        });
        updateActionButtons(activeStep);
        var headStep = document.getElementById('fr_head_step');
        if (headStep) headStep.textContent = activeStep;
    }
    updateStepperUI(stepper.getCurrentStepIndex());

    function switchDocuments(subProductId) {
        if (!docsWrapper) return;
        const blocks = docsWrapper.querySelectorAll('.docs-block');
        blocks.forEach(b => {
            b.classList.add('d-none');
            b.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);
        });
        let target;
        if (!subProductId) target = docsWrapper.querySelector('.docs-block[data-subproduct="none"]');
        else {
            target = docsWrapper.querySelector('.docs-block[data-subproduct="' + subProductId + '"]');
            if (!target) target = docsWrapper.querySelector('.docs-block[data-subproduct="default"]');
        }
        if (target) {
            target.classList.remove('d-none');
            target.querySelectorAll('input, select, textarea').forEach(el => el.disabled = false);
        }
    }
    switchDocuments(null);

    function updateGuaranteeDetails() {
        let html = "";
        const types = [...guaranteeCheckboxes].filter(x => x.checked).map(x => x.value);
        types.forEach(type => {
            if (type === "real_estate") {
                html += `<div class="mb-8"><h4 class="fw-bold mb-5">${isArabic ? "تفاصيل العقار" : "Real Estate Details"}</h4>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "نوع العقار" : "Real Estate Type"}</label>
                        <select name="real_estate_type" class="form-select form-select-solid" required>
                            <option value="">${isArabic ? "اختر النوع" : "Select Type"}</option>
                            <option value="land">${isArabic ? "أرض" : "Land"}</option>
                            <option value="commercial">${isArabic ? "تجاري" : "Commercial"}</option>
                            <option value="commercial_residential">${isArabic ? "تجاري/سكني" : "Commercial/Residential"}</option>
                        </select></div>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "قيمة العقار (القيمة السوقية)" : "Property Value (Market Value)"}</label>
                        <div class="input-group"><input type="number" name="property_value" class="form-control form-control-solid" required /><span class="input-group-text">${isArabic ? "ريال" : "SAR"}</span></div>
                        <div class="text-muted small mt-1">${isArabic ? "أدخل القيمة السوقية للعقار" : "Enter the market value of the property"}</div>
                    </div></div>`;
            } else if (type === "stocks") {
                html += `<div class="mb-8"><h4 class="fw-bold mb-5">${isArabic ? "تفاصيل الأسهم" : "Stocks Details"}</h4>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "عدد الأسهم" : "Number of Shares"}</label>
                        <input type="number" class="form-control form-control-solid" name="number_of_shares" required /></div>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "قيمة الأسهم" : "Share Value"}</label>
                        <div class="input-group"><input type="number" name="share_value" class="form-control form-control-solid" required /><span class="input-group-text">${isArabic ? "ريال" : "SAR"}</span></div></div></div>`;
            } else if (type === "promissory_note") {
                html += `<div class="mb-8"><h4 class="fw-bold mb-5">${isArabic ? "تفاصيل السند" : "Promissory Note"}</h4>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "قيمة السند" : "Note Value"}</label>
                        <div class="input-group"><input type="number" name="promissory_note_value" class="form-control form-control-solid" required /><span class="input-group-text">${isArabic ? "ريال" : "SAR"}</span></div></div>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "مرفق السند" : "Promissory Note Attachment"}</label>
                        <input type="file" name="promissory_note_file" class="form-control form-control-solid" accept=".jpg,.jpeg,.png,.pdf" required /></div></div>`;
            } else if (type === "cash_deposit") {
                html += `<div class="mb-8"><h4 class="fw-bold mb-5">${isArabic ? "تفاصيل الوديعة" : "Cash Deposit"}</h4>
                    <div class="fv-row mb-10"><label class="required form-label">${isArabic ? "قيمة الوديعة" : "Deposit Value"}</label>
                        <div class="input-group"><input type="number" name="cash_deposit_value" class="form-control form-control-solid" required /><span class="input-group-text">${isArabic ? "ريال" : "SAR"}</span></div></div></div>`;
            }
        });
        guaranteeDetailsContainer.innerHTML = html;
    }
    guaranteeCheckboxes.forEach(c => c.addEventListener("change", updateGuaranteeDetails));

    function showError(input, message) {
        input.classList.add("is-invalid");
        const parent = input.closest(".fv-row") || input.parentElement;
        if (!parent || parent.querySelector(".invalid-feedback")) return;
        const err = document.createElement("div");
        err.className = "invalid-feedback d-block"; err.innerHTML = message;
        parent.appendChild(err);
    }
    function clearErrors(scope) {
        (scope || form).querySelectorAll(".invalid-feedback").forEach(e => e.remove());
        (scope || form).querySelectorAll(".is-invalid").forEach(i => i.classList.remove("is-invalid"));
    }
    function isEmpty(el) {
        if (!el || el.disabled) return true;
        if (el.type === "checkbox" || el.type === "radio") return !el.checked;
        if (el.type === "file") return !(el.files && el.files.length);
        return (el.value ?? "").toString().trim() === "";
    }

    function validateStep(stepIndex) {
        const sections = stepperEl.querySelectorAll('[data-kt-stepper-element="content"]');
        const currentSection = sections[stepIndex - 1];
        if (!currentSection) return true;
        currentSection.querySelectorAll(".alert.alert-danger.__step_alert").forEach(a => a.remove());
        clearErrors(currentSection);
        let ok = true;
        currentSection.querySelectorAll("input, select, textarea").forEach(el => {
            if (el.closest(".d-none")) return;
            if (el.hasAttribute("required") && !el.disabled && isEmpty(el)) {
                ok = false;
                showError(el, isArabic ? "هذا الحقل مطلوب" : "This field is required");
            }
        });
        if (stepIndex === 3) {
            const anyChecked = [...guaranteeCheckboxes].some(x => x.checked);
            if (!anyChecked) {
                ok = false;
                const container = document.getElementById("guarantee_types_container");
                const msg = document.createElement("div");
                msg.className = "alert alert-danger py-3 mb-5 __step_alert";
                msg.innerHTML = isArabic ? "اختر نوع ضمان واحد على الأقل" : "Select at least one guarantee type";
                container.parentElement.insertBefore(msg, container);
            }
        }
        if (stepIndex === 5) {
            const selected = form.querySelector('input[name="selected_offer_id"]:checked');
            if (!selected) {
                ok = false;
                const table = currentSection.querySelector("table");
                if (table) {
                    const msg = document.createElement("div");
                    msg.className = "alert alert-danger py-3 mt-5 __step_alert";
                    msg.innerHTML = isArabic ? "من فضلك اختر عرض تمويل" : "Please select an offer";
                    table.parentElement.appendChild(msg);
                }
            }
        }
        const firstInvalid = currentSection.querySelector(".is-invalid");
        if (firstInvalid) firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
        return ok;
    }

    function safeVal(selector, fallback = "-") {
        const el = form.querySelector(selector);
        if (!el) return fallback;
        if (el.type === "file") return el.files?.length ? el.files[0].name : fallback;
        if (el.tagName === "SELECT") {
            const opt = el.options[el.selectedIndex];
            return opt ? (opt.textContent || fallback).trim() : fallback;
        }
        return (el.value && el.value.toString().trim() !== "") ? el.value.toString().trim() : fallback;
    }
    function reviewItem(label, value) {
        return `<div class="col-md-6"><div class="p-3 bg-light rounded"><div class="text-muted small mb-1">${label}</div><div class="fw-semibold">${value}</div></div></div>`;
    }
    function buildReview() {
        const business = document.getElementById("review_business");
        if (business) business.innerHTML = [
            reviewItem(isArabic ? "المنتج" : "Product", safeVal('[name="product_id"]')),
            reviewItem(isArabic ? "المنتج الفرعي" : "Sub-Product", safeVal('[name="sub_product_id"]')),
            reviewItem(isArabic ? "رقم الهوية" : "National ID", safeVal('[name="national_id"]')),
            reviewItem(isArabic ? "اسم الشارع" : "Street Name", safeVal('[name="street_name"]')),
            reviewItem(isArabic ? "المدينة" : "City", safeVal('[name="city"]')),
            reviewItem(isArabic ? "الرمز البريدي" : "Postal Code", safeVal('[name="postal_code"]')),
            reviewItem(isArabic ? "اسم الحي" : "District", safeVal('[name="district_name"]')),
        ].join("");
        const contact = document.getElementById("review_contact");
        if (contact) contact.innerHTML = [
            reviewItem(isArabic ? "جوال 1" : "Mobile 1", safeVal('[name="mobile_1"]')),
            reviewItem(isArabic ? "البريد" : "Email", safeVal('[name="category_1"]')),
        ].join("");
        const cr = document.getElementById("review_cr");
        if (cr) cr.innerHTML = [
            reviewItem(isArabic ? "الشكل القانوني" : "Legal Form", safeVal('[name="legal_form"]')),
            reviewItem(isArabic ? "الاسم التجاري" : "Commercial Name", safeVal('[name="commercial_name"]')),
            reviewItem(isArabic ? "السجل التجاري" : "Commercial Reg", safeVal('[name="commercial_registration"]')),
        ].join("");
        const owner = document.getElementById("review_owner");
        if (owner) owner.innerHTML = [
            reviewItem(isArabic ? "اسم المالك" : "Owner Name", safeVal('[name="owner_name"]')),
            reviewItem(isArabic ? "رقم الهوية" : "ID", safeVal('[name="owner_id_number"]')),
            reviewItem(isArabic ? "الجنسية" : "Nationality", safeVal('[name="nationality"]')),
        ].join("");
        const docs = document.getElementById("review_docs");
        if (docs && docsWrapper) {
            const visibleBlock = docsWrapper.querySelector('.docs-block:not(.d-none)');
            if (!visibleBlock) docs.innerHTML = `<div class="text-muted">${isArabic ? "لا توجد ملفات" : "No documents"}</div>`;
            else {
                const files = [...visibleBlock.querySelectorAll('input[type="file"]:not([disabled])')].map(inp => {
                    const label = inp.closest('tr')?.querySelector('.fw-bold')?.textContent?.trim() || inp.name;
                    const name = inp.files?.length ? inp.files[0].name : (isArabic ? "لم يُرفع" : "Not uploaded");
                    return `<div class="d-flex justify-content-between border-bottom py-2"><span class="fw-semibold">${label}</span><span class="text-muted">${name}</span></div>`;
                });
                docs.innerHTML = files.length ? files.join("") : `<div class="text-muted">${isArabic ? "لا توجد ملفات" : "No files"}</div>`;
            }
        }
        const g = document.getElementById("review_guarantee");
        if (g) {
            const types = [...guaranteeCheckboxes].filter(x => x.checked).map(x => x.value);
            const typesText = types.length ? types.join(", ") : (isArabic ? "غير محدد" : "None");
            const coverage = safeVal('[name="coverage_percentage"]', "-");
            g.innerHTML = `<div><span class="fw-semibold">${isArabic ? "أنواع الضمان:" : "Types:"}</span> ${typesText}</div><div><span class="fw-semibold">${isArabic ? "نسبة التغطية:" : "Coverage:"}</span> ${coverage}%</div>`;
        }
    }

    nextBtn?.addEventListener("click", async function (e) {
        e.preventDefault();
        const stepIndex = stepper.getCurrentStepIndex();
        if (!validateStep(stepIndex)) return;

        if (stepIndex === 1 && subProductSelect) switchDocuments(subProductSelect.value);

        if (stepIndex === 4) {
            buildReview();
            try {
                const fd = new FormData(form);
                const res = await fetch("{{ route('client.financing-request.store_and_pay') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: fd
                });
                const data = await res.json();
                if (data?.redirect) { window.location.href = data.redirect; return; }
                alert(isArabic ? "حدث خطأ أثناء بدء الدفع" : "Payment initialization failed");
                return;
            } catch (err) {
                console.error(err);
                alert(isArabic ? "حدث خطأ غير متوقع" : "Unexpected error");
                return;
            }
        }

        stepper.goNext();
        updateStepperUI(stepper.getCurrentStepIndex());
        if (stepper.getCurrentStepIndex() === 4) buildReview();
    });

    document.querySelector('[data-kt-stepper-action="previous"]')?.addEventListener("click", function () {
        stepper.goPrevious();
        updateStepperUI(stepper.getCurrentStepIndex());
        if (stepper.getCurrentStepIndex() === 4) buildReview();
    });

    if (productSelect && subProductSelect) {
        productSelect.addEventListener("change", function () {
            const data = this.options[this.selectedIndex].getAttribute("data-subproducts");
            subProductSelect.innerHTML = `<option value="">${isArabic ? "اختر المنتج الفرعي" : "Select Sub-Product"}</option>`;
            if (!data) { subProductSelect.disabled = true; switchDocuments(null); return; }
            try {
                const subs = JSON.parse(data);
                if (!subs.length) { subProductSelect.disabled = true; switchDocuments(null); return; }
                subProductSelect.disabled = false;
                subs.forEach(sp => {
                    const opt = document.createElement("option");
                    opt.value = sp.id;
                    opt.textContent = isArabic ? (sp.name_ar || sp.name) : (sp.name || sp.name_ar);
                    subProductSelect.appendChild(opt);
                });
                switchDocuments(null);
            } catch (e) { console.error(e); subProductSelect.disabled = true; switchDocuments(null); }
        });
        subProductSelect.addEventListener('change', function () { switchDocuments(this.value); });
    }

    flatpickr(".datepicker", { dateFormat: "d/m/Y", allowInput: true });

    document.querySelectorAll(".offer-row").forEach(row => {
        row.addEventListener("click", function () {
            row.querySelector(".offer-radio").checked = true;
            document.querySelectorAll(".offer-row").forEach(r => r.classList.remove("selected"));
            row.classList.add("selected");
        });
    });

    submitBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        if (!validateStep(5)) return;
        if (!validateStep(3)) return;
        form.submit();
    });

    updateActionButtons(stepper.getCurrentStepIndex());
});

function previewFile(input, previewId, checkId) {
    const file = input.files[0];
    const previewBox = document.getElementById(previewId);
    const checkMark = document.getElementById(checkId);
    if (!file || !previewBox || !checkMark) return;
    previewBox.innerHTML = "";
    if (file.type.includes("image")) {
        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.style.cssText = "width:60px;height:60px;object-fit:cover;border-radius:6px;border:1px solid #ddd;";
        previewBox.appendChild(img);
    } else if (file.type === "application/pdf") {
        previewBox.innerHTML = `<i class="fa-solid fa-file-pdf" style="color:#dc3545;font-size:32px;"></i>`;
    } else {
        previewBox.innerHTML = `<span>${file.name}</span>`;
    }
    checkMark.innerHTML = "✔";
    checkMark.style.cssText = "color:green;font-size:22px;font-weight:bold;";
}
</script>
@endpush
