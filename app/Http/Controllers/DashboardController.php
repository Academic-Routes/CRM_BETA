<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get dashboard data based on user role
        $data = [
            'totalStudents' => Student::count(),
            'studentsThisMonth' => Student::whereMonth('created_at', Carbon::now()->month)->count(),
            'totalCounselors' => User::whereHas('role', function($q) { $q->where('name', 'Counselor'); })->count(),
            'applicationsSent' => Student::whereIn('status', ['Sent to Application', 'Application In Review'])->count(),
            'completedApplications' => Student::where('status', 'Completed')->count(),
            'recentStudents' => Student::with(['counselor'])->latest()->limit(5)->get(),
            'recentNotifications' => $user->notifications()->limit(5)->get(),
            'statusCounts' => Student::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')
        ];
        
        return view('admin.dashboard', $data);
    }
}