<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use Translatable;

    protected $fillable = ['category', 'question', 'answer', 'order', 'is_active'];
    protected $casts    = ['question' => 'array', 'answer' => 'array', 'is_active' => 'boolean'];
    protected array $translatable = ['question', 'answer'];

    public function scopeActive($q) { return $q->where('is_active', true); }
}
