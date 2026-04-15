<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'label', 'is_translatable', 'order'];

    protected $casts = ['is_translatable' => 'boolean'];

    public static function get(string $key, $default = null)
    {
        $all = Cache::rememberForever('settings.all', fn () => static::pluck('value', 'key')->toArray());
        $val = $all[$key] ?? $default;

        // If translatable JSON, decode and pick current locale
        if (is_string($val) && str_starts_with($val, '{')) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                $locale = app()->getLocale();
                $fallback = config('app.fallback_locale', 'ar');
                return $decoded[$locale] ?? $decoded[$fallback] ?? reset($decoded) ?? $default;
            }
        }
        return $val;
    }

    public static function clearCache(): void
    {
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}
