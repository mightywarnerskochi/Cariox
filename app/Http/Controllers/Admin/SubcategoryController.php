<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with(['category', 'meta'])
            ->orderBy('category_id')
            ->positioned()
            ->get();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'image_alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
            // meta validations
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'other_meta_tags' => 'nullable|string',
        ]);

        Subcategory::where('category_id', $request->category_id)->increment('position');
        $position = 1;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subcategories', 'public');
        }

        $subcategory = Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'image' => $imagePath,
            'image_alt_text' => $request->image_alt_text,
            'position' => $position,
            'status' => 1
        ]);

        // Save Meta
        $meta = $subcategory->meta()->make([
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'other_meta_tags' => $request->other_meta_tags,
        ]);
        $meta->page_name = 'subcategory';
        $meta->save();

        $this->normalizeSubcategoryOrder($subcategory->category_id);

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory added successfully.');
    }

    public function edit($id)
    {
        $subcategory = Subcategory::with('meta')->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        if ($request->has('position') && !$request->has('name')) {
            $subcategory->position = $request->position;
            $subcategory->save();
            $this->normalizeSubcategoryOrder($subcategory->category_id);
            return back()->with('success', 'Subcategory position updated successfully.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'image_alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
            // meta validations
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'other_meta_tags' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $subcategory->image = $request->file('image')->store('subcategories', 'public');
        }

        $oldCategoryId = $subcategory->category_id;
        $newCategoryId = $request->category_id;

        $subcategory->category_id = $newCategoryId;
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug ?? Str::slug($request->name);
        $subcategory->description = $request->description;
        $subcategory->image_alt_text = $request->image_alt_text;

        if ($oldCategoryId != $newCategoryId) {
            $subcategory->position = 1;
            Subcategory::where('category_id', $newCategoryId)->increment('position');
        } elseif ($request->has('position')) {
            $subcategory->position = $request->position;
        }

        $subcategory->save();

        // Update Meta
        $meta = $subcategory->meta()->firstOrNew(['metable_type' => Subcategory::class]);
        $meta->fill([
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'other_meta_tags' => $request->other_meta_tags,
        ]);
        $meta->page_name = 'subcategory';
        $meta->save();

        $this->normalizeSubcategoryOrder($newCategoryId);
        if ($oldCategoryId != $newCategoryId) {
            $this->normalizeSubcategoryOrder($oldCategoryId);
        }

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $deletedPosition = $subcategory->position;
        if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
            Storage::disk('public')->delete($subcategory->image);
        }
        if ($subcategory->meta)
            $subcategory->meta()->delete();
        $subcategory->delete();
        $this->normalizeSubcategoryOrder($subcategory->category_id);
        return back()->with('success', 'Subcategory deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $subcategory = Subcategory::findOrFail($request->id);
        $subcategory->status = !$subcategory->status;
        if ($subcategory->status == 0) {
            $maxPos = Subcategory::where('category_id', $subcategory->category_id)->max('position') ?? 0;
            $subcategory->position = $maxPos + 1;
        }
        $subcategory->save();
        $this->normalizeSubcategoryOrder($subcategory->category_id);
        return back()->with('success', 'Subcategory status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids) {
            $items = Subcategory::whereIn('id', $request->ids)->get();
            $categoryIds = $items->pluck('category_id')->unique();
            foreach ($items as $subcategory) {
                if ($subcategory->meta) $subcategory->meta()->delete();
                $subcategory->delete();
            }
            foreach ($categoryIds as $catId) {
                $this->normalizeSubcategoryOrder($catId);
            }
            return back()->with('success', 'Selected subcategories deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        if ($request->ids) {
            $items = Subcategory::whereIn('id', $request->ids)->get();
            $categoryIds = $items->pluck('category_id')->unique();
            
            // Group actions to find max positions more efficiently
            foreach ($categoryIds as $catId) {
                $maxPos = Subcategory::where('category_id', $catId)->max('position') ?? 0;
                foreach ($items->where('category_id', $catId) as $subcategory) {
                    $subcategory->status = !$subcategory->status;
                    if ($subcategory->status == 0) {
                        $subcategory->position = ++$maxPos;
                    }
                    $subcategory->save();
                }
                $this->normalizeSubcategoryOrder($catId);
            }
            return back()->with('success', 'Selected subcategories status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    private function normalizeSubcategoryOrder($categoryId)
    {
        if (!$categoryId) return;
        $items = Subcategory::where('category_id', $categoryId)->positioned()->get();
        foreach ($items as $index => $item) {
            $newPos = $index + 1;
            if ($item->position != $newPos) {
                $item->position = $newPos;
                $item->save();
            }
        }
    }
}
