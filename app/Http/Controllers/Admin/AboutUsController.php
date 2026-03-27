<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AboutUs;
use App\Models\AboutUsImage;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $about = AboutUs::with('images')->firstOrCreate([], [
            'status' => 1
        ]);
        $sectionContent = SectionContent::firstOrCreate(['section' => 'about_us']);
        return view('admin.about.about_us', compact('about', 'sectionContent'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_label' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        $sectionContent = SectionContent::updateOrCreate(
        ['section' => 'about_us'],
            $request->only(['small_title', 'main_title', 'description', 'button_label', 'link'])
        );

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function update(Request $request)
    {
        $about = AboutUs::first();

        $request->validate([
            'detailed_description' => 'nullable|string',
            'experience_caption' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|string|max:255',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'status' => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        $about->update($request->only(['detailed_description', 'experience_caption', 'years_of_experience', 'vision', 'mission', 'status']));

        // Handle Images
        if ($request->hasFile('images')) {
            $currentImagesCount = $about->images()->count();
            $newImages = $request->file('images');

            foreach ($newImages as $index => $image) {
                if ($currentImagesCount < 3) {
                    $path = $image->store('about', 'public');
                    AboutUsImage::create([
                        'about_us_id' => $about->id,
                        'image' => $path,
                        'order' => $currentImagesCount + 1,
                        'status' => 1
                    ]);
                    $currentImagesCount++;
                }
            }
        }

        return back()->with('success', 'About Us updated successfully.');
    }

    public function deleteImage($id)
    {
        $image = AboutUsImage::findOrFail($id);
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();
        return back()->with('success', 'Image deleted successfully.');
    }
}
