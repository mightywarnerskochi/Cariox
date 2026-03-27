<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $sectionContent = SectionContent::firstOrCreate(['section' => 'testimonials']);
        $testimonials = Testimonial::orderBy('position')->get();
        return view('admin.testimonial.index', compact('testimonials', 'sectionContent'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sectionContent = SectionContent::firstOrCreate(['section' => 'testimonials']);
        $sectionContent->update([
            'small_title' => $request->small_title,
            'main_title' => $request->main_title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        $maxPosition = Testimonial::max('position') ?? 0;
        $position = $request->position ?? ($maxPosition + 1);

        if ($request->position && $request->position <= $maxPosition) {
            Testimonial::where('position', '>=', $position)->increment('position');
        }

        $path = $request->hasFile('image') ? $request->file('image')->store('testimonials', 'public') : null;

        Testimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'rating' => $request->rating,
            'content' => $request->content,
            'image' => $path,
            'alt_text' => $request->alt_text,
            'position' => $position,
            'status' => 1
        ]);

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($request->has('position') && !$request->has('name')) {
            $request->validate(['position' => 'required|integer|min:1']);

            if ($request->position != $testimonial->position) {
                $newPosition = $request->position;
                $currentPosition = $testimonial->position;

                if ($newPosition < $currentPosition) {
                    Testimonial::where('position', '>=', $newPosition)
                        ->where('position', '<', $currentPosition)
                        ->increment('position');
                }
                elseif ($newPosition > $currentPosition) {
                    Testimonial::where('position', '<=', $newPosition)
                        ->where('position', '>', $currentPosition)
                        ->decrement('position');
                }
                $testimonial->position = $newPosition;
                $testimonial->save();
            }
            return back()->with('success', 'Testimonial position updated successfully.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240']);
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $testimonial->image = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->rating = $request->rating;
        $testimonial->content = $request->content;
        $testimonial->alt_text = $request->alt_text;

        if ($request->has('position') && $request->position != $testimonial->position) {
            $newPosition = $request->position;
            $currentPosition = $testimonial->position;

            if ($newPosition < $currentPosition) {
                Testimonial::where('position', '>=', $newPosition)
                    ->where('position', '<', $currentPosition)
                    ->increment('position');
            }
            elseif ($newPosition > $currentPosition) {
                Testimonial::where('position', '<=', $newPosition)
                    ->where('position', '>', $currentPosition)
                    ->decrement('position');
            }
            $testimonial->position = $newPosition;
        }

        $testimonial->save();

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $deletedPosition = $testimonial->position;

        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();

        Testimonial::where('position', '>', $deletedPosition)->decrement('position');

        return back()->with('success', 'Testimonial deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->status = !$testimonial->status;
        $testimonial->save();
        return back()->with('success', 'Testimonial status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Testimonial::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $deletedPosition = $item->position;

                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->delete();

                Testimonial::where('position', '>', $deletedPosition)->decrement('position');
            }
            return back()->with('success', 'Selected testimonials deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Testimonial::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $item->status = !$item->status;
                $item->save();
            }
            return back()->with('success', 'Selected testimonials status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }
}
