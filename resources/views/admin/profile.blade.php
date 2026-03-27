@extends('admin.layouts.app')

@section('content')
<div class="dashboard-content">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; margin-bottom: 2rem;">
        <h1 class="page-title" style="margin: 0; font-size: 1.5rem;">Profile</h1>
        <div style="color: #64748b; font-size: 0.875rem;">
            <a href="{{ route('admin.dashboard') }}" style="color: #ef4444; text-decoration: none;">Home</a> / Profile
        </div>
    </div>

    <div class="section-container" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Informations -->
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; color: #475569; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; font-weight: 500;">Basic Informations</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="name">Name*</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required>
                        @error('name') <span class="error-text d-block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="email">Email*</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                        @error('email') <span class="error-text d-block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Profile Image & Phone Number -->
            <div style="margin-bottom: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Left: Profile Image -->
                    <div>
                        <h3 style="font-size: 1.1rem; color: #475569; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; font-weight: 500;">Profile Image</h3>
                        <div class="form-group" style="margin-bottom: 0;">
                            <div style="display: flex; gap: 0rem; flex-direction: column;">
                                <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*" onchange="previewImage(event)" style="padding: 0.4rem 0.5rem;">
                            </div>
                            <small style="color: #64748b; margin-top: 0.5rem; display: block;">Note: Image size must be 300 x 300</small>
                            @if($admin->profile_image)
                                <img id="img-preview" src="{{ Storage::url($admin->profile_image) }}" alt="Preview" style="margin-top: 1rem; max-height: 80px; border-radius: 0.25rem; border: 1px solid #e2e8f0; padding: 2px;">
                            @else
                                <img id="img-preview" src="#" alt="Preview" style="display: none; margin-top: 1rem; max-height: 80px; border-radius: 0.25rem; border: 1px solid #e2e8f0; padding: 2px;">
                            @endif
                            @error('profile_image') <span class="error-text d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Right: Contact Details -->
                    <div>
                        <h3 style="font-size: 1.1rem; color: #475569; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; font-weight: 500;">Phone Number*</h3>
                        <div class="form-group" style="margin-bottom: 0;">
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $admin->phone) }}" required>
                            @error('phone') <span class="error-text d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authentication Credentials -->
            <div style="margin-bottom: 2.5rem;">
                <h3 style="font-size: 1.1rem; color: #475569; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; font-weight: 500;">Authentication Credentials</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="username">Username*</label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $admin->username) }}" required>
                        @error('username') <span class="error-text d-block">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="password">Password</label>
                        <div style="display: flex; align-items: stretch;">
                            <input type="password" name="password" id="password" class="form-control" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" placeholder="Password">
                            <button type="button" onclick="togglePassword()" style="background: #e2e8f0; border: 1px solid #cbd5e1; border-left: none; padding: 0 1rem; border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem; cursor: pointer;">
                                <i class="fas fa-sync-alt" id="toggle-icon"></i>
                            </button>
                        </div>
                        @error('password') <span class="error-text d-block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 0.25rem; font-weight: 600; cursor: pointer;">Submit</button>
                <a href="{{ route('admin.dashboard') }}" style="background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; padding: 0.4rem 1.5rem; border-radius: 0.25rem; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('img-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    
    function togglePassword() {
        var input = document.getElementById('password');
        var icon = document.getElementById('toggle-icon');
        // Simple toggle just to refresh or show/hide password, standard is eye icon but the design has a sync/refresh icon
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
</script>
@endsection
