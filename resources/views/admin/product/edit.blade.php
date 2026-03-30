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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Product</h2>
        <a href="{{ route('admin.product.index') }}" class="btn-update" style="text-decoration: none;">Back to Products</a>
    </div>

    <form method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="section-container">
            <div class="section-header">Core Details</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Category <span style="color:red">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Subcategory <span style="color:red">*</span></label>
                        <select name="subcategory_id" class="form-control" required>
                            <option value="">Select Subcategory</option>
                            @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }} ({{ $sub->category->name ?? '' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand <span style="color:red">*</span></label>
                        <select name="brand_id" class="form-control" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Product Title <span style="color:red">*</span></label>
                        <input type="text" name="product_title" id="product_title" class="form-control" value="{{ old('product_title', $product->product_title) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Sub Title</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ old('sub_title', $product->sub_title) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
                    </div>
                    <div class="form-group">
                        <label>Order / Position</label>
                        <input type="number" min="1" name="position" class="form-control" value="{{ old('position', $product->position) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="product_description" class="form-control tinymce" rows="5">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Key Features</label>
                    <textarea name="key_features" id="key_features" class="form-control tinymce" rows="5">{{ old('key_features', $product->key_features) }}</textarea>
                </div>

                <div class="form-group" style="width: 50%;">
                    <label>Brochure File (.pdf, .doc)</label>
                    @if($product->brochure)
                        <div style="margin-bottom: 0.5rem; font-size: 0.8rem; background:#f8fafc; padding: 0.5rem; border:1px solid #e2e8f0; display:inline-block;">
                           <a href="{{ Storage::url($product->brochure) }}" target="_blank">View Current Brochure</a>
                        </div>
                    @endif
                    <input type="file" name="brochure" class="form-control" accept=".pdf,.doc,.docx">
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">Multiple Images Attached</div>
            <div class="section-body">
                <div style="display:flex; flex-wrap:wrap; gap:1rem; margin-bottom: 1.5rem;">
                    @foreach($product->images as $img)
                        <div class="image-item" style="padding:10px; border:1px solid var(--border-color); border-radius:4px; text-align:center; position:relative; background:#fff;">
                            <img src="{{ Storage::url($img->image) }}" style="height:80px; display:block; margin-bottom: 10px; margin-left:auto; margin-right:auto;">
                            <label style="font-size:0.8rem; color:red; cursor:pointer;" class="delete-label">
                                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="delete-checkbox"> Delete
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label>Add More Product Images (You can select multiple files)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                </div>
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">
                <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                    <span>Other Videos (URL & File)</span>
                    <button type="button" class="btn-add" onclick="addOtherVideo()">+ Add Video</button>
                </div>
            </div>
            <div class="section-body" id="otherVideoWrapper">
                @foreach($product->otherVideos as $video)
                    <div class="append-row existing-item">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <h4>Existing Other Video</h4>
                            <label style="font-size:0.8rem; color:red; cursor:pointer;" class="delete-label">
                                <input type="checkbox" name="delete_other_videos[]" value="{{ $video->id }}" class="delete-checkbox"> Check to Delete
                            </label>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label>Video URL</label>
                                <input type="url" name="existing_other_videos[{{ $video->id }}][video_url]" class="form-control" value="{{ $video->video_url }}">
                            </div>
                            <div class="form-group">
                                <label>Current Video File</label>
                                @if($video->video_file)
                                    <div style="margin-bottom:0.5rem; font-size:0.8rem; background:#f8fafc; padding: 0.5rem; border:1px solid #e2e8f0;">
                                      <a href="{{ Storage::url($video->video_file) }}" target="_blank">View Current File Attachment</a>
                                    </div>
                                @endif
                                <input type="file" name="existing_other_video_files[{{ $video->id }}]" class="form-control" accept="video/mp4,video/webm">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">
                <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                    <span>Videos</span>
                    <button type="button" class="btn-add" onclick="addVideo()">+ Add Video</button>
                </div>
            </div>
            <div class="section-body" id="videoWrapper">
                @foreach($product->videos as $video)
                    <div class="append-row existing-item">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <h4>Existing Video</h4>
                            <label style="font-size:0.8rem; color:red; cursor:pointer;" class="delete-label">
                                <input type="checkbox" name="delete_videos[]" value="{{ $video->id }}" class="delete-checkbox"> Check to Delete
                            </label>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label>Video Embedded Link</label>
                                <input type="url" name="existing_videos[{{ $video->id }}][link]" class="form-control" value="{{ $video->link }}">
                            </div>
                            <div class="form-group">
                                <label>Current Video File</label>
                                @if($video->video)
                                    <div style="margin-bottom:0.5rem; font-size:0.8rem; background:#f8fafc; padding: 0.5rem; border:1px solid #e2e8f0;">
                                      <a href="{{ Storage::url($video->video) }}" target="_blank">View Current File Attachment</a>
                                    </div>
                                @else
                                    <div style="font-size:0.8rem; color: #64748b; font-style: italic;">No file attached</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="section-container">
            <div class="section-header">SEO & Meta Data</div>
            <div class="section-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Meta Title</label>
                        <textarea name="meta_title" class="form-control" rows="3">{{ old('meta_title', $product->meta->meta_title ?? '') }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta->meta_description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Canonical URL (Optional, defaults to current page URL)</label>
                    <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url', $product->meta->canonical_url ?? '') }}" placeholder="https://example.com/product-slug">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Meta Keyword</label>
                        <textarea name="meta_keyword" class="form-control" rows="3">{{ old('meta_keyword', $product->meta->meta_keyword ?? '') }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Other Meta Tag</label>
                        <textarea name="other_meta_tags" class="form-control" rows="3">{{ old('other_meta_tags', $product->meta->other_meta_tags ?? '') }}</textarea>
                    </div>
                </div>

                <div style="margin: 2rem 0 1rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <h4 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0;">Open Graph (Social Sharing)</h4>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label>OG Title</label>
                        <input type="text" name="og_title" class="form-control" value="{{ old('og_title', $product->meta->og_title ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>OG Image (Recommended 1200x630)</label>
                        @if(isset($product->meta->og_image) && $product->meta->og_image)
                            <div style="margin-bottom: 0.5rem;">
                                <img src="{{ $product->meta->og_image_url }}" style="max-height: 50px; border: 1px solid #ddd;">
                            </div>
                        @endif
                        <input type="file" name="og_image" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="form-group">
                    <label>OG Description</label>
                    <textarea name="og_description" class="form-control" rows="3">{{ old('og_description', $product->meta->og_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-bottom: 2rem;">
            <a href="{{ route('admin.product.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
            <button type="submit" class="btn-add" style="padding: 0.75rem 2rem; font-size: 1rem;">Update Product</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById('product_title');
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

    // Visual feedback for deletion
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('delete-checkbox')) {
            const item = e.target.closest('.existing-item') || e.target.closest('.image-item');
            if (e.target.checked) {
                if (item) {
                    item.style.opacity = '0.5';
                    item.style.filter = 'grayscale(1)';
                    item.style.border = '1px solid red';
                    item.style.background = '#fff5f5';
                }
            } else {
                if (item) {
                    item.style.opacity = '1';
                    item.style.filter = 'none';
                    item.style.border = '1px solid var(--border-color)';
                    item.style.background = '#fff';
                }
            }
        }
    });

    function addOtherVideo() {
        const wrapper = document.getElementById('otherVideoWrapper');
        const count = wrapper.querySelectorAll('.append-row').length;
        const row = document.createElement('div');
        row.className = 'append-row';
        row.innerHTML = `
            <h4>New Other Video <button type="button" class="btn-update" style="color:red; border-color:red; padding:0.2rem 0.5rem;" onclick="this.parentElement.parentElement.remove()">Remove</button></h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label>Video URL (YouTube/Vimeo)</label>
                    <input type="url" name="other_video_urls[]" class="form-control" placeholder="https://youtube.com/...">
                </div>
                <div class="form-group">
                    <label>Or Upload Video File</label>
                    <input type="file" name="other_video_files[]" class="form-control" accept="video/mp4,video/webm">
                </div>
            </div>
        `;
        wrapper.appendChild(row);
    }

    function addVideo() {
        const wrapper = document.getElementById('videoWrapper');
        const row = document.createElement('div');
        row.className = 'append-row';
        row.innerHTML = `
            <h4>New Video <button type="button" class="btn-update" style="color:red; border-color:red; padding:0.2rem 0.5rem;" onclick="this.parentElement.parentElement.remove()">Remove</button></h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label>Video Embedded Link (Youtube, Vimeo, etc)</label>
                    <input type="url" name="video_links[]" class="form-control" placeholder="https://youtube.com/...">
                </div>
                <div class="form-group">
                    <label>- OR - Upload Video File (mp4, webm)</label>
                    <input type="file" name="video_files[]" accept="video/mp4,video/webm" class="form-control">
                </div>
            </div>
        `;
        wrapper.appendChild(row);
    }
</script>
@endpush
@endsection
