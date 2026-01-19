@extends('layouts.admin.master')

@section('title', 'Edit Student Status')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Edit Student Status</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <a href="{{ route('students.sent-for-application') }}" class="text-secondary-light hover-text-primary hover-underline"> / Sent for Application</a>
                <span class="text-secondary-light">/ Edit Status</span>
            </div>
        </div>
    </div>

    <form action="{{ route('students.update', $student) }}" method="POST" class="mt-24">
        @csrf
        @method('PUT')
        <div class="row gy-3">
            <!-- Student Info (Read Only) -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Student Information</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Name</label>
                                <p class="text-secondary-light">{{ $student->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Phone</label>
                                <p class="text-secondary-light">{{ $student->phone }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Email</label>
                                <p class="text-secondary-light">{{ $student->email ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Counselor</label>
                                <p class="text-secondary-light">{{ $student->counselor ? $student->counselor->name : 'Not Assigned' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Country</label>
                                <p class="text-secondary-light">{{ $student->interested_country ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Course</label>
                                <p class="text-secondary-light">{{ $student->interested_course ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">University</label>
                                <p class="text-secondary-light">{{ $student->interested_university ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Management -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h6 class="text-lg fw-semibold mb-0">Application Status Management</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="status" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Status</label>
                                <select name="status" class="form-control form-select" id="status" required>
                                    <option value="Sent to Application" {{ $student->status == 'Sent to Application' ? 'selected' : '' }}>Sent to Application</option>
                                    <option value="Application In Review" {{ $student->status == 'Application In Review' ? 'selected' : '' }}>Application In Review</option>
                                    <option value="Completed" {{ $student->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Rejected" {{ $student->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Current Status</label>
                                <p class="text-secondary-light">
                                    <span class="badge bg-warning">{{ $student->status }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8" onclick="window.history.back()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary-600 text-md px-56 py-12 radius-8">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection