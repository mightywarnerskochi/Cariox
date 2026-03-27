<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductKeyFeature;
use App\Models\ProductVideo;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subcategory', 'brand', 'meta', 'images'])->orderBy('position')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('admin.product.create', compact('categories', 'subcategories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'position' => 'nullable|integer|min:1',
            'canonical_url' => 'nullable|url',
            // meta
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'other_meta_tags' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'subcategory_id.required' => 'The subcategory field is mandatory.',
            'brand_id.required' => 'The brand field is mandatory.'
        ]);

        $brochurePath = null;
        if ($request->hasFile('brochure')) {
            $brochurePath = $request->file('brochure')->store('products/brochures', 'public');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'product_title' => $request->product_title,
            'sub_title' => $request->sub_title,
            'slug' => $request->slug ?? Str::slug($request->product_title),
            'description' => $request->description,
            'brochure' => $brochurePath,
            'position' => $request->position ?? (Product::max('position') + 1),
            'status' => 1
        ]);

        $this->normalizeProductOrder();

        // Save Meta
        $meta = $product->meta()->make([
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'other_meta_tags' => $request->other_meta_tags,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'canonical_url' => $request->canonical_url,
        ]);
        if ($request->hasFile('og_image')) {
            $meta->og_image = $request->file('og_image')->store('metas/og_images', 'public');
        }
        $meta->page_name = 'product';
        $meta->save();

        // Images array
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img) {
                    $imgPath = $img->store('products/images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imgPath
                    ]);
                }
            }
        }

        // Key Features arrays
        if ($request->has('feature_names')) {
            foreach ($request->feature_names as $index => $fname) {
                if (!empty($fname)) {
                    ProductKeyFeature::create([
                        'product_id' => $product->id,
                        'name' => $fname,
                        'description' => $request->feature_descriptions[$index] ?? null,
                        'position' => $index + 1,
                        'status' => 1
                    ]);
                }
            }
        }

        // Videos arrays
        if ($request->has('video_links')) {
            foreach ($request->video_links as $index => $vlink) {
                $vfile_path = null;
                // if file is uploaded
                if ($request->hasFile("video_files.$index")) {
                    $vfile_path = $request->file("video_files.$index")->store('products/videos', 'public');
                }

                if (!empty($vlink) || $vfile_path) {
                    ProductVideo::create([
                        'product_id' => $product->id,
                        'video' => $vfile_path,
                        'link' => $vlink,
                        'position' => $index + 1,
                        'status' => 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::with(['meta', 'images', 'keyFeatures', 'videos'])->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('admin.product.edit', compact('product', 'categories', 'subcategories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->has('position') && !$request->has('product_title')) {
            $request->validate(['position' => 'required|integer|min:1']);
            $product->position = $request->position;
            $product->save();
            $this->normalizeProductOrder();
            return back()->with('success', 'Product position updated successfully.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'position' => 'nullable|integer|min:1',
            // meta
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'other_meta_tags' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'canonical_url' => 'nullable|url',
        ], [
            'subcategory_id.required' => 'The subcategory field is mandatory.',
            'brand_id.required' => 'The brand field is mandatory.'
        ]);

        if ($request->hasFile('brochure')) {
            if ($product->brochure && Storage::disk('public')->exists($product->brochure)) {
                Storage::disk('public')->delete($product->brochure);
            }
            $product->brochure = $request->file('brochure')->store('products/brochures', 'public');
        }

        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->product_title = $request->product_title;
        $product->sub_title = $request->sub_title;
        $product->slug = $request->slug ?? Str::slug($request->product_title);
        $product->description = $request->description;

        if ($request->has('position')) {
            $product->position = $request->position;
        }

        $product->save();

        // Update Meta
        $meta = $product->meta()->firstOrNew(['metable_type' => Product::class]);
        $meta->fill([
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'other_meta_tags' => $request->other_meta_tags,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'canonical_url' => $request->canonical_url,
        ]);

        if ($request->hasFile('og_image')) {
            if ($meta->og_image && Storage::disk('public')->exists($meta->og_image)) {
                Storage::disk('public')->delete($meta->og_image);
            }
            $meta->og_image = $request->file('og_image')->store('metas/og_images', 'public');
        }

        $meta->page_name = 'product';
        $meta->save();

        // Manage Existing Delete array (checkboxes array of IDs to delete)
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $img_id) {
                $img = ProductImage::find($img_id);
                if ($img) {
                    if (Storage::disk('public')->exists($img->image))
                        Storage::disk('public')->delete($img->image);
                    $img->delete();
                }
            }
        }
        if ($request->has('delete_features')) {
            ProductKeyFeature::whereIn('id', $request->delete_features)->delete();
        }
        if ($request->has('delete_videos')) {
            foreach ($request->delete_videos as $vid_id) {
                $vid = ProductVideo::find($vid_id);
                if ($vid) {
                    if ($vid->video && Storage::disk('public')->exists($vid->video))
                        Storage::disk('public')->delete($vid->video);
                    $vid->delete();
                }
            }
        }

        // Update Existing Features
        if ($request->has('existing_features')) {
            foreach ($request->existing_features as $fid => $fData) {
                $feature = ProductKeyFeature::find($fid);
                if ($feature) {
                    $feature->update([
                        'name' => $fData['name'] ?? '',
                        'description' => $fData['description'] ?? null
                    ]);
                }
            }
        }

        // Update Existing Videos
        if ($request->has('existing_videos')) {
            foreach ($request->existing_videos as $vid => $vData) {
                $video = ProductVideo::find($vid);
                if ($video) {
                    $vfile_path = $video->video;
                    if ($request->hasFile("existing_video_files.$vid")) {
                        if ($vfile_path && Storage::disk('public')->exists($vfile_path))
                            Storage::disk('public')->delete($vfile_path);
                        $vfile_path = $request->file("existing_video_files.$vid")->store('products/videos', 'public');
                    }

                    $video->update([
                        'link' => $vData['link'] ?? null,
                        'video' => $vfile_path
                    ]);
                }
            }
        }

        // Add New Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img) {
                    $imgPath = $img->store('products/images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imgPath
                    ]);
                }
            }
        }

        // Key Features arrays (New)
        if ($request->has('feature_names')) {
            foreach ($request->feature_names as $index => $fname) {
                if (!empty($fname)) {
                    ProductKeyFeature::create([
                        'product_id' => $product->id,
                        'name' => $fname,
                        'description' => $request->feature_descriptions[$index] ?? null,
                        'position' => 1, // Will need sorting later or just default
                        'status' => 1
                    ]);
                }
            }
        }

        // Videos arrays (New)
        if ($request->has('video_links') || $request->hasFile('video_files')) {
            $vidCount = max(count($request->video_links ?? []), count($request->file('video_files') ?? []));
            for ($index = 0; $index < $vidCount; $index++) {
                $vlink = $request->video_links[$index] ?? null;
                $vfile_path = null;
                if ($request->hasFile("video_files.$index")) {
                    $vfile_path = $request->file("video_files.$index")->store('products/videos', 'public');
                }

                if (!empty($vlink) || $vfile_path) {
                    ProductVideo::create([
                        'product_id' => $product->id,
                        'video' => $vfile_path,
                        'link' => $vlink,
                        'position' => 1,
                        'status' => 1
                    ]);
                }
            }
        }

        $this->normalizeProductOrder();
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::with(['images', 'videos', 'meta'])->findOrFail($id);
        $deletedPosition = $product->position;

        // Delete physical files
        if ($product->brochure && Storage::disk('public')->exists($product->brochure)) {
            Storage::disk('public')->delete($product->brochure);
        }
        foreach ($product->images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image))
                Storage::disk('public')->delete($img->image);
            $img->delete();
        }
        foreach ($product->videos as $vid) {
            if ($vid->video && Storage::disk('public')->exists($vid->video))
                Storage::disk('public')->delete($vid->video);
            $vid->delete();
        }
        if ($product->meta)
            $product->meta()->delete();

        $product->keyFeatures()->delete(); // soft deletes cascading manual

        $product->delete();
        $this->normalizeProductOrder();
        return back()->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = !$product->status;
        if ($product->status == 0) {
            $product->position = Product::max('position') + 1;
        }
        $product->save();
        $this->normalizeProductOrder();
        return back()->with('success', 'Product status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Product::with(['images', 'videos', 'meta'])->whereIn('id', $ids)->get();
            foreach ($items as $product) {
                $deletedPosition = $product->position;
                if ($product->brochure && Storage::disk('public')->exists($product->brochure))
                    Storage::disk('public')->delete($product->brochure);
                foreach ($product->images as $img) {
                    if ($img->image && Storage::disk('public')->exists($img->image))
                        Storage::disk('public')->delete($img->image);
                    $img->delete();
                }
                foreach ($product->videos as $vid) {
                    if ($vid->video && Storage::disk('public')->exists($vid->video))
                        Storage::disk('public')->delete($vid->video);
                    $vid->delete();
                }
                if ($product->meta)
                    $product->meta()->delete();
                $product->keyFeatures()->delete();
                $product->delete();
            }
            $this->normalizeProductOrder();
            return back()->with('success', 'Selected products deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $items = Product::whereIn('id', $ids)->get();
            $maxPos = Product::max('position');
            foreach ($items as $product) {
                $product->status = !$product->status;
                if ($product->status == 0) {
                    $product->position = ++$maxPos;
                }
                $product->save();
            }
            $this->normalizeProductOrder();
            return back()->with('success', 'Selected products status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    private function normalizeProductOrder()
    {
        // Order by Status (Active first), then by current Position, then by most recent update
        $products = Product::orderBy('status', 'desc')
            ->orderBy('position')
            ->orderBy('updated_at', 'desc')
            ->get();
            
        foreach ($products as $index => $product) {
            $newPos = $index + 1;
            if ($product->position != $newPos) {
                $product->position = $newPos;
                $product->save();
            }
        }
    }
}
