<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\HowItWorksStep;
use Illuminate\Http\Request;

class HowItWorksStepController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.steps.index', [
            'steps' => HowItWorksStep::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.steps.form', ['step' => new HowItWorksStep()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'icon'      => $data['icon'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['title', 'description']),
        );

        HowItWorksStep::create($payload);

        return redirect()->route('admin.steps.index')->with('success', __('Created successfully'));
    }

    public function edit(HowItWorksStep $step)
    {
        return view('admin.steps.form', ['step' => $step]);
    }

    public function update(Request $request, HowItWorksStep $step)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'icon'      => $data['icon'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['title', 'description']),
        );

        $step->update($payload);

        return redirect()->route('admin.steps.index')->with('success', __('Updated successfully'));
    }

    public function destroy(HowItWorksStep $step)
    {
        $step->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'icon'           => 'nullable|string|max:100',
            'title_ar'       => 'required|string|max:190',
            'title_en'       => 'nullable|string|max:190',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'order'          => 'nullable|integer',
            'is_active'      => 'nullable|boolean',
        ]);
    }
}
