@extends('layouts.admin.master')

@section('title', 'Application Dashboard')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div>
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <p class="text-neutral-600 mt-4 mb-0">Application -> Process student applications and manage university submissions.</p>
        </div>
    </div>

    <div class="mt-24">
        <div class="row gy-4">
            <!-- Dashboard widgets start -->
            <div class="col-xxl-7">
                <div class="card radius-12 border-0 h-100">
                    <div class="card-body p-24">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="radius-8 overflow-hidden position-relative z-1 h-100 py-32 px-20 text-center d-flex justify-content-center align-items-center bg-success-600">
                                    <div>
                                        <span class="mb-12">
                                            @if(auth()->user()->profile_picture)
                                                <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile" class="w-80-px h-80-px rounded-circle object-fit-cover">
                                            @else
                                                <div class="w-80-px h-80-px bg-white bg-opacity-20 rounded-circle d-flex justify-content-center align-items-center mx-auto">
                                                    <span class="text-white text-2xl fw-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </span>
                                        <h6 class="text-white">{{ auth()->user()->name }}</h6>
                                        <span class="text-white text-lg d-block">Application Staff</span>
                                        <span class="text-white text-lg d-block">University Applications</span>
                                        <div class="mt-12">
                                            <a href="{{ route('profile') }}" class="px-20 py-8 text-white bg-white bg-opacity-10 radius-6 fw-medium text-lg">Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row g-3">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 py-24 px-16 text-center bg-warning-100">
                                            <span class="w-48-px h-48-px d-inline-flex justify-content-center align-items-center rounded-circle border border-warning-300 bg-warning-200">
                                                <iconify-icon icon="ph:clock" class="text-warning-600 text-xl"></iconify-icon>
                                            </span>
                                            <span class="text-secondary-light fw-medium d-block mt-12">Pending Applications</span>
                                            <h5 class="text-primary-light">{{ $pendingApplications }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 py-24 px-16 text-center bg-primary-100">
                                            <span class="w-48-px h-48-px d-inline-flex justify-content-center align-items-center rounded-circle border border-primary-300 bg-primary-200">
                                                <iconify-icon icon="ph:user-check" class="text-primary-600 text-xl"></iconify-icon>
                                            </span>
                                            <span class="text-secondary-light fw-medium d-block mt-12">My Applications</span>
                                            <h5 class="text-primary-light">{{ $myApplications }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 py-24 px-16 text-center bg-success-100">
                                            <span class="w-48-px h-48-px d-inline-flex justify-content-center align-items-center rounded-circle border border-success-300 bg-success-200">
                                                <iconify-icon icon="ph:calendar-check" class="text-success-600 text-xl"></iconify-icon>
                                            </span>
                                            <span class="text-secondary-light fw-medium d-block mt-12">Completed Today</span>
                                            <h5 class="text-primary-light">{{ $completedToday }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 py-24 px-16 text-center bg-purple-100">
                                            <span class="w-48-px h-48-px d-inline-flex justify-content-center align-items-center rounded-circle border border-purple-300 bg-purple-200">
                                                <iconify-icon icon="ph:trophy" class="text-purple-600 text-xl"></iconify-icon>
                                            </span>
                                            <span class="text-secondary-light fw-medium d-block mt-12">Total Completed</span>
                                            <h5 class="text-primary-light">{{ $totalCompleted }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard widgets end -->

            <!-- Quick Actions -->
            <div class="col-xxl-5">
                <div class="card radius-12 border-0 h-100">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between py-12 px-20 border-bottom border-neutral-200">
                        <h6 class="mb-2 fw-bold text-lg">Quick Actions</h6>
                    </div>
                    <div class="card-body py-24 d-flex flex-column justify-content-center">
                        <div class="row g-3">
                            <div class="col-12">
                                <a href="{{ route('students.sent-for-application') }}" class="btn btn-primary-600 w-100 d-flex align-items-center gap-2 py-12">
                                    <iconify-icon icon="ph:file-text" class="text-lg"></iconify-icon>
                                    View Pending Applications
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('students.application-completed') }}" class="btn btn-success-600 w-100 d-flex align-items-center gap-2 py-12">
                                    <iconify-icon icon="ph:check-circle" class="text-lg"></iconify-icon>
                                    Completed Applications
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('notifications.index') }}" class="btn btn-warning-600 w-100 d-flex align-items-center gap-2 py-12">
                                    <iconify-icon icon="ph:bell" class="text-lg"></iconify-icon>
                                    View Notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="col-xxl-8">
                <div class="card radius-12 border-0">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between py-12 px-20 border-bottom border-neutral-200">
                        <h6 class="mb-2 fw-bold text-lg">Recent Applications</h6>
                        <a href="{{ route('students.sent-for-application') }}" class="btn btn-primary-600 btn-sm">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Counselor</th>
                                        <th>Status</th>
                                        <th>Received</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $student)
                                    <tr>
                                        <td class="py-10-px">
                                            <div class="d-flex align-items-center">
                                                <div class="w-32-px h-32-px bg-primary-100 rounded-circle d-flex justify-content-center align-items-center me-12">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <h6 class="text-md mb-0 fw-medium">{{ $student->name }}</h6>
                                            </div>
                                        </td>
                                        <td class="py-10-px">{{ $student->counselor->name ?? 'Not Assigned' }}</td>
                                        <td class="py-10-px">
                                            <span class="bg-{{ $student->status == 'Application In Review' ? 'warning' : 'primary' }}-100 text-{{ $student->status == 'Application In Review' ? 'warning' : 'primary' }}-600 px-16 py-4 radius-4 fw-medium text-sm">{{ $student->status }}</span>
                                        </td>
                                        <td class="py-10-px">{{ $student->created_at->format('M d, Y') }}</td>
                                        <td class="py-10-px">
                                            <a href="{{ route('students.show', $student) }}" class="btn btn-outline-primary btn-sm">Process</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No applications found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="col-xxl-4">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Recent Notifications</h6>
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                        </div>
                        <div class="ps-20 pt-20 pb-20">
                            @if($recentNotifications->count() > 0)
                                <div class="pe-20 d-flex flex-column gap-20 max-h-462-px overflow-y-auto scroll-sm">
                                    @foreach($recentNotifications as $notification)
                                    <div class="d-flex align-items-start gap-16">
                                        <div class="w-40-px h-40-px bg-success-100 rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-4 text-lg">{{ $notification->title }}</h6>
                                            <p class="text-secondary-light text-sm mb-0">{{ Str::limit($notification->message, 60) }}</p>
                                            <span class="text-secondary-light text-sm mb-0 mt-4">{{ $notification->created_at->diffForHumans() }}</span>
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
        </div>
    </div>
</div>
@endsection