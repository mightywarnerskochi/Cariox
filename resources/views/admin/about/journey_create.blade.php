@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Add Journey Record</h2>
        <a href="{{ route('admin.journey.index') }}" class="btn-update" style="background: #ccc; border-color: #ccc; color: #333; height: 38px;">Back to List</a>
    </div>

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="section-container">
        <div class="section-body">
            <form action="{{ route('admin.journey.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Year <span style="color: red;">*</span></label>
                        <input type="text" name="year" class="form-control" value="{{ old('year') }}" placeholder="e.g. 2024" required>
                    </div>
                    <div class="form-group">
                        <label>Caption</label>
                        <input type="text" name="caption" class="form-control" value="{{ old('caption') }}" placeholder="Brief title for this year">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control tinymce" rows="4">{{ old('description') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="image_alt_text" class="form-control" value="{{ old('image_alt_text') }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem; width: 200px;">
                    <label>Order (Optional)</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order') }}">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn-add">Add Journey Record</button>
                    <button type="reset" class="btn-update" style="background: transparent; border-color: #ccc; color: #666; margin-left: 0.5rem;">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

