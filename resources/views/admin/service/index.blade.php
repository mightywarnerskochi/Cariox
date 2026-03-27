@extends('admin.layouts.app')

@section('content')


<div class="dashboard-content">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Services Management</h2>
    </div>

    <!-- Section Content Form -->
    <div class="section-container">
        <div class="section-header">
            Section heading (Common title & details)
        </div>
        <div class="section-body">
            <form action="{{ route('admin.service.storeSection') }}" method="POST" class="section-form" novalidate>
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

    @if(\App\Models\Service::where('status', 1)->count() >= 3)
        <div class="limit-warning">
            <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
            <strong>Limit Reached:</strong> You have 3 active services. You cannot add or activate another one unless you deactivate an existing one.
        </div>
    @endif

    <!-- Services Table -->
    <div class="section-container">
        <form action="{{ route('admin.service.bulkDelete') }}" method="POST" id="serviceBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('serviceBulkForm', '{{ route('admin.service.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('serviceBulkForm', '{{ route('admin.service.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                    <span style="font-size: 0.875rem; color: #64748b; font-weight: 400;">Manage Services (Max 3).</span>
                </div>
                <div>
                    @if(\App\Models\Service::where('status', 1)->count() < 3)
                        <a href="{{ route('admin.service.create') }}" class="btn-add">Add Service</a>
                    @else
                        <button type="button" class="btn-add" style="opacity: 0.5; cursor: not-allowed;" title="Maximum limit of 3 active services reached.">Add Service</button>
                    @endif
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'service_ids[]')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Main Image</th>
                            <th>Name</th>
                            <th style="width: 100px;">Order</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $index => $item)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" class="service_ids[]"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->main_image)
                                        <img src="{{ Storage::url($item->main_image) }}" alt="{{ $item->main_image_alt_text }}" style="height: 40px; border-radius: 4px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updatePosition('{{ route('admin.service.update', $item->id) }}', this.value)">
                                        @for($i = 1; $i <= max($services->count(), $item->position, 1); $i++)
                                            <option value="{{ $i }}" {{ $item->position == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.service.toggleStatus') }}', {{ $item->id }})" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td style="display:flex;">
                                    <a href="{{ route('admin.service.edit', $item->id) }}" class="action-btn" style="text-decoration:none;"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="button" onclick="deleteItem('{{ route('admin.service.destroy', $item->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No services added yet.</td>
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
        function toggleAll(source, className) {
            let checkboxes = document.getElementsByClassName(className);
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function submitBulkDelete(formId, url) {
            if(confirm('Are you sure you want to delete the selected items?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'DELETE';
                form.submit();
            }
        }

        function submitBulkToggle(formId, url) {
            if(confirm('Are you sure you want to toggle the status for the selected items?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'POST';
                form.submit();
            }
        }

        function toggleStatus(url, id) {
            let form = document.getElementById('actionForm');
            form.action = url;
            document.getElementById('actionMethod').value = 'POST';
            document.getElementById('actionId').value = id;
            form.submit();
        }

        function deleteItem(url) {
            if(confirm('Are you sure you want to delete this item?')) {
                let form = document.getElementById('actionForm');
                form.action = url;
                document.getElementById('actionMethod').value = 'DELETE';
                form.submit();
            }
        }

        function updatePosition(url, val) {
            let form = document.getElementById('positionForm');
            form.action = url;
            document.getElementById('positionInput').value = val;
            form.submit();
        }
    </script>
</div>
@endsection
