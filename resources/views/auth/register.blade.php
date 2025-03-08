@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-lg" style="width: 100%; max-width: 500px;">
        <div class="card-header text-center bg-primary text-white py-4 rounded-top">
            <i class="fas fa-user-plus fa-3x mb-2"></i>
            <h4 class="mb-0">{{ __('Register') }}</h4>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label text-muted">
                        <i class="fas fa-user me-2"></i>{{ __('Name') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input id="name" type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            name="name" value="{{ old('name') }}" 
                            required autocomplete="name" autofocus
                            placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
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
                            required autocomplete="email"
                            placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-muted">
                        <i class="fas fa-lock me-2"></i>{{ __('Password') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-key"></i>
                        </span>
                        <input id="password" type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="new-password"
                            placeholder="Create password">
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

                <div class="mb-4">
                    <label for="password-confirm" class="form-label text-muted">
                        <i class="fas fa-lock me-2"></i>{{ __('Confirm Password') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-check-double"></i>
                        </span>
                        <input id="password-confirm" type="password" 
                            class="form-control" name="password_confirmation" 
                            required autocomplete="new-password"
                            placeholder="Confirm password">
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-bold">
                        <i class="fas fa-user-plus me-2"></i>{{ __('Register') }}
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account? 
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                            Login here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    const icon = button.querySelector('i');
    
    button.addEventListener('click', function() {
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
}

togglePasswordVisibility('password', 'togglePassword');
togglePasswordVisibility('password-confirm', 'toggleConfirmPassword');
</script>
@endsection