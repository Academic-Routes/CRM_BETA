@extends('layouts.admin.master')

@section('title', 'Application Completed')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Application Completed</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <span class="text-secondary-light">/ Application Completed</span>
            </div>
        </div>
    </div>

    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Completed Applications</h5>
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                        <thead>
                            <tr>
                                <th scope="col">S.N.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Country</th>
                                <th scope="col">Course</th>
                                <th scope="col">Application Staff</th>
                                <th scope="col">Completed Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->email ?? 'N/A' }}</td>
                                <td>{{ $student->interested_country ?? 'N/A' }}</td>
                                <td>{{ $student->interested_course ?? 'N/A' }}</td>
                                <td>{{ $student->applicationStaff->name ?? 'Not Assigned' }}</td>
                                <td>{{ $student->updated_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $students->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <iconify-icon icon="solar:check-circle-outline" class="text-primary-600 mb-3" style="font-size: 4rem;"></iconify-icon>
                    <h5 class="text-secondary-light">No completed applications yet</h5>
                    <p class="text-secondary-light">Applications completed by the Application team will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection