<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected array $statuses = ['new', 'read', 'replied', 'closed'];

    public function index()
    {
        return view('admin.contacts.index', [
            'contacts' => Contact::orderBy('id', 'desc')->paginate(20),
            'statuses' => $this->statuses,
        ]);
    }

    public function show(Contact $contact)
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', [
            'contact'  => $contact,
            'statuses' => $this->statuses,
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'status'      => 'required|in:' . implode(',', $this->statuses),
            'admin_notes' => 'nullable|string',
        ]);

        $contact->update($data);

        return back()->with('success', __('Updated successfully'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', __('Deleted successfully'));
    }
}
