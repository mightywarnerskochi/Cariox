<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBannerContent;
use App\Models\HomeBannerMedia;
use App\Models\TrustedClient;
use Illuminate\Http\Request;

class HomeBannerContentController extends Controller
{
    public function index()
    {
        $banner = HomeBannerContent::first() ?? new HomeBannerContent();
        $mediaList = $banner->exists ? $banner->media()->orderBy('position')->get() : collect();
        $trustedClients = $banner->exists ? $banner->trustedClients()->orderBy('position')->get() : collect();

        return view('admin.home_banner.index', compact('banner', 'mediaList', 'trustedClients'));
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string|max:255',
            'button_link' => 'required|string|max:255',
            'trusted_clients_count' => 'required|string|max:255',
            'trusted_clients_label' => 'required|string|max:255',
            'rating_label' => 'required|string|max:255',
            'google_rating' => 'required|numeric|min:0|max:5',
            'review_label' => 'required|string|max:255',
        ]);

        $banner = HomeBannerContent::first();
        if ($banner) {
            $banner->update($validated);
        }
        else {
            HomeBannerContent::create($validated);
        }

        return redirect()->route('admin.home.banner.index')->with('success', 'Banner content updated successfully.');
    }
}
