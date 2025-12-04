@extends('layouts.app')

@section('title', 'Register - KitKeeper')

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
    .register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        max-width: 600px;
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
        margin-bottom: 0;
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
</style>
@endsection

@section('content')
<div class="register-card">
    <div class="logo-section">
        <i class="fas fa-box fa-3x" style="color: #1e5a96;"></i>
        <h2>KitKeeper</h2>
        <p class="text-muted">Create Your Account</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">ID Number</label>
            <input type="text" name="id_number" class="form-control" placeholder="e.g., 22222222" value="{{ old('id_number') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="your.email@example.com" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department" class="form-select" required>
                <option value="">Select Department</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Engineering">Engineering</option>
                <option value="Business Administration">Business Administration</option>
                <option value="Education">Education</option>
                <option value="Arts and Sciences">Arts and Sciences</option>
                <option value="Medical Technology">Medical Technology</option>
                <option value="Nursing">Nursing</option>
                <option value="Architecture">Architecture</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" minlength="6" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" minlength="6" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-user-plus"></i> Register
        </button>
    </form>

    <div class="text-center">
        <p class="mb-2">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Login</a></p>
        <a href="/" class="text-muted text-decoration-none">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
</div>
@endsection