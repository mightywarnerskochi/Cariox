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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Add Testimonial</h2>
        <a href="{{ route('admin.testimonial.index') }}" class="btn-update" style="text-decoration: none;">Back to Testimonials</a>
    </div>

    <div class="section-container">
        <div class="section-header">
            Create New Testimonial
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.testimonial.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Name <span style="color:red">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Designation (Optional)</label>
                        <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                        @error('designation') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Rating (1-5) <span style="color:red">*</span></label>
                        <select name="rating" class="form-control" required>
                            <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1 Star)</option>
                        </select>
                        @error('rating') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Content <span style="color:red">*</span></label>
                    <textarea name="content" class="form-control tinymce" rows="5" required>{{ old('content') }}</textarea>
                    @error('content') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Client Image / Avatar (Recommended: 180x180 px)</label>
                        <input type="file" name="image" class="form-control" accept="image/*" data-max-width="180" data-max-height="180">
                        @error('image') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text') }}">
                        @error('alt_text') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Order / Position</label>
                    <input type="number" min="1" name="position" class="form-control" placeholder="Leave empty to push to last" value="{{ old('position') }}">
                    @error('position') <span class="text-danger" style="color:red; font-size:0.8rem; display:block; margin-top:0.25rem;">{{ $message }}</span> @enderror
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <a href="{{ route('admin.testimonial.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn-add" style="padding: 0.55rem 1rem;">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
