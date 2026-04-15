<?php

namespace App\Http\Controllers;

use App\Models\ClickPayPayments;
use App\Models\FinancingRequest;
use App\Services\Payments\ClickPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClickPayController extends Controller
{
    public function confirmPayment(FinancingRequest $financingRequest)
    {
        abort_if($financingRequest->user_id !== Auth::id(), 403);
        $amount = (float) config('clickpay.fee_amount', 100);

        return view('client.financing-request.confirm_payment', compact('financingRequest', 'amount'));
    }

    public function initiate(Request $request, ClickPayService $clickPay)
    {
        $request->validate([
            'financing_request_id' => 'required|integer',
        ]);

        $financingRequest = FinancingRequest::findOrFail($request->financing_request_id);
        abort_if($financingRequest->user_id !== Auth::id(), 403);

        $user = Auth::user();
        $amount = (float) config('clickpay.fee_amount', 100);
        $currency = config('clickpay.currency', 'SAR');

        $requestUuid = (string) Str::uuid();
        $cartId = 'FIN-' . $financingRequest->id . '-' . now()->format('YmdHis') . '-' . rand(100, 999);

        $callbackUrl = route('client.financing-request.payment.callback');
        $returnUrl   = route('client.financing-request.payment.return') . '?fr_id=' . $financingRequest->id . '&req=' . $requestUuid;

        $payment = ClickPayPayments::create([
            'user_id'              => $user->id,
            'financing_request_id' => $financingRequest->id,
            'reference_id'         => $financingRequest->id,
            'request_uuid'         => $requestUuid,
            'cart_id'              => $cartId,
            'cart_description'     => 'Financing Request Payment',
            'amount'               => $amount,
            'currency'             => $currency,
            'callback_url'         => $callbackUrl,
            'return_url'           => $returnUrl,
            'payment_status'       => ClickPayPayments::STATUS_PENDING,
            'customer_name'        => $user->name ?? null,
            'customer_phone'       => $user->phone ?? null,
            'customer_email'       => $user->email ?? null,
            'customer_ip'          => $request->ip(),
        ]);

        $payload = [
            'profile_id'       => config('clickpay.profile_id'),
            'tran_type'        => 'sale',
            'tran_class'       => 'ecom',
            'cart_description' => 'Financing Request Payment',
            'cart_id'          => $cartId,
            'cart_currency'    => $currency,
            'cart_amount'      => $amount,
            'callback'         => $callbackUrl,
            'return'           => $returnUrl,
            'hide_shipping'    => true,
            'customer_details' => [
                'name'    => $user->name ?? 'Customer',
                'phone'   => $user->phone ?? '',
                'email'   => $user->email ?? '',
                'city'    => 'Riyadh',
                'state'   => 'SA',
                'country' => 'SA',
                'ip'      => $request->ip(),
            ],
        ];

        $cp = $clickPay->createPaymentPage($payload);
        $payment->update(['create_response' => $cp['raw'] ?? null]);

        if (!$cp['ok']) {
            $payment->update([
                'payment_status'   => ClickPayPayments::STATUS_FAILED,
                'response_message' => $cp['error'] ?? 'Failed to create payment page',
            ]);
            return back()->with('error', ln('Payment gateway error, please try again later.', 'حدث خطأ في بوابة الدفع، حاول لاحقًا.'));
        }

        $payment->update([
            'tran_ref'     => $cp['tran_ref'],
            'redirect_url' => $cp['redirect_url'],
        ]);

        return redirect()->away($cp['redirect_url']);
    }

    public function callback(Request $request, ClickPayService $clickPay)
    {
        Log::info('clickpay_callback', $request->all());
        $payload = $request->all();
        $tranRef = $payload['tran_ref'] ?? $payload['tranRef'] ?? null;
        $cartId  = $payload['cart_id'] ?? null;

        $payment = ClickPayPayments::query()
            ->when($tranRef, fn($q) => $q->orWhere('tran_ref', $tranRef))
            ->when($cartId,  fn($q) => $q->orWhere('cart_id', $cartId))
            ->latest()->first();

        if (!$payment) {
            return response()->json(['ok' => false, 'message' => 'payment_not_found'], 404);
        }

        $payment->update(['callback_payload' => $payload]);

        if ($payment->tran_ref) {
            $verify = $clickPay->verifyPayment($payment->tran_ref);
            $payment->update(['verification_response' => $verify['raw'] ?? null]);

            $status = data_get($verify, 'raw.payment_result.response_status');
            $code   = data_get($verify, 'raw.payment_result.response_code');
            $msg    = data_get($verify, 'raw.payment_result.response_message');
            $isPaid = in_array($status, ['A', 'APPROVED', 'approved'], true)
                  || in_array((string)$code, ['100', '0'], true);

            $payment->update([
                'response_code'   => $code,
                'response_message'=> $msg,
                'payment_status'  => $isPaid ? ClickPayPayments::STATUS_SUCCESS : ClickPayPayments::STATUS_FAILED,
                'paid_at'         => $isPaid ? now() : null,
            ]);

            if ($payment->financing_request_id) {
                FinancingRequest::where('id', $payment->financing_request_id)->update([
                    'payment_status' => $payment->payment_status,
                    'stage'          => $isPaid ? FinancingRequest::STAGE_PAID : FinancingRequest::STAGE_PENDING_PAYMENT,
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }

    public function return(Request $request)
    {
        Log::info('clickpay_return', $request->all());
        $tranRef = $request->get('tranRef') ?? $request->get('tran_ref');
        $cartId  = $request->get('cartId')  ?? $request->get('cart_id');
        $success = $request->get('respStatus') ?? $request->get('resp_status');

        $payment = ClickPayPayments::query()
            ->when($tranRef, fn($q) => $q->orWhere('tran_ref', $tranRef))
            ->when($cartId,  fn($q) => $q->orWhere('cart_id', $cartId))
            ->latest()->first();

        if (!$payment || !$payment->financing_request_id) {
            return redirect()->route('client.financing-request.payment.failed', 0);
        }

        $requestId = $payment->financing_request_id;

        if ($success === "A") {
            $payment->update([
                'payment_status'   => ClickPayPayments::STATUS_SUCCESS,
                'response_code'    => $request->get('respCode') ?? $request->get('resp_code'),
                'response_message' => $request->get('respMessage') ?? $request->get('resp_message'),
                'paid_at'          => now(),
                'callback_payload' => $request->all(),
            ]);

            FinancingRequest::where('id', $requestId)->update([
                'payment_status' => ClickPayPayments::STATUS_SUCCESS,
                'stage'          => FinancingRequest::STAGE_PAID,
            ]);

            return redirect()->route('client.financing-request.offers', $requestId);
        }

        $payment->update([
            'payment_status'   => ClickPayPayments::STATUS_FAILED,
            'response_code'    => $request->get('respCode') ?? $request->get('resp_code'),
            'response_message' => $request->get('respMessage') ?? $request->get('resp_message'),
            'callback_payload' => $request->all(),
        ]);

        FinancingRequest::where('id', $requestId)->update([
            'payment_status' => ClickPayPayments::STATUS_FAILED,
            'stage'          => FinancingRequest::STAGE_PENDING_PAYMENT,
        ]);

        return redirect()->route('client.financing-request.payment.failed', $requestId);
    }

    public function paymentSuccess($id)
    {
        $req = FinancingRequest::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return redirect()->route('client.financing-request.offers', $req->id);
    }

    public function paymentFailed($id)
    {
        $req = FinancingRequest::where('id', $id)->firstOrFail();
        return view('client.financing-request.payment_failed', compact('req'));
    }
}
