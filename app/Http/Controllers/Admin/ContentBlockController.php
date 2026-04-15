<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\Request;

class ContentBlockController extends Controller
{
    use HandlesTranslatable;

    public function index(Request $request)
    {
        $pages = ContentBlock::select('page')->distinct()->orderBy('page')->pluck('page');
        $currentPage = $request->query('page', $pages->first());

        $blocks = ContentBlock::where('page', $currentPage)
            ->orderBy('section')->orderBy('order')->orderBy('key')
            ->get()
            ->groupBy('section');

        return view('admin.content-blocks.index', compact('pages', 'currentPage', 'blocks'));
    }

    public function update(Request $request)
    {
        $rows = $request->input('blocks', []);
        foreach ($rows as $id => $fields) {
            $block = ContentBlock::find($id);
            if (! $block) continue;

            if ($block->type === 'image') {
                if ($request->hasFile("image.$id")) {
                    $path = $request->file("image.$id")->store('content', 'public');
                    $block->value = ['path' => 'storage/' . $path];
                }
            } else {
                $block->value = [
                    'ar' => $fields['ar'] ?? '',
                    'en' => $fields['en'] ?? '',
                ];
            }
            $block->save();
        }

        ContentBlock::clearCache();
        return back()->with('success', __('Updated successfully'));
    }

    public function create()
    {
        return view('admin.content-blocks.form', ['block' => new ContentBlock()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page'    => 'required|string|max:60',
            'section' => 'nullable|string|max:80',
            'key'     => 'required|string|max:120',
            'type'    => 'required|in:text,html,image',
            'label'   => 'nullable|string|max:255',
            'order'   => 'nullable|integer',
        ]);

        ContentBlock::create(array_merge($data, [
            'value' => $request->input('type') === 'image' ? [] : ['ar' => '', 'en' => ''],
        ]));

        return redirect()->route('admin.content-blocks.index', ['page' => $data['page']])
            ->with('success', __('Created successfully'));
    }

    public function destroy(ContentBlock $contentBlock)
    {
        $contentBlock->delete();
        return back()->with('success', __('Deleted successfully'));
    }
}
