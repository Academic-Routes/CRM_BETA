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

    public function stream()
    {
        return response()->stream(function () {
            $user = Auth::user();
            $lastCheck = now();
            
            // Set headers for SSE
            echo "data: {\"type\":\"connected\",\"message\":\"Connected to notification stream\"}\n\n";
            ob_flush();
            flush();
            
            while (true) {
                // Check for new notifications
                $newNotifications = $user->notifications()
                    ->where('created_at', '>', $lastCheck)
                    ->where('is_read', false)
                    ->latest()
                    ->get();
                
                if ($newNotifications->count() > 0) {
                    foreach ($newNotifications as $notification) {
                        $data = [
                            'type' => 'notification',
                            'id' => $notification->id,
                            'title' => $notification->title,
                            'message' => $notification->message,
                            'created_at' => $notification->created_at->format('Y-m-d H:i:s')
                        ];
                        
                        echo "data: " . json_encode($data) . "\n\n";
                        ob_flush();
                        flush();
                    }
                    
                    $lastCheck = now();
                }
                
                // Send heartbeat every 30 seconds
                echo "data: {\"type\":\"heartbeat\",\"timestamp\":\"" . now()->toISOString() . "\"}\n\n";
                ob_flush();
                flush();
                
                sleep(2); // Check every 2 seconds
                
                // Break if connection is closed
                if (connection_aborted()) {
                    break;
                }
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}