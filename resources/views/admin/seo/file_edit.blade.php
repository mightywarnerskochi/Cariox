@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">{{ $title }}</h2>
        <a href="{{ $backUrl }}" class="action-btn"><i class="fas fa-arrow-left"></i> Back</a>
    </div>

    <div style="background-color: #fef3c7; color: #92400e; padding: 1rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; line-height: 1.5;">
        <strong>Note:</strong> {{ $note }}
    </div>

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="section-container">
        <div class="section-header">{{ $fileName }}</div>
        <div class="section-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="28" spellcheck="false"
                        style="font-family: Consolas, Monaco, monospace; font-size: 0.85rem; white-space: pre; overflow-x: auto;">{{ old('content', $content) }}</textarea>
                </div>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save {{ $fileName }}</button>
            </form>
        </div>
    </div>
</div>
@stop
