@extends('layouts.user')

@section('title', 'Notifications')

@section('extra-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .notification-item {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }
    .notification-item.unread {
        border-left: 4px solid #1e5a96;
        background: #f0f8ff;
    }
    .notification-item:hover {
        transform: translateX(5px);
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Notifications</h4>
        <p class="text-muted mb-0">
            @if($unreadCount > 0)
                You have {{ $unreadCount }} unread notification{{ $unreadCount > 1 ? 's' : '' }}
            @else
                All caught up!
            @endif
        </p>
    </div>
    @if($unreadCount > 0)
        <a href="{{ route('user.notifications.read-all') }}" class="btn btn-primary">
            <i class="fas fa-check-double"></i> Mark All Read
        </a>
    @endif
</div>

@forelse($notifications as $notif)
    <div class="notification-item {{ $notif->is_read ? '' : 'unread' }}">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-bell text-primary me-2"></i>
                    <strong>{{ ucfirst($notif->type) }}</strong>
                    @if(!$notif->is_read)
                        <span class="badge bg-primary ms-2">New</span>
                    @endif
                </div>
                <p class="mb-2">{{ $notif->message }}</p>
                <small class="text-muted">
                    <i class="fas fa-clock"></i>
                    {{ $notif->created_at->format('F d, Y h:i A') }}
                </small>
            </div>
            @if(!$notif->is_read)
                <a href="{{ route('user.notifications.read', $notif->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-check"></i> Mark Read
                </a>
            @endif
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
            <h5>No Notifications</h5>
            <p class="text-muted">You don't have any notifications yet.</p>
        </div>
    </div>
@endforelse
@endsection

