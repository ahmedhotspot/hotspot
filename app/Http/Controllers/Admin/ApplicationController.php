<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected array $statuses = ['new', 'reviewing', 'approved', 'rejected', 'completed'];

    public function index(Request $request)
    {
        $query = Application::with(['bank', 'service', 'offer', 'user'])->orderBy('id', 'desc');

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        return view('admin.applications.index', [
            'applications' => $query->paginate(20)->withQueryString(),
            'statuses'     => $this->statuses,
            'currentStatus' => $status,
        ]);
    }

    public function show(Application $application)
    {
        $application->load(['bank', 'service', 'offer', 'user']);
        return view('admin.applications.show', [
            'application' => $application,
            'statuses'    => $this->statuses,
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', $this->statuses),
            'notes'  => 'nullable|string',
        ]);

        $application->update($data);

        return back()->with('success', __('Updated successfully'));
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.index')->with('success', __('Deleted successfully'));
    }
}
