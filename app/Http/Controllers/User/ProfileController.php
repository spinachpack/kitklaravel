<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.profile.show', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'department' => 'required|string',
        ]);
        
        $user->update($request->only(['first_name', 'last_name', 'email', 'department']));
        
        return back()->with('success', 'Profile updated successfully!');
    }
    
    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);
        
        $user = Auth::user();
        
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if not default
            if ($user->profile_picture !== 'default-avatar.png') {
                $oldPath = public_path('uploads/profiles/' . $user->profile_picture);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Upload new picture
            $file = $request->file('profile_picture');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->extension();
            $file->move(public_path('uploads/profiles'), $filename);
            
            $user->update(['profile_picture' => $filename]);
        }
        
        return back()->with('success', 'Profile picture updated successfully!');
    }
    

    public function showChangePasswordForm()
{
    return view('user.profile.change-password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);
    
    $user = Auth::user();
    
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }
    
    $user->update(['password' => Hash::make($request->new_password)]);
    
    return back()->with('success', 'Password changed successfully!');
}
}