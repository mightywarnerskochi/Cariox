@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">URL Redirects</h2>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.not_found.index') }}" class="action-btn"><i class="far fa-file-alt"></i> 404 log</a>
            <a href="{{ route('admin.sitemap.index') }}" class="action-btn"><i class="fas fa-arrow-left"></i> Sitemap</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background-color: #e0f2fe; color: #0369a1; padding: 1rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; line-height: 1.5;">
        <strong>How it works:</strong> Visitors and search engines opening an old URL are sent to the new one.
        Use <strong>301</strong> for pages that moved permanently (passes SEO value) and <strong>302</strong> for temporary moves.
        Enter the old URL as a path like <code>/old-page</code> or paste the full link.
    </div>

    <div class="section-container">
        <div class="section-header">Add Redirect</div>
        <div class="section-body">
            @include('admin.sitemap.redirects._form', [
                'action' => route('admin.redirects.store'),
                'method' => 'POST',
                'redirect' => null,
                'prefillFrom' => $prefillFrom,
                'submitLabel' => 'Add Redirect',
            ])
        </div>
    </div>

    <div class="section-container">
        <div class="section-header">Existing Redirects ({{ $redirects->count() }})</div>
        <div class="section-body" style="padding: 0; overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Old URL</th>
                        <th>Redirects To</th>
                        <th>Type</th>
                        <th>Hits</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($redirects as $redirect)
                        <tr>
                            <td><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem; word-break: break-all;">{{ $redirect->from_path }}</code></td>
                            <td style="word-break: break-all;">
                                <a href="{{ \Illuminate\Support\Str::startsWith($redirect->to_url, ['http://', 'https://']) ? $redirect->to_url : url($redirect->to_url) }}" target="_blank" rel="noopener">{{ $redirect->to_url }}</a>
                            </td>
                            <td><span style="background: {{ $redirect->status_code == 301 ? '#eef2ff' : '#fef3c7' }}; color: {{ $redirect->status_code == 301 ? '#4338ca' : '#92400e' }}; padding: 2px 10px; border-radius: 999px; font-size: 0.8rem; font-weight: 600;">{{ $redirect->status_code }}</span></td>
                            <td>
                                {{ $redirect->hits }}
                                @if($redirect->last_hit_at)
                                    <div style="color: #94a3b8; font-size: 0.75rem;">{{ $redirect->last_hit_at->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.redirects.toggleStatus', $redirect->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <label class="switch">
                                        <input type="checkbox" onchange="this.form.submit()" {{ $redirect->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </form>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('admin.redirects.edit', $redirect->id) }}" class="action-btn" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.redirects.destroy', $redirect->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this redirect?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="color: #ef4444;" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 3rem; color: #64748b;">No redirects yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
