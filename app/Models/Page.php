<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Translatable;

    protected $fillable = ['slug', 'title', 'content', 'meta_title', 'meta_description', 'image', 'is_published'];
    protected $casts    = [
        'title' => 'array', 'content' => 'array',
        'meta_title' => 'array', 'meta_description' => 'array',
        'is_published' => 'boolean',
    ];
    protected array $translatable = ['title', 'content', 'meta_title', 'meta_description'];
}
