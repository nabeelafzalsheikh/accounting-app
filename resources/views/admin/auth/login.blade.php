<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2CA01C;
            --primary-hover: #228B14;
            --light-gray: #F5F5F5;
            --border-color: #E0E0E0;
        }
        
        body {
            background-color: var(--light-gray);
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        
        .login-container {
            max-width: 440px;
            margin: 80px auto;
            padding: 0 15px;
        }
        
        .login-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .login-header {
            background-color: white;
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
        }
        
        .login-header img {
            height: 40px;
            margin-bottom: 16px;
        }
        
        .login-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        
        .login-body {
            padding: 32px;
            background-color: white;
        }
        
        .form-control {
            height: 48px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            padding: 12px 16px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(44, 160, 28, 0.2);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            height: 48px;
            font-weight: 600;
            border-radius: 4px;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .forgot-password {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        
        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #666;
        }
        
        .footer-links a {
            color: #666;
            text-decoration: none;
            margin: 0 8px;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <!-- Replace with your logo -->
                <img src="https://via.placeholder.com/150x40?text=Your+Logo" alt="Company Logo">
                <h1>Admin Portal</h1>
            </div>
            
            <div class="login-body">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            Invalid email or password. Please try again.
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label">Password</label>
                            <a href="#" class="forgot-password">Forgot password?</a>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-3">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
        
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Contact Support</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>