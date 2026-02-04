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

    public function poll()
    {
        $user = Auth::user();
        $notifications = $user->notifications()
            ->where('is_read', false)
            ->latest()
            ->limit(5)
            ->get();
            
        return response()->json([
            'notifications' => $notifications,
            'count' => $user->unreadNotifications()->count()
        ]);
    }
}