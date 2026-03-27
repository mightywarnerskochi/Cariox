@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Blog: {{ $blog->title }}</h2>
        <a href="{{ route('admin.blog.index') }}" class="btn-update" style="text-decoration: none;">Back to Blogs</a>
    </div>

    <form method="POST" action="{{ route('admin.blog.update', $blog->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="section-container">
            <div class="section-header">Content Details</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Title <span style="color:red">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $blog->slug) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $blog->date) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Main Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($blog->image)
                            <div style="margin-top: 0.5rem;">
                                <img src="{{ Storage::url($blog->image) }}" height="80" style="border-radius: 4px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Current Main Image</div>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt', $blog->image_alt) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Image 1</label>
                        <input type="file" name="image_1" class="form-control" accept="image/*">
                        @if($blog->image_1)
                            <div style="margin-top: 0.5rem;">
                                <img src="{{ Storage::url($blog->image_1) }}" height="80" style="border-radius: 4px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Current Image 1</div>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image 2</label>
                        <input type="file" name="image_2" class="form-control" accept="image/*">
                        @if($blog->image_2)
                            <div style="margin-top: 0.5rem;">
                                <img src="{{ Storage::url($blog->image_2) }}" height="80" style="border-radius: 4px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Current Image 2</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_description" class="form-control tinymce" rows="3">{{ old('short_description', $blog->short_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Detailed Description</label>
                    <textarea name="detailed_description" id="blog_detailed_description" class="form-control tinymce" data-height="400">{{ old('detailed_description', $blog->detailed_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Sub Description</label>
                    <textarea name="sub_description" id="blog_sub_description" class="form-control tinymce" data-height="400">{{ old('sub_description', $blog->sub_description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Position</label>
                        <input type="number" name="position" class="form-control" value="{{ old('position', $blog->position) }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $blog->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $blog->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">SEO & Meta Data</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Meta Title</label>
                        <textarea name="meta_title" class="form-control" rows="3">{{ old('meta_title', $blog->meta_title) }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Meta Keyword</label>
                        <textarea name="meta_keyword" class="form-control" rows="3">{{ old('meta_keyword', $blog->meta_keyword) }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Other Meta Tag</label>
                        <textarea name="other_meta_tags" class="form-control" rows="3">{{ old('other_meta_tags', $blog->other_meta_tags) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-bottom: 2rem;">
            <a href="{{ route('admin.blog.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
            <button type="submit" class="btn-add" style="padding: 0.75rem 2rem; font-size: 1rem;">Update Blog</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                let slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') 
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                slugInput.value = slug;
            });
        }
    });

</script>
@endpush
@endsection
