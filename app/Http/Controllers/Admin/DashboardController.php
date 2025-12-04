<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_equipment' => Equipment::count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_bookings' => Reservation::where('status', 'pending')->count(),
            'approved_bookings' => Reservation::where('status', 'approved')->count(),
        ];

        $recentBookings = Reservation::with(['user', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}