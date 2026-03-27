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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Brand</h2>
        <a href="{{ route('admin.brand.index') }}" class="btn-update" style="text-decoration: none;">Back to Brands</a>
    </div>

    <div class="section-container">
        <div class="section-header">
            Edit Brand Information
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.brand.update', $brand->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label>Current Image</label>
                    <img src="{{ Storage::url($brand->image) }}" alt="Preview" style="height: 100px; border-radius: 0.5rem; border: 1px solid var(--border-color); padding: 0.25rem;">
                </div>

                <div class="form-group">
                    <label>Brand Name <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Swap Brand Image (Leave blank to keep current format) </label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Image Alt Text</label>
                    <input type="text" name="alt_text" class="form-control" placeholder="e.g. Brand Name" value="{{ old('alt_text', $brand->alt_text) }}">
                </div>

                <div class="form-group">
                    <label>Position</label>
                    <input type="number" min="1" name="position" class="form-control" value="{{ old('position', $brand->position) }}">
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <a href="{{ route('admin.brand.index') }}" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem; text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn-add" style="padding: 0.55rem 1rem;">Update Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
