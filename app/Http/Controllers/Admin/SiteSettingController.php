<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaStorage;
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

    public function update(Request $request, MediaStorage $media)
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
        // Stored first; the file it replaces is removed once the record is saved
        $logoUpload = $media->stage($settings, $request, ['logo'], 'settings');
        $data = array_merge($data, $logoUpload->paths());

        // Handle Footer Logo
        // Stored first; the file it replaces is removed once the record is saved
        $footerLogoUpload = $media->stage($settings, $request, ['footer_logo'], 'settings');
        $data = array_merge($data, $footerLogoUpload->paths());

        // Handle Favicon
        // Stored first; the file it replaces is removed once the record is saved
        $faviconUpload = $media->stage($settings, $request, ['favicon'], 'settings');
        $data = array_merge($data, $faviconUpload->paths());

        $settings->update($data);
        $logoUpload->commit();
        $footerLogoUpload->commit();
        $faviconUpload->commit();

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
