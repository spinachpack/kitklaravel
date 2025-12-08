@extends('department.layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('department.bookings.index') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Bookings
    </a>
    <h4>Booking Details #{{ $booking->id }}</h4>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        <span class="badge {{ $booking->status_badge_class }} mt-2">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Submitted:</strong><br>
                        {{ $booking->created_at->format('F d, Y h:i A') }}
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Equipment:</strong><br>
                        {{ $booking->equipment->name }}
                    </div>
                    <div class="col-md-6">
                        @if($booking->equipment->image)
                            <img src="{{ asset('uploads/equipment/' . $booking->equipment->image) }}" class="img-fluid rounded" style="max-width: 300px;" alt="Equipment">
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Borrow Date:</strong><br>
                        {{ $booking->start_date->format('F d, Y') }}<br>
                        <small class="text-muted">{{ date('h:i A', strtotime($booking->start_time)) }}</small>
                    </div>
                    <div class="col-md-6">
                        <strong>Return Date:</strong><br>
                        {{ $booking->end_date->format('F d, Y') }}<br>
                        <small class="text-muted">{{ date('h:i A', strtotime($booking->end_time)) }}</small>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <strong>Purpose of Use:</strong><br>
                    <p class="mt-2">{{ $booking->purpose }}</p>
                </div>

                @if($booking->admin_notes)
                    <hr>
                    <div class="alert alert-info">
                        <strong>Admin Notes:</strong><br>
                        {{ $booking->admin_notes }}
                        @if($booking->approver)
                            <br><small class="text-muted">By: {{ $booking->approver->first_name }} {{ $booking->approver->last_name }} on {{ $booking->approved_at->format('M d, Y') }}</small>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @if($booking->status === 'pending')
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Take Action</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('department.bookings.approve', $booking->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add any notes about your decision..."></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Approve Booking
                            </button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('department.bookings.reject', $booking->id) }}" class="mt-2">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rejection Reason</label>
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Reject Booking
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @if($booking->status === 'approved')
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Equipment Status</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Equipment is currently borrowed. Click below when the user returns it.
                    </div>
                    <form method="POST" action="{{ route('department.bookings.complete', $booking->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-check-circle"></i> Mark as Returned
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong><br>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
                <p><strong>ID Number:</strong><br>{{ $booking->user->id_number }}</p>
                <p><strong>Email:</strong><br>{{ $booking->user->email }}</p>
                <p><strong>Department:</strong><br>{{ $booking->user->department }}</p>
            </div>
        </div>
    </div>
</div>
@endsection