@extends('layouts.user')

@section('title', 'Book Equipment')

@section('extra-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .equipment-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }
    .equipment-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('user.equipment.browse') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back to Equipment
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <div class="mt-2">
            <a href="{{ route('user.bookings.index') }}" class="btn btn-sm btn-success">View My Bookings</a>
            <a href="{{ route('user.equipment.browse') }}" class="btn btn-sm btn-outline-success">Browse More Equipment</a>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> 
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                @if($equipment->image)
                    <img src="{{ $equipment->image_url }}" class="equipment-image mb-3" alt="{{ $equipment->name }}">
                @else
                    <div class="equipment-placeholder mb-3">
                        <i class="fas fa-box fa-5x text-white"></i>
                    </div>
                @endif

                <span class="badge bg-primary mb-2">{{ $equipment->category->name }}</span>
                <h3>{{ $equipment->name }}</h3>
                <p class="text-muted">{{ $equipment->description }}</p>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <strong>Total Quantity:</strong>
                    <span>{{ $equipment->quantity }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <strong>Available:</strong>
                    <span class="text-success">
                        <i class="fas fa-check-circle"></i> {{ $equipment->available_quantity }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Book This Equipment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.equipment.book.store', $equipment->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purpose of Use</label>
                        <textarea name="purpose" class="form-control" rows="4"  placeholder="Please describe why you need this equipment..." required>{{ old('purpose') }}</textarea>
                        <small class="text-muted">Provide detailed information about your intended use</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> Your booking request will be reviewed by an administrator. You will receive a notification once it's approved or rejected.
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-paper-plane"></i> Submit Booking Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
