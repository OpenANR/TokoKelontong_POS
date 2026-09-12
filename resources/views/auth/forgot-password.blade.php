@extends('layouts.auth')

@section('title', 'Forgot Password')
@section('brand-subtitle', 'Get a reset link for your account.')

@section('content')
<form class="needs-validation" method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-4">
        <p class="eyebrow mb-1">Secure Access</p>
        <h1 class="h3 mb-1">Forgot Password</h1>
        <p class="text-muted mb-0">Get a reset link for your account.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 mb-3" role="alert">
            <small>{{ session('status') }}</small>
        </div>
    @endif

    <div class="mb-4">
        <label class="form-label" for="forgotEmail">Email address</label>
        <input class="form-control @error('email') is-invalid @enderror" id="forgotEmail" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @else
            <div class="invalid-feedback">Enter a valid email.</div>
        @enderror
    </div>

    <button class="btn btn-primary w-100" type="submit">
        <i class="bi bi-envelope-arrow-up" aria-hidden="true"></i> Send Reset Link
    </button>
</form>
<p class="text-muted small mt-3 mb-0">Check your inbox and spam folder after submitting.</p>
@endsection

@section('footer')
<div class="auth-footer">Remembered it? <a href="{{ route('login') }}">Back to login</a></div>
@endsection
