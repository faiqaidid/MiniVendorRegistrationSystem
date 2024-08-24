<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact_number' => 'nullable|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'role' => 'vendor',
        ]);

        // Redirect back with a success message
        return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
    }

    public function dashboard()
    {
        // Check the role of the authenticated user
        $user = Auth::user();

        // Return the appropriate view based on user role
        if ($user->role === 'admin') {
            return view('dashboard.admin');
        }

        return view('dashboard.user');
    }

    public function showProfile()
    {
        return view('dashboard.userprofile');
    }

    public function updateProfile(Request $request, $id)
    {
        // Validate the data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact' => 'nullable|numeric',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Retrieve the user and update their details
        $user = User::findOrFail($id);

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->contact_number = $validatedData['contact']; // Update contact number

        // If a password is provided, hash it
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Save the updated user information
        $user->save();

        // Redirect back with a success message
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }


}

