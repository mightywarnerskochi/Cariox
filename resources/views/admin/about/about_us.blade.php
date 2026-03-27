@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">About Us Management</h2>
    </div>

    <!-- Section Heading Form -->
    <div class="section-container">
        <div class="section-header">
            Section Heading (Common title & details)
        </div>
        <div class="section-body">
            <form action="{{ route('admin.about.storeSection') }}" method="POST" class="section-form" novalidate>
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Small Title <span style="color: red;">*</span></label>
                        <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $sectionContent->small_title) }}" required>
                        <span class="error-text @error('small_title') d-block server-error @enderror" id="error-small_title">{{ $errors->first('small_title') ?: 'Small Title is required' }}</span>
                    </div>
                    <div class="form-group">
                        <label>Main Title <span style="color: red;">*</span></label>
                        <input type="text" name="main_title" class="form-control" value="{{ old('main_title', $sectionContent->main_title) }}" required>
                        <span class="error-text @error('main_title') d-block server-error @enderror" id="error-main_title">{{ $errors->first('main_title') ?: 'Main Title is required' }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description <span style="color: red;">*</span></label>
                    <textarea name="description" id="description" class="form-control tinymce" rows="3" required>{{ old('description', $sectionContent->description) }}</textarea>
                    <span class="error-text @error('description') d-block server-error @enderror" id="error-description">{{ $errors->first('description') ?: 'Description is required' }}</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Button Label <span style="color: red;">*</span></label>
                        <input type="text" name="button_label" class="form-control" value="{{ old('button_label', $sectionContent->button_label) }}" required>
                        <span class="error-text @error('button_label') d-block server-error @enderror" id="error-button_label">{{ $errors->first('button_label') ?: 'Button Label is required' }}</span>
                    </div>
                    <div class="form-group">
                        <label>Section Link <span style="color: red;">*</span></label>
                        <input type="text" name="link" class="form-control" value="{{ old('link', $sectionContent->link) }}" required>
                        <span class="error-text @error('link') d-block server-error @enderror" id="error-link">{{ $errors->first('link') ?: 'Section Link is required' }}</span>
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn-update">Update Section Details</button>
                </div>
            </form>
        </div>
    </div>

    <!-- About Us Details Form -->
    <div class="section-container">
        <div class="section-header">
            About Us Content Details
        </div>
        <div class="section-body">
            <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Detailed Description</label>
                    <textarea name="detailed_description" id="detailed_description" class="form-control tinymce" data-height="350">{{ old('detailed_description', $about->detailed_description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Years of Experience</label>
                        <input type="text" name="years_of_experience" class="form-control" value="{{ old('years_of_experience', $about->years_of_experience) }}" placeholder="15">
                    </div>
                    <div class="form-group">
                        <label>Experience Caption</label>
                        <input type="text" name="experience_caption" class="form-control" value="{{ old('experience_caption', $about->experience_caption) }}" placeholder="Years of experience">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $about->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $about->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Vision</label>
                        <textarea name="vision" class="form-control tinymce" rows="3">{{ old('vision', $about->vision) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Mission</label>
                        <textarea name="mission" class="form-control tinymce" rows="3">{{ old('mission', $about->mission) }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Images (Max 3)</label>
                    <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem;">Current count: {{ $about->images->count() }}/3</p>
                    @if($about->images->count() < 3)
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    @else
                        <div style="background: #f8fafc; padding: 0.75rem; border: 1px dashed #cbd5e1; border-radius: 0.25rem; color: #64748b; font-size: 0.85rem;">
                            Image limit reached. Delete an existing image to upload new ones.
                        </div>
                    @endif
                </div>

                @if($about->images->count() > 0)
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
                        @foreach($about->images as $img)
                            <div style="position: relative; width: 150px;">
                                <img src="{{ Storage::url($img->image) }}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                                <button type="button" 
                                        onclick="confirmDeleteImage('{{ route('admin.about.deleteImage', $img->id) }}')" 
                                        style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn-update">Save About Us Details</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="deleteImageForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@stop

@push('scripts')
<script>
    function confirmDeleteImage(url) {
        if(confirm('Are you sure you want to delete this image?')) {
            let form = document.getElementById('deleteImageForm');
            form.action = url;
            form.submit();
        }
    }
</script>
@endpush
