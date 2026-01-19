@extends('layouts.admin.master')

@section('title', 'All Students')

@section('content')
<div class="dashboard-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>All Students</h4>
        <a href="{{ route('students.create') }}" class="btn btn-primary-600 d-flex align-items-center gap-6">
            <span class="d-flex text-md">
                <i class="ri-add-large-line"></i>
            </span>
            Add Student
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Counselor</label>
                        <select name="counselor_id" class="form-select">
                            <option value="">All Counselors</option>
                            @foreach($counselors as $counselor)
                                <option value="{{ $counselor->id }}" {{ request('counselor_id') == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Application Staff</label>
                        <select name="application_staff_id" class="form-select">
                            <option value="">All Application Staff</option>
                            @foreach($applicationStaff as $staff)
                                <option value="{{ $staff->id }}" {{ request('application_staff_id') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Assigned To</th>
                            <th>Current Department</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                @if($student->application_staff_id && in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed']))
                                    {{ $student->applicationStaff ? $student->applicationStaff->name : 'Not Assigned' }}
                                @else
                                    {{ $student->counselor ? $student->counselor->name : 'Not Assigned' }}
                                @endif
                            </td>
                            <td>
                                @if(in_array($student->status, ['New', 'Assigned to Counselor', 'Documents Pending', 'Documents Completed']))
                                    <span class="badge bg-info">Counselor</span>
                                @elseif(in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed']))
                                    <span class="badge bg-warning">Application</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ 
                                    $student->status === 'Completed' ? 'success' : 
                                    (in_array($student->status, ['Rejected', 'On Hold']) ? 'danger' : 
                                    (in_array($student->status, ['Sent to Application', 'Application In Review']) ? 'warning' : 'primary'))
                                }}">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info">View</a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection