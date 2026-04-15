<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\MicrosoftGraphMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(public User $user) {}

    public function handle(MicrosoftGraphMailer $mailer): void
    {
        $verifyUrl = url('/verify-email/' . $this->user->email_verification_token);
        $isAr      = ($this->user->locale ?? 'ar') === 'ar';

        $subject = $isAr ? 'تأكيد بريدك الإلكتروني — هوت سبوت' : 'Verify your email — Hotspot';

        $body = view('emails.verify', [
            'name'      => $this->user->name,
            'verifyUrl' => $verifyUrl,
            'isAr'      => $isAr,
        ])->render();

        $mailer->sendMail($this->user->email, $subject, $body);
    }
}
