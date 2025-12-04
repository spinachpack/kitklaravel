<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'id_or_email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->id_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'id_number';

        if (Auth::attempt([
            $loginField => $request->id_or_email,
            'password' => $request->password,
            'status' => 'active'
        ], $request->filled('remember'))) {
            
            $request->session()->regenerate();

            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'department') {
                return redirect()->intended('/department/dashboard');
            } else {
                return redirect()->intended('/user/dashboard');
            }
        }

        return back()->withErrors([
            'id_or_email' => 'Invalid credentials.',
        ])->withInput();
    }
}