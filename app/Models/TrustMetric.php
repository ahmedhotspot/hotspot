<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class TrustMetric extends Model
{
    use Translatable;

    protected $fillable = ['value', 'label', 'order', 'is_active'];
    protected $casts    = ['value' => 'array', 'label' => 'array', 'is_active' => 'boolean'];
    protected array $translatable = ['value', 'label'];

    public function scopeActive($q) { return $q->where('is_active', true); }
}
