<?php

namespace App\Support;

/**
 * Translatable fields stored as JSON: {"ar": "...", "en": "..."}.
 *
 * Usage in a model:
 *   use App\Support\Translatable;
 *   protected array $translatable = ['title', 'description'];
 *   protected $casts = ['title' => 'array', 'description' => 'array'];
 *
 * Then $model->title returns the current-locale string,
 * and $model->getTranslations('title') returns the full array.
 * $model->getRawOriginal('title') returns the JSON string.
 */
trait Translatable
{
    public function getAttribute($key)
    {
        if (in_array($key, $this->translatable ?? [], true)) {
            return $this->translate($key);
        }
        return parent::getAttribute($key);
    }

    public function translate(string $field, ?string $locale = null): ?string
    {
        $locale   = $locale ?: app()->getLocale();
        $fallback = config('app.fallback_locale', 'ar');
        $data     = $this->getTranslations($field);

        if (empty($data)) return null;

        return $data[$locale] ?? $data[$fallback] ?? reset($data) ?: null;
    }

    public function getTranslations(string $field): array
    {
        $raw = $this->attributes[$field] ?? null;
        if ($raw === null) return [];
        if (is_array($raw)) return $raw;
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function setTranslation(string $field, string $locale, ?string $value): static
    {
        $all = $this->getTranslations($field);
        if ($value === null || $value === '') {
            unset($all[$locale]);
        } else {
            $all[$locale] = $value;
        }
        $this->attributes[$field] = json_encode($all, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    public function setTranslations(string $field, array $values): static
    {
        $clean = array_filter($values, fn ($v) => $v !== null && $v !== '');
        $this->attributes[$field] = json_encode($clean, JSON_UNESCAPED_UNICODE);
        return $this;
    }
}
