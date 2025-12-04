@extends('layouts.user')

@section('title', 'Dashboard')

@section('extra-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .top-navbar {
        background: white;
        padding: 15px 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-bottom: 30px;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="top-navbar d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">Dashboard</h4>
        <small class="text-muted">Welcome back, {{ Auth::user()->first_name }}!</small>
    </div>
    <div>
        <span class="text-muted me-3"><i class="fas fa-calendar"></i> {{ now()->format('l, F j, Y') }}</span>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Bookings</h5>
            </div>
            <div class="card-body">
                @if($reservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $booking)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-box text-primary me-2"></i>
                                            {{ $booking->equipment->name }}
                                        </div>
                                    </td>
                                    <td>{{ $booking->start_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status_badge_class }} badge-status">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('user.bookings.index') }}" class="btn btn-link">View All Bookings →</a>
                @else
                    <p class="text-center text-muted py-4">No bookings yet. <a href="{{ route('user.equipment.browse') }}">Browse equipment</a> to make your first reservation.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Notifications</h5>
            </div>
            <div class="card-body">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notif)
                    <div class="alert alert-light mb-2 {{ $notif->is_read ? '' : 'border-primary' }}">
                        <small class="d-block text-muted">{{ $notif->created_at->format('M d, h:i A') }}</small>
                        {{ $notif->message }}
                    </div>
                    @endforeach
                    <a href="{{ route('user.notifications.index') }}" class="btn btn-link">View All Notifications →</a>
                @else
                    <p class="text-center text-muted py-3">No notifications yet.</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body text-center">
                <i class="fas fa-calendar-plus fa-3x text-primary mb-3"></i>
                <h5>Quick Action</h5>
                <p class="text-muted">Ready to book equipment?</p>
                <a href="{{ route('user.equipment.browse') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Browse Equipment
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
