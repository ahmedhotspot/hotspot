<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesTranslatable;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    use HandlesTranslatable;

    public function index()
    {
        return view('admin.banks.index', [
            'banks' => Bank::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.banks.form', ['bank' => new Bank()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'        => 'required|string|max:190|unique:banks,slug',
            'name_ar'     => 'required|string|max:190',
            'name_en'     => 'nullable|string|max:190',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $payload = array_merge(
            ['slug' => $data['slug'], 'order' => $data['order'] ?? 0, 'is_active' => (bool) $request->input('is_active', false)],
            $this->mergeTranslatable($request, ['name', 'description']),
        );

        if ($path = $this->uploadFile($request, 'logo', 'banks')) {
            $payload['logo'] = $path;
        }

        Bank::create($payload);

        return redirect()->route('admin.banks.index')->with('success', __('Created successfully'));
    }

    public function edit(Bank $bank)
    {
        return view('admin.banks.form', ['bank' => $bank]);
    }

    public function update(Request $request, Bank $bank)
    {
        $data = $request->validate([
            'slug'        => 'required|string|max:190|unique:banks,slug,' . $bank->id,
            'name_ar'     => 'required|string|max:190',
            'name_en'     => 'nullable|string|max:190',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);

        $payload = array_merge(
            ['slug' => $data['slug'], 'order' => $data['order'] ?? 0, 'is_active' => (bool) $request->input('is_active', false)],
            $this->mergeTranslatable($request, ['name', 'description']),
        );

        if ($path = $this->uploadFile($request, 'logo', 'banks')) {
            $payload['logo'] = $path;
        }

        $bank->update($payload);

        return redirect()->route('admin.banks.index')->with('success', __('Updated successfully'));
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return back()->with('success', __('Deleted successfully'));
    }
}
