<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.pages.index', [
            'pages' => Page::orderBy('id', 'desc')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'                 => 'required|string|max:190|unique:pages,slug',
            'title_ar'             => 'required|string|max:190',
            'title_en'             => 'nullable|string|max:190',
            'content_ar'           => 'nullable|string',
            'content_en'           => 'nullable|string',
            'meta_title_ar'        => 'nullable|string|max:190',
            'meta_title_en'        => 'nullable|string|max:190',
            'meta_description_ar'  => 'nullable|string',
            'meta_description_en'  => 'nullable|string',
            'image'                => 'nullable|image|max:2048',
            'is_published'         => 'nullable|boolean',
        ]);

        $payload = array_merge(
            ['slug' => $data['slug'], 'is_published' => (bool) $request->input('is_published', false)],
            $this->mergeTranslatable($request, ['title', 'content', 'meta_title', 'meta_description']),
        );

        if ($path = $this->uploadFile($request, 'image', 'pages')) {
            $payload['image'] = $path;
        }

        Page::create($payload);

        return redirect()->route('admin.pages.index')->with('success', __('Created successfully'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', ['page' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'slug'                 => 'required|string|max:190|unique:pages,slug,' . $page->id,
            'title_ar'             => 'required|string|max:190',
            'title_en'             => 'nullable|string|max:190',
            'content_ar'           => 'nullable|string',
            'content_en'           => 'nullable|string',
            'meta_title_ar'        => 'nullable|string|max:190',
            'meta_title_en'        => 'nullable|string|max:190',
            'meta_description_ar'  => 'nullable|string',
            'meta_description_en'  => 'nullable|string',
            'image'                => 'nullable|image|max:2048',
            'is_published'         => 'nullable|boolean',
        ]);

        $payload = array_merge(
            ['slug' => $data['slug'], 'is_published' => (bool) $request->input('is_published', false)],
            $this->mergeTranslatable($request, ['title', 'content', 'meta_title', 'meta_description']),
        );

        if ($path = $this->uploadFile($request, 'image', 'pages')) {
            $payload['image'] = $path;
        }

        $page->update($payload);

        return redirect()->route('admin.pages.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', __('Deleted successfully'));
    }
}
