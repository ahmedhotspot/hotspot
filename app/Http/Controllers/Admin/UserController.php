<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::orderBy('id', 'desc')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:190',
            'email'    => 'required|email|max:190|unique:users,email',
            'phone'    => 'nullable|string|max:50',
            'role'     => 'required|in:user,admin,super_admin',
            'password' => 'required|string|min:6|confirmed',
            'is_active'=> 'nullable|boolean',
            'locale'   => 'nullable|in:ar,en',
        ]);

        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = (bool) $request->input('is_active', false);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', __('Created successfully'));
    }

    public function edit(User $user)
    {
        return view('admin.users.form', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:190',
            'email'    => 'required|email|max:190|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:50',
            'role'     => 'required|in:user,admin,super_admin',
            'password' => 'nullable|string|min:6|confirmed',
            'is_active'=> 'nullable|boolean',
            'locale'   => 'nullable|in:ar,en',
        ]);

        $data['is_active'] = (bool) $request->input('is_active', false);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', __('Updated successfully'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', __('You cannot delete yourself'));
        }

        $user->delete();
        return back()->with('success', __('Deleted successfully'));
    }
}
