@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Choose Us Management</h2>
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

    <!-- Main Content Form -->
    <div class="section-container">
        <div class="section-header">Main Section Details</div>
        <div class="section-body">
            <form action="{{ route('admin.choose_us.updateMain') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Main Title <span style="color: red;">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $choose->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $choose->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $choose->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label>Description <span style="color: red;">*</span></label>
                    <textarea name="description" id="description" class="form-control tinymce" rows="3" required>{{ old('description', $choose->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Background Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($choose->image)
                            <div style="margin-top: 0.5rem;">
                                <img src="{{ Storage::url($choose->image) }}" style="width: 100px; border-radius: 0.25rem;">
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="image_alt_text" class="form-control" value="{{ old('image_alt_text', $choose->image_alt_text) }}">
                    </div>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn-update">Update Main Details</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Feature Items Section -->
    <div class="section-container">
        <div class="section-header">
            Additional Features (Max 6 Active)
        </div>
        <div class="section-body">
            <!-- Add Item Form -->
            <form action="{{ route('admin.choose_us.storeItem') }}" method="POST" enctype="multipart/form-data" style="background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 1rem; align-items: end;">
                    <div class="form-group">
                        <label>Feature Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Feature Text <span style="color: red;">*</span></label>
                        <input type="text" name="text" class="form-control" placeholder="Feature title or text" required>
                    </div>
                    <div class="form-group">
                        <label>Order (Optional)</label>
                        <input type="number" name="order" class="form-control" placeholder="1, 2, 3...">
                    </div>
                    <div>
                        <button type="submit" class="btn-add" style="margin: 0; height: 38px;">Add Feature</button>
                    </div>
                </div>
            </form>

            <!-- Items Table -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th style="width: 60px;">Order</th>
                        <th style="width: 80px;">Image</th>
                        <th>Feature Text</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($choose->items) > 0)
                        @foreach($choose->items as $item)
                            <tr>
                                <td style="width: 80px;">
                                    <select class="form-control" style="width: 60px; height: 32px; padding: 2px 5px !important; color: #000 !important; background-color: #fff !important; display: block; border: 1px solid #ccc;" onchange="updateItemOrder('{{ route('admin.choose_us.updateItem', $item->id) }}', this.value)">
                                        @for($i = 1; $i <= count($choose->items); $i++)
                                            <option value="{{ $i }}" {{ $item->order == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    @if(!empty($item->image))
                                        <img src="{{ asset('storage/' . $item->image) }}" style="width: 40px; height: 40px; object-fit: contain;">
                                    @else
                                        <i class="{{ $item->icon ?: 'fas fa-info-circle' }}"></i>
                                    @endif
                                </td>
                                <td>{{ $item->text }}</td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleItemStatus('{{ route('admin.choose_us.toggleStatus', $item->id) }}')" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <button type="button" 
                                            onclick='openEditModal(@json($item->id), @json($item->text), @json($item->image ? asset('storage/' . $item->image) : null), @json($item->status))'
                                            class="action-btn"><i class="fas fa-edit"></i></button>
                                    <button type="button" 
                                            onclick="confirmDeleteFeature('{{ route('admin.choose_us.destroyItem', $item->id) }}')" 
                                            class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No feature items added yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Item Editing -->
<div id="editFeatureModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 0.5rem; width: 400px;">
        <h3>Edit Feature Item</h3>
        <form id="editFeatureForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Feature Image</label>
                <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                <div id="edit_image_preview_wrapper" style="margin-top: 0.75rem; display: none;">
                    <img id="edit_image_preview" src="" style="width: 60px; height: 60px; object-fit: contain;">
                </div>
            </div>
            <div class="form-group">
                <label>Feature Text</label>
                <input type="text" name="text" id="edit_text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="document.getElementById('editFeatureModal').style.display='none'" class="btn-update" style="background: #ccc; border-color: #ccc;">Cancel</button>
                <button type="submit" class="btn-update">Update Feature</button>
            </div>
        </form>
    </div>
</div>

<form id="deleteFeatureForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="actionForm" method="POST" style="display: none;">
    @csrf
</form>

@stop

@push('scripts')
<script>
    function updateItemOrder(url, order) {
        let form = document.getElementById('actionForm');
        form.action = url;
        form.innerHTML += '@method("PUT")';
        form.innerHTML += `<input type="hidden" name="order" value="${order}">`;
        form.submit();
    }

    function toggleItemStatus(url) {
        let form = document.getElementById('actionForm');
        form.action = url;
        form.method = "POST";
        form.submit();
    }

    function confirmDeleteFeature(url) {
        if(confirm('Are you sure you want to delete this feature?')) {
            let form = document.getElementById('deleteFeatureForm');
            form.action = url;
            form.submit();
        }
    }

    function openEditModal(id, text, imageUrl, status) {
        document.getElementById('edit_text').value = text;
        document.getElementById('edit_status').value = status;

        let wrapper = document.getElementById('edit_image_preview_wrapper');
        let preview = document.getElementById('edit_image_preview');
        let input = document.getElementById('edit_image');

        if (imageUrl) {
            preview.src = imageUrl;
            wrapper.style.display = 'block';
        } else {
            preview.src = '';
            wrapper.style.display = 'none';
        }

        // Clear the file picker so re-uploading works reliably.
        if (input) input.value = '';

        document.getElementById('editFeatureForm').action = `{{ url('admin/choose-us/item') }}/${id}/update`;
        document.getElementById('editFeatureModal').style.display = 'flex';
    }

</script>
@endpush
