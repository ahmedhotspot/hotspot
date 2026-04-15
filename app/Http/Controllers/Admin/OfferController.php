<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.offers.index', [
            'offers' => Offer::with(['bank', 'service'])->orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.offers.form', [
            'offer'    => new Offer(),
            'banks'    => Bank::orderBy('order')->get(),
            'services' => Service::orderBy('order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'bank_id'        => $data['bank_id'],
                'service_id'     => $data['service_id'],
                'apr'            => $data['apr'] ?? null,
                'max_amount'     => $data['max_amount'] ?? null,
                'min_amount'     => $data['min_amount'] ?? null,
                'monthly_sample' => $data['monthly_sample'] ?? null,
                'max_term_years' => $data['max_term_years'] ?? null,
                'approval_icon'  => $data['approval_icon'] ?? null,
                'sector'         => $data['sector'] ?? null,
                'is_best'        => (bool) $request->input('is_best', false),
                'is_active'      => (bool) $request->input('is_active', false),
                'order'          => $data['order'] ?? 0,
            ],
            $this->mergeTranslatable($request, ['title', 'approval_note']),
        );

        Offer::create($payload);

        return redirect()->route('admin.offers.index')->with('success', __('Created successfully'));
    }

    public function edit(Offer $offer)
    {
        return view('admin.offers.form', [
            'offer'    => $offer,
            'banks'    => Bank::orderBy('order')->get(),
            'services' => Service::orderBy('order')->get(),
        ]);
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $this->validateData($request);

        $payload = array_merge(
            [
                'bank_id'        => $data['bank_id'],
                'service_id'     => $data['service_id'],
                'apr'            => $data['apr'] ?? null,
                'max_amount'     => $data['max_amount'] ?? null,
                'min_amount'     => $data['min_amount'] ?? null,
                'monthly_sample' => $data['monthly_sample'] ?? null,
                'max_term_years' => $data['max_term_years'] ?? null,
                'approval_icon'  => $data['approval_icon'] ?? null,
                'sector'         => $data['sector'] ?? null,
                'is_best'        => (bool) $request->input('is_best', false),
                'is_active'      => (bool) $request->input('is_active', false),
                'order'          => $data['order'] ?? 0,
            ],
            $this->mergeTranslatable($request, ['title', 'approval_note']),
        );

        $offer->update($payload);

        return redirect()->route('admin.offers.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'bank_id'            => 'required|exists:banks,id',
            'service_id'         => 'required|exists:services,id',
            'title_ar'           => 'required|string|max:190',
            'title_en'           => 'nullable|string|max:190',
            'apr'                => 'nullable|numeric',
            'max_amount'         => 'nullable|numeric',
            'min_amount'         => 'nullable|numeric',
            'monthly_sample'     => 'nullable|numeric',
            'max_term_years'     => 'nullable|integer',
            'approval_note_ar'   => 'nullable|string',
            'approval_note_en'   => 'nullable|string',
            'approval_icon'      => 'nullable|string|max:100',
            'sector'             => 'nullable|string|max:100',
            'is_best'            => 'nullable|boolean',
            'is_active'          => 'nullable|boolean',
            'order'              => 'nullable|integer',
        ]);
    }
}
