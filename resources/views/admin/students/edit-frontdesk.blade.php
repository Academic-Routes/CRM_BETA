@extends('layouts.admin.master')

@section('title', 'Edit Student - FrontDesk')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Edit Student - Status Management</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <a href="{{ route('students.index') }}" class="text-secondary-light hover-text-primary hover-underline"> / Students</a>
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
                        <h6 class="text-lg fw-semibold mb-0">Student Information (Read Only)</h6>
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
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Current Status</label>
                                <p class="text-secondary-light">
                                    <span class="badge bg-primary">{{ $student->status }}</span>
                                </p>
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
                            <div class="col-md-3">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Current Counselor</label>
                                <p class="text-secondary-light">{{ $student->counselor ? $student->counselor->name : 'Not Assigned' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Management (FrontDesk Only) -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h6 class="text-lg fw-semibold mb-0">Status Management</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="status" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Status</label>
                                <select name="status" class="form-control form-select" id="status">
                                    <option value="New" {{ $student->status == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Assigned to Counselor" {{ $student->status == 'Assigned to Counselor' ? 'selected' : '' }}>Assigned to Counselor</option>
                                    <option value="Documents Pending" {{ $student->status == 'Documents Pending' ? 'selected' : '' }}>Documents Pending</option>
                                    <option value="Documents Completed" {{ $student->status == 'Documents Completed' ? 'selected' : '' }}>Documents Completed</option>
                                    <option value="On Hold" {{ $student->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="counselor_id" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Assign to Counselor</label>
                                <select name="counselor_id" class="form-control form-select" id="counselor_id">
                                    <option value="">Select Counselor</option>
                                    @foreach($counselors as $counselor)
                                        <option value="{{ $counselor->id }}" {{ $student->counselor_id == $counselor->id ? 'selected' : '' }}>
                                            {{ $counselor->name }}
                                        </option>
                                    @endforeach
                                </select>
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