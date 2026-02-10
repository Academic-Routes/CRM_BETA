@extends('layouts.admin.master')

@section('title', 'Edit Student')

@push('styles')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.university-item {
    transition: all 0.3s ease;
}
.university-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.add-course, .remove-course {
    min-width: 40px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.courses-container .d-flex {
    align-items: center;
}

/* Premium Document Cards */
.document-preview {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.document-preview:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
}
.document-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.document-preview:hover::before {
    opacity: 1;
}
.card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.08) !important;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3) !important;
}
.file-info .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
.btn-group .btn {
    border-radius: 0;
}
.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>
@endpush

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Edit Student</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <a href="{{ route('students.index') }}" class="text-secondary-light hover-text-primary hover-underline"> / Student</a>
                <span class="text-secondary-light">/ Edit Student</span>
            </div>
        </div>
    </div>

    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" class="mt-24">
        @csrf
        @method('PUT')
        <div class="row gy-3">
            <!-- Personal Info -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Personal Info</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="name" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Name <span class="text-danger-600">*</span></label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $student->name }}" required>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="phone" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Phone <span class="text-danger-600">*</span></label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{ $student->phone }}" required>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="email" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ $student->email }}">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="gender" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Gender</label>
                                <select name="gender" class="form-control form-select" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="date_of_birth" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Date of Birth</label>
                                <div class="position-relative">
                                    <input type="text" name="date_of_birth" class="form-control flatpickr" id="date_of_birth" value="{{ $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '' }}" readonly>
                                    <span class="position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light">
                                        <i class="ri-calendar-line"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-8 col-12">
                                <label for="address" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Address</label>
                                <textarea name="address" class="form-control" id="address" rows="2">{{ $student->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Educational Info -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Educational Info</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="last_qualification" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Last Academic Qualification</label>
                                <select name="last_qualification" class="form-control form-select" id="last_qualification">
                                    <option value="">Select Qualification</option>
                                    <option value="+2" {{ $student->last_qualification == '+2' ? 'selected' : '' }}>+2</option>
                                    <option value="Diploma" {{ $student->last_qualification == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="Bachelor" {{ $student->last_qualification == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                                    <option value="Masters" {{ $student->last_qualification == 'Masters' ? 'selected' : '' }}>Masters</option>
                                    <option value="Others" {{ $student->last_qualification == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6" id="other_qualification_div" style="display: {{ $student->last_qualification == 'Others' ? 'block' : 'none' }};">
                                <label for="other_qualification" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Please Specify</label>
                                <input type="text" name="other_qualification" class="form-control" id="other_qualification" value="{{ $student->other_qualification }}">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="last_score" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Last Academic Score</label>
                                <input type="text" name="last_score" class="form-control" id="last_score" value="{{ $student->last_score }}">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="passed_year" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Passed Year</label>
                                <input type="number" name="passed_year" class="form-control" id="passed_year" value="{{ $student->passed_year }}">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="interested_country" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Interested Country</label>
                                <input type="text" name="interested_country" class="form-control" id="interested_country" value="{{ $student->interested_country }}">
                            </div>
                            
                            <!-- Universities and Courses Section -->
                            <div class="col-12">
                                <div class="border border-neutral-200 rounded-8 p-16 mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="text-md fw-semibold mb-0 text-primary-light">Universities & Courses</h6>
                                        <button type="button" id="add-university" class="btn btn-primary-600 btn-sm">
                                            <i class="ri-add-line"></i> Add University
                                        </button>
                                    </div>
                                    <div id="universities-container">
                                        @if($student->universities && $student->universities->count() > 0)
                                            @foreach($student->universities->groupBy('university_name') as $universityName => $courses)
                                                <div class="university-item border border-neutral-100 rounded-6 p-12 mb-3">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="text-sm fw-medium text-secondary-light">University {{ $loop->iteration }}</span>
                                                        <button type="button" class="btn btn-danger-600 btn-sm remove-university" style="display: {{ $loop->first ? 'none' : 'block' }};">Remove</button>
                                                    </div>
                                                    <div class="row gy-2">
                                                        <div class="col-md-6">
                                                            <input type="text" name="universities[]" class="form-control" value="{{ $universityName }}" placeholder="University Name">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="courses-container">
                                                                @foreach($courses as $course)
                                                                    <div class="d-flex gap-2 mb-2">
                                                                        <input type="text" name="courses[{{ $loop->parent->index }}][]" class="form-control" value="{{ $course->course_name }}" placeholder="Course Name">
                                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-course" style="display: {{ $loop->first && $courses->count() == 1 ? 'none' : 'block' }};">-</button>
                                                                    </div>
                                                                @endforeach
                                                                @if($courses->count() == 1)
                                                                    <button type="button" class="btn btn-outline-primary btn-sm add-course">+ Add Course</button>
                                                                @else
                                                                    <button type="button" class="btn btn-outline-primary btn-sm add-course">+ Add Course</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="university-item border border-neutral-100 rounded-6 p-12 mb-3">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-sm fw-medium text-secondary-light">University 1</span>
                                                    <button type="button" class="btn btn-danger-600 btn-sm remove-university" style="display: none;">Remove</button>
                                                </div>
                                                <div class="row gy-2">
                                                    <div class="col-md-6">
                                                        <input type="text" name="universities[]" class="form-control" placeholder="University Name">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="courses-container">
                                                            <div class="d-flex gap-2 mb-2">
                                                                <input type="text" name="courses[0][]" class="form-control" placeholder="Course Name">
                                                                <button type="button" class="btn btn-outline-primary btn-sm add-course">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="english_test" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">English Test</label>
                                <select name="english_test" class="form-control form-select" id="english_test">
                                    <option value="">Select Test</option>
                                    <option value="IELTS" {{ $student->english_test == 'IELTS' ? 'selected' : '' }}>IELTS</option>
                                    <option value="TOEFL" {{ $student->english_test == 'TOEFL' ? 'selected' : '' }}>TOEFL</option>
                                    <option value="PTE" {{ $student->english_test == 'PTE' ? 'selected' : '' }}>PTE</option>
                                    <option value="Duolingo" {{ $student->english_test == 'Duolingo' ? 'selected' : '' }}>Duolingo</option>
                                    <option value="Others" {{ $student->english_test == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6" id="other_english_test_div" style="display: {{ $student->english_test == 'Others' ? 'block' : 'none' }};">
                                <label for="other_english_test" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Please Specify</label>
                                <input type="text" name="other_english_test" class="form-control" id="other_english_test" value="{{ $student->other_english_test }}">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="english_test_score" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">English Test Score</label>
                                <input type="text" name="english_test_score" class="form-control" id="english_test_score" value="{{ $student->english_test_score }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Upload Documents -->
            <div class="col-xl-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Upload Documents</h6>
                        <button type="button" id="add-document-type" class="btn btn-primary-600 btn-sm">
                            <i class="ri-add-line"></i> Add Document
                        </button>
                    </div>
                    <div class="card-body p-20">
                        @php
                            $documentTypes = [
                                'passport' => 'Passport',
                                'lor' => 'Letter of Recommendation (LOR)',
                                'moi' => 'Medium of Instruction',
                                'cv' => 'CV/Resume',
                                'sop' => 'Statement of Purpose (SOP)',
                                'transcripts' => 'Academic Transcripts',
                                'english_test_doc' => 'English Test (IELTS/TOEFL)',
                                'financial_docs' => 'Financial Documents',
                                'birth_certificate' => 'Birth Certificate',
                                'medical_certificate' => 'Medical Certificate',
                                'student_photo' => 'Student Photo'
                            ];
                            $existingDocs = [];
                            foreach($documentTypes as $field => $label) {
                                if($student->$field) {
                                    $existingDocs[$field] = $label;
                                }
                            }
                        @endphp
                        
                        <div id="document-types-container">
                            @if(count($existingDocs) > 0)
                                <div class="row g-3">
                                    @foreach($existingDocs as $field => $label)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card border-0 shadow-sm h-100" data-field="{{ $field }}">
                                            <div class="card-header bg-light border-0 py-3">
                                                <h6 class="mb-0 text-dark fw-semibold">{{ $label }}</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                @php
                                                    $docPath = $student->$field;
                                                    $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                                                    $fileUrl = url('/storage/' . $docPath);
                                                    $fileName = basename($docPath);
                                                @endphp
                                                <div class="text-center mb-3">
                                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <div class="document-preview mb-2" style="width: 80px; height: 80px; background: url('{{ $fileUrl }}') center/cover; border-radius: 8px; margin: 0 auto; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')"></div>
                                                    @elseif(strtolower($extension) === 'pdf')
                                                        <div class="document-preview mb-2" style="width: 80px; height: 80px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(220,53,69,0.3);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', 'pdf')">
                                                            <i class="fas fa-file-pdf" style="font-size: 28px; color: white;"></i>
                                                        </div>
                                                    @else
                                                        <div class="document-preview mb-2" style="width: 80px; height: 80px; background: linear-gradient(135deg, #6c757d, #5a6268); border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(108,117,125,0.3);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')">                                                            <i class="fas fa-file-alt" style="font-size: 28px; color: white;"></i>
                                                        </div>
                                                    @endif
                                                    <div class="file-info">
                                                        <span class="badge bg-primary mb-1">{{ strtoupper($extension) }}</span>
                                                        <p class="small text-muted mb-0">{{ strlen($fileName) > 20 ? substr($fileName, 0, 20) . '...' : $fileName }}</p>
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')">
                                                            <i class="ri-eye-line"></i>
                                                        </button>
                                                        <a href="{{ route('students.download-document', [$student, $field]) }}" class="btn btn-outline-success btn-sm">
                                                            <i class="ri-download-line"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-warning btn-sm replace-document" data-field="{{ $field }}">
                                                            <i class="ri-upload-line"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm delete-document-btn" data-field="{{ $field }}" data-student-id="{{ $student->id }}">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <!-- Additional Documents -->
                            @php
                                $additionalDocs = $student->additional_documents;
                                if (is_string($additionalDocs)) {
                                    $additionalDocs = json_decode($additionalDocs, true);
                                }
                                $additionalDocs = $additionalDocs ?? [];
                            @endphp
                            @if(count($additionalDocs) > 0)
                                <div class="card border-0 shadow-sm mt-4">
                                    <div class="card-header bg-gradient-primary text-white py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-semibold">Additional Documents</h6>
                                            <button type="button" class="btn btn-light btn-sm add-more-additional">
                                                <i class="ri-add-line"></i> Add More
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3" id="additional-docs-container">
                                            @foreach($additionalDocs as $index => $doc)
                                                <div class="col-lg-4 col-md-6 additional-doc-item" data-index="{{ $index }}">
                                                    <div class="card border h-100">
                                                        <div class="card-body p-3 text-center">
                                                            @php
                                                                $docPath = $doc['file'] ?? '';
                                                                $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                                                                $fileUrl = url('/storage/' . $docPath);
                                                                $fileName = $doc['name'] ?? basename($docPath);
                                                            @endphp
                                                            <div class="mb-3">
                                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <div class="document-preview" style="width: 70px; height: 70px; background: url('{{ $fileUrl }}') center/cover; border-radius: 8px; margin: 0 auto; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')"></div>
                                                                @elseif(strtolower($extension) === 'pdf')
                                                                    <div class="document-preview" style="width: 70px; height: 70px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(220,53,69,0.3);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')">                                                                        <i class="fas fa-file-pdf" style="font-size: 24px; color: white;"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="document-preview" style="width: 70px; height: 70px; background: linear-gradient(135deg, #6c757d, #5a6268); border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(108,117,125,0.3);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')">                                                                        <i class="fas fa-file-alt" style="font-size: 24px; color: white;"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="file-info mb-3">
                                                                <span class="badge bg-secondary mb-1">{{ strtoupper($extension) }}</span>
                                                                <h6 class="small fw-semibold mb-0">{{ $fileName }}</h6>
                                                            </div>
                                                            <div class="btn-group w-100" role="group">
                                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')" title="Preview">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                                <a href="{{ route('students.download-additional-document', [$student, $index]) }}" class="btn btn-outline-success btn-sm" title="Download">
                                                                    <i class="ri-download-line"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-outline-danger btn-sm delete-additional-doc-btn" data-index="{{ $index }}" data-student-id="{{ $student->id }}" title="Remove">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if(count($existingDocs) == 0 && count($additionalDocs) == 0)
                                <div class="text-center text-muted py-4" id="no-documents-message">
                                    <p>Click "Add Document" to upload documents</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Academic Documents -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Academic Documents</h6>
                        @if(!$student->academic_documents || (is_array($student->academic_documents) && count($student->academic_documents) == 0))
                            <button type="button" id="add-academic-level" class="btn btn-primary-600 btn-sm">
                                <i class="ri-add-line"></i> Add Academic Level
                            </button>
                        @endif
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
                        
                        <div id="academic-levels-container">
                            @if($academicDocs && count($academicDocs) > 0)
                                <!-- Show existing academic documents with delete functionality -->
                                @foreach($academicDocs as $level => $documents)
                                    @if($documents && count($documents) > 0)
                                    <div class="academic-level-item border border-neutral-200 rounded-8 p-16 mb-3" data-level="{{ $level }}">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-md fw-semibold mb-0 text-primary-light">{{ $levelLabels[$level] ?? ucfirst($level) . ' Documents' }}</h6>
                                            <div>
                                                <button type="button" class="btn btn-primary-600 btn-sm me-2 add-more-to-level" data-level="{{ $level }}">
                                                    <i class="ri-add-line"></i> Add More
                                                </button>
                                                <button type="button" class="btn btn-danger-600 btn-sm delete-academic-level" data-level="{{ $level }}">
                                                    <i class="ri-delete-bin-line"></i> Delete Level
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row gy-3 existing-documents">
                                            @foreach($documents as $index => $docPath)
                                                <div class="col-lg-3 col-md-4 col-sm-6 document-item" data-path="{{ $docPath }}" data-level="{{ $level }}" data-index="{{ $index }}">
                                                    <div class="card border-0 shadow-sm h-100 position-relative">
                                                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 8px; right: 8px; z-index: 10; width: 28px; height: 28px; padding: 0; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2);" onclick="deleteAcademicDocument('{{ $level }}', {{ $index }}, {{ $student->id }}, this)">
                                                            <i class="ri-close-line" style="font-size: 14px;"></i>
                                                        </button>
                                                        <div class="card-body p-3 text-center">
                                                            @php
                                                                $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                                                                $fileUrl = url('/storage/' . $docPath);
                                                                $fileName = basename($docPath);
                                                            @endphp
                                                            <div class="mb-3">
                                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <div class="document-preview" style="width: 80px; height: 80px; background: url('{{ $fileUrl }}') center/cover; border-radius: 8px; margin: 0 auto; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')"></div>
                                                                @elseif(strtolower($extension) === 'pdf')
                                                                    <div class="document-preview" style="width: 80px; height: 80px; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(220,53,69,0.3);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', 'pdf')">
                                                                        <i class="fas fa-file-pdf" style="font-size: 32px; color: white;"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="document-preview" style="width: 80px; height: 80px; background: linear-gradient(135deg, #6c757d, #5a6268); border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(108,117,125,0.3);" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')">                                                                        <i class="fas fa-file-alt" style="font-size: 32px; color: white;"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="file-info mb-3">
                                                                <span class="badge bg-info mb-1">{{ strtoupper($extension) }}</span>
                                                                <p class="small text-muted mb-0">{{ strlen($fileName) > 15 ? substr($fileName, 0, 15) . '...' : $fileName }}</p>
                                                            </div>
                                                            <div class="btn-group w-100" role="group">
                                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="previewDocument('{{ $fileUrl }}', '{{ $fileName }}', '{{ strtolower($extension) }}')" title="Preview">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                                <a href="{{ route('students.download-academic-document', [$student, $level, $index]) }}" class="btn btn-outline-success btn-sm" title="Download">
                                                                    <i class="ri-download-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="new-documents-container" style="display: none;">
                                            <div class="row gy-3 mt-2">
                                                <div class="col-md-12">
                                                    <label class="text-sm fw-semibold text-secondary-light d-inline-block mb-8">Add New Documents</label>
                                                    <input type="file" class="form-control new-academic-docs" name="new_academic_documents[{{ $level }}][]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                <button type="button" id="add-academic-level" class="btn btn-primary-600 btn-sm">
                                    <i class="ri-add-line"></i> Add New Academic Level
                                </button>
                            @else
                                <div class="text-center text-muted py-4" id="no-academic-message">
                                    <p>Click "Add New Academic Level" to upload documents for different academic levels</p>
                                </div>
                                <button type="button" id="add-academic-level" class="btn btn-primary-600 btn-sm">
                                    <i class="ri-add-line"></i> Add Academic Level
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Management -->
            @if(auth()->user()->canManageRoles() || (auth()->user()->hasRole('Counselor') && ($student->counselor_id == auth()->id() || $student->created_by == auth()->id()) && !in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed'])) || (auth()->user()->hasRole('FrontDesk') && $student->created_by == auth()->id() && !in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed']))))
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h6 class="text-lg fw-semibold mb-0">Status Management</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-md-4">
                                <label for="status" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Status</label>
                                <select name="status" class="form-control form-select" id="status">
                                    @if(auth()->user()->canManageRoles())
                                        {{-- Admin can access all statuses --}}
                                        <option value="New" {{ $student->status == 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Assigned to Counselor" {{ $student->status == 'Assigned to Counselor' ? 'selected' : '' }}>Assigned to Counselor</option>
                                        <option value="Documents Pending" {{ $student->status == 'Documents Pending' ? 'selected' : '' }}>Documents Pending</option>
                                        <option value="Documents Completed" {{ $student->status == 'Documents Completed' ? 'selected' : '' }}>Documents Completed</option>
                                        <option value="Sent to Application" {{ $student->status == 'Sent to Application' ? 'selected' : '' }}>Sent to Application</option>
                                        <option value="Application In Review" {{ $student->status == 'Application In Review' ? 'selected' : '' }}>Application In Review</option>
                                        <option value="Completed" {{ $student->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="On Hold" {{ $student->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="Rejected" {{ $student->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    @else
                                        {{-- Counselor/FrontDesk can only access limited statuses --}}
                                        <option value="Assigned to Counselor" {{ $student->status == 'Assigned to Counselor' ? 'selected' : '' }}>Assigned to Counselor</option>
                                        <option value="Documents Pending" {{ $student->status == 'Documents Pending' ? 'selected' : '' }}>Documents Pending</option>
                                        <option value="Documents Completed" {{ $student->status == 'Documents Completed' ? 'selected' : '' }}>Documents Completed</option>
                                        <option value="Sent to Application" {{ $student->status == 'Sent to Application' ? 'selected' : '' }}>Sent to Application</option>
                                        <option value="On Hold" {{ $student->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                        @if($student->status == 'New')
                                            <option value="New" selected>New</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                            @if(auth()->user()->canManageRoles())
                            <div class="col-md-4">
                                <label for="counselor_id" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Assign to Counselor</label>
                                <select name="counselor_id" class="form-control form-select" id="counselor_id">
                                    <option value="">Select Counselor</option>
                                    @foreach($counselors as $counselor)
                                        <option value="{{ $counselor->id }}" {{ $student->counselor_id == $counselor->id ? 'selected' : '' }}>
                                            {{ $counselor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <label for="application_staff_id" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Assign to Application</label>
                                <select name="application_staff_id" class="form-control form-select" id="application_staff_id">
                                    <option value="">Select Application Staff</option>
                                    @foreach($applicationStaff as $staff)
                                        <option value="{{ $staff->id }}" {{ $student->application_staff_id == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Notes Section -->
            @if(auth()->user()->hasRole('Counselor') || auth()->user()->canManageRoles())
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h6 class="text-lg fw-semibold mb-0">Add Counselor Note</h6>
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <div class="col-md-12">
                                <label for="counselor_note" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Note</label>
                                <textarea name="counselor_note" class="form-control" rows="3" placeholder="Add a counselor note about this student..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Submit Buttons -->
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8" onclick="window.history.back()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary-600 text-md px-56 py-12 radius-8">
                        Update Student
                    </button>
                    @if(auth()->user()->canManageRoles())
                        <button type="button" id="sendToApplicationBtn" class="btn btn-success text-md px-56 py-12 radius-8" disabled onclick="sendToApplication()">
                            Send to Application
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Document Preview Modal -->
<div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="documentPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentPreviewModalLabel">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="documentPreviewContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="downloadDocumentBtn" class="btn btn-primary" download>Download</a>
            </div>
        </div>
    </div>
</div>

<!-- Replace Document Modal -->
<div class="modal fade" id="replaceDocumentModal" tabindex="-1" aria-labelledby="replaceDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replaceDocumentModalLabel">Replace Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="replaceDocumentForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="replaceDocumentFile" class="form-label">Select New Document</label>
                        <input type="file" class="form-control" id="replaceDocumentFile" name="document" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                        <small class="text-muted">Supported formats: PDF, Images, Word documents (Max: 10MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Replace Document</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Document Preview Function - matches show.blade.php approach
    document.addEventListener('DOMContentLoaded', function() {
        // Attach click handlers to all preview buttons
        document.querySelectorAll('[onclick^="previewDocument"]').forEach(function(element) {
            const onclickAttr = element.getAttribute('onclick');
            element.removeAttribute('onclick');
            element.addEventListener('click', function() {
                const match = onclickAttr.match(/previewDocument\('([^']*)',\s*'([^']*)',\s*'([^']*)'\)/);
                if (match) {
                    let fileUrl = match[1];
                    const fileName = match[2];
                    const extension = match[3];
                    
                    // Decode HTML entities
                    fileUrl = fileUrl.replace(/&#39;/g, "'").replace(/&amp;/g, '&').replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
                    
                    showDocumentModal(fileUrl, extension, fileName);
                }
            });
        });
    });
    
    function showDocumentModal(fileUrl, fileType, title) {
        const modal = new bootstrap.Modal(document.getElementById('documentPreviewModal'));
        const content = document.getElementById('documentPreviewContent');
        const downloadBtn = document.getElementById('downloadDocumentBtn');
        const modalTitle = document.getElementById('documentPreviewModalLabel');
        
        modalTitle.textContent = `Preview: ${title}`;
        downloadBtn.href = fileUrl;
        downloadBtn.download = title + '.' + fileType;
        
        content.innerHTML = '';
        
        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
            const img = new Image();
            img.onload = function() {
                content.innerHTML = `<img src="${fileUrl}" class="img-fluid" style="max-height: 70vh;" alt="${title}">`;
            };
            img.onerror = function() {
                content.innerHTML = `
                    <div class="text-center py-5">
                        <h5>Image failed to load</h5>
                        <p class="text-muted">The image could not be displayed.</p>
                        <a href="${fileUrl}" class="btn btn-primary" download="${title}.${fileType}">Download File</a>
                    </div>
                `;
            };
            img.src = fileUrl;
        } else if (fileType === 'pdf') {
            content.innerHTML = `<iframe src="${fileUrl}" width="100%" height="600px" frameborder="0"></iframe>`;
        } else {
            content.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-5x text-muted mb-3"></i>
                    <h5>${title}</h5>
                    <p class="text-muted">Preview not available for this file type.</p>
                    <a href="${fileUrl}" class="btn btn-primary" download="${title}.${fileType}">
                        <i class="ri-download-line"></i> Download to View
                    </a>
                </div>
            `;
        }
        
        modal.show();
    }
    
    // Delete Document Function
    $(document).on('click', '.delete-document-btn', function() {
        const field = $(this).data('field');
        const studentId = $(this).data('student-id');
        const button = $(this);
        
        if (confirm('Are you sure you want to delete this document? This action cannot be undone.')) {
            $.ajax({
                url: `/students/${studentId}/delete-document/${field}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        button.closest('.document-type-item').fadeOut(300, function() {
                            $(this).remove();
                            if ($('.document-type-item').length === 0) {
                                $('#no-documents-message').show();
                            }
                        });
                        alert('Document deleted successfully!');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the document.');
                }
            });
        }
    });
    
    // Delete Additional Document Function
    $(document).on('click', '.delete-additional-doc-btn', function() {
        const index = $(this).data('index');
        const studentId = $(this).data('student-id');
        const item = $(this).closest('.additional-doc-item');
        
        if (confirm('Are you sure you want to delete this document? This action cannot be undone.')) {
            $.ajax({
                url: `/students/${studentId}/delete-additional-document/${index}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        item.fadeOut(300, function() {
                            $(this).remove();
                        });
                        alert('Document deleted successfully!');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the document.');
                }
            });
        }
    });
    
    // Delete Academic Document Function
    window.deleteAcademicDocument = function(level, index, studentId, button) {
        if (confirm('Are you sure you want to delete this document? This action cannot be undone.')) {
            $.ajax({
                url: `/students/${studentId}/delete-academic-document/${level}/${index}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $(button).closest('.document-item').fadeOut(300, function() {
                            $(this).remove();
                            
                            // Check if level is empty and hide if needed
                            const levelContainer = $(`.academic-level-item[data-level="${level}"]`);
                            if (levelContainer.find('.document-item').length === 0) {
                                levelContainer.find('.existing-documents').hide();
                            }
                        });
                        alert('Document deleted successfully!');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the document.');
                }
            });
        }
    };
    
    // Replace Document Function
    let currentReplaceField = null;
    let currentStudentId = {{ $student->id }};
    
    $(document).on('click', '.replace-document', function() {
        currentReplaceField = $(this).data('field');
        const modal = new bootstrap.Modal(document.getElementById('replaceDocumentModal'));
        modal.show();
    });
    
    $('#replaceDocumentForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!currentReplaceField) {
            alert('No document field selected.');
            return;
        }
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).text('Replacing...');
        
        $.ajax({
            url: `/students/${currentStudentId}/replace-document/${currentReplaceField}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Document replaced successfully!');
                    location.reload(); // Reload to show updated document
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while replacing the document.');
            },
            complete: function() {
                submitBtn.prop('disabled', false).text('Replace Document');
                bootstrap.Modal.getInstance(document.getElementById('replaceDocumentModal')).hide();
            }
        });
    });
    
    $('.flatpickr').flatpickr({
        dateFormat: "Y-m-d",
        maxDate: "today",
        yearRange: [1950, new Date().getFullYear()],
        defaultDate: null,
        allowInput: true
    });
    
    // Show/hide other qualification field
    $('#last_qualification').on('change', function() {
        if ($(this).val() === 'Others') {
            $('#other_qualification_div').show();
        } else {
            $('#other_qualification_div').hide();
        }
    });
    
    // Show/hide other english test field
    $('#english_test').on('change', function() {
        if ($(this).val() === 'Others') {
            $('#other_english_test_div').show();
        } else {
            $('#other_english_test_div').hide();
        }
    });
    
    // Add more documents functionality
    $('#add-more-docs').on('click', function() {
        const container = $('#additional-docs-container');
        const newItem = `
            <div class="additional-doc-item mb-3">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <input type="text" name="additional_doc_names[]" class="form-control" placeholder="Document Name">
                    </div>
                    <div class="col-md-5">
                        <input type="file" name="additional_docs[]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger-600 remove-doc">Remove</button>
                    </div>
                </div>
            </div>
        `;
        container.append(newItem);
        $('.remove-doc').show();
    });
    
    // Remove document functionality
    $(document).on('click', '.remove-doc', function() {
        $(this).closest('.additional-doc-item').remove();
        if ($('.additional-doc-item').length === 1) {
            $('.remove-doc').hide();
        }
    });
    
    // University and Course Management
    let universityIndex = $('.university-item').length - 1;
    
    // Add University
    $('#add-university').on('click', function() {
        universityIndex++;
        const newUniversity = `
            <div class="university-item border border-neutral-100 rounded-6 p-12 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-sm fw-medium text-secondary-light">University ${universityIndex + 1}</span>
                    <button type="button" class="btn btn-danger-600 btn-sm remove-university">Remove</button>
                </div>
                <div class="row gy-2">
                    <div class="col-md-6">
                        <input type="text" name="universities[]" class="form-control" placeholder="University Name">
                    </div>
                    <div class="col-md-6">
                        <div class="courses-container">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" name="courses[${universityIndex}][]" class="form-control" placeholder="Course Name">
                                <button type="button" class="btn btn-outline-primary btn-sm add-course">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#universities-container').append(newUniversity);
        updateRemoveButtons();
    });
    
    // Remove University
    $(document).on('click', '.remove-university', function() {
        $(this).closest('.university-item').remove();
        updateUniversityLabels();
        updateRemoveButtons();
    });
    
    // Add Course to University
    $(document).on('click', '.add-course', function() {
        const coursesContainer = $(this).closest('.courses-container');
        const universityIdx = $(this).closest('.university-item').index();
        const newCourse = `
            <div class="d-flex gap-2 mb-2">
                <input type="text" name="courses[${universityIdx}][]" class="form-control" placeholder="Course Name">
                <button type="button" class="btn btn-outline-danger btn-sm remove-course">-</button>
            </div>
        `;
        coursesContainer.append(newCourse);
    });
    
    // Remove Course
    $(document).on('click', '.remove-course', function() {
        const coursesContainer = $(this).closest('.courses-container');
        $(this).closest('.d-flex').remove();
        
        // If no courses left, add a default one
        if (coursesContainer.find('.d-flex').length === 0) {
            const universityIdx = $(this).closest('.university-item').index();
            const newCourse = `
                <div class="d-flex gap-2 mb-2">
                    <input type="text" name="courses[${universityIdx}][]" class="form-control" placeholder="Course Name">
                    <button type="button" class="btn btn-outline-primary btn-sm add-course">+</button>
                </div>
            `;
            coursesContainer.append(newCourse);
        }
    });
    
    // Update remove buttons visibility
    function updateRemoveButtons() {
        const universityItems = $('.university-item');
        if (universityItems.length > 1) {
            $('.remove-university').show();
        } else {
            $('.remove-university').hide();
        }
    }
    
    // Update university labels
    function updateUniversityLabels() {
        $('.university-item').each(function(index) {
            $(this).find('span').text(`University ${index + 1}`);
            $(this).find('input[name^="courses"]').each(function() {
                const name = $(this).attr('name');
                $(this).attr('name', name.replace(/courses\[\d+\]/, `courses[${index}]`));
            });
        });
    }
    
    // Enable/disable Send to Application button
    $('#application_staff_id').on('change', function() {
        $('#sendToApplicationBtn').prop('disabled', !this.value);
    });
    
    // Check initial state
    $(document).ready(function() {
        $('#sendToApplicationBtn').prop('disabled', !$('#application_staff_id').val());
    });
    
    function sendToApplication() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("students.send-to-application", $student) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // Upload Documents Management
    let documentsToDeleteUpload = [];
    
    // Delete individual upload document
    window.deleteUploadDocument = function(field, button) {
        if (confirm('Are you sure you want to delete this document?')) {
            documentsToDeleteUpload.push(field);
            $(button).closest('.document-type-item').remove();
            
            // Create hidden input to track deletions
            const deleteInput = $('<input>', {
                type: 'hidden',
                name: 'delete_upload_documents[]',
                value: field
            });
            $('form').append(deleteInput);
            
            // Show no documents message if no documents left
            if ($('.document-type-item').length === 0) {
                $('#no-documents-message').show();
            }
        }
    };
    
    // Delete entire document type
    $(document).on('click', '.delete-document-type', function() {
        const field = $(this).data('field');
        if (confirm('Are you sure you want to delete this document?')) {
            documentsToDeleteUpload.push(field);
            $(this).closest('.document-type-item').remove();
            
            const deleteInput = $('<input>', {
                type: 'hidden',
                name: 'delete_upload_documents[]',
                value: field
            });
            $('form').append(deleteInput);
            
            if ($('.document-type-item').length === 0) {
                $('#no-documents-message').show();
            }
        }
    });
    
    // Replace document
    $(document).on('click', '.replace-document', function() {
        const container = $(this).closest('.document-type-item').find('.new-document-container');
        container.show();
    });
    
    // Add new document type
    $('#add-document-type').on('click', function() {
        const documentTypes = {
            'passport': 'Passport',
            'lor': 'Letter of Recommendation (LOR)',
            'moi': 'Medium of Instruction',
            'cv': 'CV/Resume',
            'sop': 'Statement of Purpose (SOP)',
            'transcripts': 'Academic Transcripts',
            'english_test_doc': 'English Test (IELTS/TOEFL)',
            'financial_docs': 'Financial Documents',
            'birth_certificate': 'Birth Certificate',
            'medical_certificate': 'Medical Certificate',
            'student_photo': 'Student Photo',
            'other': 'Other Document (Please Specify)'
        };
        
        // Get already used document types (excluding 'other' to allow multiple)
        const usedTypes = [];
        $('.document-type-item').each(function() {
            const field = $(this).data('field');
            if (field && field !== 'additional' && field !== 'other') {
                usedTypes.push(field);
            }
        });
        
        // Create options for unused document types
        let options = '<option value="">Select Document Type</option>';
        Object.keys(documentTypes).forEach(key => {
            if (!usedTypes.includes(key)) {
                options += `<option value="${key}">${documentTypes[key]}</option>`;
            }
        });
        
        if (options === '<option value="">Select Document Type</option>') {
            alert('All document types have been added.');
            return;
        }
        
        const newDocumentItem = `
            <div class="document-type-item border border-neutral-200 rounded-8 p-16 mb-3 new-document-type">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-md fw-semibold mb-0 text-primary-light">New Document</h6>
                    <button type="button" class="btn btn-danger-600 btn-sm remove-new-document-type">
                        <i class="ri-delete-bin-line"></i> Remove
                    </button>
                </div>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Document Type</label>
                        <select class="form-control form-select document-type-select">
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Upload Document</label>
                        <input type="file" class="form-control new-document-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" disabled>
                        <small class="text-muted">Select document type first</small>
                    </div>
                </div>
                <div class="other-document-name" style="display: none;">
                    <div class="row gy-3 mt-2">
                        <div class="col-md-12">
                            <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Document Name</label>
                            <input type="text" class="form-control other-doc-name" placeholder="Please specify document name">
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#document-types-container').append(newDocumentItem);
        $('#no-documents-message').hide();
    });
    
    // Remove new document type
    $(document).on('click', '.remove-new-document-type', function() {
        $(this).closest('.document-type-item').remove();
        
        if ($('.document-type-item').length === 0) {
            $('#no-documents-message').show();
        }
    });
    
    // Document type selection
    $(document).on('change', '.document-type-select', function() {
        const selectedType = $(this).val();
        const fileInput = $(this).closest('.document-type-item').find('.new-document-file');
        const container = $(this).closest('.document-type-item');
        const otherNameDiv = container.find('.other-document-name');
        const otherNameInput = container.find('.other-doc-name');
        
        if (selectedType) {
            fileInput.prop('disabled', false);
            fileInput.siblings('small').text('You can upload PDF, Images, or Word documents');
            
            if (selectedType === 'other') {
                otherNameDiv.show();
                otherNameInput.prop('required', true);
                fileInput.attr('name', 'other_documents[]');
                container.find('h6').text('Other Document (Please Specify)');
            } else {
                otherNameDiv.hide();
                otherNameInput.prop('required', false);
                fileInput.attr('name', selectedType);
                
                // Update the title
                const documentTypes = {
                    'passport': 'Passport',
                    'lor': 'Letter of Recommendation (LOR)',
                    'moi': 'Medium of Instruction',
                    'cv': 'CV/Resume',
                    'sop': 'Statement of Purpose (SOP)',
                    'transcripts': 'Academic Transcripts',
                    'english_test_doc': 'English Test (IELTS/TOEFL)',
                    'financial_docs': 'Financial Documents',
                    'birth_certificate': 'Birth Certificate',
                    'medical_certificate': 'Medical Certificate',
                    'student_photo': 'Student Photo'
                };
                container.find('h6').text(documentTypes[selectedType]);
            }
        } else {
            fileInput.prop('disabled', true);
            fileInput.removeAttr('name');
            fileInput.siblings('small').text('Select document type first');
            otherNameDiv.hide();
            otherNameInput.prop('required', false);
            container.find('h6').text('New Document');
        }
    });
    
    // Add more additional documents
    $(document).on('click', '.add-more-additional', function() {
        const container = $('#additional-docs-container');
        if (container.length === 0) {
            // Create additional documents section if it doesn't exist
            const additionalSection = `
                <div class="document-type-item border border-neutral-200 rounded-8 p-16 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-md fw-semibold mb-0 text-primary-light">Additional Documents</h6>
                        <button type="button" class="btn btn-primary-600 btn-sm add-more-additional" data-field="additional">
                            <i class="ri-add-line"></i> Add More
                        </button>
                    </div>
                    <div id="additional-docs-container">
                        <div class="additional-doc-item mb-3">
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <input type="text" name="additional_doc_names[]" class="form-control" placeholder="Document Name">
                                </div>
                                <div class="col-md-5">
                                    <input type="file" name="additional_docs[]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger-600 remove-doc" style="display: none;">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-more-docs" class="btn btn-primary-600 btn-sm mt-2">
                        <i class="ri-add-line"></i> Add More Documents
                    </button>
                </div>
            `;
            $('#document-types-container').append(additionalSection);
        }
    });
    
    // Academic Documents Management
    let academicDocuments = {};
    let academicLevelCounter = $('.academic-level-item').length;
    let documentsToDelete = [];
    
    // Delete entire academic level
    $(document).on('click', '.delete-academic-level', function() {
        const level = $(this).data('level');
        if (confirm('Are you sure you want to delete this entire academic level and all its documents?')) {
            const levelContainer = $(this).closest('.academic-level-item');
            
            // Add all documents in this level to deletion list
            levelContainer.find('.document-item').each(function() {
                const docPath = $(this).data('path');
                documentsToDelete.push({level: level, path: docPath});
                
                const deleteInput = $('<input>', {
                    type: 'hidden',
                    name: 'delete_academic_documents[]',
                    value: JSON.stringify({level: level, path: docPath})
                });
                $('form').append(deleteInput);
            });
            
            levelContainer.remove();
            
            // Show no academic message if no levels left
            if ($('.academic-level-item').length === 0) {
                $('#no-academic-message').show();
            }
        }
    });
    
    // Add more documents to existing level
    $(document).on('click', '.add-more-to-level', function() {
        const level = $(this).data('level');
        const container = $(this).closest('.academic-level-item').find('.new-documents-container');
        container.show();
    });
    
    // Add new academic level
    $('#add-academic-level').on('click', function() {
        academicLevelCounter++;
        const levelItem = `
            <div class="academic-level-item border border-neutral-200 rounded-8 p-16 mb-3" data-counter="${academicLevelCounter}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-md fw-semibold mb-0 text-primary-light">New Academic Level</h6>
                    <button type="button" class="btn btn-danger-600 btn-sm remove-new-academic-level">
                        <i class="ri-delete-bin-line"></i> Remove
                    </button>
                </div>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Select Academic Level</label>
                        <select class="form-control form-select academic-level-select" name="new_academic_levels[${academicLevelCounter}][level]" data-counter="${academicLevelCounter}">
                            <option value="">Choose Academic Level</option>
                            <option value="class10">Class 10 Documents</option>
                            <option value="grade12">+2/Grade 12 Documents</option>
                            <option value="diploma">Diploma Documents</option>
                            <option value="bachelor">Bachelor Documents</option>
                            <option value="masters">Masters Documents</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Upload Documents</label>
                        <input type="file" class="form-control academic-documents-input" name="new_academic_levels[${academicLevelCounter}][documents][]" data-counter="${academicLevelCounter}" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple disabled>
                        <small class="text-muted">Select academic level first, then upload files</small>
                    </div>
                </div>
            </div>
        `;
        
        $('#academic-levels-container').append(levelItem);
        $('#no-academic-message').hide();
    });
    
    // Remove new academic level
    $(document).on('click', '.remove-new-academic-level', function() {
        $(this).closest('.academic-level-item').remove();
        
        if ($('.academic-level-item').length === 0) {
            $('#no-academic-message').show();
        }
    });
    
    // Academic level selection for new levels
    $(document).on('change', '.academic-level-select', function() {
        const counter = $(this).data('counter');
        const level = $(this).val();
        const fileInput = $(this).closest('.academic-level-item').find('.academic-documents-input');
        
        if (level) {
            fileInput.prop('disabled', false);
            fileInput.siblings('small').text('You can upload multiple files (PDF, Images, Word documents)');
        } else {
            fileInput.prop('disabled', true);
            fileInput.siblings('small').text('Select academic level first, then upload files');
        }
    });
</script>
@endpush
@endsection