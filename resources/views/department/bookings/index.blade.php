@extends('department.layouts.app')

@section('title', 'Manage Bookings')

@section('content')
<div class="mb-4">
    <h4>Manage Bookings</h4>
    <p class="text-muted">Review and manage equipment booking requests</p>
</div>

<!-- Filter Buttons -->
<div class="card mb-4">
    <div class="card-body">
        <div class="btn-group flex-wrap" role="group">
            <a href="{{ route('department.bookings.index') }}" 
               class="btn {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                All Bookings
            </a>
            <a href="{{ route('department.bookings.index', ['status' => 'pending']) }}" 
               class="btn {{ request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                Pending
            </a>
            <a href="{{ route('department.bookings.index', ['status' => 'approved']) }}" 
               class="btn {{ request('status') === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                Approved
            </a>
            <a href="{{ route('department.bookings.index', ['status' => 'rejected']) }}" 
               class="btn {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                Rejected
            </a>
            <a href="{{ route('department.bookings.index', ['status' => 'completed']) }}" 
               class="btn {{ request('status') === 'completed' ? 'btn-info' : 'btn-outline-info' }}">
                Completed
            </a>
        </div>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-body">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Details</th>
                            <th>Equipment</th>
                            <th>Date & Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>
                                    <strong>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</strong><br>
                                    <small class="text-muted">{{ $booking->user->id_number }}</small><br>
                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                </td>
                                <td>{{ $booking->equipment->name }}</td>
                                <td>
                                    <strong>{{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}</strong><br>
                                    <small>{{ date('h:i A', strtotime($booking->start_time)) }} - {{ date('h:i A', strtotime($booking->end_time)) }}</small>
                                </td>
                                <td>
                                    <small>{{ Str::limit($booking->purpose, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $booking->status_badge_class }} badge-status">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal for each booking -->
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
                                                    <h6>User Information</h6>
                                                    <p><strong>Name:</strong> {{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
                                                    <p><strong>ID Number:</strong> {{ $booking->user->id_number }}</p>
                                                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Booking Information</h6>
                                                    <p><strong>Equipment:</strong> {{ $booking->equipment->name }}</p>
                                                    <p><strong>Start:</strong> {{ $booking->start_date->format('M d, Y') }} {{ date('h:i A', strtotime($booking->start_time)) }}</p>
                                                    <p><strong>End:</strong> {{ $booking->end_date->format('M d, Y') }} {{ date('h:i A', strtotime($booking->end_time)) }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <h6>Purpose of Use</h6>
                                            <p>{{ $booking->purpose }}</p>
                                            
                                            @if($booking->admin_notes)
                                                <hr>
                                                <h6>Admin Notes</h6>
                                                <p>{{ $booking->admin_notes }}</p>
                                                @if($booking->approver)
                                                    <p><small class="text-muted">Reviewed by: {{ $booking->approver->first_name }} {{ $booking->approver->last_name }} on {{ $booking->approved_at->format('M d, Y') }}</small></p>
                                                @endif
                                            @endif

                                            @if($booking->status === 'pending')
                                                <hr>
                                                <form method="POST" action="{{ route('department.bookings.approve', $booking->id) }}" id="approveForm{{ $booking->id }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label">Admin Notes (Optional)</label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add notes about your decision..."></textarea>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </div>
                                                </form>
                                                <form method="POST" action="{{ route('department.bookings.reject', $booking->id) }}" class="mt-2" id="rejectForm{{ $booking->id }}">
                                                    @csrf
                                                    <input type="hidden" name="admin_notes" id="rejectNotes{{ $booking->id }}">
                                                    <button type="button" class="btn btn-danger" onclick="submitReject({{ $booking->id }})">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            @endif

                                            @if($booking->status === 'approved')
                                                <hr>
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> Equipment has been borrowed. Mark as returned when the user returns it.
                                                </div>
                                                <form method="POST" action="{{ route('department.bookings.complete', $booking->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fas fa-check-circle"></i> Mark as Returned
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5>No Bookings Found</h5>
                <p class="text-muted">There are no bookings matching your filter.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function submitReject(bookingId) {
    const notes = document.querySelector(`#approveForm${bookingId} textarea[name="admin_notes"]`).value;
    document.getElementById(`rejectNotes${bookingId}`).value = notes;
    document.getElementById(`rejectForm${bookingId}`).submit();
}
</script>
@endpush