<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorRegistration;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class VendorController extends Controller
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showRegistrationForm()
    {
        return view('vendor.register');
    }

    function sanitizeFileName($filename) {
        // Replace special characters with underscores
        return preg_replace('/[^A-Za-z0-9\-\.]/', '_', $filename);
    }

    public function register(Request $request)
    {
        $request->validate([
            'business_license' => 'required|string',
            'tax_id' => 'required|string',
            'incorporation_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg',
            'insurance_certificates.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg',
            'business_logo' => 'nullable|file|mimes:jpeg,png,jpg',
            'premises_photo' => 'nullable|file|mimes:jpeg,png,jpg',
            'product_images.*' => 'nullable|file|mimes:jpeg,png,jpg',
        ]);

        $vendorRegistration = new VendorRegistration();
        $vendorRegistration->user_id = Auth::id();
        $vendorRegistration->business_license = $request->input('business_license');
        $vendorRegistration->tax_id = $request->input('tax_id');

        // Handle file uploads
        if ($request->hasFile('incorporation_certificate')) {
            //$file = $request->file('incorporation_certificate');
           // $filename = time() . '-' . $file->getClientOriginalName(); // You can customize the filename as needed
            //$vendorRegistration->incorporation_certificate = $file->storeAs('documents', $filename);

            $file = $request->file('incorporation_certificate');
            $filename = $this->sanitizeFileName(time() . '-' . $file->getClientOriginalName());
            $vendorRegistration->incorporation_certificate = $file->storeAs('documents', $filename, 'public');
        }

        if ($request->hasFile('insurance_certificates')) {
            $files = $request->file('insurance_certificates');
            $filenames = array_map(function($file) {
                $filename = $this->sanitizeFileName(time() . '-' . $file->getClientOriginalName()); // Customize filename as needed
                return $file->storeAs('documents', $filename, 'public');
            }, $files);
            $vendorRegistration->insurance_certificates = json_encode($filenames);
        }

        if ($request->hasFile('business_logo')) {
            $file = $request->file('business_logo');
            $filename = $this->sanitizeFileName(time() . '-' . $file->getClientOriginalName()); // Customize filename as needed
            $vendorRegistration->business_logo = $file->storeAs('images', $filename, 'public');
        }

        if ($request->hasFile('premises_photo')) {
            $file = $request->file('premises_photo');
            $filename = $this->sanitizeFileName(time() . '-' . $file->getClientOriginalName()); // Customize filename as needed
            $vendorRegistration->premises_photo = $file->storeAs('images', $filename, 'public');
        }

        if ($request->hasFile('product_images')) {
            $files = $request->file('product_images');
            $filenames = array_map(function($file) {
                $filename = $this->sanitizeFileName(time() . '-' . $file->getClientOriginalName()); // Customize filename as needed
                return $file->storeAs('images', $filename, 'public');
            }, $files);
            $vendorRegistration->product_images = json_encode($filenames);
        }

        $vendorRegistration->save();

        return redirect()->route('vendor.register')->with('success', 'Vendor registration submitted successfully!');
    }


    public function showSubmission()
    {
        // Fetch the vendor registrations for the authenticated user
        $vendors = VendorRegistration::where('user_id', Auth::id())
        ->orderBy('submitted_at', 'desc')
        ->get();

        if ($vendors->isEmpty()) {
            return redirect()->route('vendor.register')->with('error', 'No vendor registration found.');
        }

        return view('vendor.show', compact('vendors'));
    }

    // public function showAllSubmission()
    // {
    //     // Fetch all vendor registrations
    //     // $vendors = VendorRegistration::all();
    //     // Fetch all vendor registrations where status is 'Pending' (case-insensitive)
    //     $vendors = VendorRegistration::whereRaw('LOWER(status) = ?', ['pending'])->get();

    //     if ($vendors->isEmpty()) {
    //         return view('vendor.vendor-submissions', ['vendors' => $vendors])->with('error', 'No vendor registrations found.');
    //     }

    //     return view('vendor.vendor-submissions', compact('vendors'));
    // }

    public function showAllSubmission()
    {
        // Fetch all vendor registrations where status is 'Pending' (case-insensitive)
        $vendors = VendorRegistration::select('vendor_registrations.*', 'users.name', 'users.contact_number')
            ->join('users', 'vendor_registrations.user_id', '=', 'users.id')
            ->whereRaw('LOWER(vendor_registrations.status) = ?', ['pending'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        if ($vendors->isEmpty()) {
            return view('vendor.vendor-submissions', ['vendors' => $vendors])->with('error', 'No vendor registrations found.');
        }

        return view('vendor.vendor-submissions', compact('vendors'));
    }

    public function showAllSubmission2()
    {
        // Fetch all vendor registrations
        // $vendors = VendorRegistration::all();
        $vendors = VendorRegistration::select('vendor_registrations.*', 'users.name', 'users.contact_number')
            ->join('users', 'vendor_registrations.user_id', '=', 'users.id')
            ->whereRaw('LOWER(vendor_registrations.status) = ?', ['approved'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        if ($vendors->isEmpty()) {
            return view('vendor.vendor-accepted', ['vendors' => $vendors])->with('error', 'No vendor registrations found.');
        }

        return view('vendor.vendor-accepted', compact('vendors'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request data (optional)
        $request->validate([
            'status' => 'required|string|in:Pending,Approved,Rejected',
        ]);

        // Find the vendor record by ID
        $vendor = VendorRegistration::findOrFail($id);

        // Update the status
        $vendor->status = $request->input('status');
        $vendor->save();

        // Redirect back with a success message
        return redirect()->route('vendor.submissions')->with('success', 'Vendor status updated successfully.');
    }

    public function deleteSubmission($id)
    {
        // Find the vendor submission that belongs to the authenticated user
        $vendor = VendorRegistration::where('user_id', Auth::id())->findOrFail($id);

        // Convert the status to lowercase for comparison
        if (strtolower($vendor->status) === 'approved') {
            // Redirect with an error message if the status is 'Approved'
            return redirect()->route('vendor.submission')->with('error', 'Approved submissions cannot be deleted.');
        }

        // Perform the deletion
        $vendor->delete();

        // Redirect with a success message
        return redirect()->route('vendor.submission')->with('success', 'Submission deleted successfully.');
    }





}


