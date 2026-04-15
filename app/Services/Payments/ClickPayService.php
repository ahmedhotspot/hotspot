<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClickPayService
{
    protected string $serverKey;
    protected ?string $profileId;
    protected string $requestUrl;
    protected string $queryUrl;

    public function __construct()
    {
        $this->serverKey  = (string) config('clickpay.server_key');
        $this->profileId  = config('clickpay.profile_id');
        $this->requestUrl = (string) config('clickpay.request_url');
        $this->queryUrl   = (string) config('clickpay.query_url');
    }

    public function createPaymentPage(array $payload): array
    {
        try {
            $payload['profile_id'] = $payload['profile_id'] ?? $this->profileId;

            $res = Http::withHeaders([
                'authorization' => $this->serverKey,
                'content-type'  => 'application/json',
            ])->post($this->requestUrl, $payload);

            $body = $res->json();

            if (! $res->successful() || empty($body['tran_ref']) || empty($body['redirect_url'])) {
                Log::error('ClickPay create payment failed', [
                    'status' => $res->status(),
                    'body'   => $body,
                ]);

                return [
                    'ok'    => false,
                    'error' => $body['message'] ?? 'Failed to create payment page',
                    'raw'   => $body,
                ];
            }

            return [
                'ok'           => true,
                'tran_ref'     => (string) $body['tran_ref'],
                'redirect_url' => (string) $body['redirect_url'],
                'raw'          => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('ClickPay createPaymentPage exception', ['error' => $e->getMessage()]);
            return ['ok' => false, 'error' => $e->getMessage(), 'raw' => null];
        }
    }

    public function verifyPayment(string $tranRef): array
    {
        try {
            $res = Http::withHeaders([
                'authorization' => $this->serverKey,
                'content-type'  => 'application/json',
            ])->post($this->queryUrl, [
                'profile_id' => $this->profileId,
                'tran_ref'   => $tranRef,
            ]);

            return [
                'ok'  => $res->successful(),
                'raw' => $res->json(),
            ];
        } catch (\Throwable $e) {
            Log::error('ClickPay verifyPayment exception', ['error' => $e->getMessage()]);
            return ['ok' => false, 'raw' => null];
        }
    }
}
