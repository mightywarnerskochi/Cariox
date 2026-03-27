<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageMetadata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageMetadataController extends Controller
{
    /**
     * Allowed image extensions for OG image (security: do not trust client extension).
     */
    private const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Static pages that have SEO metadata (no DB change).
     */
    private const PAGES = [
        ['name' => 'Home', 'slug' => 'home'],
        ['name' => 'About Us', 'slug' => 'about'],
        ['name' => 'Services', 'slug' => 'services'],
        ['name' => 'Blogs', 'slug' => 'blogs'],
        ['name' => 'Contact Us', 'slug' => 'contact'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.metadata.index', ['pages' => self::PAGES]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $page_name): View
    {
        if (!$this->isAllowedPage($page_name)) {
            abort(404, 'Page not found.');
        }

        $metadata = PageMetadata::firstOrNew(['page_name' => $page_name]);
        if (!$metadata->exists) {
            $metadata->page_name = $page_name;
        }

        return view('admin.metadata.edit', compact('metadata', 'page_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $page_name): RedirectResponse
    {
        if (!$this->isAllowedPage($page_name)) {
            abort(404, 'Page not found.');
        }

        $request->validate([
            'canonical_url' => 'nullable|url',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'other_meta' => 'nullable|string',
        ]);

        $metadata = PageMetadata::firstOrNew(['page_name' => $page_name]);

        $data = $request->only([
            'canonical_url', 'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'other_meta',
        ]);

        if ($request->hasFile('og_image')) {
            $this->deleteOldOgImage($metadata->og_image);
            $data['og_image'] = $this->storeOgImage($request->file('og_image'));
        }

        $metadata->fill($data);
        $metadata->save();

        return redirect()->route('admin.metadata.index')->with('success', 'Metadata updated successfully');
    }

    /**
     * Check if the given page slug is allowed (security: prevent arbitrary DB rows).
     */
    private function isAllowedPage(string $page_name): bool
    {
        $allowedSlugs = array_column(self::PAGES, 'slug');
        return in_array($page_name, $allowedSlugs, true);
    }

    /**
     * Delete the previous OG image from disk (supports both Storage and legacy public path).
     */
    private function deleteOldOgImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        // New path: stored under Storage disk 'public' as 'metadata/...'
        if (Str::startsWith($path, 'metadata/')) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            return;
        }

        // Legacy path: public_path('uploads/metadata/...')
        $fullPath = public_path($path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Store uploaded OG image; return path to store in DB (Storage path for new uploads).
     */
    private function storeOgImage(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, self::ALLOWED_IMAGE_EXTENSIONS, true)) {
            $ext = 'jpg';
        }
        $name = Str::random(24) . '.' . $ext;

        $file->storeAs('metadata', $name, 'public');

        return 'metadata/' . $name;
    }
}
