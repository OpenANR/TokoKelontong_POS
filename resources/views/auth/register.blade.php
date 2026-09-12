@extends('layouts.auth')

@section('title', 'Register')
@section('brand-subtitle', 'Create your adminHMD account.')

@section('content')
<form class="needs-validation" method="POST" action="{{ route('register.post') }}">
    @csrf

    <div class="mb-4">
        <p class="eyebrow mb-1">Secure Access</p>
        <h1 class="h3 mb-1">Register</h1>
        <p class="text-muted mb-0">Create your adminHMD account.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 mb-3" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li><small>{{ $error }}</small></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label" for="registerName">Full name</label>
        <input class="form-control @error('name') is-invalid @enderror" id="registerName" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @else
            <div class="invalid-feedback">Full name is required.</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="registerEmail">Email address</label>
        <input class="form-control @error('email') is-invalid @enderror" id="registerEmail" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @else
            <div class="invalid-feedback">Enter a valid email.</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="registerPassword">Password</label>
        <input class="form-control @error('password') is-invalid @enderror" id="registerPassword" type="password" name="password" minlength="6" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @else
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="registerPasswordConfirm">Confirm Password</label>
        <input class="form-control" id="registerPasswordConfirm" type="password" name="password_confirmation" minlength="6" required>
    </div>

    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="terms" required checked>
        <label class="form-check-label" for="terms">I agree to the terms</label>
    </div>

    <button class="btn btn-primary w-100" type="submit">
        <i class="bi bi-person-plus" aria-hidden="true"></i> Create Account
    </button>
</form>
@endsection

@section('footer')
<div class="auth-footer">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
@endsection
