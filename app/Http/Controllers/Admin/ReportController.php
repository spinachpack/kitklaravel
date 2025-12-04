<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_equipment' => Equipment::count(),
            'total_bookings' => Reservation::count(),
            'pending_bookings' => Reservation::where('status', 'pending')->count(),
            'approved_bookings' => Reservation::where('status', 'approved')->count(),
            'rejected_bookings' => Reservation::where('status', 'rejected')->count(),
            'completed_bookings' => Reservation::where('status', 'completed')->count(),
        ];

        // Most booked equipment
        $popularEquipment = Equipment::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(10)
            ->get();

        // Recent activity
        $recentActivity = Reservation::with(['user', 'equipment'])
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        // Bookings by status
        $statusData = Reservation::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'popularEquipment',
            'recentActivity',
            'statusData'
        ));
    }
}