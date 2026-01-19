@extends('layouts.admin.master')

@section('title', 'Applications')

@section('content')
<div class="dashboard-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Student Applications</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Assigned To</th>
                            <th>Application Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->applicationStaff ? $student->applicationStaff->name : ($student->counselor ? $student->counselor->name : 'Not Assigned') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $student->status === 'Completed' ? 'success' : 
                                    (in_array($student->status, ['Rejected', 'On Hold']) ? 'danger' : 'warning')
                                }}">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info">Review</a>
                                
                                @if($student->status === 'Sent to Application')
                                    <form action="{{ route('students.update-status', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Application In Review">
                                        <button type="submit" class="btn btn-sm btn-warning">Start Review</button>
                                    </form>
                                @endif
                                
                                @if($student->status === 'Application In Review')
                                    <form action="{{ route('students.update-status', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" class="btn btn-sm btn-success">Complete</button>
                                    </form>
                                @endif
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