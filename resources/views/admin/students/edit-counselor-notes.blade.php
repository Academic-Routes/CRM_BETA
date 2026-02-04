@extends('layouts.admin.master')

@section('title', 'Add Note - ' . $student->name)

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Add Note</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <a href="{{ route('students.index') }}" class="text-secondary-light hover-text-primary hover-underline"> / Students</a>
                <span class="text-secondary-light">/ Add Note</span>
            </div>
        </div>
        <div class="">
            <a href="{{ route('students.index') }}" class="btn btn-primary-600">Back to Students</a>
        </div>
    </div>

    <div class="row gy-4">
        <!-- Student Info Card -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Student Information</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        <div class="col-md-3">
                            <strong>Name:</strong> {{ $student->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>Phone:</strong> {{ $student->phone }}
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ in_array($student->status, ['Completed']) ? 'success' : 'primary' }}">
                                {{ $student->status }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong>Application Staff:</strong> {{ $student->applicationStaff ? $student->applicationStaff->name : 'Not assigned' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Note Form -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Add Counselor Note</h6>
                </div>
                <div class="card-body p-24">
                    <form action="{{ route('students.update', $student) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-20">
                            <label for="counselor_note" class="form-label fw-semibold text-primary-light text-sm mb-8">Note <span class="text-danger-600">*</span></label>
                            <textarea name="counselor_note" id="counselor_note" class="form-control radius-8" rows="5" placeholder="Enter your note here..." required></textarea>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <a href="{{ route('students.index') }}" class="btn btn-outline-primary-600 radius-8 px-20 py-11">Cancel</a>
                            <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">Add Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Notes -->
        @if($student->notes && $student->notes->count() > 0)
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Existing Notes</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        @foreach($student->notes->groupBy('type') as $type => $notes)
                            <div class="col-md-6">
                                <h6 class="text-md fw-semibold mb-3 text-{{ $type == 'counselor' ? 'primary' : 'success' }}">{{ ucfirst($type) }} Notes</h6>
                                @foreach($notes as $note)
                                    <div class="border border-{{ $type == 'counselor' ? 'primary' : 'success' }}-200 rounded-8 p-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <small class="text-{{ $type == 'counselor' ? 'primary' : 'success' }} fw-medium">{{ $note->user->name }}</small>
                                            <small class="text-muted">{{ $note->created_at->format('M d, Y H:i') }}</small>
                                        </div>
                                        <p class="mb-0 text-sm">{{ $note->note }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection