<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class HowItWorksStep extends Model
{
    use Translatable;

    protected $table = 'how_it_works_steps';
    protected $fillable = ['icon', 'title', 'description', 'order', 'is_active'];
    protected $casts    = ['title' => 'array', 'description' => 'array', 'is_active' => 'boolean'];
    protected array $translatable = ['title', 'description'];

    public function scopeActive($q) { return $q->where('is_active', true); }
}
