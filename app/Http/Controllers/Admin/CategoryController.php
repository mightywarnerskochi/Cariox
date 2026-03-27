<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $sectionContent = SectionContent::firstOrCreate(['section' => 'products']);
        $categories = Category::with('meta')->orderBy('position')->get();
        return view('admin.category.index', compact('categories', 'sectionContent'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $sectionContent = SectionContent::firstOrCreate(['section' => 'products']);
        $sectionContent->update([
            'small_title' => $request->small_title,
            'main_title' => $request->main_title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'logo_alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
            // meta validations
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'other_meta_tags' => 'nullable|string',
        ]);

        $maxPosition = Category::max('position') ?? 0;
        $position = $request->position ?? ($maxPosition + 1);

        if ($request->position && $request->position <= $maxPosition) {
            Category::where('position', '>=', $position)->increment('position');
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('categories', 'public');
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'logo' => $logoPath,
            'logo_alt_text' => $request->logo_alt_text,
            'position' => $position,
            'status' => 1
        ]);

        // Save Meta
        $meta = $category->meta()->make([
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'other_meta_tags' => $request->other_meta_tags,
        ]);
        $meta->page_name = 'category';
        $meta->save();

        return redirect()->route('admin.category.index')->with('success', 'Category added successfully.');
    }

    public function edit($id)
    {
        $category = Category::with('meta')->findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if ($request->has('position') && !$request->has('name')) {
            $request->validate(['position' => 'required|integer|min:1']);
            if ($request->position != $category->position) {
                $newPosition = $request->position;
                $currentPosition = $category->position;
                if ($newPosition < $currentPosition) {
                    Category::where('position', '>=', $newPosition)
                        ->where('position', '<', $currentPosition)->increment('position');
                }
                elseif ($newPosition > $currentPosition) {
                    Category::where('position', '<=', $newPosition)
                        ->where('position', '>', $currentPosition)->decrement('position');
                }
                $category->position = $newPosition;
                $category->save();
            }
            return back()->with('success', 'Category position updated successfully.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'logo_alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
            // meta validations
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'other_meta_tags' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            if ($category->logo && Storage::disk('public')->exists($category->logo)) {
                Storage::disk('public')->delete($category->logo);
            }
            $category->logo = $request->file('logo')->store('categories', 'public');
        }

        $category->name = $request->name;
        $category->slug = $request->slug ?? Str::slug($request->name);
        $category->description = $request->description;
        $category->logo_alt_text = $request->logo_alt_text;

        if ($request->has('position') && $request->position != $category->position) {
            $newPosition = $request->position;
            $currentPosition = $category->position;
            if ($newPosition < $currentPosition) {
                Category::where('position', '>=', $newPosition)->where('position', '<', $currentPosition)->increment('position');
            }
            elseif ($newPosition > $currentPosition) {
                Category::where('position', '<=', $newPosition)->where('position', '>', $currentPosition)->decrement('position');
            }
            $category->position = $newPosition;
        }

        $category->save();

        // Update Meta
        $meta = $category->meta()->firstOrNew(['metable_type' => Category::class]);
        $meta->fill([
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'other_meta_tags' => $request->other_meta_tags,
        ]);
        $meta->page_name = 'category';
        $meta->save();

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $deletedPosition = $category->position;
        if ($category->logo && Storage::disk('public')->exists($category->logo)) {
            Storage::disk('public')->delete($category->logo);
        }
        if ($category->meta)
            $category->meta()->delete();
        $category->delete();
        Category::where('position', '>', $deletedPosition)->decrement('position');
        return back()->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = !$category->status;
        $category->save();
        return back()->with('success', 'Category status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Category::whereIn('id', $ids)->get();
            foreach ($items as $category) {
                $deletedPosition = $category->position;
                if ($category->logo && Storage::disk('public')->exists($category->logo)) {
                    Storage::disk('public')->delete($category->logo);
                }
                if ($category->meta)
                    $category->meta()->delete();
                $category->delete();
                Category::where('position', '>', $deletedPosition)->decrement('position');
            }
            return back()->with('success', 'Selected categories deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Category::whereIn('id', $ids)->get();
            foreach ($items as $category) {
                $category->status = !$category->status;
                $category->save();
            }
            return back()->with('success', 'Selected categories status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }
}
