<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'stars'     => $data['stars'] ?? 5,
                'initial'   => $data['initial'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['name', 'city', 'text']),
        );

        if ($path = $this->uploadFile($request, 'avatar', 'testimonials')) {
            $payload['avatar'] = $path;
        }

        Testimonial::create($payload);

        return redirect()->route('admin.testimonials.index')->with('success', __('Created successfully'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', ['testimonial' => $testimonial]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'stars'     => $data['stars'] ?? 5,
                'initial'   => $data['initial'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['name', 'city', 'text']),
        );

        if ($path = $this->uploadFile($request, 'avatar', 'testimonials')) {
            $payload['avatar'] = $path;
        }

        $testimonial->update($payload);

        return redirect()->route('admin.testimonials.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'name_ar'   => 'required|string|max:190',
            'name_en'   => 'nullable|string|max:190',
            'city_ar'   => 'nullable|string|max:190',
            'city_en'   => 'nullable|string|max:190',
            'text_ar'   => 'nullable|string',
            'text_en'   => 'nullable|string',
            'stars'     => 'nullable|numeric|min:0|max:5',
            'avatar'    => 'nullable|image|max:2048',
            'initial'   => 'nullable|string|max:4',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
    }
}
