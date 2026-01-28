@extends('layouts.admin.master')

@section('title', $title)

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div>
            <h6 class="fw-semibold mb-0">{{ $title }}</h6>
            <p class="text-neutral-600 mt-4 mb-0">{{ $staff->name }} - {{ ucfirst($type) }}</p>
        </div>
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <iconify-icon icon="ph:arrow-left" class="me-2"></iconify-icon>
            Back to Dashboard
        </a>
    </div>

    <div class="card radius-12 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                            @if($type === 'application')
                            <th>Counselor</th>
                            @endif
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td class="py-10-px">
                                <div class="d-flex align-items-center">
                                    <div class="w-32-px h-32-px bg-primary-100 rounded-circle d-flex justify-content-center align-items-center me-12">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <h6 class="text-md mb-0 fw-medium">{{ $student->name }}</h6>
                                </div>
                            </td>
                            <td class="py-10-px">
                                <span class="bg-{{ $student->status == 'Completed' ? 'success' : ($student->status == 'New' ? 'warning' : 'primary') }}-100 text-{{ $student->status == 'Completed' ? 'success' : ($student->status == 'New' ? 'warning' : 'primary') }}-600 px-16 py-4 radius-4 fw-medium text-sm">{{ $student->status }}</span>
                            </td>
                            @if($type === 'application')
                            <td class="py-10-px">{{ $student->counselor->name ?? 'Not Assigned' }}</td>
                            @endif
                            <td class="py-10-px">{{ $student->created_at->format('M d, Y') }}</td>
                            <td class="py-10-px">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-outline-primary btn-sm">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $type === 'application' ? '5' : '4' }}" class="text-center py-4">No students found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($students->hasPages())
            <div class="d-flex justify-content-center mt-3 pb-3">
                {{ $students->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection