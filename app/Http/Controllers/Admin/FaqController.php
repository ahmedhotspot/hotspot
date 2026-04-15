<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.faqs.index', [
            'faqs' => Faq::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.faqs.form', ['faq' => new Faq()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'category'  => $data['category'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['question', 'answer']),
        );

        Faq::create($payload);

        return redirect()->route('admin.faqs.index')->with('success', __('Created successfully'));
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', ['faq' => $faq]);
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'category'  => $data['category'] ?? null,
                'order'     => $data['order'] ?? 0,
                'is_active' => (bool) $request->input('is_active', false),
            ],
            $this->mergeTranslatable($request, ['question', 'answer']),
        );

        $faq->update($payload);

        return redirect()->route('admin.faqs.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'category'    => 'nullable|string|max:190',
            'question_ar' => 'required|string|max:500',
            'question_en' => 'nullable|string|max:500',
            'answer_ar'   => 'nullable|string',
            'answer_en'   => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);
    }
}
