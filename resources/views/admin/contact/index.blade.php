@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Contact Management</h2>
        <a href="{{ route('admin.contact.create') }}" class="btn-add">Add New Contact</a>
    </div>

    <div class="section-container">
        <form action="{{ route('admin.contact.bulkDelete') }}" method="POST" id="contactBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('contactBulkForm', '{{ route('admin.contact.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('contactBulkForm', '{{ route('admin.contact.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                </div>
                <div>
                    <!-- Optional secondary action could go here -->
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'contact_ids')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Logo</th>
                            <th>Country</th>
                            <th>Address</th>
                            <th>Phones & Emails</th>
                            <th style="width: 80px;">Order</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $index => $item)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" class="contact_ids"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->country_logo)
                                        <img src="{{ Storage::url($item->country_logo) }}" alt="logo" style="height: 30px; border-radius: 4px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td><strong>{{ $item->country }}</strong></td>
                                <td>
                                    <div style="font-size: 0.85rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {!! $item->address !!}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.8rem;">
                                        <div><i class="fas fa-phone-alt"></i> {{ $item->phones->count() }} Numbers</div>
                                        <div><i class="fas fa-envelope"></i> {{ $item->emails->count() }} Emails</div>
                                    </div>
                                </td>
                                <td>
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updateOrder('{{ route('admin.contact.update', $item->id) }}', this.value)">
                                        @for($i = 1; $i <= max($contacts->count(), $item->order, 1); $i++)
                                            <option value="{{ $i }}" {{ $item->order == $i ? 'selected' : '' }}>{{ $i }}</option>
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
                                        <a href="{{ route('admin.contact.edit', $item->id) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                                        <button type="button" onclick="deleteItem({{ $item->id }})" class="action-btn" style="color:red; background:none; border:none; cursor:pointer;"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 2rem; color: #64748b;">No contacts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Actions Hidden Form -->
    <form id="actionForm" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="_method" id="actionMethod" value="DELETE">
    </form>

    <form id="orderForm" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="order" id="orderInput">
    </form>

    <script>
        function toggleAll(source, className) {
            let checkboxes = document.getElementsByClassName(className);
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function submitBulkDelete(formId, url) {
            if(confirm('Are you sure you want to delete the selected contacts?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'DELETE';
                form.submit();
            }
        }

        function submitBulkToggle(formId, url) {
            if(confirm('Are you sure you want to toggle the status for the selected contacts?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'POST';
                form.submit();
            }
        }

        function toggleStatus(id) {
            const form = document.getElementById('actionForm');
            form.action = "{{ url('admin/contact') }}/" + id + "/toggle-status";
            document.getElementById('actionMethod').value = 'POST';
            form.submit();
        }

        function deleteItem(id) {
            if(confirm('Are you sure you want to delete this contact?')) {
                const form = document.getElementById('actionForm');
                form.action = "{{ url('admin/contact') }}/" + id + "/destroy";
                document.getElementById('actionMethod').value = 'DELETE';
                form.submit();
            }
        }

        function updateOrder(url, val) {
            let form = document.getElementById('orderForm');
            form.action = url;
            document.getElementById('orderInput').value = val;
            form.submit();
        }
    </script>
</div>
@endsection
