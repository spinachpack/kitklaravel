@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<div class="mb-4">
    <h4>My Profile</h4>
    <p class="text-muted">Manage your profile information and settings</p>
</div>

<div class="row">
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <img src="{{ auth()->user()->profile_picture_url }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; border: 5px solid var(--primary-blue); object-fit: cover;" alt="Profile">
                <h5>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
                <p class="text-muted mb-3">{{ auth()->user()->id_number }}</p>
                
                <form method="POST" action="{{ route('user.profile.picture') }}" enctype="multipart/form-data" id="pictureForm">
                    @csrf
                    <label for="profilePicture" class="btn btn-outline-primary" style="cursor: pointer;">
                        <i class="fas fa-camera me-2"></i> Change Picture
                    </label>
                    <input type="file" id="profilePicture" name="profile_picture" accept="image/*" style="display:none" onchange="this.form.submit()">
                </form>
                <small class="text-muted d-block mt-2">JPG, JPEG, PNG, or GIF (Max 5MB)</small>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', auth()->user()->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ID Number</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->id_number }}" disabled>
                        <small class="text-muted">ID number cannot be changed</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-select @error('department') is-invalid @enderror" required>
                            <option value="">Select Department</option>
                            @php
                                $departments = ['Computer Science', 'Engineering', 'Business Administration', 'Education', 'Arts and Sciences', 'Medical Technology', 'Nursing', 'Architecture', 'Administration', 'Sports Department'];
                            @endphp
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ auth()->user()->department == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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