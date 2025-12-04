@extends('layouts.app')

@section('title', 'Login - KitKeeper')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    body {
        background: linear-gradient(135deg, #0d3b66 0%, #1e5a96 50%, #4a9dd6 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        max-width: 450px;
        width: 100%;
        padding: 40px;
        margin: 20px;
    }
    .logo-section {
        text-align: center;
        margin-bottom: 30px;
    }
    .logo-section h2 {
        color: #1e5a96;
        font-weight: bold;
        margin-top: 15px;
    }
    .logo-section p {
        color: #666;
    }
    .form-control:focus {
        border-color: #1e5a96;
        box-shadow: 0 0 0 0.2rem rgba(30, 90, 150, 0.25);
    }
    .btn-primary {
        background: #1e5a96;
        border: none;
        padding: 12px;
        font-size: 1.1rem;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background: #0d3b66;
        transform: translateY(-2px);
    }
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }
    .input-wrapper {
        position: relative;
    }
    .input-wrapper input {
        padding-left: 45px;
    }
</style>
@endsection

@section('content')
<div class="login-card">
    <div class="logo-section">
        <i class="fas fa-box fa-3x" style="color: #1e5a96;"></i>
        <h2>KitKeeper</h2>
        <p class="text-muted">WEB PORTAL</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3 input-wrapper">
            <i class="fas fa-user input-icon"></i>
            <input type="text" name="id_or_email" class="form-control" placeholder="ID Number or Email" value="{{ old('id_or_email') }}" required>
        </div>

        <div class="mb-3 input-wrapper">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">
                Remember Me
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('register') }}" class="d-block mb-2 text-decoration-none">Register</a>
        <a href="/" class="text-muted text-decoration-none">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
</div>
@endsection