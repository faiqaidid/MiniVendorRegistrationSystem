<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdminController extends Controller
{
    public function showProfile()
    {
        return view('dashboard.adminprofile');
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
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }




    // public function viewSubmission()
    // {
    //     // Retrieve vendor submissions (assuming 'vendor' role or similar filter)
    //     $vendors = User::where('role', 'vendor')->get();
    //     // Pass the vendor submissions to the view
    //     return view('vendor.vendor-submissions', compact('vendors'));
    // }
    // public function viewSubmission()
    // {
    //     $vendors = User::all(); // or any other query to fetch vendors
    //     return view('vendor.vendor-submissions', compact('vendors'));
    // }


}
