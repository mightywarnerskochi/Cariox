@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Newsletter Subscriptions</h2>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.newsletter.export', array_merge(request()->all(), ['type' => 'excel'])) }}" class="btn-update" style="text-decoration: none; padding: 0.5rem 1rem; background: #2563eb; color: white; border-color: #2563eb;">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.newsletter.export', array_merge(request()->all(), ['type' => 'csv'])) }}" class="btn-update" style="text-decoration: none; padding: 0.5rem 1rem; background: #10b981; color: white; border-color: #10b981;">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="section-container" style="margin-bottom: 2rem; background: transparent; border: none; box-shadow: none;">
        <div class="section-body" style="padding: 0;">
            <form action="{{ route('admin.newsletter.index') }}" method="GET" style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: flex-end;">
                <div class="form-group" style="margin: 0; min-width: 200px;">
                    <label style="font-weight: 500; color: #1e293b; margin-bottom: 0.5rem; display: block;">From date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="border-color: #e2e8f0; border-radius: 0.5rem;">
                </div>
                <div class="form-group" style="margin: 0; min-width: 200px;">
                    <label style="font-weight: 500; color: #1e293b; margin-bottom: 0.5rem; display: block;">To date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="border-color: #e2e8f0; border-radius: 0.5rem;">
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-update" style="height: 42px; padding: 0 1.5rem; border-radius: 0.5rem;">Filter</button>
                    <a href="{{ route('admin.newsletter.index') }}" class="btn-update" style="height: 42px; padding: 0 1.5rem; text-decoration: none; border-color: #e2e8f0; color: #64748b; border-radius: 0.5rem; display: flex; align-items: center;">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div style="margin-bottom: 1rem; display: none;" id="bulkActionContainer">
        <button type="button" onclick="bulkDelete()" class="btn-update" style="color: #ef4444; border-color: #ef4444; background: #fef2f2;">
            <i class="fas fa-trash"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>
    </div>

    <!-- Table -->
    <div class="section-container">
        <div class="section-body" style="padding: 0;">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                        <th>Email ID</th>
                        <th>Subscribed At</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td><input type="checkbox" class="data-checkbox" value="{{ $data->id }}" onchange="updateBulkUI()"></td>
                            <td><strong>{{ $data->email }}</strong></td>
                            <td>{{ $data->created_at->format('M d, Y - h:i A') }}</td>
                            <td style="text-align: right;">
                                <button type="button" class="action-btn" style="color: #ef4444;" onclick="confirmSingleDelete('{{ route('admin.newsletter.destroy', $data->id) }}')" title="Remove"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 3rem; color: #64748b;">No newsletter subscriptions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@stop

@push('scripts')
<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.getElementsByClassName('data-checkbox');
    const bulkContainer = document.getElementById('bulkActionContainer');
    const selectedCountSpan = document.getElementById('selectedCount');

    selectAll.addEventListener('change', function() {
        Array.from(checkboxes).forEach(cb => cb.checked = selectAll.checked);
        updateBulkUI();
    });

    function updateBulkUI() {
        const checked = Array.from(checkboxes).filter(cb => cb.checked);
        selectedCountSpan.innerText = checked.length;
        bulkContainer.style.display = checked.length > 0 ? 'block' : 'none';
    }

    function confirmSingleDelete(url) {
        if (confirm('Are you sure you want to remove this subscription?')) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    }

    function bulkDelete() {
        if (!confirm('Are you sure you want to delete the selected subscriptions?')) return;
        
        const ids = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        
        fetch('{{ route("admin.newsletter.bulkDelete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error occurred.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete items.');
        });
    }
</script>
@endpush
