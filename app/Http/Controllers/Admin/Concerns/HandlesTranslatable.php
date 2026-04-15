<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;

trait HandlesTranslatable
{
    /**
     * Merge translatable fields from request ({field}_ar, {field}_en) into JSON arrays.
     */
    protected function mergeTranslatable(Request $request, array $fields): array
    {
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = [
                'ar' => $request->input($field . '_ar'),
                'en' => $request->input($field . '_en'),
            ];
        }
        return $data;
    }

    /**
     * Handle a single file upload and return the stored path (relative to public disk).
     */
    protected function uploadFile(Request $request, string $field, string $folder = 'uploads'): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }
        $path = $request->file($field)->store($folder, 'public');
        return 'storage/' . $path;
    }
}
