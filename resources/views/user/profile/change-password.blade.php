@extends('layouts.user')

@section('title', 'Change Password')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.profile.show') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Profile
    </a>
    <h4>Change Password</h4>
    <p class="text-muted">Update your account password</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Change Your Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.change-password.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" minlength="6" required>
                        <small class="text-muted">Must be at least 6 characters</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" minlength="6" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3">Password Security Tips</h6>
                <ul class="text-muted small mb-0">
                    <li>Use at least 6 characters</li>
                    <li>Include a mix of letters and numbers</li>
                    <li>Don't use easily guessed passwords</li>
                    <li>Don't share your password with anyone</li>
                    <li>Change your password regularly</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection