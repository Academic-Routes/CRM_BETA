@extends('layouts.admin.master')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Sent for Application</h6>
    </div>

    <div class="card basic-data-table">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
                    <thead>
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Counselor</th>
                            <th scope="col">Application Staff</th>
                            <th scope="col">Status</th>
                            <th scope="col">Sent Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        <tr>
                            <td>{{ $students->firstItem() + $index }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->email ?? 'N/A' }}</td>
                            <td>{{ $student->counselor ? $student->counselor->name : 'Not Assigned' }}</td>
                            <td>{{ $student->applicationStaff ? $student->applicationStaff->name : 'Not Assigned' }}</td>
                            <td>
                                <span class="badge bg-warning">{{ $student->status }}</span>
                            </td>
                            <td>{{ $student->updated_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-10">
                                    <a href="{{ route('students.show', $student) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </a>
                                    @if(auth()->user()->canManageRoles() || (auth()->user()->hasRole('Counselor') && $student->counselor_id === auth()->id()) || auth()->user()->hasRole('Application'))
                                    <a href="{{ route('students.edit', $student) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection