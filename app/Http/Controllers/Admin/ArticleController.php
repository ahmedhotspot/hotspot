<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.articles.index', [
            'articles' => Article::orderBy('order')->orderBy('id', 'desc')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.articles.form', [
            'article' => new Article(),
            'users'   => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'slug'         => $data['slug'],
                'image'        => null,
                'author_id'    => $data['author_id'] ?? auth()->id(),
                'published_at' => $data['published_at'] ?? null,
                'is_featured'  => (bool) $request->input('is_featured', false),
                'order'        => $data['order'] ?? 0,
            ],
            $this->mergeTranslatable($request, ['title', 'category', 'excerpt', 'content']),
        );

        if ($path = $this->uploadFile($request, 'image', 'articles')) {
            $payload['image'] = $path;
        }

        Article::create($payload);

        return redirect()->route('admin.articles.index')->with('success', __('Created successfully'));
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', [
            'article' => $article,
            'users'   => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validateData($request, $article->id);

        $payload = array_merge(
            [
                'slug'         => $data['slug'],
                'author_id'    => $data['author_id'] ?? auth()->id(),
                'published_at' => $data['published_at'] ?? null,
                'is_featured'  => (bool) $request->input('is_featured', false),
                'order'        => $data['order'] ?? 0,
            ],
            $this->mergeTranslatable($request, ['title', 'category', 'excerpt', 'content']),
        );

        if ($path = $this->uploadFile($request, 'image', 'articles')) {
            $payload['image'] = $path;
        }

        $article->update($payload);

        return redirect()->route('admin.articles.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        $unique = 'unique:articles,slug' . ($id ? ',' . $id : '');
        return $request->validate([
            'slug'          => 'required|string|max:190|' . $unique,
            'title_ar'      => 'required|string|max:190',
            'title_en'      => 'nullable|string|max:190',
            'category_ar'   => 'nullable|string|max:190',
            'category_en'   => 'nullable|string|max:190',
            'excerpt_ar'    => 'nullable|string',
            'excerpt_en'    => 'nullable|string',
            'content_ar'    => 'nullable|string',
            'content_en'    => 'nullable|string',
            'image'         => 'nullable|image|max:2048',
            'author_id'     => 'nullable|exists:users,id',
            'published_at'  => 'nullable|date',
            'is_featured'   => 'nullable|boolean',
            'order'         => 'nullable|integer',
        ]);
    }
}
