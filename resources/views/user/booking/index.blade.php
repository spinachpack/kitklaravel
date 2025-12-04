@extends('layouts.user')

@section('title', 'My Bookings')

@section('extra-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .booking-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }
    .booking-card:hover {
        transform: translateY(-3px);
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <h4>My Bookings</h4>
    <p class="text-muted">View all your equipment reservation history</p>
</div>

@forelse($bookings as $booking)
    <div class="booking-card">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-box fa-2x text-white"></i>
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="mb-1">{{ $booking->equipment->name }}</h5>
                <small class="text-muted">Booking ID: #{{ $booking->id }}</small>
            </div>
            <div class="col-md-3">
                <p class="mb-0"><i class="fas fa-calendar text-primary"></i> <strong>Start:</strong></p>
                <small>{{ $booking->start_date->format('M d, Y') }} {{ $booking->start_time }}</small>
                <p class="mb-0 mt-2"><i class="fas fa-calendar text-danger"></i> <strong>End:</strong></p>
                <small>{{ $booking->end_date->format('M d, Y') }} {{ $booking->end_time }}</small>
            </div>
            <div class="col-md-2">
                <span class="badge {{ $booking->status_badge_class }} badge-status">
                    {{ ucfirst($booking->status) }}
                </span>
                <p class="mb-0 mt-2">
                    <small class="text-muted">Requested: {{ $booking->created_at->format('M d, Y') }}</small>
                </p>
            </div>
            <div class="col-md-1">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details #{{ $booking->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Equipment Information</h6>
                            <p><strong>Name:</strong> {{ $booking->equipment->name }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge {{ $booking->status_badge_class }} badge-status">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Booking Period</h6>
                            <p><strong>Start:</strong> {{ $booking->start_date->format('F d, Y') }} {{ $booking->start_time }}</p>
                            <p><strong>End:</strong> {{ $booking->end_date->format('F d, Y') }} {{ $booking->end_time }}</p>
                        </div>
                    </div>
                    <hr>
                    <h6>Purpose of Use</h6>
                    <p>{{ $booking->purpose }}</p>

                    @if($booking->admin_notes)
                    <hr>
                    <h6>Admin Notes</h6>
                    <div class="alert alert-info">{{ $booking->admin_notes }}</div>
                    @endif

                    <hr>
                    <p><small class="text-muted">Submitted on: {{ $booking->created_at->format('F d, Y h:i A') }}</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
            <h5>No Bookings Yet</h5>
            <p class="text-muted">You haven't made any equipment reservations yet.</p>
            <a href="{{ route('user.equipment.browse') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Browse Equipment
            </a>
        </div>
    </div>
@endforelse
@endsection
