@if(session('success'))
    <div class="alert alert-success" style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; border-left: 4px solid #10b981;">
        <i class="fas fa-check-circle" style="margin-right: 0.75rem; font-size: 1.25rem;"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error" style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; border-left: 4px solid #ef4444;">
        <i class="fas fa-exclamation-circle" style="margin-right: 0.75rem; font-size: 1.25rem;"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error" style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border-left: 4px solid #ef4444;">
        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
            <i class="fas fa-exclamation-triangle" style="margin-right: 0.75rem; font-size: 1.25rem;"></i>
            <strong style="font-weight: 600;">Please check the following errors:</strong>
        </div>
        <ul style="margin: 0; padding-left: 2rem; font-size: 0.9rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
