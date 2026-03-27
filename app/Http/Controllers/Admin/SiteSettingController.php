<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first() ?? SiteSetting::create();
        return view('admin.settings.site_information', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::first() ?? SiteSetting::create();

        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            'company_name' => 'nullable|string|max:255',
            'official_email' => 'nullable|email|max:255',
            'official_phone' => 'nullable|string|max:50',
            'official_whatsapp' => 'nullable|string|max:50',
            'copyright' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'pinterest_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'terms_conditions' => 'nullable|string',
            'privacy_policy' => 'nullable|string',
            'gtm_ids' => 'nullable|string',
            'custom_head_scripts' => 'nullable|string',
            'custom_body_scripts' => 'nullable|string',
        ]);

        $data = $request->except(['logo', 'footer_logo', 'favicon']);

        // Handle Logo
        if ($request->hasFile('logo')) {
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        // Handle Footer Logo
        if ($request->hasFile('footer_logo')) {
            if ($settings->footer_logo && Storage::disk('public')->exists($settings->footer_logo)) {
                Storage::disk('public')->delete($settings->footer_logo);
            }
            $data['footer_logo'] = $request->file('footer_logo')->store('settings', 'public');
        }

        // Handle Favicon
        if ($request->hasFile('favicon')) {
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $settings->update($data);

        return back()->with('success', 'Site information updated successfully.');
    }

    public function removeImage(Request $request)
    {
        $request->validate(['field' => 'required|in:logo,footer_logo,favicon']);
        
        $settings = SiteSetting::first();
        if (!$settings) return response()->json(['success' => false, 'message' => 'Settings not found.']);
        
        $field = $request->field;
        
        if ($settings->$field) {
            if (Storage::disk('public')->exists($settings->$field)) {
                Storage::disk('public')->delete($settings->$field);
            }
            $settings->$field = null;
            $settings->save();
        }
        
        return response()->json(['success' => true]);
    }
}
