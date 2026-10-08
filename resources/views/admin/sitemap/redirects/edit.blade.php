@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Edit Redirect</h2>
        <a href="{{ route('admin.redirects.index') }}" class="action-btn"><i class="fas fa-arrow-left"></i> Back</a>
    </div>

    <div class="section-container">
        <div class="section-header">Redirect Details</div>
        <div class="section-body">
            @include('admin.sitemap.redirects._form', [
                'action' => route('admin.redirects.update', $redirect->id),
                'method' => 'PUT',
                'redirect' => $redirect,
                'prefillFrom' => null,
                'submitLabel' => 'Update Redirect',
            ])
        </div>
    </div>
</div>
@stop
