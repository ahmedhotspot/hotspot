<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Translatable;

    protected $fillable = ['slug', 'title', 'description', 'long_description', 'icon', 'icon_class', 'image', 'order', 'is_active'];
    protected $casts    = [
        'title' => 'array', 'description' => 'array', 'long_description' => 'array',
        'is_active' => 'boolean',
    ];
    protected array $translatable = ['title', 'description', 'long_description'];

    public function offers() { return $this->hasMany(Offer::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
