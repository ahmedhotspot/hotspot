<?php

namespace App\Models;

use App\Support\Translatable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Translatable;

    protected $fillable = [
        'slug', 'title', 'category', 'excerpt', 'content',
        'image', 'author_id', 'published_at', 'is_featured', 'order',
    ];
    protected $casts = [
        'title' => 'array', 'category' => 'array', 'excerpt' => 'array', 'content' => 'array',
        'is_featured' => 'boolean', 'published_at' => 'datetime',
    ];
    protected array $translatable = ['title', 'category', 'excerpt', 'content'];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }

    public function scopePublished($q)
    {
        return $q->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
