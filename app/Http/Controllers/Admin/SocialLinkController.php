<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        return view('admin.social.index', [
            'links' => SocialLink::orderBy('order')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.social.form', ['link' => new SocialLink()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['is_active'] = (bool) $request->input('is_active', false);

        SocialLink::create($data);

        return redirect()->route('admin.social.index')->with('success', __('Created successfully'));
    }

    public function edit(SocialLink $social)
    {
        return view('admin.social.form', ['link' => $social]);
    }

    public function update(Request $request, SocialLink $social)
    {
        $data = $this->validateData($request);
        $data['is_active'] = (bool) $request->input('is_active', false);

        $social->update($data);

        return redirect()->route('admin.social.index')->with('success', __('Updated successfully'));
    }

    public function destroy(SocialLink $social)
    {
        $social->delete();
        return back()->with('success', __('Deleted successfully'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'platform'  => 'nullable|string|max:100',
            'url'       => 'required|string|max:500',
            'icon'      => 'nullable|string|max:100',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
    }
}
