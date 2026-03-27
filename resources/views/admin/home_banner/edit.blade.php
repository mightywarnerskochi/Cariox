@extends('admin.layouts.app')

@section('content')


<div class="dashboard-content">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1 class="page-title">Edit Home Banner Content</h1>
        <a href="{{ route('admin.home.banner.index') }}" style="color: var(--text-light); text-decoration: none;"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="content-card" style="max-width: 800px;">
        <form action="{{ route('admin.home.banner.update', $banner->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="small_title">Small Title</label>
                <input type="text" name="small_title" id="small_title" class="form-control" value="{{ old('small_title', $banner->small_title) }}" required>
                @error('small_title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="main_title">Main Title</label>
                <input type="text" name="main_title" id="main_title" class="form-control" value="{{ old('main_title', $banner->main_title) }}" required>
                @error('main_title') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control tinymce" rows="4" required>{{ old('description', $banner->description) }}</textarea>
                @error('description') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="button_text">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}" required>
                    @error('button_text') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="button_link">Button Link</label>
                    <input type="text" name="button_link" id="button_link" class="form-control" value="{{ old('button_link', $banner->button_link) }}" required>
                    @error('button_link') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 2rem 0;">
            <h3 style="margin-bottom: 1rem; color: #1e293b;">Stats & Reviews Area</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="trusted_clients_count">Trusted Clients Count (e.g., 8231)</label>
                    <input type="text" name="trusted_clients_count" id="trusted_clients_count" class="form-control" value="{{ old('trusted_clients_count', $banner->trusted_clients_count) }}">
                </div>

                <div class="form-group">
                    <label for="trusted_clients_label">Trusted Clients Label</label>
                    <input type="text" name="trusted_clients_label" id="trusted_clients_label" class="form-control" value="{{ old('trusted_clients_label', $banner->trusted_clients_label) }}">
                </div>

                <div class="form-group">
                    <label for="rating_label">Rating Label (e.g., Google Rating)</label>
                    <input type="text" name="rating_label" id="rating_label" class="form-control" value="{{ old('rating_label', $banner->rating_label) }}">
                </div>

                <div class="form-group">
                    <label for="google_rating">Rating Score (e.g., 5.0)</label>
                    <input type="number" step="0.1" max="5.0" name="google_rating" id="google_rating" class="form-control" value="{{ old('google_rating', $banner->google_rating) }}">
                </div>

                <div class="form-group">
                    <label for="review_label">Review Label</label>
                    <input type="text" name="review_label" id="review_label" class="form-control" value="{{ old('review_label', $banner->review_label) }}">
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn-submit">Update Banner Content</button>
            </div>
        </form>
    </div>
</div>
@endsection
