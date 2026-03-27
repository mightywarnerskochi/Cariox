<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\SectionContent;
use App\Models\Meta;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $sectionContent = SectionContent::firstOrCreate(['section' => 'services']);
        $services = Service::orderBy('position')->get();
        return view('admin.service.index', compact('services', 'sectionContent'));
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

        $sectionContent = SectionContent::firstOrCreate(['section' => 'services']);
        $sectionContent->update([
            'small_title' => $request->small_title,
            'main_title' => $request->main_title,
            'description' => $request->description,
            'button_label' => $request->button_label,
            'link' => $request->link,
        ]);

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function create()
    {
        $activeCount = Service::where('status', 1)->count();
        if ($activeCount >= 3) {
            return redirect()->route('admin.service.index')->withErrors(['message' => 'Maximum limit of 3 active services reached. You cannot add more with active status.']);
        }
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $activeCount = Service::where('status', 1)->count();
        if ($activeCount >= 3) {
            return redirect()->route('admin.service.index')->withErrors(['message' => 'Maximum limit of 3 active services reached.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'home_description' => 'nullable|string',
            'page_description' => 'nullable|string',
            'main_description' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'background_image_alt_text' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'main_image_alt_text' => 'nullable|string|max:255',
            'base_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'base_image1_alt_text' => 'nullable|string|max:255',
            'base_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'base_image2_alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        $maxPosition = Service::max('position') ?? 0;
        $position = $request->position ?? ($maxPosition + 1);

        if ($request->position && $request->position <= $maxPosition) {
            Service::where('position', '>=', $position)->increment('position');
        }

        $service = new Service();
        $service->name = $request->name;

        $slug = $request->slug ? \Illuminate\Support\Str::slug($request->slug) : \Illuminate\Support\Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (\App\Models\Service::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $service->slug = $slug;

        $service->home_description = $request->home_description;
        $service->page_description = $request->page_description;
        $service->main_description = $request->main_description;

        $service->background_image_alt_text = $request->background_image_alt_text;
        $service->main_image_alt_text = $request->main_image_alt_text;
        $service->base_image1_alt_text = $request->base_image1_alt_text;
        $service->base_image2_alt_text = $request->base_image2_alt_text;

        $service->position = $position;
        $service->status = 1;

        if ($request->hasFile('background_image')) {
            $service->background_image = $request->file('background_image')->store('services', 'public');
        }
        if ($request->hasFile('main_image')) {
            $service->main_image = $request->file('main_image')->store('services', 'public');
        }
        if ($request->hasFile('base_image1')) {
            $service->base_image1 = $request->file('base_image1')->store('services', 'public');
        }
        if ($request->hasFile('base_image2')) {
            $service->base_image2 = $request->file('base_image2')->store('services', 'public');
        }

        $service->save();

        $meta = new Meta();
        $meta->meta_title = $request->meta_title;
        $meta->meta_keyword = $request->meta_keyword;
        $meta->meta_description = $request->meta_description;
        $meta->other_meta_tags = $request->other_meta_tags;
        $meta->og_title = $request->og_title;
        $meta->og_description = $request->og_description;
        if ($request->hasFile('og_image')) {
            $meta->og_image = $request->file('og_image')->store('metas/og_images', 'public');
        }
        $meta->page_name = 'service';
        $service->meta()->save($meta);

        return redirect()->route('admin.service.index')->with('success', 'Service added successfully.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        if ($request->has('position') && !$request->has('name')) {
            $request->validate(['position' => 'required|integer|min:1']);

            if ($request->position != $service->position) {
                $newPosition = $request->position;
                $currentPosition = $service->position;

                if ($newPosition < $currentPosition) {
                    Service::where('position', '>=', $newPosition)
                        ->where('position', '<', $currentPosition)
                        ->increment('position');
                }
                elseif ($newPosition > $currentPosition) {
                    Service::where('position', '<=', $newPosition)
                        ->where('position', '>', $currentPosition)
                        ->decrement('position');
                }
                $service->position = $newPosition;
                $service->save();
            }
            return back()->with('success', 'Service position updated successfully.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'home_description' => 'nullable|string',
            'page_description' => 'nullable|string',
            'main_description' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'background_image_alt_text' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'main_image_alt_text' => 'nullable|string|max:255',
            'base_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'base_image1_alt_text' => 'nullable|string|max:255',
            'base_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'base_image2_alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        $service->name = $request->name;

        $slug = $request->slug ? \Illuminate\Support\Str::slug($request->slug) : \Illuminate\Support\Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (\App\Models\Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $service->slug = $slug;

        $service->home_description = $request->home_description;
        $service->page_description = $request->page_description;
        $service->main_description = $request->main_description;

        $service->background_image_alt_text = $request->background_image_alt_text;
        $service->main_image_alt_text = $request->main_image_alt_text;
        $service->base_image1_alt_text = $request->base_image1_alt_text;
        $service->base_image2_alt_text = $request->base_image2_alt_text;

        // Image Handling
        $imageFields = ['background_image', 'main_image', 'base_image1', 'base_image2'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($service->$field && Storage::disk('public')->exists($service->$field)) {
                    Storage::disk('public')->delete($service->$field);
                }
                $service->$field = $request->file($field)->store('services', 'public');
            }
        }

        // Position Logic
        if ($request->has('position') && $request->position != $service->position) {
            $newPosition = $request->position;
            $currentPosition = $service->position;

            if ($newPosition < $currentPosition) {
                Service::where('position', '>=', $newPosition)
                    ->where('position', '<', $currentPosition)
                    ->increment('position');
            }
            elseif ($newPosition > $currentPosition) {
                Service::where('position', '<=', $newPosition)
                    ->where('position', '>', $currentPosition)
                    ->decrement('position');
            }
            $service->position = $newPosition;
        }

        $service->save();

        $meta = $service->meta ?: new Meta();
        $meta->meta_title = $request->meta_title;
        $meta->meta_keyword = $request->meta_keyword;
        $meta->meta_description = $request->meta_description;
        $meta->other_meta_tags = $request->other_meta_tags;
        $meta->og_title = $request->og_title;
        $meta->og_description = $request->og_description;
        if ($request->hasFile('og_image')) {
            if ($meta->og_image && Storage::disk('public')->exists($meta->og_image)) {
                Storage::disk('public')->delete($meta->og_image);
            }
            $meta->og_image = $request->file('og_image')->store('metas/og_images', 'public');
        }
        $meta->page_name = 'service';
        $service->meta()->save($meta);

        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $deletedPosition = $service->position;

        $imageFields = ['background_image', 'main_image', 'base_image1', 'base_image2'];
        foreach ($imageFields as $field) {
            if ($service->$field && Storage::disk('public')->exists($service->$field)) {
                Storage::disk('public')->delete($service->$field);
            }
        }

        $service->delete();

        Service::where('position', '>', $deletedPosition)->decrement('position');

        return back()->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $service = Service::findOrFail($request->id);

        // If we are trying to activate it, check the limit
        if (!$service->status) {
            $activeCount = Service::where('status', 1)->count();
            if ($activeCount >= 3) {
                return back()->withErrors(['message' => 'Cannot activate. Maximum limit of 3 active services reached.']);
            }
        }

        $service->status = !$service->status;
        $service->save();
        return back()->with('success', 'Service status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Service::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $deletedPosition = $item->position;

                $imageFields = ['background_image', 'main_image', 'base_image1', 'base_image2'];
                foreach ($imageFields as $field) {
                    if ($item->$field && Storage::disk('public')->exists($item->$field)) {
                        Storage::disk('public')->delete($item->$field);
                    }
                }

                $item->delete();

                Service::where('position', '>', $deletedPosition)->decrement('position');
            }
            return back()->with('success', 'Selected services deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Service::whereIn('id', $ids)->get();
            $activeCount = Service::where('status', 1)->count();

            foreach ($items as $item) {
                if (!$item->status) { // Attempting to activate
                    if ($activeCount < 3) {
                        $item->status = 1;
                        $activeCount++;
                    }
                    else {
                        // Skip activation if limit reached, or we could return an error after the loop
                        continue;
                    }
                }
                else { // Deactivating
                    $item->status = 0;
                    $activeCount--;
                }
                $item->save();
            }
            return back()->with('success', 'Selected services status toggled (respecting the limit of 3 active services).');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }
}
