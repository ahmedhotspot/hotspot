<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ContentBlock extends Model
{
    protected $fillable = ['page', 'section', 'key', 'type', 'value', 'label', 'order'];
    protected $casts    = ['value' => 'array'];

    public static function get(string $dotKey, ?string $default = null): ?string
    {
        [$page, $section, $key] = array_pad(explode('.', $dotKey, 3), 3, null);

        $all = Cache::rememberForever('content_blocks.all', function () {
            return static::all()->mapWithKeys(function ($b) {
                return [$b->page.'.'.$b->section.'.'.$b->key => $b];
            });
        });

        $block = $all->get($dotKey);
        if (! $block) return $default;

        $value = $block->value ?? [];

        if ($block->type === 'image') {
            return $value['path'] ?? $default;
        }

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'ar');
        return $value[$locale] ?? $value[$fallback] ?? $default;
    }

    public static function clearCache(): void
    {
        Cache::forget('content_blocks.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}
