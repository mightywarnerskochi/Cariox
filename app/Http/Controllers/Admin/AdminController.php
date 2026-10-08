<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaStorage;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\FormData;
use App\Models\Newsletter;

class AdminController extends Controller
{
    public function index()
    {
        $counts = [
            'brands' => Brand::count(),
            'categories' => Category::count(),
            'subcategories' => Subcategory::count(),
            'products' => Product::count(),
            'testimonials' => Testimonial::count(),
            'services' => Service::count(),
            'blogs' => Blog::count(),
            'contacts' => Contact::count(),
            'form_datas' => FormData::count(),
            'newsletters' => Newsletter::count(),
        ];

        $recentProducts = Product::with(['category', 'brand', 'images'])->latest()->take(5)->get();
        $recentEnquiries = FormData::latest()->take(5)->get();

        return view('admin.dashboard', compact('counts', 'recentProducts', 'recentEnquiries'));
    }

    public function profile()
    {
        $admin = auth('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request, MediaStorage $media)
    {
        $admin = auth('admin')->user();

        /** @var \App\Models\Admin $admin */
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'phone' => 'required|numeric',
            'password' => 'nullable|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->phone = $request->phone;

        if ($request->filled('password')) {
            $admin->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        // Stored first; the file it replaces is removed once the record is saved
        $profileImageUpload = $media->stage($admin, $request, ['profile_image'], 'admins');
        $admin->forceFill($profileImageUpload->paths());

        $admin->save();
        $profileImageUpload->commit();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
