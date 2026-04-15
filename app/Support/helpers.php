<?php

use App\Models\ContentBlock;

if (! function_exists('ln')) {
    /**
     * Return text for the current locale.
     */
    function ln(string $en, string $ar): string
    {
        return app()->getLocale() === 'ar' ? $ar : $en;
    }
}

if (! function_exists('block')) {
    /**
     * Return a translatable content block value, with an optional default fallback.
     * Example: block('about.hero.badge', 'About Us')
     */
    function block(string $key, ?string $default = null): ?string
    {
        return ContentBlock::get($key, $default);
    }
}
