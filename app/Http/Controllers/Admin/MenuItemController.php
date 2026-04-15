<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    use HandlesTranslatable;

    protected array $locations = ['header', 'footer_finance', 'footer_company', 'footer_legal'];

    public function index()
    {
        return view('admin.menus.index', [
            'items'     => MenuItem::orderBy('location')->orderBy('order')->paginate(20),
            'locations' => $this->locations,
        ]);
    }

    public function create()
    {
        return view('admin.menus.form', [
            'item'      => new MenuItem(),
            'parents'   => MenuItem::whereNull('parent_id')->orderBy('order')->get(),
            'locations' => $this->locations,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'location'  => $data['location'],
                'parent_id' => $data['parent_id'] ?: null,
                'url'       => $data['url'] ?? null,
                'target'    => $data['target'] ?? '_self',
                'icon'      => $data['icon'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['label']),
        );

        MenuItem::create($payload);

        return redirect()->route('admin.menus.index')->with('success', __('Created successfully'));
    }

    public function edit(MenuItem $menu)
    {
        return view('admin.menus.form', [
            'item'      => $menu,
            'parents'   => MenuItem::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('order')->get(),
            'locations' => $this->locations,
        ]);
    }

    public function update(Request $request, MenuItem $menu)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'location'  => $data['location'],
                'parent_id' => $data['parent_id'] ?: null,
                'url'       => $data['url'] ?? null,
                'target'    => $data['target'] ?? '_self',
                'icon'      => $data['icon'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['label']),
        );

        $menu->update($payload);

        return redirect()->route('admin.menus.index')->with('success', __('Updated successfully'));
    }

    public function destroy(MenuItem $menu)
    {
        $menu->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'location'  => 'required|in:' . implode(',', $this->locations),
            'parent_id' => 'nullable|exists:menu_items,id',
            'label_ar'  => 'required|string|max:190',
            'label_en'  => 'nullable|string|max:190',
            'url'       => 'nullable|string|max:500',
            'target'    => 'nullable|in:_self,_blank',
            'icon'      => 'nullable|string|max:100',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
    }
}
