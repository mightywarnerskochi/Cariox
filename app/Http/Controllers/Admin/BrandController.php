<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $sectionContent = SectionContent::firstOrCreate(['section' => 'brand']);
        $brands = Brand::positioned()->get();
        return view('admin.brand.index', compact('brands', 'sectionContent'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $sectionContent = SectionContent::firstOrCreate(['section' => 'brand']);
        $sectionContent->update([
            'small_title' => $request->small_title,
            'main_title' => $request->main_title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        Brand::increment('position');
        $position = 1;

        $path = $request->file('image')->store('brands', 'public');

        Brand::create([
            'name' => $request->name,
            'image' => $path,
            'alt_text' => $request->alt_text,
            'position' => $position,
            'status' => 1
        ]);

        $this->normalizeBrandOrder();

        return redirect()->route('admin.brand.index')->with('success', 'Brand added successfully.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240']);
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->name = $request->name;

        if ($request->has('alt_text')) {
            $brand->alt_text = $request->alt_text;
        }

        if ($request->has('position')) {
            $brand->position = $request->position;
        }

        $brand->save();
        $this->normalizeBrandOrder();
        return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $deletedPosition = $brand->position;

        if ($brand->image && Storage::disk('public')->exists($brand->image)) {
            Storage::disk('public')->delete($brand->image);
        }
        $brand->delete();
        $this->normalizeBrandOrder();

        return back()->with('success', 'Brand deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->status = !$brand->status;
        if ($brand->status == 0) {
            $brand->position = Brand::max('position') + 1;
        }
        $brand->save();
        $this->normalizeBrandOrder();
        return back()->with('success', 'Brand status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $brands = Brand::whereIn('id', $ids)->get();
            foreach ($brands as $brand) {
                $brand->delete();
            }
            $this->normalizeBrandOrder();
            return back()->with('success', 'Selected brands deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $brands = Brand::whereIn('id', $ids)->get();
            $maxPos = Brand::max('position');
            foreach ($brands as $brand) {
                $brand->status = !$brand->status;
                if ($brand->status == 0) {
                    $brand->position = ++$maxPos;
                }
                $brand->save();
            }
            $this->normalizeBrandOrder();
            return back()->with('success', 'Selected brands status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    private function normalizeBrandOrder()
    {
        $items = Brand::positioned()->get();
        foreach ($items as $index => $item) {
            $newPos = $index + 1;
            if ($item->position != $newPos) {
                $item->position = $newPos;
                $item->save();
            }
        }
    }
}
