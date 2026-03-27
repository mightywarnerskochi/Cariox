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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Subcategories</h2>
    </div>

    <!-- Subcategories Table -->
    <div class="section-container">
        <form action="{{ route('admin.subcategory.bulkDelete') }}" method="POST" id="subcategoryBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('subcategoryBulkForm', '{{ route('admin.subcategory.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('subcategoryBulkForm', '{{ route('admin.subcategory.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                </div>
                <div>
                    <a href="{{ route('admin.subcategory.create') }}" class="btn-add">Add Subcategory</a>
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'subcategory_ids[]')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Image</th>
                            <th>Subcategory Name</th>
                            <th>Parent Category</th>
                            <th>Slug</th>
                            <th style="width: 100px;">Order</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subcategories as $index => $item)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" class="subcategory_ids[]"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->image_alt_text }}" style="height: 40px; border-radius: 4px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td><span style="background: #e2e8f0; color: #475569; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">{{ $item->category->name ?? 'N/A' }}</span></td>
                                <td>{{ $item->slug }}</td>
                                <td>
                                    @php 
                                        $catGroupCount = $subcategories->where('category_id', $item->category_id)->count();
                                    @endphp
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updatePosition('{{ route('admin.subcategory.update', $item->id) }}', this.value)">
                                        @for($i = 1; $i <= $catGroupCount; $i++)
                                            <option value="{{ $i }}" {{ $item->position == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.subcategory.toggleStatus') }}', {{ $item->id }})" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td style="display:flex;">
                                    <a href="{{ route('admin.subcategory.edit', $item->id) }}" class="action-btn" style="text-decoration:none;"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="button" onclick="deleteItem('{{ route('admin.subcategory.destroy', $item->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 2rem; color: #64748b;">No subcategories found.</td>
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
