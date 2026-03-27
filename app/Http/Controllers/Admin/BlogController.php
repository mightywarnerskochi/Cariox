<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\SectionContent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $sectionContent = SectionContent::firstOrCreate(['section' => 'blog']);
        $blogs = Blog::positioned()->get();
        return view('admin.blog.index', compact('blogs', 'sectionContent'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $sectionContent = SectionContent::firstOrCreate(['section' => 'blog']);
        $sectionContent->update([
            'small_title' => $request->small_title,
            'main_title' => $request->main_title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'image_1' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120',
            'image_2' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure unique slug
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $data = $request->all();
        $data['slug'] = $slug;
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }
        if ($request->hasFile('image_1')) {
            $data['image_1'] = $request->file('image_1')->store('blogs', 'public');
        }
        if ($request->hasFile('image_2')) {
            $data['image_2'] = $request->file('image_2')->store('blogs', 'public');
        }

        Blog::whereNotNull('position')->increment('position');
        $blog = new Blog($data);
        $blog->page_name = 'blog';
        $blog->position = 1;
        $blog->save();

        $this->normalizeBlogOrder();
        return redirect()->route('admin.blog.index')->with('success', 'Blog created successfully.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        if ($request->has('position') && !$request->has('title')) {
            $blog->position = $request->position;
            $blog->save();
            $this->normalizeBlogOrder();
            return back()->with('success', 'Blog position updated successfully.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'image_1' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120',
            'image_1' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120',
            'image_2' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120',
            'position' => 'nullable|integer|min:1',
        ]);

        $data = $request->all();

        if ($request->slug) {
            $data['slug'] = Str::slug($request->slug);
        }
        else {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle unique slug on update
        if ($data['slug'] != $blog->slug) {
            $originalSlug = $data['slug'];
            $count = 1;
            while (Blog::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $count++;
            }
        }

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        if ($request->hasFile('image_1')) {
            if ($blog->image_1 && Storage::disk('public')->exists($blog->image_1)) {
                Storage::disk('public')->delete($blog->image_1);
            }
            $data['image_1'] = $request->file('image_1')->store('blogs', 'public');
        }

        if ($request->hasFile('image_2')) {
            if ($blog->image_2 && Storage::disk('public')->exists($blog->image_2)) {
                Storage::disk('public')->delete($blog->image_2);
            }
            $data['image_2'] = $request->file('image_2')->store('blogs', 'public');
        }

        // Handle order change in full update
        if ($request->has('position')) {
            $blog->position = $request->position;
        }
        $blog->fill($data);
        $blog->page_name = 'blog';
        $blog->save();
        $this->normalizeBlogOrder();
        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        $this->normalizeBlogOrder();
        return back()->with('success', 'Blog moved to trash.');
    }

    public function toggleStatus($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = !$blog->status;
        if ($blog->status == 0) {
            $blog->position = Blog::max('position') + 1;
        }
        $blog->save();
        $this->normalizeBlogOrder();
        return back()->with('success', 'Status updated.');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids) {
            Blog::whereIn('id', $request->ids)->delete();
            $this->normalizeBlogOrder();
            return back()->with('success', 'Selected blogs moved to trash.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        if ($request->ids) {
            $blogs = Blog::whereIn('id', $request->ids)->get();
            $maxPos = Blog::max('position');
            foreach ($blogs as $blog) {
                $blog->status = !$blog->status;
                if ($blog->status == 0) {
                    $blog->position = ++$maxPos;
                }
                $blog->save();
            }
            $this->normalizeBlogOrder();
            return back()->with('success', 'Selected blogs status toggled.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    private function normalizeBlogOrder()
    {
        $blogs = Blog::positioned()->get();
        foreach ($blogs as $index => $blog) {
            if ($blog->position != ($index + 1)) {
                $blog->position = $index + 1;
                $blog->save();
            }
        }
    }
}
