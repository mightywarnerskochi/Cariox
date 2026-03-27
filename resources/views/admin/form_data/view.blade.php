@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Form Data Details</h2>
        <a href="{{ route('admin.form_data.index') }}" class="btn-update" style="text-decoration: none;">Back to List</a>
    </div>

    <div class="section-container">
        <div class="section-header">Basic Information</div>
        <div class="section-body">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                <div class="form-group">
                    <label style="color: #64748b;">Full Name</label>
                    <div style="font-size: 1rem; font-weight: 600; padding: 0.5rem; background: #f8fafc; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                        {{ $data->name ?: 'Not Provided' }}
                    </div>
                </div>
                <div class="form-group">
                    <label style="color: #64748b;">Email Address</label>
                    <div style="font-size: 1rem; font-weight: 600; padding: 0.5rem; background: #f8fafc; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                        {{ $data->email ?: 'Not Provided' }}
                    </div>
                </div>
                <div class="form-group">
                    <label style="color: #64748b;">Phone Number</label>
                    <div style="font-size: 1rem; font-weight: 600; padding: 0.5rem; background: #f8fafc; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                        {{ $data->phone ?: 'Not Provided' }}
                    </div>
                </div>
                <div class="form-group">
                    <label style="color: #64748b;">Company Name</label>
                    <div style="font-size: 1rem; font-weight: 600; padding: 0.5rem; background: #f8fafc; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                        {{ $data->company ?: 'Not Provided' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-container">
        <div class="section-header">Inquiry Details</div>
        <div class="section-body">
            <div class="form-group">
                <label style="color: #64748b;">Interested Product/Service</label>
                <div style="font-size: 1rem; font-weight: 600; padding: 0.5rem; background: #f8fafc; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                    {{ $data->product_name ?: 'General Enquiry' }}
                </div>
            </div>
            <div class="form-group" style="margin-top: 1.5rem;">
                <label style="color: #64748b;">Customer Message</label>
                <div style="font-size: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.375rem; border: 1px solid #e2e8f0; line-height: 1.6; min-height: 100px;">
                    {!! nl2br(e($data->message ?: 'No message provided.')) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="section-container">
        <div class="section-header">Traffic & Source Details</div>
        <div class="section-body">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                <div class="form-group">
                    <label style="color: #64748b;">Page Source</label>
                    <div style="font-size: 0.95rem; font-weight: 600; padding: 0.5rem; background: #f1f5f9; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                        {{ $data->page_source ?: 'Direct' }}
                    </div>
                </div>
                <div class="form-group">
                    <label style="color: #64748b;">Submitted At</label>
                    <div style="font-size: 0.95rem; font-weight: 600; padding: 0.5rem; background: #f1f5f9; border-radius: 0.375rem; border: 1px solid #e2e8f0;">
                        {{ $data->created_at->format('M d, Y - h:i A') }}
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top: 1.5rem;">
                <label style="color: #64748b;">Page URL</label>
                <div style="font-size: 0.9rem; padding: 0.5rem; background: #f1f5f9; border-radius: 0.375rem; border: 1px solid #e2e8f0; word-break: break-all;">
                    @if($data->page_url)
                        <a href="{{ $data->page_url }}" target="_blank" style="color: #2563eb; text-decoration: none;">{{ $data->page_url }} <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i></a>
                    @else
                        Not Tracked
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 3rem; text-align: right;">
        <form action="{{ route('admin.form_data.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-update" style="color: #ef4444; border-color: #ef4444; background: transparent; padding: 0.75rem 2rem;">
                <i class="fas fa-trash"></i> Delete This Record
            </button>
        </form>
    </div>
</div>
@stop
