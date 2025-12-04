<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return view('user.notifications.index', compact('notifications', 'unreadCount'));
    }
    
    public function markRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        
        $notification->markAsRead();
        
        return redirect()->route('user.notifications.index');
    }
    
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return redirect()->route('user.notifications.index');
    }
}