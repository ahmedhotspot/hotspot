<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use Translatable;

    protected $fillable = ['name', 'city', 'text', 'stars', 'avatar', 'initial', 'order', 'is_active'];
    protected $casts    = [
        'name' => 'array', 'city' => 'array', 'text' => 'array',
        'stars' => 'decimal:1', 'is_active' => 'boolean',
    ];
    protected array $translatable = ['name', 'city', 'text'];

    public function scopeActive($q) { return $q->where('is_active', true); }
}
