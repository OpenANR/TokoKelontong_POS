@extends('layouts.auth')

@section('title', 'Login')
@section('brand-subtitle', 'Sign in to your admin workspace.')

@section('content')
<form class="needs-validation" method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="mb-4">
        <p class="eyebrow mb-1">Secure Access</p>
        <h1 class="h3 mb-1">Login</h1>
        <p class="text-muted mb-0">Sign in to your admin workspace.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-danger py-2 mb-3" role="alert">
            <small>{{ session('error') }}</small>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success py-2 mb-3" role="alert">
            <small>{{ session('success') }}</small>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label" for="loginEmail">Email address</label>
        <input class="form-control @error('email') is-invalid @enderror" id="loginEmail" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @else
            <div class="invalid-feedback">Enter a valid email.</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="loginPassword">Password</label>
            <a class="small fw-semibold" href="{{ route('password.request') }}">Forgot?</a>
        </div>
        <input class="form-control @error('password') is-invalid @enderror" id="loginPassword" type="password" name="password" minlength="6" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @else
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
        @enderror
    </div>

    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
        <label class="form-check-label" for="rememberMe">Remember me</label>
    </div>

    <button class="btn btn-primary w-100" type="submit">
        <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Sign In
    </button>
</form>
@endsection

@section('footer')
<div class="auth-footer">New here? <a href="{{ route('register') }}">Create an account</a></div>
@endsection
