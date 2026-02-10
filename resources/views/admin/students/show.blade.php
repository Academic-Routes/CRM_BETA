@extends('layouts.admin.master')

@section('title', 'View Student')

@push('styles')
<style>
.university-card {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border: 1px solid rgba(99, 102, 241, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.university-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
}

.university-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.15);
    border-color: rgba(99, 102, 241, 0.2);
}

.course-item {
    transition: all 0.2s ease;
    border: 1px solid #e5e7eb;
}

.course-item:hover {
    background: #f8fafc;
    border-color: #d1d5db;
    transform: translateX(4px);
}

.courses-list {
    max-height: 300px;
    overflow-y: auto;
}

.courses-list::-webkit-scrollbar {
    width: 4px;
}

.courses-list::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 2px;
}

.courses-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.courses-list::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">View Student</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <a href="{{ route('students.index') }}" class="text-secondary-light hover-text-primary hover-underline"> / Students</a>
                <span class="text-secondary-light">/ View Student</span>
            </div>
        </div>
        <div class="">
            @if(auth()->user()->hasRole('Application'))
                <a href="{{ route('students.sent-for-application') }}" class="btn btn-primary-600">Back to Applications</a>
            @else
                <a href="{{ route('students.index') }}" class="btn btn-primary-600">Back to Students</a>
            @endif
        </div>
    </div>

    <div class="row gy-3">
        <!-- Personal Info -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Personal Information</h6>
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
                            <strong>Email:</strong> {{ $student->email ?? 'Not provided' }}
                        </div>
                        @if($student->application_email)
                        <div class="col-md-3">
                            <strong>Application Email:</strong> {{ $student->application_email }}
                        </div>
                        @endif
                        <div class="col-md-3">
                            <strong>Gender:</strong> {{ $student->gender ?? 'Not provided' }}
                        </div>
                        <div class="col-md-3">
                            <strong>Date of Birth:</strong> {{ $student->date_of_birth ?? 'Not provided' }}
                        </div>
                        <div class="col-md-9">
                            <strong>Address:</strong> {{ $student->address ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Educational Info -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Educational Information</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <strong>Last Qualification:</strong> {{ $student->last_qualification ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Last Score:</strong> {{ $student->last_score ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Passed Year:</strong> {{ $student->passed_year ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Interested Country:</strong> {{ $student->interested_country ?? 'Not provided' }}
                        </div>
                        <div class="col-md-8">
                            <strong>English Test:</strong> {{ $student->english_test ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>English Test Score:</strong> {{ $student->english_test_score ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Universities and Courses -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Universities & Courses</h6>
                </div>
                <div class="card-body p-24">
                    @if($student->universities && $student->universities->count() > 0)
                        <div class="row g-4">
                            @foreach($student->universities->groupBy('university_name') as $universityName => $courses)
                                <div class="col-lg-6 col-xl-4">
                                    <div class="university-card bg-gradient-primary-light border-0 rounded-12 p-20 h-100">
                                        <div class="d-flex align-items-center mb-16">
                                            <div class="w-40-px h-40-px bg-primary-600 rounded-circle d-flex align-items-center justify-content-center me-12">
                                                <iconify-icon icon="ph:graduation-cap" class="text-white text-xl"></iconify-icon>
                                            </div>
                                            <h6 class="text-primary-600 fw-semibold mb-0 flex-grow-1">{{ $universityName }}</h6>
                                        </div>
                                        <div class="courses-list">
                                            <p class="text-sm text-secondary-light mb-8 fw-medium">Courses ({{ $courses->count() }})</p>
                                            <div class="d-flex flex-column gap-8">
                                                @foreach($courses as $course)
                                                    <div class="course-item bg-white rounded-8 px-12 py-8 border border-neutral-200">
                                                        <div class="d-flex align-items-center">
                                                            <div class="w-6-px h-6-px bg-success-600 rounded-circle me-8"></div>
                                                            <span class="text-sm text-neutral-700 fw-medium">{{ $course->course_name }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-40">
                            <div class="w-80-px h-80-px bg-neutral-100 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-16">
                                <iconify-icon icon="ph:graduation-cap" class="text-neutral-400 text-3xl"></iconify-icon>
                            </div>
                            <h6 class="text-neutral-600 mb-8">No Universities Selected</h6>
                            <p class="text-neutral-400 text-sm mb-0">No universities and courses have been specified for this student</p>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">System Information</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ in_array($student->status, ['Completed']) ? 'success' : (in_array($student->status, ['Rejected', 'On Hold']) ? 'danger' : 'primary') }}">
                                {{ $student->status }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong>Counselor:</strong> {{ $student->counselor ? $student->counselor->name : 'Not assigned' }}
                        </div>
                        <div class="col-md-3">
                            <strong>Submitted:</strong> {{ $student->submitted ? 'Yes' : 'No' }}
                        </div>
                        <div class="col-md-3">
                            <strong>Created:</strong> {{ $student->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Documents -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Personal Documents</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        @php
                            $personalDocs = [
                                'passport' => 'Passport',
                                'lor' => 'Letter of Recommendation',
                                'moi' => 'MOI',
                                'cv' => 'CV/Resume',
                                'sop' => 'Statement of Purpose',
                                'transcripts' => 'Transcripts',
                                'english_test_doc' => 'English Test Document',
                                'financial_docs' => 'Financial Documents',
                                'birth_certificate' => 'Birth Certificate',
                                'medical_certificate' => 'Medical Certificate',
                                'student_photo' => 'Student Photo'
                            ];
                        @endphp
                        @foreach($personalDocs as $field => $label)
                        <div class="col-md-3 mb-3">
                            <strong>{{ $label }}:</strong><br>
                            @if($student->$field)
                                @php
                                    $extension = pathinfo($student->$field, PATHINFO_EXTENSION);
                                @endphp
                                <div class="text-center">
                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <div style="width: 80px; height: 80px; background: url('{{ route('students.thumbnail', [$student, $field]) }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto;"></div><br>
                                    @elseif(strtolower($extension) === 'pdf')
                                        <div style="width: 80px; height: 80px; background: url('{{ route('students.thumbnail', [$student, $field]) }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto; position: relative;">
                                            <div style="position: absolute; bottom: 3px; right: 3px; background: rgba(220,53,69,0.9); border-radius: 3px; padding: 1px 4px; font-size: 9px; font-weight: bold; color: white;">PDF</div>
                                        </div><br>
                                    @else
                                        <div style="width: 80px; height: 80px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fas fa-file-alt" style="font-size: 24px; color: #6c757d;"></i>
                                        </div><br>
                                    @endif
                                    <small>{{ strtoupper($extension) }}</small><br>
                                    <button class="btn btn-sm btn-primary mt-1 preview-doc" data-file="{{ route('students.download-document', [$student, $field]) }}" data-title="{{ $label }}" data-type="{{ strtolower($extension) }}">Preview</button>
                                </div>
                            @else
                                <span class="text-muted">Not uploaded</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Class 10 Documents -->
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Class 10 Documents</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        @php
                            $class10Docs = [
                                'class10_marksheet' => 'Marksheet',
                                'class10_certificate' => 'Certificate',
                                'class10_character' => 'Character Certificate'
                            ];
                        @endphp
                        @foreach($class10Docs as $field => $label)
                        <div class="col-md-3 mb-3">
                            <strong>{{ $label }}:</strong><br>
                            @if($student->$field)
                                @php
                                    $extension = pathinfo($student->$field, PATHINFO_EXTENSION);
                                @endphp
                                <div class="text-center">
                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <div style="width: 80px; height: 80px; background: url('{{ route('students.thumbnail', [$student, $field]) }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto;"></div><br>
                                    @elseif(strtolower($extension) === 'pdf')
                                        <div style="width: 80px; height: 80px; background: url('{{ route('students.thumbnail', [$student, $field]) }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto; position: relative;">
                                            <div style="position: absolute; bottom: 3px; right: 3px; background: rgba(220,53,69,0.9); border-radius: 3px; padding: 1px 4px; font-size: 9px; font-weight: bold; color: white;">PDF</div>
                                        </div><br>
                                    @else
                                        <div style="width: 80px; height: 80px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fas fa-file-alt" style="font-size: 24px; color: #6c757d;"></i>
                                        </div><br>
                                    @endif
                                    <small>{{ strtoupper($extension) }}</small><br>
                                    <button class="btn btn-sm btn-primary mt-1 preview-doc" data-file="{{ route('students.download-document', [$student, $field]) }}" data-title="{{ $label }}" data-type="{{ strtolower($extension) }}">Preview</button>
                                </div>
                            @else
                                <span class="text-muted">Not uploaded</span>
                            @endif
                        </div>
                        @endforeach
                        @if($student->class10_other_name && $student->class10_other_file)
                        <div class="col-md-3 mb-3">
                            <strong>{{ $student->class10_other_name }}:</strong><br>
                            @php
                                $extension = pathinfo($student->class10_other_file, PATHINFO_EXTENSION);
                            @endphp
                            <div class="text-center">
                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <div style="width: 80px; height: 80px; background: url('{{ route('students.thumbnail', [$student, 'class10_other_file']) }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto;"></div><br>
                                @elseif(strtolower($extension) === 'pdf')
                                    <div style="width: 80px; height: 80px; background: url('{{ route('students.thumbnail', [$student, 'class10_other_file']) }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto; position: relative;">
                                        <div style="position: absolute; bottom: 3px; right: 3px; background: rgba(220,53,69,0.9); border-radius: 3px; padding: 1px 4px; font-size: 9px; font-weight: bold; color: white;">PDF</div>
                                    </div><br>
                                @else
                                    <div style="width: 80px; height: 80px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-file-alt" style="font-size: 24px; color: #6c757d;"></i>
                                    </div><br>
                                @endif
                                <small>{{ strtoupper($extension) }}</small><br>
                                <button class="btn btn-sm btn-primary mt-1 preview-doc" data-file="{{ route('students.download-document', [$student, 'class10_other_file']) }}" data-title="{{ $student->class10_other_name }}" data-type="{{ strtolower($extension) }}">Preview</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        @if($student->notes && $student->notes->count() > 0)
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Notes</h6>
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

        <!-- Additional Documents -->
        @if($student->additional_documents)
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Additional Documents</h6>
                </div>
                <div class="card-body p-20">
                    <div class="row gy-3">
                        @php
                            $additionalDocs = is_string($student->additional_documents) ? json_decode($student->additional_documents, true) : $student->additional_documents;
                        @endphp
                        @if($additionalDocs && count($additionalDocs) > 0)
                            @foreach($additionalDocs as $index => $doc)
                                @if(isset($doc['name']) && isset($doc['file']))
                                <div class="col-md-3 mb-3">
                                    <strong>{{ $doc['name'] }}:</strong><br>
                                    @php
                                        $extension = pathinfo($doc['file'], PATHINFO_EXTENSION);
                                        $fileUrl = url('/storage/' . $doc['file']);
                                    @endphp
                                    <div class="text-center">
                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                            <div style="width: 80px; height: 80px; background: url('{{ $fileUrl }}') center/cover; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto;"></div><br>
                                        @elseif(strtolower($extension) === 'pdf')
                                            <div style="width: 80px; height: 80px; background: #dc3545; border: 1px solid #ddd; border-radius: 4px; margin: 0 auto; display: flex; align-items: center; justify-content: center; position: relative;">
                                                <i class="fas fa-file-pdf" style="font-size: 24px; color: white;"></i>
                                                <div style="position: absolute; bottom: 3px; right: 3px; background: rgba(220,53,69,0.9); border-radius: 3px; padding: 1px 4px; font-size: 9px; font-weight: bold; color: white;">PDF</div>
                                            </div><br>
                                        @else
                                            <div style="width: 80px; height: 80px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                                <i class="fas fa-file-alt" style="font-size: 24px; color: #6c757d;"></i>
                                            </div><br>
                                        @endif
                                        <small>{{ strtoupper($extension) }}</small><br>
                                        <button class="btn btn-sm btn-primary mt-1 preview-additional-doc" data-file="{{ $fileUrl }}" data-title="{{ $doc['name'] }}" data-type="{{ strtolower($extension) }}">Preview</button>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-12">
                                <span class="text-muted">No additional documents uploaded</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="documentModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="border-radius: 0; box-shadow: none; border: none; height: 100vh;">
            <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 20px; right: 20px; z-index: 1050; background: rgba(255,255,255,0.95); border-radius: 50%; width: 45px; height: 45px; box-shadow: 0 4px 15px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; color: #333; border: 2px solid rgba(255,255,255,0.8);" onmouseover="this.style.background='rgba(255,255,255,1)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255,255,255,0.95)'; this.style.transform='scale(1)'">×</button>
            
            <div class="position-absolute" style="top: 20px; left: 20px; z-index: 1050;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white px-3 py-2 rounded-pill shadow" style="backdrop-filter: blur(10px);">
                        <iconify-icon icon="solar:document-text-bold" class="me-2 text-primary"></iconify-icon>
                        <span class="fw-semibold text-dark" id="documentModalTitle">Document Preview</span>
                    </div>
                    <a href="#" id="downloadBtn" class="btn btn-success shadow-lg" style="border-radius: 25px; padding: 12px 24px; font-weight: 600; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(40,167,69,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.2)'">
                        <iconify-icon icon="solar:download-bold" class="me-2"></iconify-icon>
                        Download
                    </a>
                </div>
            </div>
            
            <div class="modal-body" style="padding: 80px 20px 20px 20px; background: #000; height: 100vh; display: flex; align-items: center; justify-content: center; position: relative;">
                <div id="documentContent" style="width: 95%; height: 90%; display: flex; align-items: center; justify-content: center;"></div>
                <div id="loadingSpinner" class="d-none" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
                    <p class="mt-3 text-light">Loading document...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle regular document previews
    document.querySelectorAll('.preview-doc').forEach(function(button) {
        button.addEventListener('click', function() {
            const fileUrl = this.getAttribute('data-file');
            const fileType = this.getAttribute('data-type');
            const title = this.getAttribute('data-title');
            
            showDocumentModal(fileUrl, fileType, title);
        });
    });
    
    // Handle additional document previews
    document.querySelectorAll('.preview-additional-doc').forEach(function(button) {
        button.addEventListener('click', function() {
            const fileUrl = this.getAttribute('data-file');
            const fileType = this.getAttribute('data-type');
            const title = this.getAttribute('data-title');
            
            showDocumentModal(fileUrl, fileType, title);
        });
    });
    
    function showDocumentModal(fileUrl, fileType, title) {
        document.getElementById('documentModalTitle').textContent = title;
        
        // Set download with proper filename
        const downloadBtn = document.getElementById('downloadBtn');
        downloadBtn.href = fileUrl;
        downloadBtn.download = title + '.' + fileType;
        
        const content = document.getElementById('documentContent');
        const spinner = document.getElementById('loadingSpinner');
        
        // Show loading spinner
        content.innerHTML = '';
        spinner.classList.remove('d-none');
        
        setTimeout(() => {
            spinner.classList.add('d-none');
            
            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                const img = new Image();
                img.onload = function() {
                    content.innerHTML = `
                        <img src="${fileUrl}" style="max-width: 95%; max-height: 95%; object-fit: contain; box-shadow: 0 10px 40px rgba(255,255,255,0.1);">
                    `;
                };
                img.onerror = function() {
                    content.innerHTML = `
                        <div style="padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px;">
                            <h5 style="color: #fff;">Image failed to load</h5>
                            <p style="color: rgba(255,255,255,0.8);">The image could not be displayed.</p>
                            <a href="${fileUrl}" class="btn btn-light" download="${title}.${fileType}">Download File</a>
                        </div>
                    `;
                };
                img.src = fileUrl;
            } else if (fileType === 'pdf') {
                // Try iframe first, fallback to embed
                content.innerHTML = `
                    <iframe src="${fileUrl}" width="100%" height="100%" style="border: none;" 
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"></iframe>
                    <div style="display: none; padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px;">
                        <h5 style="color: #fff;">PDF Preview Unavailable</h5>
                        <p style="color: rgba(255,255,255,0.8);">Click download to view the PDF file.</p>
                        <a href="${fileUrl}" class="btn btn-light" download="${title}.${fileType}">Download PDF</a>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div style="padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                        <iconify-icon icon="solar:file-text-bold" style="font-size: 64px; color: #fff; margin-bottom: 20px;"></iconify-icon>
                        <h5 style="color: #fff; margin-bottom: 10px;">Preview not available</h5>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">This file type cannot be previewed in the browser.</p>
                        <a href="${fileUrl}" class="btn btn-light" style="border-radius: 25px; padding: 12px 25px; font-weight: 600;" download="${title}.${fileType}">
                            <iconify-icon icon="solar:download-bold" class="me-2"></iconify-icon>
                            Download File
                        </a>
                    </div>
                `;
            }
        }, 800);
        
        const modalElement = document.getElementById('documentModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
});
</script>
@endsection