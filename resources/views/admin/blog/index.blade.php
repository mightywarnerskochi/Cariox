@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Blog Management</h2>
        <a href="{{ route('admin.blog.create') }}" class="btn-add">Add New Blog</a>
    </div>

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

    <!-- Section Heading Form -->
    <div class="section-container" style="margin-bottom: 2rem;">
        <div class="section-header">
            Section Heading (Pill Title & Description)
        </div>
        <div class="section-body" style="padding: 1.5rem;">
            <form action="{{ route('admin.blog.storeSection') }}" method="POST" novalidate>
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label>Small Title (Pill Text) <span style="color:red">*</span></label>
                        <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $sectionContent->small_title) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Main Title <span style="color:red">*</span></label>
                        <input type="text" name="main_title" class="form-control" value="{{ old('main_title', $sectionContent->main_title) }}" required>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label>Description <span style="color:red">*</span></label>
                    <textarea name="description" id="description" class="form-control tinymce" rows="3" required>{{ old('description', $sectionContent->description) }}</textarea>
                </div>
                <button type="submit" class="btn-update">Update Section Details</button>
            </form>
        </div>
    </div>

    <div class="section-container">
        <form action="{{ route('admin.blog.bulkDelete') }}" method="POST" id="blogBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('blogBulkForm', '{{ route('admin.blog.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('blogBulkForm', '{{ route('admin.blog.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'blog_ids')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Author & Date</th>
                            <th style="width: 80px;">Position</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $index => $item)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" class="blog_ids"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="blog" style="height: 40px; border-radius: 4px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td><strong>{{ $item->title }}</strong></td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        By: {{ $item->author ?? 'Admin' }}<br>
                                        {{ $item->date ? \Carbon\Carbon::parse($item->date)->format('M d, Y') : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updatePosition('{{ route('admin.blog.update', $item->id) }}', this.value)">
                                        @for($i = 1; $i <= $blogs->count(); $i++)
                                            <option value="{{ $i }}" {{ $item->position == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus({{ $item->id }})" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.blog.edit', $item->id) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                                        <button type="button" onclick="deleteItem({{ $item->id }})" class="action-btn" style="color:red; background:none; border:none; cursor:pointer;"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem; color: #64748b;">No blogs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <form id="actionForm" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="_method" id="actionMethod" value="DELETE">
    </form>

    <form id="positionForm" method="POST" style="display:none;">
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
            if(confirm('Are you sure you want to delete the selected blogs?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'DELETE';
                form.submit();
            }
        }

        function submitBulkToggle(formId, url) {
            if(confirm('Are you sure you want to toggle the status for the selected blogs?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'POST';
                form.submit();
            }
        }

        function toggleStatus(id) {
            const form = document.getElementById('actionForm');
            form.action = "{{ url('admin/blog') }}/" + id + "/toggle-status";
            document.getElementById('actionMethod').value = 'POST';
            form.submit();
        }

        function deleteItem(id) {
            if(confirm('Are you sure you want to delete this blog?')) {
                const form = document.getElementById('actionForm');
                form.action = "{{ url('admin/blog') }}/" + id + "/destroy";
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
