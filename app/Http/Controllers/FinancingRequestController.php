<?php

namespace App\Http\Controllers;

use App\Models\ClickPayPayments;
use App\Models\FinancingRequest;
use App\Models\RequestLog;
use App\Services\Payments\ClickPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FinancingRequestController extends Controller
{
    public function saveSubProductToSession(Request $request)
    {
        $data = $request->validate([
            'sub_product_id' => 'required|integer',
        ]);

        session(['selected_sub_product_id' => $data['sub_product_id']]);

        return view('client.financing-request.file_documents', [
            'currentSubProductId' => $data['sub_product_id'],
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        $products = Cache::remember('financing_request.products', 300, function () {
            try {
                $response = Http::withHeaders([
                    'Authorization' => env('EXTERNAL_API_TOKEN', '6NKbQBoieHE8xf29cl1pyUFNP9vowU='),
                ])->get(env('EXTERNAL_API_URL', 'http://8.213.80.135/hotspotloans/public/api/website/product'));

                if ($response->successful() && $response->json('status')) {
                    return $response->json('data', []);
                }
            } catch (\Throwable $e) {
                Log::error('Failed to fetch products', ['error' => $e->getMessage()]);
            }
            return [];
        });

        if (empty($products)) {
            $products = [[
                'id' => 1,
                'name' => 'Test Product',
                'name_ar' => 'منتج تجريبي',
                'sub_products' => [
                    ['id' => 101, 'name' => 'Test Sub Product', 'name_ar' => 'منتج فرعي تجريبي'],
                ],
            ]];
        }

        return view('client.financing-request.create', compact('user', 'products'));
    }

    protected function validationRules(array $types): array
    {
        return [
            'product_id' => 'required|integer',
            'sub_product_id' => 'required|integer',

            'national_id' => 'required|digits:10',
            'residence_number' => 'nullable|string',
            'street_name' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'district_name' => 'required|string',
            'additional_code' => 'required|string',
            'location_description' => 'required|string',
            'mobile_1' => 'required|string',
            'mobile_2' => 'nullable|string',
            'category_1' => 'required|email',

            'legal_form' => 'required|string',
            'commercial_name' => 'required|string',
            'commercial_registration' => 'required|string',
            'city_2' => 'required|string',
            'license_expiry_date_hijri' => 'required|string',
            'establishment_date_hijri' => 'required|string',

            'supplier_name' => 'nullable|string',
            'invoice_number' => 'nullable|string',
            'contract_type' => 'nullable|string',
            'contract_expiry_date' => 'nullable|string',

            'owner_name' => 'required|string',
            'owner_id_number' => 'required|digits:10',
            'nationality' => 'required|string|in:سعودي,غير سعودي',
            'birth_date' => 'required|string',
            'mobile_without_zero' => 'required|string',
            'id_expiry_date' => 'required|string',

            'commercial_registration_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'financial_statements' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'zakat_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'vat_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'national_address_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'invoices_file' => 'nullable|file|mimes:pdf,zip,jpg,jpeg,png|max:10240',

            'wc_budget_text' => 'nullable|string|max:255',
            'wc_authorized_signatory' => 'nullable|string|max:255',
            'wc_bank_statement_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'wc_budget_last_3_years_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'wc_articles_of_association_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'wc_commercial_registration_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

            're_income_down_payment_amount' => 'nullable|numeric|min:0',
            're_income_down_payment_details' => 'nullable|string|max:255',
            're_income_audited_fs_3y_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_income_bank_statement_12m_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_income_commercial_registration_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_income_articles_of_association_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_income_latest_valuation_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

            're_land_financing_amount' => 'nullable|numeric|min:0',
            're_land_property_value' => 'nullable|numeric|min:0',
            're_land_down_payment' => 'nullable|numeric|min:0',
            're_land_total_rent_value' => 'nullable|numeric|min:0',
            're_land_remaining_tenure' => 'nullable|numeric|min:0',
            're_land_audited_fs_3y_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_land_bank_statement_12m_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_land_commercial_registration_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_land_articles_of_association_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            're_land_latest_valuation_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

            'guarantee_types' => 'required|array|min:1',
            'guarantee_types.*' => 'in:real_estate,stocks,promissory_note,cash_deposit',

            'real_estate_type' => [in_array('real_estate', $types) ? 'required' : 'nullable', 'in:land,commercial,commercial_residential'],
            'property_value' => [in_array('real_estate', $types) ? 'required' : 'nullable', 'numeric', 'min:0'],

            'number_of_shares' => [in_array('stocks', $types) ? 'required' : 'nullable', 'integer', 'min:1'],
            'share_value' => [in_array('stocks', $types) ? 'required' : 'nullable', 'numeric', 'min:0'],

            'promissory_note_value' => [in_array('promissory_note', $types) ? 'required' : 'nullable', 'numeric', 'min:0'],
            'promissory_note_file' => [in_array('promissory_note', $types) ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],

            'cash_deposit_value' => [in_array('cash_deposit', $types) ? 'required' : 'nullable', 'numeric', 'min:0'],

            'coverage_percentage' => 'nullable|numeric|min:0|max:100',
            'selected_offer_id' => 'nullable|integer',
        ];
    }

    protected function fileFields(): array
    {
        return [
            'commercial_registration_doc', 'financial_statements', 'bank_statement',
            'zakat_certificate', 'vat_certificate', 'national_address_certificate',
            'contract_file', 'invoices_file',
            'wc_bank_statement_file', 'wc_budget_last_3_years_file',
            'wc_articles_of_association_file', 'wc_commercial_registration_file',
            're_income_audited_fs_3y_file', 're_income_bank_statement_12m_file',
            're_income_commercial_registration_file', 're_income_articles_of_association_file',
            're_income_latest_valuation_file',
            're_land_audited_fs_3y_file', 're_land_bank_statement_12m_file',
            're_land_commercial_registration_file', 're_land_articles_of_association_file',
            're_land_latest_valuation_file',
        ];
    }

    protected function processGuarantee(array $validated, array $types): array
    {
        $validated['guarantee_type'] = $types;

        if (!in_array('real_estate', $types)) {
            $validated['real_estate_type'] = null;
            $validated['property_value'] = null;
        }
        if (!in_array('stocks', $types)) {
            $validated['number_of_shares'] = null;
            $validated['share_value'] = null;
        }
        if (!in_array('promissory_note', $types)) {
            $validated['promissory_note_value'] = null;
            $validated['promissory_note_file'] = null;
        }
        if (!in_array('cash_deposit', $types)) {
            $validated['cash_deposit_value'] = null;
        }
        return $validated;
    }

    protected function pushToExternalApi(FinancingRequest $fr): void
    {
        try {
            $base = rtrim(env('EXTERNAL_API_URL', 'http://8.213.80.135/hotspotloans/public/api/website'), '/');
            $payload = $fr->toArray();
            $payload['request_number'] = $fr->request_number;
            $payload['user_id']        = $fr->user_id;

            $response = Http::withHeaders([
                'Authorization' => env('EXTERNAL_API_TOKEN', '6NKbQBoieHE8xf29cl1pyUFNP9vowU='),
                'Accept'        => 'application/json',
            ])->timeout(15)->post($base . '/financing-request', $payload);

            if (!$response->successful()) {
                Log::warning('External financing-request push failed', [
                    'id'     => $fr->id,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            } else {
                $fr->update(['external_reference' => $response->json('data.id') ?? $response->json('id')]);
            }
        } catch (\Throwable $e) {
            Log::error('External financing-request push exception', [
                'id'    => $fr->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $types = $request->input('guarantee_types', []);
        $validated = $request->validate($this->validationRules($types));

        foreach ($this->fileFields() as $field) {
            if ($request->hasFile($field)) {
                $fileName = uniqid() . '_' . $field . '.' . $request->file($field)->extension();
                $validated[$field] = $request->file($field)->storeAs('financing_documents', $fileName, 'public');
            }
        }

        if ($request->hasFile('promissory_note_file')) {
            $fileName = uniqid() . '_note.' . $request->file('promissory_note_file')->extension();
            $validated['promissory_note_file'] = $request->file('promissory_note_file')
                ->storeAs('promissory_notes', $fileName, 'public');
        }

        if (!empty($request->contract_expiry_date)) {
            try {
                $validated['contract_expiry_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->contract_expiry_date)->format('Y-m-d');
            } catch (\Throwable $e) {
                $validated['contract_expiry_date'] = null;
            }
        }

        $validated = $this->processGuarantee($validated, $types);

        $validated['request_number'] = FinancingRequest::generateRequestNumber();
        $validated['user_id']        = Auth::id();
        $validated['status']         = FinancingRequest::STATUS_PENDING;

        $financingRequest = FinancingRequest::create($validated);

        $this->pushToExternalApi($financingRequest);

        return redirect()
            ->route('client.financing-request.success', $financingRequest->id)
            ->with('success', ln('Financing request submitted successfully!', 'تم تقديم طلب التمويل بنجاح!'));
    }

    public function storeAndPay(Request $request, ClickPayService $clickPay)
    {
        $types = $request->input('guarantee_types', []);
        $validated = $request->validate($this->validationRules($types));

        foreach ($this->fileFields() as $field) {
            if ($request->hasFile($field)) {
                $fileName = uniqid() . '_' . $field . '.' . $request->file($field)->extension();
                $validated[$field] = $request->file($field)->storeAs('financing_documents', $fileName, 'public');
            }
        }

        if ($request->hasFile('promissory_note_file')) {
            $fileName = uniqid() . '_note.' . $request->file('promissory_note_file')->extension();
            $validated['promissory_note_file'] = $request->file('promissory_note_file')
                ->storeAs('promissory_notes', $fileName, 'public');
        }

        if (!empty($request->contract_expiry_date)) {
            try {
                $validated['contract_expiry_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->contract_expiry_date)->format('Y-m-d');
            } catch (\Throwable $e) {
                $validated['contract_expiry_date'] = null;
            }
        }

        $validated = $this->processGuarantee($validated, $types);

        $validated['request_number'] = FinancingRequest::generateRequestNumber();
        $validated['user_id']        = Auth::id();
        $validated['status']         = FinancingRequest::STATUS_PENDING;
        $validated['stage']          = FinancingRequest::STAGE_PENDING_PAYMENT;
        $validated['payment_status'] = ClickPayPayments::STATUS_PENDING;

        $amount = (float) config('clickpay.fee_amount', 100);
        $currency = config('clickpay.currency', 'SAR');

        $financingRequest = FinancingRequest::create($validated);

        $this->pushToExternalApi($financingRequest);

        $cartId = 'FR-' . $financingRequest->id . '-' . Str::upper(Str::random(8));

        $payment = ClickPayPayments::create([
            'user_id'              => Auth::id(),
            'financing_request_id' => $financingRequest->id,
            'reference_id'         => $financingRequest->id,
            'cart_id'              => $cartId,
            'cart_description'     => 'Financing Request Payment #' . $financingRequest->request_number,
            'amount'               => $amount,
            'currency'             => $currency,
            'payment_status'       => ClickPayPayments::STATUS_PENDING,
            'customer_name'        => $financingRequest->owner_name,
            'customer_email'       => $financingRequest->category_1,
            'customer_phone'       => $financingRequest->mobile_1,
            'customer_ip'          => $request->ip(),
        ]);

        $financingRequest->update(['payment_id' => $payment->id]);

        $billing = [
            'name'    => $payment->customer_name ?? 'Customer',
            'email'   => $payment->customer_email ?? 'test@example.com',
            'phone'   => $payment->customer_phone ?? '0000000000',
            'street1' => $request->street_name ?? 'N/A',
            'city'    => $request->city ?? 'Riyadh',
            'state'   => 'Ar Riyad',
            'country' => 'SA',
            'zip'     => $request->postal_code ?? '00000',
        ];

        $payload = [
            'profile_id'       => config('clickpay.profile_id'),
            'tran_type'        => 'sale',
            'tran_class'       => 'ecom',
            'cart_id'          => $cartId,
            'cart_description' => $payment->cart_description,
            'cart_currency'    => $currency,
            'cart_amount'      => $amount,
            'callback'         => route('client.financing-request.payment.callback'),
            'return'           => route('client.financing-request.payment.return'),
            'customer_details' => $billing,
            'address_details'  => $billing,
            'hide_shipping'    => true,
        ];

        $cp = $clickPay->createPaymentPage($payload);

        if (!$cp['ok']) {
            $payment->update([
                'payment_status'    => ClickPayPayments::STATUS_FAILED,
                'response_message'  => $cp['error'] ?? 'Payment init failed',
                'clickpay_response' => $cp['raw'] ?? null,
            ]);
            $financingRequest->update([
                'payment_status' => ClickPayPayments::STATUS_FAILED,
                'stage'          => FinancingRequest::STAGE_PENDING_PAYMENT,
            ]);

            return response()->json([
                'ok'       => false,
                'redirect' => route('client.financing-request.payment.failed', $financingRequest->id),
            ], 200);
        }

        $payment->update([
            'tran_ref'          => $cp['tran_ref'],
            'redirect_url'      => $cp['redirect_url'],
            'clickpay_response' => $cp['raw'],
        ]);

        return response()->json([
            'ok'       => true,
            'redirect' => $cp['redirect_url'],
        ]);
    }

    public function offers($id)
    {
        $req = FinancingRequest::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($req->payment_status !== ClickPayPayments::STATUS_SUCCESS) {
            return redirect()->route('client.financing-request.payment.failed', $req->id);
        }

        return view('client.financing-request.offers', [
            'request' => $req,
            'offers'  => [],
        ]);
    }

    public function selectOffer(Request $request, $id)
    {
        $req = FinancingRequest::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'selected_offer_id' => 'required|integer',
        ]);

        $req->update([
            'selected_offer_id' => $data['selected_offer_id'],
            'stage'             => FinancingRequest::STAGE_OFFER_SELECTED,
        ]);

        return redirect()
            ->route('client.financing-request.show', $req->id)
            ->with('success', ln('Offer selected successfully', 'تم اختيار العرض بنجاح'));
    }

    public function paymentFailed($id)
    {
        $req = FinancingRequest::where('id', $id)->firstOrFail();
        return view('client.financing-request.payment_failed', compact('req'));
    }

    public function success($id)
    {
        $request = FinancingRequest::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('client.financing-request.success', compact('request'));
    }

    public function index()
    {
        $requests = FinancingRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.financing-request.index', compact('requests'));
    }

    public function show($id)
    {
        $financingRequest = FinancingRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.financing-request.show', compact('financingRequest'));
    }

    public function trackStep(Request $request)
    {
        try {
            $user = Auth::user();
            RequestLog::create([
                'method'              => 'POST',
                'url'                 => $request->input('url', $request->fullUrl()),
                'route_name'          => 'client.financing-request.track-step',
                'ip_address'          => $request->ip(),
                'user_agent'          => $request->userAgent(),
                'user_id'             => $user->id ?? null,
                'user_email'          => $user->email ?? null,
                'user_name'           => $user->name ?? null,
                'user_national_id'    => $user->national_id ?? null,
                'financing_step'      => $request->input('step'),
                'financing_step_name' => $request->input('step_name'),
                'request_data'        => $request->all(),
                'response_status'     => 200,
                'session_id'          => $request->session()->getId(),
            ]);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Failed to track step', ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }
}
