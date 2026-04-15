<?php

use App\Models\ContentBlock;

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
