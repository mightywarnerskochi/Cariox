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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Add Service</h2>
        <a href="{{ route('admin.service.index') }}" class="btn-update" style="text-decoration: none;">Back to Services</a>
    </div>

    <div class="section-container">
        <div class="section-header">
            Create New Service Module
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.service.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Name <span style="color:red">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Slug <span style="font-size: 0.8em; color: gray;">(Auto-generated, editable)</span></label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
                </div>

                <div class="form-group">
                    <label>Home Description</label>
                    <textarea name="home_description" class="form-control tinymce" rows="3">{{ old('home_description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Page Description</label>
                    <textarea name="page_description" class="form-control tinymce" rows="3">{{ old('page_description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Main Description</label>
                    <textarea id="main_description" name="main_description" class="form-control tinymce" data-height="350" rows="5">{{ old('main_description') }}</textarea>
                </div>

                <!-- Background Image -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Background Image</label>
                        <input type="file" name="background_image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Background Image Alt Text</label>
                        <input type="text" name="background_image_alt_text" class="form-control" value="{{ old('background_image_alt_text') }}">
                    </div>
                </div>

                <!-- Main Image -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Main Image</label>
                        <input type="file" name="main_image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Main Image Alt Text</label>
                        <input type="text" name="main_image_alt_text" class="form-control" value="{{ old('main_image_alt_text') }}">
                    </div>
                </div>

                <!-- Base Image 1 -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Base Image 1</label>
                        <input type="file" name="base_image1" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Base Image 1 Alt Text</label>
                        <input type="text" name="base_image1_alt_text" class="form-control" value="{{ old('base_image1_alt_text') }}">
                    </div>
                </div>

                <!-- Base Image 2 -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Base Image 2</label>
                        <input type="file" name="base_image2" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Base Image 2 Alt Text</label>
                        <input type="text" name="base_image2_alt_text" class="form-control" value="{{ old('base_image2_alt_text') }}">
                    </div>
                </div>

                <div class="form-group" style="width: 50%;">
                    <label>Order / Position</label>
                    <input type="number" min="1" name="position" class="form-control" placeholder="Leave empty to push to last" value="{{ old('position') }}">
                </div>

                <!-- Meta Details -->
                <div class="meta-card">
                    <h4>SEO & Meta Data</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Meta Title</label>
                            <textarea name="meta_title" class="form-control" rows="3">{{ old('meta_title') }}</textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Meta Keyword</label>
                            <textarea name="meta_keyword" class="form-control" rows="3">{{ old('meta_keyword') }}</textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Other Meta Tag</label>
                            <textarea name="other_meta_tags" class="form-control" rows="3">{{ old('other_meta_tags') }}</textarea>
                        </div>
                    </div>

                    <div style="margin: 2rem 0 1rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                        <h4 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0;">Open Graph (Social Sharing)</h4>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label>OG Title</label>
                            <input type="text" name="og_title" class="form-control" value="{{ old('og_title') }}">
                        </div>
                        <div class="form-group">
                            <label>OG Image (Recommended 1200x630)</label>
                            <input type="file" name="og_image" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>OG Description</label>
                        <textarea name="og_description" class="form-control" rows="3">{{ old('og_description') }}</textarea>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <a href="{{ route('admin.service.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn-add" style="padding: 0.55rem 1rem;">Save Service Module</button>
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
