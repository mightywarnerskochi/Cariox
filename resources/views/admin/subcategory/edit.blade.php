@extends('admin.layouts.app')

@section('content')


<div class="dashboard-content">

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin:0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Subcategory</h2>
        <a href="{{ route('admin.subcategory.index') }}" class="btn-update" style="text-decoration: none;">Back to Subcategories</a>
    </div>

    <div class="section-container">
        <div class="section-header">
            Edit {{ $subcategory->name }}
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.subcategory.update', $subcategory->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group" style="width: 50%;">
                    <label>Select Parent Category <span style="color:red">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $subcategory->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Subcategory Name <span style="color:red">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $subcategory->slug) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control tinymce" rows="4">{{ old('description', $subcategory->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Subcategory Image</label>
                        @if($subcategory->image)
                            <div style="margin-bottom: 10px;">
                                <img src="{{ Storage::url($subcategory->image) }}" alt="" style="height: 60px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small style="color: #64748b;">Leave empty to keep current image</small>
                    </div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="image_alt_text" class="form-control" value="{{ old('image_alt_text', $subcategory->image_alt_text) }}">
                    </div>
                </div>

                <div class="form-group" style="width: 50%;">
                    <label>Position</label>
                    <input type="number" min="1" name="position" class="form-control" value="{{ old('position', $subcategory->position) }}">
                    <small style="color: #64748b;">Position is relative to other subcategories in the same parent category.</small>
                </div>

                <!-- Meta Details -->
                <div class="meta-card">
                    <h4>SEO & Meta Data</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Meta Title</label>
                            <textarea name="meta_title" class="form-control" rows="3">{{ old('meta_title', $subcategory->meta->meta_title ?? '') }}</textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $subcategory->meta->meta_description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Meta Keyword</label>
                            <textarea name="meta_keyword" class="form-control" rows="3">{{ old('meta_keyword', $subcategory->meta->meta_keyword ?? '') }}</textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Other Meta Tag</label>
                            <textarea name="other_meta_tags" class="form-control" rows="3">{{ old('other_meta_tags', $subcategory->meta->other_meta_tags ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <a href="{{ route('admin.subcategory.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn-add" style="padding: 0.55rem 1rem;">Update Subcategory</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        if (nameInput && slugInput) {
            nameInput.addEventListener('input', function() {
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
