@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Header Links</h2>
        @php $hasActive = $links->contains('status', 1); @endphp
        <a href="{{ $hasActive ? 'javascript:void(0)' : route('admin.settings.header_links.create') }}" 
           class="btn-add" 
           style="text-decoration: none; {{ $hasActive ? 'background: #94a3b8; cursor: not-allowed; pointer-events: none;' : '' }}" 
           title="{{ $hasActive ? 'Deactivate current link to add a new one' : 'Add New Link' }}">
           + Add New Link
        </a>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Policy Note -->
    <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <i class="fas fa-info-circle" style="font-size: 1.1rem;"></i>
        <p style="margin: 0; font-weight: 500;"><strong>Note:</strong> Only one header link can be active at a time. Inactivate the active link to add a new one.</p>
    </div>

    <div class="section-container">
        <div class="section-body" style="padding: 0;">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th style="width: 80px;">Order</th>
                        <th>Title</th>
                        <th>Link / URL</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $link)
                        <tr>
                            <td>
                                <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 6px; font-weight: 600;">{{ $link->order }}</span>
                            </td>
                            <td><strong>{{ $link->title }}</strong></td>
                            <td><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">{{ $link->link }}</code></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" onchange="toggleStatus({{ $link->id }})" {{ $link->status ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.settings.header_links.edit', $link->id) }}" class="action-btn" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.settings.header_links.destroy', $link->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="color: #ef4444;" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;">No header links found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script>
    function toggleStatus(id) {
        fetch('{{ route("admin.settings.header_links.toggleStatus") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

<style>
/* Simple Toggle Switch Styling */
.switch { position: relative; display: inline-block; width: 44px; height: 22px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px; }
.slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
input:checked + .slider { background-color: #2563eb; }
input:checked + .slider:before { transform: translateX(22px); }
</style>
@endpush
