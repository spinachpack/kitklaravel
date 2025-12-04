@extends('layouts.user')

@section('title', 'My Profile')

@section('extra-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .profile-picture-section {
        text-align: center;
        padding: 30px;
    }
    .profile-picture-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid var(--primary-blue);
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <h4>My Profile</h4>
    <p class="text-muted">Manage your profile information and settings</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body profile-picture-section">
                <img src="{{ $user->profile_picture_url }}" class="profile-picture-large mb-3" alt="Profile">
                <h5>{{ $user->full_name }}</h5>
                <p class="text-muted mb-3">{{ $user->id_number }}</p>
                
                <form method="POST" action="{{ route('user.profile.picture') }}" enctype="multipart/form-data" id="pictureForm">
                    @csrf
                    <label for="profilePicture" class="btn btn-outline-primary">
                        <i class="fas fa-camera me-2"></i> Change Picture
                    </label>
                    <input type="file" id="profilePicture" name="profile_picture" accept="image/*" style="display:none" onchange="this.form.submit()">
                </form>
                <small class="text-muted d-block mt-2">JPG, JPEG, PNG, or GIF (Max 5MB)</small>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-white">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ID Number</label>
                        <input type="text" class="form-control" value="{{ $user->id_number }}" disabled>
                        <small class="text-muted">ID number cannot be changed</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-select" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science" {{ $user->department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                            <option value="Engineering" {{ $user->department == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Business Administration" {{ $user->department == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                            <option value="Education" {{ $user->department == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Arts and Sciences" {{ $user->department == 'Arts and Sciences' ? 'selected' : '' }}>Arts and Sciences</option>
                            <option value="Medical Technology" {{ $user->department == 'Medical Technology' ? 'selected' : '' }}>Medical Technology</option>
                            <option value="Nursing" {{ $user->department == 'Nursing' ? 'selected' : '' }}>Nursing</option>
                            <option value="Architecture" {{ $user->department == 'Architecture' ? 'selected' : '' }}>Architecture</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('user.profile.change-password') }}" class="btn btn-warning">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection