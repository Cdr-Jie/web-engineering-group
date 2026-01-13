<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // Optional: handle registration submission
    public function register(Request $request)
{
    $data = $request->validate([
        'category' => 'required|in:staff,student,public',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|min:6|confirmed', // add password_confirmation input in form if you want
        'event' => 'required|array|min:1',
    ]);

    // Create user
    \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'phone' => $data['phone'] ?? null,
        'category' => $data['category'],
        'events' => json_encode($data['event']), // store as JSON
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please login.');
    }


    // Optional: handle login submission
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

// Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showDashboard(Request $request)
    {
        return view('dashboard.index');
    }

    public function showEventBoard()
    {
        return view('events'); // resources/views/auth/login.blade.php
    }

}

