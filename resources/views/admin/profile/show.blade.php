@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="mb-4">
    <h4>My Profile</h4>
    <p class="text-muted">Manage your profile information</p>
</div>

<div class="row">
    <!-- Profile Picture Section -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <img src="{{ auth()->user()->profile_picture_url }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; border: 5px solid var(--primary-blue); object-fit: cover;" alt="Profile">
                <h5>{{ $user->first_name }} {{ $user->last_name }}</h5>
                <p class="text-muted mb-3">{{ $user->id_number }}</p>
                
                <form method="POST" action="{{ route('admin.profile.picture') }}" enctype="multipart/form-data" id="pictureForm">
                    @csrf
                    <div class="position-relative d-inline-block">
                        <label for="profile_picture" class="btn btn-outline-primary" style="cursor: pointer;">
                            <i class="fas fa-camera me-2"></i> Change Picture
                        </label>
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;" onchange="document.getElementById('pictureForm').submit();">
                    </div>
                </form>
                <small class="text-muted d-block mt-2">JPG, JPEG, PNG, or GIF (Max 5MB)</small>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ID Number</label>
                        <input type="text" class="form-control" value="{{ $user->id_number }}" disabled>
                        <small class="text-muted">ID number cannot be changed</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        @if(auth()->user()->id_number === 'ADMIN001' || auth()->user()->email === 'admin@ucbanilad.edu.ph')
                            <input type="text" class="form-control" value="{{ $user->department }}" disabled>
                            <small class="text-muted">Original administrator's department cannot be changed</small>
                        @else
                            <select name="department" class="form-select @error('department') is-invalid @enderror" required>
                                <option value="">Select Department</option>
                                @php
                                    $departments = ['Computer Science', 'Engineering', 'Business Administration', 'Education', 'Arts and Sciences', 'Medical Technology', 'Nursing', 'Architecture', 'Administration', 'Sports Department'];
                                @endphp
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ $user->department == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.profile.change-password') }}" class="btn btn-warning">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection