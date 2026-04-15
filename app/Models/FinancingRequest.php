<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancingRequest extends Model
{
    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELED = 'canceled';

    const STAGE_PENDING_PAYMENT = 'pending_payment';
    const STAGE_PAID            = 'paid';
    const STAGE_OFFERS          = 'offers';
    const STAGE_OFFER_SELECTED  = 'offer_selected';
    const STAGE_COMPLETED       = 'completed';

    protected $guarded = ['id'];

    protected $casts = [
        'guarantee_type'                => 'array',
        'documents'                     => 'array',
        're_income_down_payment_amount' => 'decimal:2',
        're_land_financing_amount'      => 'decimal:2',
        're_land_property_value'        => 'decimal:2',
        're_land_down_payment'          => 'decimal:2',
        're_land_total_rent_value'      => 'decimal:2',
        're_land_remaining_tenure'      => 'decimal:2',
        'property_value'                => 'decimal:2',
        'share_value'                   => 'decimal:2',
        'promissory_note_value'         => 'decimal:2',
        'cash_deposit_value'            => 'decimal:2',
        'coverage_percentage'           => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ClickPayPayments::class, 'financing_request_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(RequestLog::class, 'financing_request_id');
    }

    public function selectedOffer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'selected_offer_id');
    }

    public static function generateRequestNumber(): string
    {
        do {
            $number = 'FR-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('request_number', $number)->exists());

        return $number;
    }

    public function getStatusLabelAttribute(): string
    {
        $map = [
            self::STATUS_PENDING  => ln('Pending', 'قيد المراجعة'),
            self::STATUS_APPROVED => ln('Approved', 'مقبول'),
            self::STATUS_REJECTED => ln('Rejected', 'مرفوض'),
            self::STATUS_CANCELED => ln('Canceled', 'ملغي'),
        ];
        return $map[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_APPROVED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_CANCELED => 'secondary',
            default               => 'warning',
        };
    }

    public function getClientNameAttribute(): ?string
    {
        return $this->owner_name ?? optional($this->user)->name;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->mobile_1 ?? $this->mobile_without_zero;
    }
}
