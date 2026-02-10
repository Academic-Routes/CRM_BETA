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
                        @if($student->$field)
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-3 text-center">
                                    @php
                                        $extension = pathinfo($student->$field, PATHINFO_EXTENSION);
                                    @endphp
                                    <h6 class="mb-3 fw-semibold text-dark">{{ $label }}</h6>
                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <div style="width: 120px; height: 120px; background: url('{{ route('students.preview-document', [$student, $field]) }}') center/cover; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px;"></div>
                                    @elseif(strtolower($extension) === 'pdf')
                                        <div style="width: 120px; height: 120px; background: url('{{ route('students.thumbnail-document', [$student, $field]) }}') center/cover; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px;"></div>
                                    @else
                                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #6c757d, #5a6268); border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-alt" style="font-size: 48px; color: white;"></i>
                                        </div>
                                    @endif
                                    <span class="badge bg-primary mb-2">{{ strtoupper($extension) }}</span>
                                    <div class="btn-group w-100 mt-2" role="group">
                                        <button class="btn btn-outline-primary btn-sm preview-doc" data-preview="{{ route('students.preview-document', [$student, $field]) }}" data-download="{{ route('students.download-document', [$student, $field]) }}" data-title="{{ $label }}" data-type="{{ strtolower($extension) }}">
                                            <i class="ri-eye-line"></i> Preview
                                        </button>
                                        <a href="{{ route('students.download-document', [$student, $field]) }}" class="btn btn-outline-success btn-sm">
                                            <i class="ri-download-line"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Documents -->
        @if($student->academic_documents)
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
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3 text-center">
                                            @php
                                                $extension = pathinfo($doc['file'], PATHINFO_EXTENSION);
                                            @endphp
                                            <h6 class="mb-3 fw-semibold text-dark">{{ $doc['name'] }}</h6>
                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                <div style="width: 120px; height: 120px; background: url('{{ route('students.preview-additional-document', [$student, $index]) }}') center/cover; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px;"></div>
                                            @elseif(strtolower($extension) === 'pdf')
                                                <div style="width: 120px; height: 120px; background: url('{{ route('students.thumbnail-additional-document', [$student, $index]) }}') center/cover; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px;"></div>
                                            @else
                                                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #6c757d, #5a6268); border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-file-alt" style="font-size: 48px; color: white;"></i>
                                                </div>
                                            @endif
                                            <span class="badge bg-secondary mb-2">{{ strtoupper($extension) }}</span>
                                            <div class="btn-group w-100 mt-2" role="group">
                                                <button class="btn btn-outline-primary btn-sm preview-doc" data-preview="{{ route('students.preview-additional-document', [$student, $index]) }}" data-download="{{ route('students.download-additional-document', [$student, $index]) }}" data-title="{{ $doc['name'] }}" data-type="{{ strtolower($extension) }}">
                                                    <i class="ri-eye-line"></i> Preview
                                                </button>
                                                <a href="{{ route('students.download-additional-document', [$student, $index]) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="ri-download-line"></i> Download
                                                </a>
                                            </div>
                                        </div>
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

        <!-- Academic Documents -->
        @if($student->academic_documents)
        <div class="col-lg-12">
            <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Academic Documents</h6>
                </div>
                <div class="card-body p-20">
                    @php
                        $academicDocs = is_string($student->academic_documents) ? json_decode($student->academic_documents, true) : $student->academic_documents;
                        $levelLabels = [
                            'class10' => 'Class 10 Documents',
                            'grade12' => '+2/Grade 12 Documents',
                            'diploma' => 'Diploma Documents',
                            'bachelor' => 'Bachelor Documents',
                            'masters' => 'Masters Documents'
                        ];
                    @endphp
                    @if($academicDocs && count($academicDocs) > 0)
                        @foreach($academicDocs as $level => $documents)
                            @if($documents && count($documents) > 0)
                            <div class="mb-4">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">{{ $levelLabels[$level] ?? ucfirst($level) . ' Documents' }}</h6>
                                <div class="row gy-3">
                                    @foreach($documents as $index => $docPath)
                                    <div class="col-md-3 mb-3">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body p-3 text-center">
                                                @php
                                                    $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                                                @endphp
                                                <h6 class="mb-3 fw-semibold text-dark">Document {{ $index + 1 }}</h6>
                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <div style="width: 120px; height: 120px; background: url('{{ route('students.preview-academic-document', [$student, $level, $index]) }}') center/cover; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px;"></div>
                                                @elseif(strtolower($extension) === 'pdf')
                                                    <div style="width: 120px; height: 120px; background: url('{{ route('students.thumbnail-academic-document', [$student, $level, $index]) }}') center/cover; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px;"></div>
                                                @else
                                                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #6c757d, #5a6268); border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-file-alt" style="font-size: 48px; color: white;"></i>
                                                    </div>
                                                @endif
                                                <span class="badge bg-info mb-2">{{ strtoupper($extension) }}</span>
                                                <div class="btn-group w-100 mt-2" role="group">
                                                    <button class="btn btn-outline-primary btn-sm preview-doc" data-preview="{{ route('students.preview-academic-document', [$student, $level, $index]) }}" data-download="{{ route('students.download-academic-document', [$student, $level, $index]) }}" data-title="{{ $levelLabels[$level] ?? ucfirst($level) }} - Document {{ $index + 1 }}" data-type="{{ strtolower($extension) }}">
                                                        <i class="ri-eye-line"></i> Preview
                                                    </button>
                                                    <a href="{{ route('students.download-academic-document', [$student, $level, $index]) }}" class="btn btn-outline-success btn-sm">
                                                        <i class="ri-download-line"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <p>No academic documents uploaded</p>
                        </div>
                    @endif
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
            const previewUrl = this.getAttribute('data-preview');
            const downloadUrl = this.getAttribute('data-download');
            const fileType = this.getAttribute('data-type');
            const title = this.getAttribute('data-title');
            
            showDocumentModal(previewUrl, fileType, title, downloadUrl);
        });
    });
    
    // Handle additional document previews
    document.querySelectorAll('.preview-additional-doc').forEach(function(button) {
        button.addEventListener('click', function() {
            const fileUrl = this.getAttribute('data-file');
            const fileType = this.getAttribute('data-type');
            const title = this.getAttribute('data-title');
            
            showDocumentModal(fileUrl, fileType, title, fileUrl);
        });
    });
    
    function showDocumentModal(previewUrl, fileType, title, downloadUrl) {
        document.getElementById('documentModalTitle').textContent = title;
        
        const downloadBtn = document.getElementById('downloadBtn');
        downloadBtn.href = downloadUrl;
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
                        <img src="${previewUrl}" style="max-width: 95%; max-height: 95%; object-fit: contain; box-shadow: 0 10px 40px rgba(255,255,255,0.1);">
                    `;
                };
                img.onerror = function() {
                    content.innerHTML = `
                        <div style="padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px;">
                            <h5 style="color: #fff;">Image failed to load</h5>
                            <p style="color: rgba(255,255,255,0.8);">The image could not be displayed.</p>
                            <a href="${downloadUrl}" class="btn btn-light" download="${title}.${fileType}">Download File</a>
                        </div>
                    `;
                };
                img.src = previewUrl;
            } else if (fileType === 'pdf') {
                content.innerHTML = `
                    <iframe src="${previewUrl}" width="100%" height="100%" style="border: none;" 
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"></iframe>
                    <div style="display: none; padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px;">
                        <h5 style="color: #fff;">PDF Preview Unavailable</h5>
                        <p style="color: rgba(255,255,255,0.8);">Click download to view the PDF file.</p>
                        <a href="${downloadUrl}" class="btn btn-light" download="${title}.${fileType}">Download PDF</a>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div style="padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                        <iconify-icon icon="solar:file-text-bold" style="font-size: 64px; color: #fff; margin-bottom: 20px;"></iconify-icon>
                        <h5 style="color: #fff; margin-bottom: 10px;">Preview not available</h5>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">This file type cannot be previewed in the browser.</p>
                        <a href="${downloadUrl}" class="btn btn-light" style="border-radius: 25px; padding: 12px 25px; font-weight: 600;" download="${title}.${fileType}">
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