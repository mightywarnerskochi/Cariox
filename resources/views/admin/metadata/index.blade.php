@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Metadata / SEO</h2>
    </div>

    <div style="background-color: #e0f2fe; color: #0369a1; padding: 1rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; line-height: 1.5;">
        <strong>About this section:</strong> Manage meta title, description, and Open Graph data for each page. Used for SEO and social sharing. Meta title recommended max: 60 characters. Meta description recommended max: 160 characters.
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="section-container">
        <div class="section-body" style="padding: 0;">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Page Name</th>
                        <th>Slug</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td><strong>{{ $page['name'] }}</strong></td>
                            <td><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">{{ $page['slug'] }}</code></td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.metadata.edit', $page['slug']) }}" class="action-btn" title="Edit Metadata">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
