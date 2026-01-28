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
        
        // Role-specific dashboards
        if ($user->hasRole('Counselor')) {
            return $this->counselorDashboard($user);
        } elseif ($user->hasRole('Application')) {
            return $this->applicationDashboard($user);
        } elseif ($user->hasRole('FrontDesk')) {
            return $this->frontdeskDashboard($user);
        } elseif ($user->hasRole('Admin') || $user->hasRole('Super Admin') || $user->hasRole('Supervisor')) {
            return $this->adminDashboard($user);
        }
        
        abort(403);
    }
    
    private function counselorDashboard($user)
    {
        $data = [
            'myStudents' => Student::where('counselor_id', $user->id)->count(),
            'documentsCompleted' => Student::where('counselor_id', $user->id)->where('status', 'Documents Completed')->count(),
            'sentToApplication' => Student::where('counselor_id', $user->id)->whereIn('status', ['Sent to Application', 'Application In Review'])->count(),
            'completedApplications' => Student::where('counselor_id', $user->id)->where('status', 'Completed')->count(),
            'recentStudents' => Student::select('id', 'name', 'status', 'created_at')
                                ->where('counselor_id', $user->id)
                                ->latest()
                                ->limit(5)
                                ->get(),
            'recentNotifications' => $user->notifications()->select('id', 'title', 'message', 'is_read', 'created_at')->limit(5)->get(),
        ];
        
        return view('admin.dashboards.counselor', $data);
    }
    
    private function applicationDashboard($user)
    {
        $data = [
            'pendingApplications' => Student::whereIn('status', ['Sent to Application', 'Application In Review'])->count(),
            'myApplications' => Student::where('application_staff_id', $user->id)->count(),
            'completedToday' => Student::where('application_staff_id', $user->id)->where('status', 'Completed')->whereDate('updated_at', today())->count(),
            'totalCompleted' => Student::where('application_staff_id', $user->id)->where('status', 'Completed')->count(),
            'recentApplications' => Student::select('id', 'name', 'status', 'counselor_id', 'created_at')
                                    ->with(['counselor:id,name'])
                                    ->whereIn('status', ['Sent to Application', 'Application In Review'])
                                    ->latest()
                                    ->limit(5)
                                    ->get(),
            'recentNotifications' => $user->notifications()->select('id', 'title', 'message', 'is_read', 'created_at')->limit(5)->get(),
        ];
        
        return view('admin.dashboards.application', $data);
    }
    
    private function frontdeskDashboard($user)
    {
        $data = [
            'totalStudents' => Student::count(),
            'newStudents' => Student::where('status', 'New')->count(),
            'studentsToday' => Student::whereDate('created_at', today())->count(),
            'assignedStudents' => Student::whereNotNull('counselor_id')->count(),
            'recentStudents' => Student::select('id', 'name', 'status', 'counselor_id', 'created_at')
                                ->with(['counselor:id,name'])
                                ->latest()
                                ->limit(5)
                                ->get(),
            'recentNotifications' => $user->notifications()->select('id', 'title', 'message', 'is_read', 'created_at')->limit(5)->get(),
            'topCounselors' => User::whereHas('role', function($q) { $q->where('name', 'Counselor'); })
                                ->select('id', 'name')
                                ->withCount('students')
                                ->orderBy('students_count', 'desc')
                                ->limit(5)
                                ->get(),
            'topApplicationStaff' => User::whereHas('role', function($q) { $q->where('name', 'Application'); })
                                        ->select('id', 'name')
                                        ->withCount('applicationStudents')
                                        ->orderBy('application_students_count', 'desc')
                                        ->limit(5)
                                        ->get()
        ];
        
        return view('admin.dashboards.frontdesk', $data);
    }
    
    private function adminDashboard($user)
    {
        $data = [
            'totalStudents' => Student::count(),
            'studentsThisMonth' => Student::whereMonth('created_at', Carbon::now()->month)->count(),
            'totalCounselors' => User::whereHas('role', function($q) { $q->where('name', 'Counselor'); })
                                    ->whereHas('students')
                                    ->count(),
            'applicationsSent' => Student::whereIn('status', ['Sent to Application', 'Application In Review'])->count(),
            'completedApplications' => Student::where('status', 'Completed')->count(),
            'newStudents' => Student::where('status', 'New')->count(),
            'assignedToCounselor' => Student::where('status', 'Assigned to Counselor')->count(),
            'rejectedStudents' => Student::where('status', 'Rejected')->count(),
            'onHoldStudents' => Student::where('status', 'On Hold')->count(),
            'recentStudents' => Student::select('id', 'name', 'status', 'counselor_id', 'created_at')
                                ->with(['counselor:id,name'])
                                ->latest()
                                ->limit(5)
                                ->get(),
            'recentNotifications' => $user->notifications()->select('id', 'title', 'message', 'is_read', 'created_at')->limit(5)->get(),
            'topCounselors' => User::whereHas('role', function($q) { $q->where('name', 'Counselor'); })
                                ->select('id', 'name')
                                ->withCount('students')
                                ->orderBy('students_count', 'desc')
                                ->limit(5)
                                ->get(),
            'topApplicationStaff' => User::whereHas('role', function($q) { $q->where('name', 'Application'); })
                                        ->select('id', 'name')
                                        ->withCount('applicationStudents')
                                        ->orderBy('application_students_count', 'desc')
                                        ->limit(5)
                                        ->get()
        ];
        
        return view('admin.dashboard', $data);
    }
    
    public function staffStudents($staffId, $type)
    {
        $staff = User::findOrFail($staffId);
        
        if ($type === 'counselor') {
            $students = Student::where('counselor_id', $staffId)
                              ->with(['counselor:id,name'])
                              ->paginate(15);
            $title = "Students assigned to {$staff->name} (Counselor)";
        } elseif ($type === 'application') {
            $students = Student::where('application_staff_id', $staffId)
                              ->with(['counselor:id,name'])
                              ->paginate(15);
            $title = "Students handled by {$staff->name} (Application Staff)";
        } else {
            abort(404);
        }
        
        return view('admin.staff-students', compact('students', 'staff', 'title', 'type'));
    }
}