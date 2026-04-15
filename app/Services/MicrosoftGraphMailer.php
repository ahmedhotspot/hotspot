<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class MicrosoftGraphMailer
{
    private string $tenantId;
    private string $clientId;
    private string $clientSecret;
    private string $fromEmail;

    public function __construct()
    {
        $this->tenantId     = (string) config('services.microsoft.tenant_id');
        $this->clientId     = (string) config('services.microsoft.client_id');
        $this->clientSecret = (string) config('services.microsoft.client_secret');
        $this->fromEmail    = (string) config('services.microsoft.noreply_email');
    }

    private function getAccessToken(): string
    {
        $cacheKey = 'ms_graph_token_' . md5($this->clientId);

        return Cache::remember($cacheKey, 3500, function () {
            $client = new Client(['timeout' => 15]);
            $url = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token";

            $response = $client->post($url, [
                'form_params' => [
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'scope'         => 'https://graph.microsoft.com/.default',
                    'grant_type'    => 'client_credentials',
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            if (empty($data['access_token'])) {
                throw new RuntimeException('Microsoft Graph token request failed.');
            }

            return $data['access_token'];
        });
    }

    public function sendMail(string $to, string $subject, string $htmlBody): void
    {
        try {
            $token  = $this->getAccessToken();
            $client = new Client(['timeout' => 20]);
            $url    = "https://graph.microsoft.com/v1.0/users/{$this->fromEmail}/sendMail";

            $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'message' => [
                        'subject' => $subject,
                        'body'    => [
                            'contentType' => 'HTML',
                            'content'     => $htmlBody,
                        ],
                        'toRecipients' => [
                            ['emailAddress' => ['address' => $to]],
                        ],
                    ],
                    'saveToSentItems' => false,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('MicrosoftGraphMailer: send failed', [
                'to'      => $to,
                'subject' => $subject,
                'error'   => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
