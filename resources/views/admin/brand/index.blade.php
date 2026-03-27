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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Brands Management</h2>
    </div>

    <!-- Section Content Form -->
    <div class="section-container">
        <div class="section-header">
            Section heading (Common title & details)
        </div>
        <div class="section-body">
            <form action="{{ route('admin.brand.storeSection') }}" method="POST" class="section-form" novalidate>
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

                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn-update">Update Section Details</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Brands Table -->
    <div class="section-container">
        <form action="{{ route('admin.brand.bulkDelete') }}" method="POST" id="brandBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('brandBulkForm', '{{ route('admin.brand.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('brandBulkForm', '{{ route('admin.brand.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                    <span style="font-size: 0.875rem; color: #64748b; font-weight: 400;">Manage Brands. Active brands appear on the frontend.</span>
                </div>
                <div>
                    <a href="{{ route('admin.brand.create') }}" class="btn-add">Add Brand</a>
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'brand_ids[]')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Image Alt Text</th>
                            <th style="width: 100px;">Position</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $index => $brand)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $brand->id }}" class="brand_ids[]"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->alt_text }}" style="height: 40px; border-radius: 4px;">
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->alt_text ?: '-' }}</td>
                                <td>
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updatePosition('{{ route('admin.brand.update', $brand->id) }}', this.value)">
                                        @for($i = 1; $i <= $brands->count(); $i++)
                                            <option value="{{ $i }}" {{ $brand->position == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.brand.toggleStatus') }}', {{ $brand->id }})" {{ $brand->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td style="display:flex;">
                                    <a href="{{ route('admin.brand.edit', $brand->id) }}" class="action-btn" style="text-decoration:none;"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="button" onclick="deleteItem('{{ route('admin.brand.destroy', $brand->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No brands added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Hidden Form for Deletes and Toggles -->
    <form id="actionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" id="actionMethod" value="DELETE">
        <input type="hidden" name="id" id="actionId">
    </form>

    <!-- Hidden Form for Position Change -->
    <form id="positionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="position" id="positionInput">
    </form>

    <script>
        // Toggle All Checkboxes
        function toggleAll(source, className) {
            let checkboxes = document.getElementsByClassName(className);
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        // Submit Bulk Delete Action
        function submitBulkDelete(formId, url) {
            if(confirm('Are you sure you want to delete the selected items?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'DELETE';
                form.submit();
            }
        }

        // Submit Bulk Toggle Action
        function submitBulkToggle(formId, url) {
            if(confirm('Are you sure you want to toggle the status for the selected items?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'POST';
                form.submit();
            }
        }

        // Single Toggle Status Switch
        function toggleStatus(url, id) {
            let form = document.getElementById('actionForm');
            form.action = url;
            document.getElementById('actionMethod').value = 'POST';
            document.getElementById('actionId').value = id;
            form.submit();
        }

        // Single Delete
        function deleteItem(url) {
            if(confirm('Are you sure you want to delete this item?')) {
                let form = document.getElementById('actionForm');
                form.action = url;
                document.getElementById('actionMethod').value = 'DELETE';
                form.submit();
            }
        }

        // Single Position Update
        function updatePosition(url, val) {
            let form = document.getElementById('positionForm');
            form.action = url;
            document.getElementById('positionInput').value = val;
            form.submit();
        }
    </script>
</div>
@endsection
