<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use Translatable;

    protected $fillable = [
        'bank_id', 'service_id', 'title', 'apr', 'max_amount', 'min_amount',
        'monthly_sample', 'max_term_years', 'approval_note', 'approval_icon',
        'sector', 'is_best', 'is_active', 'order',
    ];
    protected $casts = [
        'title' => 'array', 'approval_note' => 'array',
        'is_best' => 'boolean', 'is_active' => 'boolean',
    ];
    protected array $translatable = ['title', 'approval_note'];

    public function bank() { return $this->belongsTo(Bank::class); }
    public function service() { return $this->belongsTo(Service::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
}
