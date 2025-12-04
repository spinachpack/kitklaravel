<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Recent reservations
        $reservations = Reservation::with('equipment')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Recent notifications
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Unread count
        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        // Statistics
        $stats = [
            'total_bookings' => Reservation::where('user_id', $user->id)->count(),
            'pending' => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Reservation::where('user_id', $user->id)->where('status', 'approved')->count(),
            'completed' => Reservation::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];
        
        return view('user.dashboard', compact('reservations', 'notifications', 'unreadCount', 'stats'));
    }
}