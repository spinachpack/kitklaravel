@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="mb-4">
    <h4>My Bookings</h4>
    <p class="text-muted">View all your equipment reservation history</p>
</div>

<div class="card">
    <div class="card-body">
        @forelse($bookings as $booking)
            <div class="border-bottom pb-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        @if($booking->equipment->image)
                            <img src="{{ asset('uploads/equipment/' . $booking->equipment->image) }}" style="width: 80px; height: 80px; border-radius: 10px; object-fit: cover;" alt="">
                        @else
                            <div style="width: 80px; height: 80px; background: #6c757d; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-box fa-2x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <h6 class="mb-1">{{ $booking->equipment->name }}</h6>
                        <small class="text-muted">Booking ID: #{{ $booking->id }}</small>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted"><i class="fas fa-calendar"></i> Start:</small><br>
                        <small>{{ $booking->start_date->format('M d, Y') }} {{ date('h:i A', strtotime($booking->start_time)) }}</small><br>
                        <small class="text-muted"><i class="fas fa-calendar"></i> End:</small><br>
                        <small>{{ $booking->end_date->format('M d, Y') }} {{ date('h:i A', strtotime($booking->end_time)) }}</small>
                    </div>
                    <div class="col-md-2">
                        <span class="badge {{ $booking->status_badge_class }}">
                            {{ ucfirst($booking->status) }}
                        </span><br>
                        <small class="text-muted">{{ $booking->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                            <i class="fas fa-eye"></i> View
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
                                        <span class="badge {{ $booking->status_badge_class }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Booking Period</h6>
                                    <p><strong>Start:</strong> {{ $booking->start_date->format('F d, Y') }} {{ date('h:i A', strtotime($booking->start_time)) }}</p>
                                    <p><strong>End:</strong> {{ $booking->end_date->format('F d, Y') }} {{ date('h:i A', strtotime($booking->end_time)) }}</p>
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
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5>No Bookings Yet</h5>
                <p class="text-muted">You haven't made any equipment reservations yet.</p>
                <a href="{{ route('user.equipment.browse') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Browse Equipment
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection