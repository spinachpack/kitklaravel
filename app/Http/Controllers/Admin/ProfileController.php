<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('admin.profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Check if this is the original admin
        $isOriginalAdmin = ($user->id_number === 'ADMIN001' || $user->email === 'admin@ucbanilad.edu.ph');

        // If original admin, don't allow department change
        if ($isOriginalAdmin) {
            $validated = $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);
        } else {
            $validated = $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'department' => 'required|string|max:100',
            ]);
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePicture(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        // Delete old picture
        if ($user->profile_picture && $user->profile_picture !== 'default-avatar.png') {
            $oldPath = public_path('uploads/profiles/' . $user->profile_picture);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Upload new picture
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $request->file('profile_picture')->extension();
        $request->file('profile_picture')->move(public_path('uploads/profiles'), $filename);

        $user->update(['profile_picture' => $filename]);

        return back()->with('success', 'Profile picture updated successfully!');
    }

    public function showChangePasswordForm()
    {
        return view('admin.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password changed successfully!');
    }
}