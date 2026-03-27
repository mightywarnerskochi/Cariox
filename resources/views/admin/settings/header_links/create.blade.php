@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin: 0;">Add Header Link</h2>
        <a href="{{ route('admin.settings.header_links.index') }}" class="btn-update" style="text-decoration: none;">Back to List</a>
    </div>

    @if($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="section-container">
        <div class="section-body">
            <form action="{{ route('admin.settings.header_links.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label>Title <span style="color:red">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Services, About Us" required>
                    </div>
                    <div class="form-group">
                        <label>Link / URL <span style="color:red">*</span></label>
                        <input type="text" name="link" class="form-control" placeholder="e.g. #services, /contact" required>
                    </div>
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>
                    <div class="form-group">
                        <label>Initial Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <button type="submit" class="btn-update" style="padding: 0.75rem 2.5rem; background: #2563eb; color: white; border-color: #2563eb;">Create Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
