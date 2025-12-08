<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'equipment', 'approver']);

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        return view('department.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Reservation::with(['user', 'equipment', 'approver'])->findOrFail($id);
        return view('department.bookings.show', compact('booking'));
    }

    public function approve(Request $request, $id)
    {
        $booking = Reservation::findOrFail($id);
        
        $booking->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        $booking->equipment->decrement('available_quantity');

        Notification::create([
            'user_id' => $booking->user_id,
            'message' => "Your booking request for {$booking->equipment->name} has been approved!",
            'type' => 'booking_approved',
        ]);

        return redirect()->route('department.bookings.index')
            ->with('success', 'Booking approved successfully!');
    }

    public function reject(Request $request, $id)
    {
        $booking = Reservation::findOrFail($id);
        
        $booking->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        Notification::create([
            'user_id' => $booking->user_id,
            'message' => "Your booking request for {$booking->equipment->name} has been rejected. Reason: {$request->admin_notes}",
            'type' => 'booking_rejected',
        ]);

        return redirect()->route('department.bookings.index')
            ->with('success', 'Booking rejected successfully!');
    }

    public function complete($id)
    {
        $booking = Reservation::findOrFail($id);
        
        $booking->update(['status' => 'completed']);
        $booking->equipment->increment('available_quantity');

        Notification::create([
            'user_id' => $booking->user_id,
            'message' => "Your borrowed {$booking->equipment->name} has been marked as returned. Thank you!",
            'type' => 'booking_completed',
        ]);

        return redirect()->route('department.bookings.index')
            ->with('success', 'Equipment marked as returned successfully!');
    }
}