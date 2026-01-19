@extends('layouts.admin.master')

@section('title', 'My Students')

@section('content')
<div class="dashboard-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>My Students</h4>
        <a href="{{ route('students.create') }}" class="btn btn-primary-600 d-flex align-items-center gap-6">
            <span class="d-flex text-md">
                <i class="ri-add-large-line"></i>
            </span>
            Add Student
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Document Completion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $student->status === 'Documents Completed' ? 'success' : 
                                    (in_array($student->status, ['Documents Pending']) ? 'warning' : 'primary')
                                }}">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td>
                                @php $completion = $student->getDocumentCompletionPercentage(); @endphp
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-{{ $completion == 100 ? 'success' : ($completion >= 50 ? 'warning' : 'danger') }}" 
                                         role="progressbar" style="width: {{ $completion }}%">
                                        {{ $completion }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info">View</a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                
                                @if($student->getDocumentCompletionPercentage() == 100 && $student->status !== 'Sent to Application')
                                    <form action="{{ route('students.send-to-application', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Send to Application</button>
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