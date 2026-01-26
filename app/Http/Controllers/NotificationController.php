<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }

    public function getLatest()
    {
        $notifications = Auth::user()->notifications()->limit(5)->get();
        return response()->json($notifications);
    }

    public function stream()
    {
        $user = Auth::user();
        $lastNotificationId = request('lastId', 0);
        
        // If no lastId provided, get the latest notification ID to prevent showing old ones
        if ($lastNotificationId == 0) {
            $latestNotification = $user->notifications()->latest()->first();
            $lastNotificationId = $latestNotification ? $latestNotification->id : 0;
        }
        
        return response()->stream(function() use ($user, $lastNotificationId) {
            echo "data: " . json_encode(['type' => 'connected']) . "\n\n";
            ob_flush();
            flush();
            
            $currentLastId = $lastNotificationId;
            
            while (true) {
                $notifications = $user->notifications()
                    ->where('id', '>', $currentLastId)
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
                if ($notifications->count() > 0) {
                    foreach ($notifications as $notification) {
                        echo "data: " . json_encode([
                            'type' => 'notification',
                            'id' => $notification->id,
                            'title' => $notification->title,
                            'message' => $notification->message,
                            'created_at' => $notification->created_at->diffForHumans()
                        ]) . "\n\n";
                        $currentLastId = $notification->id;
                    }
                    ob_flush();
                    flush();
                }
                
                sleep(2);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}