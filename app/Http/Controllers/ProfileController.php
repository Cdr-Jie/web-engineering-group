<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'phone' => 'nullable|string',
        'category' => 'required',
        'events' => 'required|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    } else {
        unset($data['password']);
    }

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Delete old profile image if exists
        if (Auth::user()->profile_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete(Auth::user()->profile_image);
        }
        $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
    }

    Auth::user()->update($data);

    return redirect()->route('dashboard')->with('success', 'Profile updated!');
    }  

     public function edit()
    {
        return view('dashboard.profile'); // your Blade file
    }


}
