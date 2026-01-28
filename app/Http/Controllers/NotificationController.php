<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->update([
            'read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    public function getLatest()
    {
        return response()->json(
            Auth::user()
                ->notifications()
                ->latest()
                ->limit(5)
                ->get()
        );
    }

    public function poll(Request $request)
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotifications()->count();
        
        $newNotifications = $user->notifications()
            ->where('created_at', '>', now()->subMinutes(5))
            ->where('is_read', false)
            ->latest()
            ->get();

        return response()->json([
            'count' => $unreadCount,
            'new_notifications' => $newNotifications
        ]);
    }
}