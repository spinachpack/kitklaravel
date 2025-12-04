<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent changing original admin (ID 1)
        if ($user->id == 1) {
            return back()->with('error', 'Cannot change the role of the original administrator.');
        }

        $validated = $request->validate([
            'role' => 'required|in:user,department,admin',
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'User role updated successfully! User must log out and log back in for changes to take effect.');
    }

    public function changeStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user->update(['status' => $validated['status']]);

        return back()->with('success', 'User status updated successfully!');
    }
}