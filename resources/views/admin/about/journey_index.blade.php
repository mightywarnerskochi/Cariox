@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Journey Management</h2>
        <a href="{{ route('admin.journey.create') }}" class="btn-add">Add Journey Record</a>
    </div>

    <!-- Main Content Table -->
    <div class="section-container">
        <div class="section-header">Journey Records List</div>
        <div class="section-body">
            <form action="{{ route('admin.journey.bulkDelete') }}" method="POST" id="bulkActionForm">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                    <button type="submit" onclick="return confirm('Delete selected records?')" class="btn-update" style="background: #ef4444; border-color: #ef4444; color: white;">Bulk Delete</button>
                    <button type="submit" formaction="{{ route('admin.journey.bulkToggleStatus') }}" formmethod="POST" class="btn-update" style="background: #64748b; border-color: #64748b; color: white;">Bulk Toggle Status</button>
                </div>

                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                            <th style="width: 80px;">Order</th>
                            <th style="width: 100px;">Year</th>
                            <th style="width: 150px;">Caption</th>
                            <th style="width: 100px;">Image</th>
                            <th>Description</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journeys as $journey)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $journey->id }}" class="item-checkbox"></td>
                                <td>
                                    <select class="form-control" style="width: 60px;" onchange="updateOrder('{{ route('admin.journey.update', $journey->id) }}', this.value)">
                                        @for($i = 1; $i <= $journeys->count(); $i++)
                                            <option value="{{ $i }}" {{ $journey->order == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td><strong>{{ $journey->year }}</strong></td>
                                <td>{{ $journey->caption }}</td>
                                <td>
                                    @if($journey->image)
                                        <img src="{{ Storage::url($journey->image) }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ strip_tags($journey->description) }}</td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.journey.toggleStatus', $journey->id) }}')" {{ $journey->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{{ route('admin.journey.edit', $journey->id) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                                    <button type="button" onclick="confirmDelete('{{ route('admin.journey.destroy', $journey->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No journey records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<form id="actionForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@stop

@push('scripts')
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
    });

    function toggleStatus(url) {
        let form = document.getElementById('actionForm');
        form.action = url;
        form.submit();
    }

    function updateOrder(url, order) {
        let form = document.getElementById('actionForm');
        form.action = url;
        form.innerHTML = '@csrf @method("PUT")';
        form.innerHTML += `<input type="hidden" name="order" value="${order}">`;
        form.submit();
    }

    function confirmDelete(url) {
        if(confirm('Are you sure you want to delete this journey record?')) {
            let form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    }
</script>
@endpush
