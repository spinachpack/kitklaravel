<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function show($id)
    {
        $equipment = Equipment::with('category')
            ->where('id', $id)
            ->where('status', 'available')
            ->firstOrFail();
        
        return view('user.booking.book', compact('equipment'));
    }
    
    public function store(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'purpose' => 'required|string',
        ]);
        
        // Custom validations
        if (strtotime($request->start_date) < strtotime(date('Y-m-d'))) {
            return back()->withErrors(['start_date' => 'Start date cannot be in the past.'])->withInput();
        }
        
        if (strtotime($request->end_date) < strtotime($request->start_date)) {
            return back()->withErrors(['end_date' => 'End date must be after start date.'])->withInput();
        }
        
        if ($request->start_date === $request->end_date && strtotime($request->end_time) <= strtotime($request->start_time)) {
            return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
        }
        
        $equipment = Equipment::findOrFail($id);
    
    // Check for conflicts
        $conflicts = Reservation::where('equipment_id', $id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function($q) use ($request) {
                        $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })->exists();
        
        if ($conflicts) {
            return back()->withErrors(['error' => 'This equipment is already booked for the selected dates. Please choose different dates.'])->withInput();
        }
        
        if ($equipment->available_quantity < 1) {
            return back()->withErrors(['error' => 'This equipment is currently unavailable.'])->withInput();
        }
            
            // Create reservation
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'equipment_id' => $id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'purpose' => $request->purpose,
                'status' => 'pending',
            ]);
            
            // Create notification
            Notification::create([
                'user_id' => Auth::id(),
                'message' => "Your booking request for {$equipment->name} has been submitted and is pending approval.",
                'type' => 'booking',
            ]);
            
            return redirect()->route('user.bookings.index')
                ->with('success', 'Booking request submitted successfully!');
    }
    
    public function index()
    {
        $bookings = Reservation::with('equipment')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return view('user.booking.index', compact('bookings'));
    }
}