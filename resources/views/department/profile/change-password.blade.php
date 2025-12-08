@extends('department.layouts.app')

@section('title', 'Change Password')

@section('content')
<a href="{{ route('department.profile.show') }}" class="btn btn-outline-primary mb-3">
    <i class="fas fa-arrow-left"></i> Back to Profile
</a>

<div class="mb-4">
    <h4>Change Password</h4>
    <p class="text-muted">Update your account password</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Change Your Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('department.profile.change-password.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" minlength="6" required>
                        <small class="text-muted">Must be at least 6 characters</small>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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