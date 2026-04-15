<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\MicrosoftGraphMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(public User $user) {}

    public function handle(MicrosoftGraphMailer $mailer): void
    {
        $isAr    = ($this->user->locale ?? 'ar') === 'ar';
        $subject = $isAr ? 'أهلاً بك في هوت سبوت!' : 'Welcome to Hotspot!';

        $body = view('emails.welcome', [
            'name'        => $this->user->name,
            'dashboardUrl'=> url(route('client.dashboard', [], false)),
            'isAr'        => $isAr,
        ])->render();

        $mailer->sendMail($this->user->email, $subject, $body);
    }
}
