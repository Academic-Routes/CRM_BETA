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
                            <!-- Medium of Instruction -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Medium of Instruction</label>
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
                        
                        @if($academicDocs && count($academicDocs) > 0)
                            <!-- Show existing academic documents -->
                            @foreach($academicDocs as $level => $documents)
                                @if($documents && count($documents) > 0)
                                <div class="mb-4">
                                    <h6 class="text-md fw-semibold mb-3 text-primary-light">{{ $levelLabels[$level] ?? ucfirst($level) . ' Documents' }}</h6>
                                    <div class="row gy-3">
                                        @foreach($documents as $index => $docPath)
                                            <div class="col-md-3 mb-3">
                                                <strong>Document {{ $index + 1 }}:</strong><br>
                                                @php
                                                    $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                                                    $fileUrl = url('/storage/' . $docPath);
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
                                                    <small class="text-success">Uploaded</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @else
                            <!-- Show new academic documents upload interface -->
                            <div id="academic-levels-container">
                                <div class="text-center text-muted py-4" id="no-academic-message">
                                    <p>Click "Add Academic Level" to upload documents for different academic levels</p>
                                </div>
                            </div>
                        @endif
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
    
    // Academic Documents Management (only if no existing documents)
    @if(!$student->academic_documents || (is_array($student->academic_documents) && count($student->academic_documents) == 0))
    let academicDocuments = {};
    let academicLevelCounter = 0;
    
    $('#add-academic-level').on('click', function() {
        academicLevelCounter++;
        const levelItem = `
            <div class="academic-level-item border border-neutral-200 rounded-8 p-16 mb-3" data-counter="${academicLevelCounter}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-md fw-semibold mb-0 text-primary-light">Academic Level ${academicLevelCounter}</h6>
                    <button type="button" class="btn btn-danger-600 btn-sm remove-academic-level">Remove</button>
                </div>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Select Academic Level</label>
                        <select class="form-control form-select academic-level-select" data-counter="${academicLevelCounter}">
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
                        <input type="file" class="form-control academic-documents-input" data-counter="${academicLevelCounter}" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple disabled>
                        <small class="text-muted">Select academic level first, then upload files</small>
                    </div>
                </div>
                <div class="selected-documents mt-3" style="display: none;">
                    <h6 class="text-sm fw-semibold mb-2 text-secondary-light">Selected Documents</h6>
                    <div class="documents-list row gy-2"></div>
                </div>
            </div>
        `;
        
        $('#academic-levels-container').append(levelItem);
        $('#no-academic-message').hide();
        updateRemoveButtons();
    });
    
    // Remove academic level
    $(document).on('click', '.remove-academic-level', function() {
        const counter = $(this).closest('.academic-level-item').data('counter');
        delete academicDocuments[counter];
        $(this).closest('.academic-level-item').remove();
        
        if ($('.academic-level-item').length === 0) {
            $('#no-academic-message').show();
        }
        
        updateRemoveButtons();
        createHiddenInputs();
    });
    
    // Academic level selection
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
    
    // File upload handling
    $(document).on('change', '.academic-documents-input', function() {
        const counter = $(this).data('counter');
        const levelSelect = $(this).closest('.academic-level-item').find('.academic-level-select');
        const level = levelSelect.val();
        const files = this.files;
        
        if (level && files.length > 0) {
            const key = `${counter}_${level}`;
            
            if (!academicDocuments[key]) {
                academicDocuments[key] = [];
            }
            
            // Add new files
            for (let i = 0; i < files.length; i++) {
                academicDocuments[key].push(files[i]);
            }
            
            displaySelectedDocuments(counter, level);
            createHiddenInputs();
        }
    });
    
    // Display selected documents
    function displaySelectedDocuments(counter, level) {
        const key = `${counter}_${level}`;
        const levelItem = $(`.academic-level-item[data-counter="${counter}"]`);
        const documentsDiv = levelItem.find('.selected-documents');
        const documentsList = levelItem.find('.documents-list');
        
        if (academicDocuments[key] && academicDocuments[key].length > 0) {
            documentsDiv.show();
            documentsList.empty();
            
            academicDocuments[key].forEach((file, index) => {
                const fileItem = `
                    <div class="col-md-6 mb-2">
                        <div class="border border-neutral-200 rounded-6 p-2 d-flex justify-content-between align-items-center">
                            <span class="text-sm">${file.name}</span>
                            <button type="button" class="btn btn-danger btn-sm remove-academic-doc" data-key="${key}" data-index="${index}">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                `;
                documentsList.append(fileItem);
            });
        } else {
            documentsDiv.hide();
        }
    }
    
    // Remove individual document
    $(document).on('click', '.remove-academic-doc', function() {
        const key = $(this).data('key');
        const index = $(this).data('index');
        
        academicDocuments[key].splice(index, 1);
        
        if (academicDocuments[key].length === 0) {
            delete academicDocuments[key];
        }
        
        const [counter, level] = key.split('_');
        displaySelectedDocuments(parseInt(counter), level);
        createHiddenInputs();
    });
    
    // Create hidden inputs for form submission
    function createHiddenInputs() {
        // Remove existing hidden inputs
        $('input[name^="academic_documents"]').remove();
        
        Object.keys(academicDocuments).forEach(key => {
            const [counter, level] = key.split('_');
            academicDocuments[key].forEach((file, index) => {
                const input = $('<input>', {
                    type: 'file',
                    name: `academic_documents[${level}][]`,
                    style: 'display: none;'
                });
                
                // Create a new FileList with just this file
                const dt = new DataTransfer();
                dt.items.add(file);
                input[0].files = dt.files;
                
                $('form').append(input);
            });
        });
    }
    @endif
</script>
@endpush
@endsection