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
                                                            <input type="text" name="universities[]" class="form-control" value="{{ $universityName }}" placeholder="University Name" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="courses-container">
                                                                @foreach($courses as $course)
                                                                    <div class="d-flex gap-2 mb-2">
                                                                        <input type="text" name="courses[{{ $loop->parent->index }}][]" class="form-control" value="{{ $course->course_name }}" placeholder="Course Name" required>
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
                                                        <input type="text" name="universities[]" class="form-control" placeholder="University Name" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="courses-container">
                                                            <div class="d-flex gap-2 mb-2">
                                                                <input type="text" name="courses[0][]" class="form-control" placeholder="Course Name" required>
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
                    </div>
                    <div class="card-body p-20">
                        <div class="row gy-3">
                            <!-- Passport -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Passport</label>
                                <input type="file" name="passport" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($student->passport)<small class="text-success">Current: {{ basename($student->passport) }}</small>@endif
                            </div>
                            <!-- LOR -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Letter of Recommendation (LOR)</label>
                                <input type="file" name="lor" class="form-control" accept=".pdf,.doc,.docx">
                                @if($student->lor)<small class="text-success">Current: {{ basename($student->lor) }}</small>@endif
                            </div>
                            <!-- MOI -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Motivation of Interest (MOI)</label>
                                <input type="file" name="moi" class="form-control" accept=".pdf,.doc,.docx">
                                @if($student->moi)<small class="text-success">Current: {{ basename($student->moi) }}</small>@endif
                            </div>
                            <!-- CV -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">CV/Resume</label>
                                <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                                @if($student->cv)<small class="text-success">Current: {{ basename($student->cv) }}</small>@endif
                            </div>
                            <!-- SOP -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Statement of Purpose (SOP)</label>
                                <input type="file" name="sop" class="form-control" accept=".pdf,.doc,.docx">
                                @if($student->sop)<small class="text-success">Current: {{ basename($student->sop) }}</small>@endif
                            </div>
                            <!-- Academic Transcripts -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Academic Transcripts</label>
                                <input type="file" name="transcripts" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($student->transcripts)<small class="text-success">Current: {{ basename($student->transcripts) }}</small>@endif
                            </div>
                            <!-- English Test -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">English Test (IELTS/TOEFL)</label>
                                <input type="file" name="english_test_doc" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($student->english_test_doc)<small class="text-success">Current: {{ basename($student->english_test_doc) }}</small>@endif
                            </div>
                            <!-- Financial Documents -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Financial Documents</label>
                                <input type="file" name="financial_docs" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($student->financial_docs)<small class="text-success">Current: {{ basename($student->financial_docs) }}</small>@endif
                            </div>
                            <!-- Birth Certificate -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Birth Certificate</label>
                                <input type="file" name="birth_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($student->birth_certificate)<small class="text-success">Current: {{ basename($student->birth_certificate) }}</small>@endif
                            </div>
                            <!-- Medical Certificate -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Medical Certificate</label>
                                <input type="file" name="medical_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                @if($student->medical_certificate)<small class="text-success">Current: {{ basename($student->medical_certificate) }}</small>@endif
                            </div>
                            <!-- Student Photo -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Student Photo</label>
                                <input type="file" name="student_photo" class="form-control" accept=".jpg,.jpeg,.png">
                                @if($student->student_photo)<small class="text-success">Current: {{ basename($student->student_photo) }}</small>@endif
                            </div>
                            <!-- Additional Documents -->
                            <div class="col-sm-12">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Additional Documents</label>
                                <div id="additional-docs-container">
                                    @if($student->additional_documents && is_array($student->additional_documents) && count($student->additional_documents) > 0)
                                        @foreach($student->additional_documents as $index => $doc)
                                            <div class="additional-doc-item mb-3">
                                                <div class="row align-items-end">
                                                    <div class="col-md-5">
                                                        <input type="text" name="additional_doc_names[]" class="form-control" value="{{ $doc['name'] ?? '' }}" placeholder="Document Name">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="file" name="additional_docs[]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                        @if(isset($doc['file']))<small class="text-success">Current: {{ basename($doc['file']) }}</small>@endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger-600 remove-doc" style="display: {{ $index > 0 ? 'block' : 'none' }};">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
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
                                    @endif
                                </div>
                                <button type="button" id="add-more-docs" class="btn btn-primary-600 btn-sm mt-2">
                                    <i class="ri-add-line"></i> Add More Documents
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Academic Documents -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Academic Documents</h6>
                    </div>
                    <div class="card-body p-20">
                        <div id="document-sections">
                            <!-- Class 10 Documents -->
                            <div class="document-section" id="class10-docs">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Class 10 Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Marksheet</label>
                                        <input type="file" name="class10_marksheet" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->class10_marksheet)<small class="text-success">Current: {{ basename($student->class10_marksheet) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Certificate</label>
                                        <input type="file" name="class10_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->class10_certificate)<small class="text-success">Current: {{ basename($student->class10_certificate) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="class10_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->class10_character)<small class="text-success">Current: {{ basename($student->class10_character) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="class10_other_name" class="form-control mb-2" value="{{ $student->class10_other_name }}" placeholder="Document name">
                                        <input type="file" name="class10_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->class10_other_file)<small class="text-success">Current: {{ basename($student->class10_other_file) }}</small>@endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Diploma Documents -->
                            <div class="document-section" id="diploma-docs">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Diploma Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Marksheet</label>
                                        <input type="file" name="diploma_marksheet" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->diploma_marksheet)<small class="text-success">Current: {{ basename($student->diploma_marksheet) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Certificate</label>
                                        <input type="file" name="diploma_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->diploma_certificate)<small class="text-success">Current: {{ basename($student->diploma_certificate) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="diploma_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->diploma_character)<small class="text-success">Current: {{ basename($student->diploma_character) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Registration</label>
                                        <input type="file" name="diploma_registration" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->diploma_registration)<small class="text-success">Current: {{ basename($student->diploma_registration) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="diploma_other_name" class="form-control mb-2" value="{{ $student->diploma_other_name }}" placeholder="Document name">
                                        <input type="file" name="diploma_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->diploma_other_file)<small class="text-success">Current: {{ basename($student->diploma_other_file) }}</small>@endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Grade 12 Documents -->
                            <div class="document-section" id="grade12-docs">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Grade 12 Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Transcript</label>
                                        <input type="file" name="grade12_transcript" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->grade12_transcript)<small class="text-success">Current: {{ basename($student->grade12_transcript) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Provisional</label>
                                        <input type="file" name="grade12_provisional" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->grade12_provisional)<small class="text-success">Current: {{ basename($student->grade12_provisional) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Migrational</label>
                                        <input type="file" name="grade12_migrational" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->grade12_migrational)<small class="text-success">Current: {{ basename($student->grade12_migrational) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="grade12_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->grade12_character)<small class="text-success">Current: {{ basename($student->grade12_character) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="grade12_other_name" class="form-control mb-2" value="{{ $student->grade12_other_name }}" placeholder="Document name">
                                        <input type="file" name="grade12_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->grade12_other_file)<small class="text-success">Current: {{ basename($student->grade12_other_file) }}</small>@endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bachelor Documents -->
                            <div class="document-section" id="bachelor-docs">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Bachelor Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Transcript</label>
                                        <input type="file" name="bachelor_transcript" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->bachelor_transcript)<small class="text-success">Current: {{ basename($student->bachelor_transcript) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Degree</label>
                                        <input type="file" name="bachelor_degree" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->bachelor_degree)<small class="text-success">Current: {{ basename($student->bachelor_degree) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Provisional</label>
                                        <input type="file" name="bachelor_provisional" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->bachelor_provisional)<small class="text-success">Current: {{ basename($student->bachelor_provisional) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="bachelor_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->bachelor_character)<small class="text-success">Current: {{ basename($student->bachelor_character) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="bachelor_other_name" class="form-control mb-2" value="{{ $student->bachelor_other_name }}" placeholder="Document name">
                                        <input type="file" name="bachelor_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->bachelor_other_file)<small class="text-success">Current: {{ basename($student->bachelor_other_file) }}</small>@endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Masters Documents -->
                            <div class="document-section" id="masters-docs">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Masters Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Transcript</label>
                                        <input type="file" name="masters_transcript" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->masters_transcript)<small class="text-success">Current: {{ basename($student->masters_transcript) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Degree</label>
                                        <input type="file" name="masters_degree" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->masters_degree)<small class="text-success">Current: {{ basename($student->masters_degree) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Provisional</label>
                                        <input type="file" name="masters_provisional" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->masters_provisional)<small class="text-success">Current: {{ basename($student->masters_provisional) }}</small>@endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="masters_other_name" class="form-control mb-2" value="{{ $student->masters_other_name }}" placeholder="Document name">
                                        <input type="file" name="masters_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($student->masters_other_file)<small class="text-success">Current: {{ basename($student->masters_other_file) }}</small>@endif
                                    </div>
                                </div>
                            </div>
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
<script>
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
                        <input type="text" name="universities[]" class="form-control" placeholder="University Name" required>
                    </div>
                    <div class="col-md-6">
                        <div class="courses-container">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" name="courses[${universityIndex}][]" class="form-control" placeholder="Course Name" required>
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
                <input type="text" name="courses[${universityIdx}][]" class="form-control" placeholder="Course Name" required>
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
                    <input type="text" name="courses[${universityIdx}][]" class="form-control" placeholder="Course Name" required>
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
</script>
@endpush
@endsection