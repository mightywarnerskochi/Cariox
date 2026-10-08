@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">404 Log</h2>
        <div style="display: flex; gap: 0.5rem;">
            @if($logs->total())
                <form action="{{ route('admin.not_found.clear') }}" method="POST" style="margin: 0;" onsubmit="return confirm('Clear the entire 404 log?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i> Clear log</button>
                </form>
            @endif
            <a href="{{ route('admin.redirects.index') }}" class="action-btn"><i class="fas fa-exchange-alt"></i> URL redirects</a>
            <a href="{{ route('admin.sitemap.index') }}" class="action-btn"><i class="fas fa-arrow-left"></i> Sitemap</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background-color: #e0f2fe; color: #0369a1; padding: 1rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; line-height: 1.5;">
        <strong>About this log:</strong> Website URLs that returned "page not found" are recorded here, most recent first.
        Use <strong>Redirect</strong> to send a broken URL to a working page; the entry is removed once the redirect is added.
        Missing images, scripts and admin URLs are not logged.
    </div>

    <div class="section-container">
        <div class="section-header">Broken URLs ({{ $logs->total() }})</div>
        <div class="section-body" style="padding: 0; overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>URL</th>
                        <th>Hits</th>
                        <th>Last Seen</th>
                        <th>Referrer</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem; word-break: break-all;">{{ $log->path }}</code></td>
                            <td><strong>{{ $log->hits }}</strong></td>
                            <td style="white-space: nowrap;" title="{{ $log->last_seen_at?->format('d M Y, h:i A') }}">{{ $log->last_seen_at?->diffForHumans() ?? '—' }}</td>
                            <td style="max-width: 260px; word-break: break-all; font-size: 0.85rem; color: #64748b;">{{ $log->referer ?: 'Direct / unknown' }}</td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('admin.redirects.index', ['from' => $log->path]) }}" class="action-btn" title="Create a redirect for this URL"><i class="fas fa-exchange-alt"></i> Redirect</a>
                                <form action="{{ route('admin.not_found.destroy', $log->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="color: #ef4444;" title="Remove"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;">No 404 errors recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($logs->hasPages())
        <div style="display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 0.9rem;">
            <span>Page {{ $logs->currentPage() }} of {{ $logs->lastPage() }}</span>
            <div style="display: flex; gap: 0.5rem;">
                @if(!$logs->onFirstPage())
                    <a href="{{ $logs->previousPageUrl() }}" class="action-btn"><i class="fas fa-chevron-left"></i> Previous</a>
                @endif
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="action-btn">Next <i class="fas fa-chevron-right"></i></a>
                @endif
            </div>
        </div>
    @endif
</div>
@stop
