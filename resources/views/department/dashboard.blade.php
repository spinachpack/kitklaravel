@extends('department.layouts.app')

@section('title', 'Department Dashboard')

@section('content')
<div class="bg-white p-4 rounded-3 shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Department Dashboard</h4>
            <small class="text-muted">Manage equipment and bookings</small>
        </div>
        <div>
            <span class="text-muted me-3"><i class="fas fa-calendar"></i> {{ now()->format('l, F j, Y') }}</span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-box fa-2x text-primary mb-2"></i>
                <h3>{{ $stats['total_equipment'] }}</h3>
                <p class="text-muted mb-0">Total Equipment</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h3>{{ $stats['pending_bookings'] }}</h3>
                <p class="text-muted mb-0">Pending Requests</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3>{{ $stats['approved_bookings'] }}</h3>
                <p class="text-muted mb-0">Approved Bookings</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Booking Requests</h5>
        <a href="{{ route('department.bookings.index') }}" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body">
        @if($recentBookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Equipment</th>
                            <th>Date Range</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>
                                    <strong>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</strong><br>
                                    <small class="text-muted">{{ $booking->user->id_number }}</small>
                                </td>
                                <td>{{ $booking->equipment->name }}</td>
                                <td>
                                    {{ $booking->start_date->format('M d') }} - 
                                    {{ $booking->end_date->format('M d, Y') }}
                                </td>
                                <td>
                                    <span class="badge {{ $booking->status_badge_class }} badge-status">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted py-4">No booking requests yet.</p>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('department.equipment.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus-circle"></i> Add New Equipment
                    </a>
                    <a href="{{ route('department.bookings.index', ['status' => 'pending']) }}" class="btn btn-outline-warning">
                        <i class="fas fa-tasks"></i> Review Pending Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection