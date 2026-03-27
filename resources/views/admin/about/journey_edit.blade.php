@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Journey Record</h2>
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
            <form action="{{ route('admin.journey.update', $journey->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Year <span style="color: red;">*</span></label>
                        <input type="text" name="year" class="form-control" value="{{ old('year', $journey->year) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Caption</label>
                        <input type="text" name="caption" class="form-control" value="{{ old('caption', $journey->caption) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control tinymce" rows="4">{{ old('description', $journey->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($journey->image)
                            <div style="margin-top: 0.5rem;">
                                <img src="{{ Storage::url($journey->image) }}" style="width: 100px; border-radius: 4px;">
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="image_alt_text" class="form-control" value="{{ old('image_alt_text', $journey->image_alt_text) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $journey->order) }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $journey->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $journey->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn-update">Update Journey Record</button>
                    <button type="reset" class="btn-update" style="background: transparent; border-color: #ccc; color: #666; margin-left: 0.5rem;">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

