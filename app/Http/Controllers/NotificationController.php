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
            'is_read' => true
        ]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()
            ->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

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
        $unreadCount = $user->notifications()->where('is_read', false)->count();
        
        $lastCheck = $request->input('last_check', now()->subMinutes(1)->timestamp);
        $lastCheckTime = \Carbon\Carbon::createFromTimestamp($lastCheck);
        
        // Get new notifications since last check
        $newNotifications = $user->notifications()
            ->where('created_at', '>', $lastCheckTime)
            ->where('is_read', false)
            ->latest()
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'created_at' => $notification->created_at->format('Y-m-d H:i:s')
                ];
            });

        return response()->json([
            'count' => $unreadCount,
            'new_notifications' => $newNotifications,
            'timestamp' => now()->timestamp
        ]);
    }
}