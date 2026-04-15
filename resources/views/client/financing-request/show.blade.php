@extends('layouts.client')

@include('client.financing-request._home_theme')

@section('title', ln('Financing Request Details', 'تفاصيل طلب التمويل'))
@section('page_title', ln('Request', 'طلب') . ' #' . ($financingRequest->request_number ?? $financingRequest->id))

@php
    $fr = $financingRequest;

    $statusMap = [
        'new'        => ['#e0e7ff', '#4338ca', 'fa-clock',         ln('New', 'جديد')],
        'pending'    => ['#fef3c7', '#a16207', 'fa-hourglass-half', ln('Pending', 'قيد الانتظار')],
        'reviewing'  => ['#fef3c7', '#a16207', 'fa-magnifying-glass', ln('Under Review', 'قيد المراجعة')],
        'approved'   => ['#dcfce7', '#166534', 'fa-circle-check',  ln('Approved', 'موافق')],
        'rejected'   => ['#fee2e2', '#991b1b', 'fa-circle-xmark',  ln('Rejected', 'مرفوض')],
        'completed'  => ['#dbeafe', '#1d4ed8', 'fa-flag-checkered',ln('Completed', 'مكتمل')],
    ];
    [$sBg, $sFg, $sIcon, $sLabel] = $statusMap[$fr->status] ?? ['#f3f4f6', '#4b5563', 'fa-circle-info', ucfirst((string)$fr->status)];

    $fileFields = [
        'commercial_registration_doc' => ln('Commercial Registration', 'السجل التجاري'),
        'financial_statements'        => ln('Financial Statements', 'القوائم المالية'),
        'bank_statement'              => ln('Bank Statement', 'كشف الحساب البنكي'),
        'zakat_certificate'           => ln('Zakat Certificate', 'شهادة الزكاة'),
        'vat_certificate'             => ln('VAT Certificate', 'شهادة ض.ق.م'),
        'national_address_certificate'=> ln('National Address', 'العنوان الوطني'),
        'contract_file'               => ln('Contract File', 'ملف العقد'),
        'invoices_file'               => ln('Invoices File', 'الفواتير'),
        'promissory_note_file'        => ln('Promissory Note', 'سند لأمر'),
        'wc_bank_statement_file'         => ln('WC Bank Statement', 'كشف بنكي - ر.م.ع'),
        'wc_budget_last_3_years_file'    => ln('WC Budget 3y', 'ميزانية ٣ سنوات'),
        'wc_articles_of_association_file'=> ln('WC Articles', 'عقد التأسيس'),
        'wc_commercial_registration_file'=> ln('WC CR', 'السجل - ر.م.ع'),
        're_income_audited_fs_3y_file'   => ln('RE Income Audited FS', 'ميزانية مدققة'),
        're_income_bank_statement_12m_file' => ln('RE Income 12m Bank Stmt', 'كشف بنكي ١٢ شهر'),
        're_income_commercial_registration_file' => ln('RE Income CR', 'السجل التجاري'),
        're_income_articles_of_association_file' => ln('RE Income Articles', 'عقد التأسيس'),
        're_income_latest_valuation_file' => ln('RE Income Valuation', 'تقييم عقاري'),
        're_land_audited_fs_3y_file'      => ln('RE Land Audited FS', 'ميزانية مدققة'),
        're_land_bank_statement_12m_file' => ln('RE Land 12m Bank Stmt', 'كشف بنكي ١٢ شهر'),
        're_land_commercial_registration_file' => ln('RE Land CR', 'السجل التجاري'),
        're_land_articles_of_association_file' => ln('RE Land Articles', 'عقد التأسيس'),
        're_land_latest_valuation_file'   => ln('RE Land Valuation', 'تقييم عقاري'),
    ];

    $hasContact = $fr->mobile_1 || $fr->mobile_2 || $fr->phone_1 || $fr->phone_2 || $fr->category_1;
    $hasCommercial = $fr->legal_form || $fr->commercial_name || $fr->commercial_registration;
    $hasOwner = $fr->owner_name || $fr->owner_id_number || $fr->nationality;
    $hasGuarantee = !empty($fr->guarantee_type) || $fr->coverage_percentage || $fr->property_value || $fr->number_of_shares || $fr->promissory_note_value || $fr->cash_deposit_value;
    $docCount = collect($fileFields)->filter(fn ($l, $f) => !empty($fr->{$f}))->count();
@endphp

@push('styles')
<style>
    .fr-show { max-width: 1200px; margin: 0 auto; }

    .fr-hero {
        background: var(--c-gradient, linear-gradient(135deg, #FF4040 0%, #FF6B6B 100%));
        color: #fff; border-radius: 14px; padding: 1.5rem 1.75rem;
        display: flex; flex-wrap: wrap; gap: 1rem;
        align-items: center; justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .fr-hero .num { font-size: .85rem; opacity: .85; margin-bottom: .25rem; letter-spacing: .04em; }
    .fr-hero h2 { margin: 0 0 .35rem; font-size: 1.6rem; font-weight: 800; }
    .fr-hero .meta { font-size: .85rem; opacity: .9; }
    .fr-hero .meta i { margin: 0 .35rem; opacity: .8; }
    .fr-hero .actions { display: flex; gap: .5rem; flex-wrap: wrap; }
    .fr-hero .btn-w {
        background: rgba(255,255,255,.18); color: #fff;
        padding: .55rem 1rem; border-radius: 8px; font-weight: 600; font-size: .88rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
        border: 1px solid rgba(255,255,255,.35); transition: all .15s;
    }
    .fr-hero .btn-w:hover { background: rgba(255,255,255,.28); color: #fff; }
    .fr-hero .status-pill {
        display: inline-flex; align-items: center; gap: .45rem;
        background: #fff; padding: .45rem .9rem; border-radius: 999px;
        font-weight: 700; font-size: .85rem;
    }

    .fr-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.25rem; }
    .fr-summary .card-mini {
        background: #fff; border: 1px solid var(--c-border); border-radius: 12px;
        padding: 1rem 1.1rem; display: flex; align-items: center; gap: .85rem;
    }
    .fr-summary .ic {
        width: 44px; height: 44px; border-radius: 10px; display: grid; place-items: center;
        background: var(--c-primary-light, #FFEDED); color: var(--c-primary-dark, #D32F2F);
        font-size: 1.1rem;
    }
    .fr-summary .lbl { color: var(--c-muted); font-size: .78rem; margin-bottom: .15rem; }
    .fr-summary .val { font-weight: 800; font-size: 1.05rem; line-height: 1.1; }

    .fr-section { background: #fff; border: 1px solid var(--c-border); border-radius: 12px; margin-bottom: 1rem; overflow: hidden; }
    .fr-section .sec-head {
        display: flex; align-items: center; gap: .65rem;
        padding: .9rem 1.15rem; border-bottom: 1px solid var(--c-border);
        background: #fafbff;
    }
    .fr-section .sec-head .sh-ic {
        width: 32px; height: 32px; border-radius: 8px; display: grid; place-items: center;
        background: var(--c-primary-light, #FFEDED); color: var(--c-primary-dark, #D32F2F);
        font-size: .9rem;
    }
    .fr-section .sec-head h3 { margin: 0; font-size: .98rem; font-weight: 700; }
    .fr-section .sec-body { padding: 1.1rem 1.15rem; }

    .fr-grid {
        display: grid; gap: 0;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }
    .fr-cell {
        padding: .65rem .25rem; border-bottom: 1px dashed #eef0f5;
    }
    .fr-cell .k { color: var(--c-muted); font-size: .78rem; margin-bottom: .25rem; }
    .fr-cell .v { font-weight: 600; color: var(--c-text); font-size: .95rem; word-break: break-word; }
    .fr-cell .v.muted { color: #9ca3af; font-weight: 500; }

    .fr-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
    .fr-chip { background: var(--c-primary-light, #FFEDED); color: var(--c-primary-dark, #D32F2F);
        padding: .25rem .7rem; border-radius: 999px; font-size: .78rem; font-weight: 700; }

    .fr-docs { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: .75rem; }
    .fr-doc {
        display: flex; align-items: center; gap: .75rem;
        padding: .8rem .9rem; background: #fafbff; border: 1px solid var(--c-border);
        border-radius: 10px; text-decoration: none; color: var(--c-text);
        transition: all .15s;
    }
    .fr-doc:hover { background: #fff; border-color: var(--c-primary, #FF4040); transform: translateY(-1px); }
    .fr-doc .di { width: 38px; height: 38px; border-radius: 8px; display: grid; place-items: center;
        background: var(--c-primary-light, #FFEDED); color: var(--c-primary-dark, #D32F2F); font-size: 1rem; flex-shrink: 0; }
    .fr-doc .dn { font-weight: 600; font-size: .88rem; line-height: 1.25; }
    .fr-doc .ds { font-size: .75rem; color: var(--c-muted); margin-top: .15rem; }

    .fr-empty { text-align: center; padding: 1.5rem; color: var(--c-muted); font-size: .9rem; }
</style>
@endpush

@section('content')
<div class="fr-show">

    {{-- HERO --}}
    <div class="fr-hero">
        <div>
            <div class="num">{{ ln('Request', 'طلب') }} #{{ $fr->request_number ?? $fr->id }}</div>
            <h2>{{ $fr->commercial_name ?? $fr->owner_name ?? ln('Financing Request', 'طلب تمويل') }}</h2>
            <div class="meta">
                <i class="fa-regular fa-calendar"></i> {{ optional($fr->created_at)->format('Y-m-d') ?? '-' }}
                <i class="fa-solid fa-circle" style="font-size:.3rem; vertical-align:middle;"></i>
                <span class="status-pill" style="color: {{ $sFg }};">
                    <i class="fa-solid {{ $sIcon }}"></i> {{ $sLabel }}
                </span>
            </div>
        </div>
        <div class="actions">
            @if(\Route::has('client.financing-request.offers') && $fr->status === 'approved')
                <a href="{{ route('client.financing-request.offers', $fr) }}" class="btn-w">
                    <i class="fa-solid fa-handshake"></i> {{ ln('View Offers', 'عرض العروض') }}
                </a>
            @endif
            <a href="{{ route('client.financing-request.index') }}" class="btn-w">
                <i class="fa-solid fa-arrow-{{ $isRtl ?? true ? 'left' : 'right' }}"></i> {{ ln('Back', 'رجوع') }}
            </a>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="fr-summary">
        <div class="card-mini">
            <div class="ic"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
                <div class="lbl">{{ ln('Financing Amount', 'مبلغ التمويل') }}</div>
                <div class="val">{{ $fr->financing_amount ? number_format((float) $fr->financing_amount) . ' ' . ln('SAR','ر.س') : '—' }}</div>
            </div>
        </div>
        <div class="card-mini">
            <div class="ic"><i class="fa-solid fa-calendar-days"></i></div>
            <div>
                <div class="lbl">{{ ln('Term', 'المدة') }}</div>
                <div class="val">{{ $fr->financing_period ? $fr->financing_period . ' ' . ln('months','شهر') : ($fr->term_years ? $fr->term_years . ' ' . ln('yrs','سنة') : '—') }}</div>
            </div>
        </div>
        <div class="card-mini">
            <div class="ic"><i class="fa-solid fa-folder-open"></i></div>
            <div>
                <div class="lbl">{{ ln('Documents', 'المستندات') }}</div>
                <div class="val">{{ $docCount }}</div>
            </div>
        </div>
        <div class="card-mini">
            <div class="ic"><i class="fa-solid fa-shield-halved"></i></div>
            <div>
                <div class="lbl">{{ ln('Coverage', 'التغطية') }}</div>
                <div class="val">{{ $fr->coverage_percentage ? $fr->coverage_percentage . '%' : '—' }}</div>
            </div>
        </div>
    </div>

    {{-- BUSINESS / ADDRESS --}}
    <div class="fr-section">
        <div class="sec-head">
            <div class="sh-ic"><i class="fa-solid fa-location-dot"></i></div>
            <h3>{{ ln('Business & Address', 'العمل والعنوان') }}</h3>
        </div>
        <div class="sec-body">
            <div class="fr-grid">
                @foreach ([
                    ln('National ID','رقم الهوية') => $fr->national_id,
                    ln('Residence Number','رقم الإقامة') => $fr->residence_number,
                    ln('Street','الشارع') => $fr->street_name,
                    ln('City','المدينة') => $fr->city,
                    ln('Postal Code','الرمز البريدي') => $fr->postal_code,
                    ln('District','الحي') => $fr->district_name,
                    ln('Additional Code','الرمز الإضافي') => $fr->additional_code,
                    ln('Location Description','وصف الموقع') => $fr->location_description,
                ] as $k => $v)
                    <div class="fr-cell">
                        <div class="k">{{ $k }}</div>
                        <div class="v {{ $v ? '' : 'muted' }}">{{ $v ?: '—' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- CONTACT --}}
    @if($hasContact)
    <div class="fr-section">
        <div class="sec-head">
            <div class="sh-ic"><i class="fa-solid fa-phone"></i></div>
            <h3>{{ ln('Contact Information', 'بيانات التواصل') }}</h3>
        </div>
        <div class="sec-body">
            <div class="fr-grid">
                @foreach ([
                    ln('Mobile 1','جوال 1') => $fr->mobile_1,
                    ln('Mobile 2','جوال 2') => $fr->mobile_2,
                    ln('Phone 1','هاتف 1') => $fr->phone_1,
                    ln('Phone 2','هاتف 2') => $fr->phone_2,
                    ln('Email','البريد الإلكتروني') => $fr->category_1,
                ] as $k => $v)
                    <div class="fr-cell">
                        <div class="k">{{ $k }}</div>
                        <div class="v {{ $v ? '' : 'muted' }}">{{ $v ?: '—' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- COMMERCIAL --}}
    @if($hasCommercial)
    <div class="fr-section">
        <div class="sec-head">
            <div class="sh-ic"><i class="fa-solid fa-building"></i></div>
            <h3>{{ ln('Commercial Registration', 'السجل التجاري') }}</h3>
        </div>
        <div class="sec-body">
            <div class="fr-grid">
                @foreach ([
                    ln('Legal Form','الشكل القانوني') => $fr->legal_form,
                    ln('Commercial Name','الاسم التجاري') => $fr->commercial_name,
                    ln('CR Number','رقم السجل') => $fr->commercial_registration,
                    ln('CR City','مدينة السجل') => $fr->city_2,
                    ln('License Expiry (Hijri)','انتهاء الترخيص (هجري)') => $fr->license_expiry_date_hijri,
                    ln('Establishment (Hijri)','تاريخ التأسيس (هجري)') => $fr->establishment_date_hijri,
                ] as $k => $v)
                    <div class="fr-cell">
                        <div class="k">{{ $k }}</div>
                        <div class="v {{ $v ? '' : 'muted' }}">{{ $v ?: '—' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- OWNER --}}
    @if($hasOwner)
    <div class="fr-section">
        <div class="sec-head">
            <div class="sh-ic"><i class="fa-solid fa-user-tie"></i></div>
            <h3>{{ ln('Owner Details', 'بيانات المالك') }}</h3>
        </div>
        <div class="sec-body">
            <div class="fr-grid">
                @foreach ([
                    ln('Owner Name','اسم المالك') => $fr->owner_name,
                    ln('ID Number','رقم الهوية') => $fr->owner_id_number,
                    ln('Nationality','الجنسية') => $fr->nationality,
                    ln('Birth Date','تاريخ الميلاد') => $fr->birth_date,
                    ln('Mobile','الجوال') => $fr->mobile_without_zero,
                    ln('ID Expiry','انتهاء الهوية') => $fr->id_expiry_date,
                ] as $k => $v)
                    <div class="fr-cell">
                        <div class="k">{{ $k }}</div>
                        <div class="v {{ $v ? '' : 'muted' }}">{{ $v ?: '—' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- GUARANTEE --}}
    @if($hasGuarantee)
    <div class="fr-section">
        <div class="sec-head">
            <div class="sh-ic"><i class="fa-solid fa-shield-halved"></i></div>
            <h3>{{ ln('Guarantee', 'الضمان') }}</h3>
        </div>
        <div class="sec-body">
            <div class="fr-grid">
                <div class="fr-cell">
                    <div class="k">{{ ln('Types', 'الأنواع') }}</div>
                    <div class="v">
                        @php $types = (array) ($fr->guarantee_type ?? []); @endphp
                        @if(count($types))
                            <div class="fr-chips">
                                @foreach($types as $t)
                                    <span class="fr-chip">{{ $t }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="muted">—</span>
                        @endif
                    </div>
                </div>
                <div class="fr-cell">
                    <div class="k">{{ ln('Coverage %', 'نسبة التغطية') }}</div>
                    <div class="v {{ $fr->coverage_percentage ? '' : 'muted' }}">{{ $fr->coverage_percentage ? $fr->coverage_percentage . '%' : '—' }}</div>
                </div>
                @if($fr->property_value)
                    <div class="fr-cell"><div class="k">{{ ln('Property Value','قيمة العقار') }}</div><div class="v">{{ number_format((float)$fr->property_value) }}</div></div>
                @endif
                @if($fr->number_of_shares)
                    <div class="fr-cell"><div class="k">{{ ln('Shares','الأسهم') }}</div><div class="v">{{ $fr->number_of_shares }} × {{ $fr->share_value }}</div></div>
                @endif
                @if($fr->promissory_note_value)
                    <div class="fr-cell"><div class="k">{{ ln('Promissory Note','السند') }}</div><div class="v">{{ number_format((float)$fr->promissory_note_value) }}</div></div>
                @endif
                @if($fr->cash_deposit_value)
                    <div class="fr-cell"><div class="k">{{ ln('Cash Deposit','الوديعة') }}</div><div class="v">{{ number_format((float)$fr->cash_deposit_value) }}</div></div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- DOCUMENTS --}}
    <div class="fr-section">
        <div class="sec-head">
            <div class="sh-ic"><i class="fa-solid fa-folder-open"></i></div>
            <h3>{{ ln('Documents', 'المستندات') }} <span style="color:var(--c-muted); font-weight:500; font-size:.85rem;">({{ $docCount }})</span></h3>
        </div>
        <div class="sec-body">
            @if($docCount === 0)
                <div class="fr-empty"><i class="fa-regular fa-folder-open" style="font-size:1.5rem; opacity:.5;"></i><br>{{ ln('No documents uploaded.', 'لا توجد مستندات مرفوعة.') }}</div>
            @else
                <div class="fr-docs">
                    @foreach($fileFields as $field => $label)
                        @if(!empty($fr->{$field}))
                            @php
                                $path = $fr->{$field};
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                $iconMap = ['pdf'=>'fa-file-pdf','jpg'=>'fa-file-image','jpeg'=>'fa-file-image','png'=>'fa-file-image','doc'=>'fa-file-word','docx'=>'fa-file-word'];
                                $ic = $iconMap[$ext] ?? 'fa-file';
                            @endphp
                            <a href="{{ asset('storage/' . $path) }}" target="_blank" class="fr-doc">
                                <div class="di"><i class="fa-solid {{ $ic }}"></i></div>
                                <div>
                                    <div class="dn">{{ $label }}</div>
                                    <div class="ds">{{ strtoupper($ext) ?: ln('File','ملف') }} · {{ ln('Open','فتح') }}</div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
