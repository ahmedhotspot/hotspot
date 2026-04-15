@php
    $isArabic = app()->getLocale() === 'ar';
@endphp

<div class="w-100" id="required_documents_wrapper">

    <div class="docs-block" data-subproduct="none">
        <div class="pb-10 pb-lg-12 text-center">
            <h2 class="fw-bolder text-dark mb-3">{{ ln('Required Documents', 'المستندات المطلوبة') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please select a sub-product first to show its required documents', 'من فضلك اختر المنتج الفرعي أولاً لعرض المستندات المطلوبة') }}</div>
        </div>
    </div>

    <div class="docs-block d-none" data-subproduct="2">
        <div class="pb-10 pb-lg-12">
            <h2 class="fw-bolder text-dark">{{ ln('Required Documents', 'المستندات المطلوبة') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please upload all required documents to complete your financing request', 'يرجى رفع جميع المستندات المطلوبة لإكمال طلب التمويل') }}</div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-row-bordered border">
                <thead class="fs-6 fw-bolder bg-light">
                    <tr class="text-center">
                        <th>{{ ln('Document Name', 'اسم المستند') }}</th>
                        <th>{{ ln('Attach', 'ارفاق') }}</th>
                        <th>{{ ln('Preview', 'معاينة') }}</th>
                        <th>{{ ln('Status', 'الحالة') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach([
                        ['commercial_registration_doc', ln('Commercial Registration', 'السجل التجاري'), 'doc1'],
                        ['financial_statements', ln('Financial Statements', 'القوائم المالية'), 'doc2'],
                        ['bank_statement', ln('Bank Statement', 'كشف الحساب البنكي'), 'doc3'],
                        ['zakat_certificate', ln('Zakat Certificate', 'شهادة الزكاة'), 'doc4'],
                        ['vat_certificate', ln('VAT Registration Certificate', 'شهادة ضريبة القيمة المضافة'), 'doc5'],
                        ['national_address_certificate', ln('National Address Certificate', 'شهادة العنوان الوطني'), 'doc6'],
                    ] as $row)
                        <tr>
                            <td class="fw-bold">{{ $row[1] }}</td>
                            <td>
                                <label class="btn btn-light-primary btn-sm">
                                    {{ ln('Attach', 'ارفاق') }}
                                    <input type="file" name="{{ $row[0] }}" class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                        onchange="previewFile(this, '{{ $row[2] }}_preview', '{{ $row[2] }}_status')">
                                </label>
                            </td>
                            <td><div id="{{ $row[2] }}_preview"></div></td>
                            <td><span class="status-icon" id="{{ $row[2] }}_status">○</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="docs-block d-none" data-subproduct="1">
        <div class="pb-10 pb-lg-12">
            <h2 class="fw-bolder text-dark">{{ ln('Supplier Contract Documents', 'مستندات عقد المورد') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please fill supplier details and upload contract & invoices', 'من فضلك أدخل بيانات المورد وارفع العقد وجميع الفواتير حتى تاريخه') }}</div>
        </div>

        <div class="card card-flush mb-10">
            <div class="card-body">
                <div class="row g-9 mb-7">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Supplier Name', 'اسم المورد') }}</label>
                        <input type="text" name="supplier_name" class="form-control form-control-solid" value="{{ old('supplier_name') }}">
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Invoice Number', 'رقم الفاتورة') }}</label>
                        <input type="text" name="invoice_number" class="form-control form-control-solid" value="{{ old('invoice_number') }}">
                    </div>
                </div>
                <div class="row g-9 mb-7">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Contract Type', 'نوع العقد') }}</label>
                        <select name="contract_type" class="form-select form-select-solid">
                            <option value="">{{ ln('Select Contract Type','اختر نوع العقد') }}</option>
                            <option value="مباشر"      {{ old('contract_type')==='مباشر' ? 'selected' : '' }}>{{ ln('Direct','مباشر') }}</option>
                            <option value="غير مباشر" {{ old('contract_type')==='غير مباشر' ? 'selected' : '' }}>{{ ln('Indirect','غير مباشر') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Contract Expiry Date', 'تاريخ انتهاء العقد') }}</label>
                        <input type="text" name="contract_expiry_date" class="form-control form-control-solid datepicker" value="{{ old('contract_expiry_date') }}" placeholder="dd/mm/yyyy">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-bordered border">
                <thead class="fs-6 fw-bolder bg-light">
                    <tr class="text-center">
                        <th>{{ ln('Document Name', 'اسم المستند') }}</th>
                        <th>{{ ln('Attach', 'ارفاق') }}</th>
                        <th>{{ ln('Preview', 'معاينة') }}</th>
                        <th>{{ ln('Status', 'الحالة') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach([
                        ['contract_file', ln('Contract File', 'صورة/ملف العقد'), 'contract', '.pdf,.jpg,.jpeg,.png'],
                        ['invoices_file', ln('All Invoices Till Date', 'إرفاق جميع الفواتير حتى تاريخه'), 'invoices', '.pdf,.zip,.jpg,.jpeg,.png'],
                    ] as $row)
                        <tr>
                            <td class="fw-bold">{{ $row[1] }}</td>
                            <td>
                                <label class="btn btn-light-primary btn-sm">
                                    {{ ln('Attach', 'ارفاق') }}
                                    <input type="file" name="{{ $row[0] }}" class="d-none" accept="{{ $row[3] }}"
                                        onchange="previewFile(this, '{{ $row[2] }}_preview', '{{ $row[2] }}_status')">
                                </label>
                            </td>
                            <td><div id="{{ $row[2] }}_preview"></div></td>
                            <td><span class="status-icon" id="{{ $row[2] }}_status">○</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="docs-block d-none" data-subproduct="3">
        <div class="pb-10 pb-lg-12">
            <h2 class="fw-bolder text-dark">{{ ln('Working Capital Financing Documents', 'مستندات تمويل رأس المال العامل') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please fill required info and upload all required documents', 'من فضلك أدخل البيانات المطلوبة وارفع جميع المستندات لإكمال الطلب') }}</div>
        </div>

        <div class="card card-flush mb-10">
            <div class="card-body">
                <div class="row g-9 mb-7">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Budget', 'الميزانية') }}</label>
                        <input type="text" name="wc_budget_text" class="form-control form-control-solid" value="{{ old('wc_budget_text') }}">
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Authorized Signatory', 'المفوض بالتوقيع') }}</label>
                        <input type="text" name="wc_authorized_signatory" class="form-control form-control-solid" value="{{ old('wc_authorized_signatory') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-bordered border">
                <thead class="fs-6 fw-bolder bg-light">
                    <tr class="text-center">
                        <th>{{ ln('Document Name', 'اسم المستند') }}</th>
                        <th>{{ ln('Attach', 'ارفاق') }}</th>
                        <th>{{ ln('Preview', 'معاينة') }}</th>
                        <th>{{ ln('Status', 'الحالة') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach([
                        ['wc_bank_statement_file', ln('Bank Statement', 'كشف حساب'), 'wc_doc1'],
                        ['wc_budget_last_3_years_file', ln('Budget (Last 3 Years)', 'الميزانية آخر 3 سنين'), 'wc_doc2'],
                        ['wc_articles_of_association_file', ln('Articles of Association', 'عقد التأسيس'), 'wc_doc3'],
                        ['wc_commercial_registration_file', ln('Commercial Registration', 'السجل التجاري'), 'wc_doc4'],
                    ] as $row)
                        <tr>
                            <td class="fw-bold">{{ $row[1] }}</td>
                            <td>
                                <label class="btn btn-light-primary btn-sm">
                                    {{ ln('Attach', 'ارفاق') }}
                                    <input type="file" name="{{ $row[0] }}" class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                        onchange="previewFile(this, '{{ $row[2] }}_preview', '{{ $row[2] }}_status')">
                                </label>
                            </td>
                            <td><div id="{{ $row[2] }}_preview"></div></td>
                            <td><span class="status-icon" id="{{ $row[2] }}_status">○</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="docs-block d-none" data-subproduct="4">
        <div class="pb-10 pb-lg-12">
            <h2 class="fw-bolder text-dark">{{ ln('Real Estate Financing (Income) Documents', 'مستندات التمويل العقاري - إيراد') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please fill required info and upload all required documents', 'من فضلك أدخل البيانات المطلوبة وارفع جميع المستندات لإكمال الطلب') }}</div>
        </div>

        <div class="card card-flush mb-10">
            <div class="card-body">
                <div class="row g-9 mb-7">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Down Payment Amount', 'مبلغ الدفعة المقدمة') }}</label>
                        <input type="text" name="re_income_down_payment_amount" class="form-control form-control-solid" value="{{ old('re_income_down_payment_amount') }}">
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Down Payment Details', 'الدفعة المقدمة') }}</label>
                        <input type="text" name="re_income_down_payment_details" class="form-control form-control-solid" value="{{ old('re_income_down_payment_details') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-bordered border">
                <thead class="fs-6 fw-bolder bg-light">
                    <tr class="text-center">
                        <th>{{ ln('Document Name', 'اسم المستند') }}</th>
                        <th>{{ ln('Attach', 'ارفاق') }}</th>
                        <th>{{ ln('Preview', 'معاينة') }}</th>
                        <th>{{ ln('Status', 'الحالة') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach([
                        ['re_income_audited_fs_3y_file', ln('Audited Financial Statements (Last 3 Years)', 'ميزانية مالية مدققة آخر ٣ سنوات'), 're4_doc1'],
                        ['re_income_bank_statement_12m_file', ln('Bank Statement (Last 12 Months)', 'كشف حساب البنك آخر ١٢ شهر'), 're4_doc2'],
                        ['re_income_commercial_registration_file', ln('Commercial Registration', 'السجل التجاري'), 're4_doc3'],
                        ['re_income_articles_of_association_file', ln('Articles of Association', 'عقد التأسيس'), 're4_doc4'],
                        ['re_income_latest_valuation_file', ln('Latest Real Estate Valuation', 'آخر تقييم عقاري'), 're4_doc5'],
                    ] as $row)
                        <tr>
                            <td class="fw-bold">{{ $row[1] }}</td>
                            <td>
                                <label class="btn btn-light-primary btn-sm">
                                    {{ ln('Attach', 'ارفاق') }}
                                    <input type="file" name="{{ $row[0] }}" class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                        onchange="previewFile(this, '{{ $row[2] }}_preview', '{{ $row[2] }}_status')">
                                </label>
                            </td>
                            <td><div id="{{ $row[2] }}_preview"></div></td>
                            <td><span class="status-icon" id="{{ $row[2] }}_status">○</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="docs-block d-none" data-subproduct="5">
        <div class="pb-10 pb-lg-12">
            <h2 class="fw-bolder text-dark">{{ ln('Real Estate Financing (Land / Warehouse) Documents', 'مستندات التمويل العقاري - أرض أو مستودع') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please fill required info and upload all required documents', 'من فضلك أدخل البيانات المطلوبة وارفع جميع المستندات لإكمال الطلب') }}</div>
        </div>

        <div class="card card-flush mb-10">
            <div class="card-body">
                <div class="row g-9 mb-7">
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Financing Amount', 'مبلغ التمويل') }}</label>
                        <input type="number" step="0.01" name="re_land_financing_amount" class="form-control form-control-solid" value="{{ old('re_land_financing_amount') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Remaining Financing Tenure', 'باقي مدة التمويل') }}</label>
                        <input type="number" min="0" name="re_land_remaining_tenure" class="form-control form-control-solid" value="{{ old('re_land_remaining_tenure') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Property Value', 'قيمة العقار') }}</label>
                        <input type="number" step="0.01" name="re_land_property_value" class="form-control form-control-solid" value="{{ old('re_land_property_value') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Down Payment', 'الدفعة المقدمة') }}</label>
                        <input type="number" step="0.01" name="re_land_down_payment" class="form-control form-control-solid" value="{{ old('re_land_down_payment') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">{{ ln('Total Rental Income', 'إجمالي قيمة الإيجارات') }}</label>
                        <input type="number" step="0.01" name="re_land_total_rent_value" class="form-control form-control-solid" value="{{ old('re_land_total_rent_value') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-bordered border">
                <thead class="fs-6 fw-bolder bg-light">
                    <tr class="text-center">
                        <th>{{ ln('Document Name', 'اسم المستند') }}</th>
                        <th>{{ ln('Attach', 'ارفاق') }}</th>
                        <th>{{ ln('Preview', 'معاينة') }}</th>
                        <th>{{ ln('Status', 'الحالة') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach([
                        ['re_land_audited_fs_3y_file', ln('Audited Financial Statements (Last 3 Years)', 'ميزانية مالية مدققة آخر ٣ سنوات'), 're5_doc1'],
                        ['re_land_bank_statement_12m_file', ln('Bank Statement (Last 12 Months)', 'كشف حساب البنك آخر ١٢ شهر'), 're5_doc2'],
                        ['re_land_commercial_registration_file', ln('Commercial Registration', 'السجل التجاري'), 're5_doc3'],
                        ['re_land_articles_of_association_file', ln('Articles of Association', 'عقد التأسيس'), 're5_doc4'],
                        ['re_land_latest_valuation_file', ln('Latest Real Estate Valuation', 'آخر تقييم عقاري'), 're5_doc5'],
                    ] as $row)
                        <tr>
                            <td class="fw-bold">{{ $row[1] }}</td>
                            <td>
                                <label class="btn btn-light-primary btn-sm">
                                    {{ ln('Attach', 'ارفاق') }}
                                    <input type="file" name="{{ $row[0] }}" class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                        onchange="previewFile(this, '{{ $row[2] }}_preview', '{{ $row[2] }}_status')">
                                </label>
                            </td>
                            <td><div id="{{ $row[2] }}_preview"></div></td>
                            <td><span class="status-icon" id="{{ $row[2] }}_status">○</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="docs-block d-none" data-subproduct="default">
        <div class="pb-10 pb-lg-12">
            <h2 class="fw-bolder text-dark">{{ ln('General Required Documents', 'المستندات العامة المطلوبة') }}</h2>
            <div class="text-muted fw-bold fs-6">{{ ln('Please upload the general documents required for this product', 'يرجى رفع المستندات العامة المطلوبة لهذا المنتج') }}</div>
        </div>
        <p class="text-muted">{{ ln('You can customize this block later for other sub-products.', 'تستطيع تخصيص هذا البلوك لاحقاً لباقي المنتجات الفرعية.') }}</p>
    </div>

</div>
