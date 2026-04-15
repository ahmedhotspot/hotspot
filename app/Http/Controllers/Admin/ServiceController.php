<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.services.index', [
            'services' => Service::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'slug'       => $data['slug'],
                'icon'       => $data['icon'] ?? null,
                'icon_class' => $data['icon_class'] ?? null,
                'order'      => $data['order'] ?? 0,
                'is_active'  => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['title', 'description', 'long_description']),
        );

        if ($path = $this->uploadFile($request, 'image', 'services')) {
            $payload['image'] = $path;
        }

        Service::create($payload);

        return redirect()->route('admin.services.index')->with('success', __('Created successfully'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', ['service' => $service]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validateData($request, $service->id);

        $payload = array_merge(
            [
                'slug'       => $data['slug'],
                'icon'       => $data['icon'] ?? null,
                'icon_class' => $data['icon_class'] ?? null,
                'order'      => $data['order'] ?? 0,
                'is_active'  => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['title', 'description', 'long_description']),
        );

        if ($path = $this->uploadFile($request, 'image', 'services')) {
            $payload['image'] = $path;
        }

        $service->update($payload);

        return redirect()->route('admin.services.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        $unique = 'unique:services,slug' . ($id ? ',' . $id : '');
        return $request->validate([
            'slug'                  => 'required|string|max:190|' . $unique,
            'title_ar'              => 'required|string|max:190',
            'title_en'              => 'nullable|string|max:190',
            'description_ar'        => 'nullable|string',
            'description_en'        => 'nullable|string',
            'long_description_ar'   => 'nullable|string',
            'long_description_en'   => 'nullable|string',
            'icon'                  => 'nullable|string|max:100',
            'icon_class'            => 'nullable|string|max:100',
            'image'                 => 'nullable|image|max:2048',
            'order'                 => 'nullable|integer',
            'is_active'             => 'nullable|boolean',
        ]);
    }
}
