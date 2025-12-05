@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<div class="mb-4">
    <h4>System Reports</h4>
    <p class="text-muted">Overview of system usage and statistics</p>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h3>{{ $stats['pending_bookings'] }}</h3>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3>{{ $stats['approved_bookings'] }}</h3>
                <p class="text-muted mb-0">Approved</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                <h3>{{ $stats['rejected_bookings'] }}</h3>
                <p class="text-muted mb-0">Rejected</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clipboard-check fa-2x text-info mb-2"></i>
                <h3>{{ $stats['completed_bookings'] }}</h3>
                <p class="text-muted mb-0">Completed</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Booking Status Summary -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Booking Status Summary</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td class="text-end"><strong>{{ $stats['pending_bookings'] }}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td class="text-end"><strong>{{ $stats['approved_bookings'] }}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-danger">Rejected</span></td>
                            <td class="text-end"><strong>{{ $stats['rejected_bookings'] }}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">Completed</span></td>
                            <td class="text-end"><strong>{{ $stats['completed_bookings'] }}</strong></td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>Total</strong></td>
                            <td class="text-end"><strong>{{ $stats['total_bookings'] }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Most Booked Equipment -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Most Booked Equipment</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Equipment</th>
                                <th class="text-end">Bookings</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popularEquipment as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-primary">{{ $item->reservations_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Equipment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivity as $activity)
                                <tr>
                                    <td>{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                    <td>{{ $activity->user->first_name }} {{ $activity->user->last_name }}</td>
                                    <td>{{ $activity->equipment->name }}</td>
                                    <td>
                                        <span class="badge {{ $activity->status_badge_class }}">
                                            {{ ucfirst($activity->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No activity yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection