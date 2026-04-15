<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\TrustMetric;
use Illuminate\Http\Request;

class TrustMetricController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.trust-metrics.index', [
            'metrics' => TrustMetric::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.trust-metrics.form', ['metric' => new TrustMetric()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            ['order' => $data['order'] ?? 0, 'is_active' => (bool) $request->input('is_active', false)],
            $this->mergeTranslatable($request, ['value', 'label']),
        );

        TrustMetric::create($payload);

        return redirect()->route('admin.trust-metrics.index')->with('success', __('Created successfully'));
    }

    public function edit(TrustMetric $trustMetric)
    {
        return view('admin.trust-metrics.form', ['metric' => $trustMetric]);
    }

    public function update(Request $request, TrustMetric $trustMetric)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            ['order' => $data['order'] ?? 0, 'is_active' => (bool) $request->input('is_active', false)],
            $this->mergeTranslatable($request, ['value', 'label']),
        );

        $trustMetric->update($payload);

        return redirect()->route('admin.trust-metrics.index')->with('success', __('Updated successfully'));
    }

    public function destroy(TrustMetric $trustMetric)
    {
        $trustMetric->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'value_ar'  => 'required|string|max:190',
            'value_en'  => 'nullable|string|max:190',
            'label_ar'  => 'required|string|max:190',
            'label_en'  => 'nullable|string|max:190',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
    }
}
