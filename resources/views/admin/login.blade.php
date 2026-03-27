<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Cariox</title>
    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $faviconUrl = $siteSettings && $siteSettings->favicon 
            ? Storage::url($siteSettings->favicon) 
            : asset('favicon.ico');
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4b2382; /* Deep purple matching design outline */
            --primary-hover: #3b186b;
            --bg-color: #f9f9fb; /* Very light background */
            --card-bg: #ffffff;
            --text-main: #000000; /* Dark text */
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --error-color: #ef4444;
            --gradient-start: #4b2382;
            --gradient-end: #ef4444; /* Reddish orange */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Light gradient background inspired by the design */
            background-image: radial-gradient(circle at top right, rgba(239, 68, 68, 0.05), transparent 40%),
                              radial-gradient(circle at bottom left, rgba(75, 35, 130, 0.1), transparent 40%);
        }

        .login-container {
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: 1.5rem; /* Smoother corner */
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px -15px rgba(75, 35, 130, 0.15); /* Tinted shadow */
            border: 1px solid rgba(75,35,130, 0.05); /* Very faint purple border */
            animation: slideUp 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            /* Gradient corresponding to the border lines in the design */
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: var(--primary-color);
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-main);
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(75, 35, 130, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input {
            margin-right: 0.5rem;
            width: 1rem;
            height: 1rem;
            accent-color: var(--primary-color);
        }

        .checkbox-group label {
            font-size: 0.875rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1>Admin Portal</h1>
            <p>Welcome back! Please sign in to continue.</p>
        </div>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="name@company.com">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" class="form-control" style="padding-right: 2.5rem;" required placeholder="••••••••">
                    <button type="button" id="togglePassword" title="Show Password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); display: flex; align-items: center; justify-content: center; width: 24px; height: 24px;">
                        <i class="far fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="checkbox-group">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                        togglePassword.setAttribute('title', 'Hide Password');
                    } else {
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                        togglePassword.setAttribute('title', 'Show Password');
                    }
                });
            }
        });
    </script>
</body>
</html>
