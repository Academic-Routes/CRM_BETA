@extends('layouts.admin.master')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div>
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <p class="text-neutral-600 mt-4 mb-0">Academic Routes -> Route It Right From Dream To Destination.</p>
        </div>
    </div>

    <div class="mt-24">
        <div class="row gy-4">
            <!-- Stats Cards -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-primary-600 rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="ph:student" class="text-white text-xl"></iconify-icon>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Total Students</p>
                        </div>
                        <h6 class="mb-0">{{ $totalStudents ?? 0 }}</h6>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center gap-1 text-success-600 text-sm fw-semibold">
                                {{ $studentsThisMonth ?? 0 }}
                                <iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon>
                            </span>
                            This Month
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-warning-600 rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:account-check" class="text-white text-xl"></iconify-icon>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Active Counselors</p>
                        </div>
                        <h6 class="mb-0">{{ $totalCounselors ?? 0 }}</h6>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">
                            <span class="text-secondary-light">Available for assignments</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-success-600 rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:file-document-check" class="text-white text-xl"></iconify-icon>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Applications Sent</p>
                        </div>
                        <h6 class="mb-0">{{ $applicationsSent ?? 0 }}</h6>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">
                            <span class="text-secondary-light">To application team</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-purple-600 rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:check-circle" class="text-white text-xl"></iconify-icon>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Completed</p>
                        </div>
                        <h6 class="mb-0">{{ $completedApplications ?? 0 }}</h6>
                        <p class="fw-medium text-sm text-primary-light mt-12 mb-0">
                            <span class="text-secondary-light">Successfully processed</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Students -->
            <div class="col-xxl-8">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Recent Students</h6>
                            <a href="{{ route('students.index') }}" class="btn btn-primary-600 btn-sm">View All</a>
                        </div>
                        <div class="p-20">
                            @if(isset($recentStudents) && $recentStudents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Counselor</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentStudents as $student)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="w-32-px h-32-px bg-primary-100 rounded-circle d-flex justify-content-center align-items-center">
                                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                                        </div>
                                                        <span class="fw-medium">{{ $student->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $student->status == 'Completed' ? 'success' : ($student->status == 'New' ? 'warning' : 'primary') }}">{{ $student->status }}</span>
                                                </td>
                                                <td>{{ $student->counselor->name ?? 'Not Assigned' }}</td>
                                                <td>{{ $student->created_at->format('M d, Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-secondary-light">No recent students found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Distribution -->
            <div class="col-xxl-4">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Status Distribution</h6>
                        </div>
                        <div class="p-20">
                            @if(isset($statusCounts))
                                @foreach($statusCounts as $status => $count)
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="w-12-px h-12-px radius-2 bg-{{ $status == 'Completed' ? 'success' : ($status == 'New' ? 'warning' : 'primary') }}-600"></span>
                                        <span class="text-neutral-600">{{ $status }}</span>
                                    </div>
                                    <span class="fw-semibold text-primary-light">{{ $count }}</span>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <p class="text-secondary-light">No data available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Recent Notifications</h6>
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                        </div>
                        <div class="ps-20 pt-20 pb-20">
                            @if(isset($recentNotifications) && $recentNotifications->count() > 0)
                                <div class="pe-20 d-flex flex-column gap-20 max-h-300-px overflow-y-auto scroll-sm">
                                    @foreach($recentNotifications as $notification)
                                    <div class="d-flex align-items-start gap-16">
                                        <div class="w-8-px h-8-px bg-{{ $notification->is_read ? 'secondary' : 'primary' }}-600 rounded-circle mt-8 flex-shrink-0"></div>
                                        <div>
                                            <h6 class="mb-4 text-sm">{{ $notification->title }}</h6>
                                            <p class="text-secondary-light text-xs mb-0">{{ Str::limit($notification->message, 60) }}</p>
                                            <span class="text-secondary-light text-xs mt-2">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-secondary-light">No recent notifications</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Quick Actions</h6>
                        </div>
                        <div class="p-20">
                            <div class="row gy-3">
                                <div class="col-6">
                                    <a href="{{ route('students.create') }}" class="btn btn-primary-600 w-100 d-flex align-items-center gap-2">
                                        <iconify-icon icon="ph:plus" class="text-lg"></iconify-icon>
                                        Add Student
                                    </a>
                                </div>
                                @if(auth()->user()->canManageRoles())
                                <div class="col-6">
                                    <a href="{{ route('users.create') }}" class="btn btn-outline-primary w-100 d-flex align-items-center gap-2">
                                        <iconify-icon icon="ph:user-plus" class="text-lg"></iconify-icon>
                                        Add User
                                    </a>
                                </div>
                                @endif
                                <div class="col-6">
                                    <a href="{{ route('students.sent-for-application') }}" class="btn btn-warning-600 w-100 d-flex align-items-center gap-2">
                                        <iconify-icon icon="ph:file-text" class="text-lg"></iconify-icon>
                                        Applications
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('students.application-completed') }}" class="btn btn-success-600 w-100 d-flex align-items-center gap-2">
                                        <iconify-icon icon="ph:check-circle" class="text-lg"></iconify-icon>
                                        Completed
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Counselors -->
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Top Counselors</h6>
                        </div>
                        <div class="ps-20 pt-20 pb-20">
                            <div class="pe-20 d-flex flex-column gap-20">
                                @forelse($topCounselors ?? [] as $counselor)
                                <div class="d-flex align-items-center justify-content-between gap-16">
                                    <div class="d-flex align-items-start gap-16">
                                        @if($counselor->profile_picture)
                                            <img src="{{ $counselor->profile_picture_url }}" alt="{{ $counselor->name }}" class="w-40-px h-40-px rounded-circle object-fit-cover flex-shrink-0">
                                        @else
                                            <div class="w-40-px h-40-px bg-primary-100 rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                {{ strtoupper(substr($counselor->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $counselor->name }}</h6>
                                            <span class="text-secondary-light text-xs mb-0">{{ $counselor->student_count }} Students</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-secondary-light">No counselors found</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Application Staff -->
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Top Application Staff</h6>
                        </div>
                        <div class="ps-20 pt-20 pb-20">
                            <div class="pe-20 d-flex flex-column gap-20">
                                @forelse($topApplicationStaff ?? [] as $staff)
                                <div class="d-flex align-items-center justify-content-between gap-16">
                                    <div class="d-flex align-items-start gap-16">
                                        @if($staff->profile_picture)
                                            <img src="{{ $staff->profile_picture_url }}" alt="{{ $staff->name }}" class="w-40-px h-40-px rounded-circle object-fit-cover flex-shrink-0">
                                        @else
                                            <div class="w-40-px h-40-px bg-success-100 rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                {{ strtoupper(substr($staff->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $staff->name }}</h6>
                                            <span class="text-secondary-light text-xs mb-0">{{ $staff->student_count }} Students</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-secondary-light">No application staff found</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection