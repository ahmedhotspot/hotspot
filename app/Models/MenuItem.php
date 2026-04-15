<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use Translatable;

    protected $fillable = ['location', 'parent_id', 'label', 'url', 'target', 'icon', 'order', 'is_active'];
    protected $casts    = ['label' => 'array', 'is_active' => 'boolean'];
    protected array $translatable = ['label'];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function scopeFor($q, string $location) { return $q->where('location', $location); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
