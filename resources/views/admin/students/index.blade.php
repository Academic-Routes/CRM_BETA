@extends('layouts.admin.master')

@section('title', 'Students')

@section('content')
<div class="dashboard-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Students</h4>
        @if(auth()->user()->hasRole('Counselor') || auth()->user()->hasRole('FrontDesk') || auth()->user()->canManageRoles())
            <a href="{{ route('students.create') }}" class="btn btn-primary-600 d-flex align-items-center gap-6">
                <span class="d-flex text-md">
                    <i class="ri-add-large-line"></i>
                </span>
                Add Student
            </a>
        @endif
    </div>

    <!-- Search Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or phone number" value="{{ request('search') }}">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary me-2">Search</button>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Clear</a>
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
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Assigned Counselor</th>
                            <th>Current Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        <tr>
                            <td>{{ $students->firstItem() + $index }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->counselor ? $student->counselor->name : 'Not Assigned' }}</td>
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
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info">View</a>
                                
                                @if(auth()->user()->canManageRoles() || (auth()->user()->hasRole('Counselor') && $student->counselor_id === auth()->id()) || auth()->user()->hasRole('FrontDesk'))
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                @endif
                                
                                @if(auth()->user()->canManageRoles())
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $students->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection