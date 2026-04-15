<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'request_data' => 'array',
        'meta'         => 'array',
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
