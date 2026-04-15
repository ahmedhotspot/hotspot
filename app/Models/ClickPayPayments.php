<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClickPayPayments extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED  = 'failed';

    protected $table = 'click_pay_payments';

    protected $guarded = ['id'];

    protected $casts = [
        'amount'                => 'decimal:2',
        'create_response'       => 'array',
        'callback_payload'      => 'array',
        'verify_response'       => 'array',
        'verification_response' => 'array',
        'clickpay_response'     => 'array',
        'paid_at'               => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function financingRequest(): BelongsTo
    {
        return $this->belongsTo(FinancingRequest::class, 'financing_request_id');
    }
}
