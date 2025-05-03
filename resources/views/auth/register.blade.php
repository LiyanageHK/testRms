@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register') }}" id="registerForm">
    @csrf
    
    <!-- Name Input -->
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   placeholder="Full Name" name="name" value="{{ old('name') }}" 
                   required autocomplete="name" autofocus>
            <span class="input-group-text">
                <i class="fas fa-user"></i>
            </span>
        </div>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    
    <!-- Email Input -->
    <div class="form-group">
        <div class="input-group">
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   placeholder="Email Address" name="email" value="{{ old('email') }}" 
                   required autocomplete="email">
            <span class="input-group-text">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    
    <!-- Password Input -->
    <div class="form-group">
        <div class="input-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Password" name="password" required autocomplete="new-password"
                   id="password">
            <span class="input-group-text">
                <i class="fas fa-lock"></i>
            </span>
        </div>
        <div class="password-strength mt-2">
            <div class="progress" style="height: 5px;">
                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
            <small class="text-muted password-strength-text">Password strength</small>
        </div>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    
    <!-- Confirm Password Input -->
    <div class="form-group">
        <div class="input-group">
            <input type="password" class="form-control" 
                   placeholder="Confirm Password" name="password_confirmation" 
                   required autocomplete="new-password" id="password_confirmation">
            <span class="input-group-text">
                <i class="fas fa-lock"></i>
            </span>
        </div>
        <div class="password-match mt-2">
            <small class="text-muted password-match-text"></small>
        </div>
    </div>
    
    <!-- Terms and Conditions -->
    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="terms" required>
            <label class="custom-control-label" for="terms">
                I agree to the <a href="#" class="text-primary">Terms and Conditions</a>
            </label>
        </div>
    </div>
    
    <!-- Register Button -->
    <div class="form-group">
        <button type="submit" class="btn btn-secondary btn-block register-btn" 
                style="background-color: #E7592B; border-color: #E7592B;">
            <span class="btn-text">Register</span>
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
    </div>
    
    <!-- Divider -->
    <div class="divider">OR</div>
    
    <!-- Login Link -->
    <div class="form-group">
        <a href="{{ route('login') }}" class="btn btn-secondary">
            Already have an account? Login
        </a>
    </div>
</form>

<style>
    .password-strength {
        transition: all 0.3s ease;
    }
    
    .progress-bar {
        transition: width 0.3s ease;
    }
    
    .register-btn {
        position: relative;
        overflow: hidden;
    }
    
    .register-btn .spinner-border {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .custom-control-label {
        cursor: pointer;
    }
    
    .custom-control-label a {
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .custom-control-label a:hover {
        color: #E7592B !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const strengthBar = document.querySelector('.progress-bar');
    const strengthText = document.querySelector('.password-strength-text');
    const matchText = document.querySelector('.password-match-text');
    const registerBtn = document.querySelector('.register-btn');
    const btnText = document.querySelector('.btn-text');
    const spinner = document.querySelector('.spinner-border');
    
    // Password strength indicator
    password.addEventListener('input', function() {
        const value = this.value;
        let strength = 0;
        
        if (value.length >= 8) strength += 25;
        if (value.match(/[a-z]/)) strength += 25;
        if (value.match(/[A-Z]/)) strength += 25;
        if (value.match(/[0-9]/)) strength += 25;
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 25) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Very Weak';
        } else if (strength < 50) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Weak';
        } else if (strength < 75) {
            strengthBar.className = 'progress-bar bg-info';
            strengthText.textContent = 'Medium';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Strong';
        }
    });
    
    // Password match indicator
    confirmPassword.addEventListener('input', function() {
        if (this.value === password.value) {
            matchText.textContent = 'Passwords match';
            matchText.className = 'text-success';
        } else {
            matchText.textContent = 'Passwords do not match';
            matchText.className = 'text-danger';
        }
    });
    
    // Form submission animation
    document.getElementById('registerForm').addEventListener('submit', function() {
        registerBtn.disabled = true;
        btnText.classList.add('d-none');
        spinner.classList.remove('d-none');
    });
});
</script>
@endsection
