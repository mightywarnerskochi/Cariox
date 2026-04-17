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
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Products</h2>
    </div>

    <!-- Products Table -->
    <div class="section-container">
        <form action="{{ route('admin.product.bulkDelete') }}" method="POST" id="productBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('productBulkForm', '{{ route('admin.product.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('productBulkForm', '{{ route('admin.product.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                </div>
                <div>
                    <a href="{{ route('admin.product.create') }}" class="btn-add">Add Product</a>
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'product_ids[]')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Image</th>
                            <th>Product Title</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Brand</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 120px;">Display in Home</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $item)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" class="product_ids[]"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->images->count() > 0)
                                        <img src="{{ Storage::url($item->images->first()->image) }}" alt="product" style="height: 40px; border-radius: 4px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->product_title }}</td>
                                <td><span style="background: #e0e7ff; color: #3730a3; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">{{ $item->category->name ?? 'N/A' }}</span></td>
                                <td><span style="background: #dbeafe; color: #1e40af; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">{{ $item->subcategory->name ?? 'N/A' }}</span></td>
                                <td>{{ $item->brand->name ?? 'N/A' }}</td>

                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.product.toggleStatus') }}', {{ $item->id }})" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleHome('{{ route('admin.product.toggleHome') }}', {{ $item->id }}, this)" {{ $item->display_in_home ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td style="display:flex;">
                                    <a href="{{ route('admin.product.edit', $item->id) }}" class="action-btn" style="text-decoration:none;"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="button" onclick="deleteItem('{{ route('admin.product.destroy', $item->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 2rem; color: #64748b;">No products found.</td>
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

        function toggleHome(url, id, element) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    console.log(data.message);
                } else {
                    alert('Error updating display status');
                    element.checked = !element.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
                element.checked = !element.checked;
            });
        }

        function deleteItem(url) {
            if(confirm('Are you sure you want to delete this item?')) {
                let form = document.getElementById('actionForm');
                form.action = url;
                document.getElementById('actionMethod').value = 'DELETE';
                form.submit();
            }
        }


    </script>
</div>
@endsection
