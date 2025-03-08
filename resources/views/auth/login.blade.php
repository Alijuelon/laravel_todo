@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-lg" style="width: 100%; max-width: 400px;">
        <div class="card-header text-center bg-primary text-white py-4 rounded-top">
            <i class="fas fa-user-circle fa-3x mb-2"></i>
            <h4 class="mb-0">{{ __('Login') }}</h4>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label text-muted">
                        <i class="fas fa-envelope me-2"></i>{{ __('Email Address') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-at"></i>
                        </span>
                        <input id="email" type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" 
                            required autocomplete="email" autofocus
                            placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-muted">
                        <i class="fas fa-lock me-2"></i>{{ __('Password') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-key"></i>
                        </span>
                        <input id="password" type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="current-password"
                            placeholder="Enter your password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" 
                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember">
                        <i class="fas fa-clock me-2"></i>{{ __('Remember Me') }}
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-bold">
                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                    </button>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                            class="btn btn-link text-decoration-none">
                            <i class="fas fa-key me-2"></i>{{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">Don't have an account? 
                        <a href="{{ route('register') }}" class="text-primary text-decoration-none">
                            Register here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
@endsection