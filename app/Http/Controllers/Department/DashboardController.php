<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_equipment' => Equipment::count(),
            'pending_bookings' => Reservation::where('status', 'pending')->count(),
            'approved_bookings' => Reservation::where('status', 'approved')->count(),
        ];

        $recentBookings = Reservation::with(['user', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('department.dashboard', compact('stats', 'recentBookings'));
    }
}