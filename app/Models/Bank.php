<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use Translatable;

    protected $fillable = ['slug', 'name', 'logo', 'description', 'order', 'is_active'];
    protected $casts    = ['name' => 'array', 'description' => 'array', 'is_active' => 'boolean'];
    protected array $translatable = ['name', 'description'];

    public function offers() { return $this->hasMany(Offer::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
