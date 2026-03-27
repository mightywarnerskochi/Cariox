@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Metadata: {{ ucfirst($page_name) }}</h2>
        <a href="{{ route('admin.metadata.index') }}" class="btn-update" style="text-decoration: none;">Back to list</a>
    </div>

    @if($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0;">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="section-container">
        <div class="section-body">
            <div style="background-color: #e0f2fe; color: #0369a1; padding: 1rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; line-height: 1.5;">
                <strong>About this section:</strong> Manage meta title, description, and Open Graph data for each page. Used for SEO and social sharing. Meta title recommended max: 60 characters. Meta description recommended max: 160 characters.
            </div>
            <form action="{{ route('admin.metadata.update', $page_name) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Canonical URL</label>
                    <input type="text" name="canonical_url" class="form-control" value="{{ old('canonical_url', $metadata->canonical_url) }}" placeholder="https://example.com/page">
                    <small style="color: #64748b;">Optional. Full URL of the preferred version of this page for search engines.</small>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Meta Title (recommended max 60 characters)</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $metadata->meta_title) }}" id="meta_title" maxlength="60">
                    <small id="title_counter" style="color: #64748b;">0/60</small>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Meta Description (recommended max 160 characters)</label>
                    <textarea name="meta_description" class="form-control" rows="3" id="meta_description" maxlength="160">{{ old('meta_description', $metadata->meta_description) }}</textarea>
                    <small id="desc_counter" style="color: #64748b;">0/160</small>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Meta Keywords (comma separated)</label>
                    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $metadata->meta_keywords) }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Other Meta Tags (HTML)</label>
                    <textarea name="other_meta" class="form-control" rows="3" placeholder="Paste any other meta tags here, e.g. <meta name='robots' content='noindex'>">{{ old('other_meta', $metadata->other_meta) }}</textarea>
                </div>

                <div style="margin: 2.5rem 0 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e2e8f0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0;">Open Graph (social sharing)</h3>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">OG Title</label>
                        <input type="text" name="og_title" class="form-control" value="{{ old('og_title', $metadata->og_title) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">OG Description</label>
                    <textarea name="og_description" class="form-control" rows="3">{{ old('og_description', $metadata->og_description) }}</textarea>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">OG Image</label>
                    <div style="background-color: #e0f2fe; color: #0369a1; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                        <strong>OG Image requirements:</strong> Max size 512 KB. Recommended dimensions 1200×630 pixels (or similar aspect ratio).
                    </div>
                    
                    @if($metadata->og_image)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ $metadata->og_image_url }}" alt="OG Image" style="max-width: 200px; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                        </div>
                    @endif
                    
                    <input type="file" name="og_image" class="form-control">
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <button type="submit" class="btn-update" style="padding: 0.75rem 2.5rem; background: #2563eb; color: white; border-color: #2563eb;">Update</button>
                    <a href="{{ route('admin.metadata.index') }}" class="btn-update" style="padding: 0.75rem 2rem; text-decoration: none; border-color: #e2e8f0; color: #64748b; margin-left:1rem;">Back to list</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script>
    const titleInput = document.getElementById('meta_title');
    const titleCounter = document.getElementById('title_counter');
    const descInput = document.getElementById('meta_description');
    const descCounter = document.getElementById('desc_counter');

    function updateCounter(input, counter, max) {
        if (input.value.length > max) {
            input.value = input.value.substring(0, max);
        }
        const length = input.value.length;
        counter.textContent = `${length}/${max}`;
        if (length === max) {
            counter.style.color = '#ef4444';
        } else {
            counter.style.color = '#64748b';
        }
    }

    titleInput.addEventListener('input', () => updateCounter(titleInput, titleCounter, 60));
    titleInput.addEventListener('paste', () => setTimeout(() => updateCounter(titleInput, titleCounter, 60), 0));
    descInput.addEventListener('input', () => updateCounter(descInput, descCounter, 160));
    descInput.addEventListener('paste', () => setTimeout(() => updateCounter(descInput, descCounter, 160), 0));

    // Initial count
    updateCounter(titleInput, titleCounter, 60);
    updateCounter(descInput, descCounter, 160);
</script>
@endpush
