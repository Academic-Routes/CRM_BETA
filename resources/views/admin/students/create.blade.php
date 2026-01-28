@extends('layouts.admin.master')

@section('title', 'Add Student')

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
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Add New Student</h1>
            <div class="">
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <a href="{{ route('students.index') }}" class="text-secondary-light hover-text-primary hover-underline"> / Student</a>
                <span class="text-secondary-light">/ Add New Student</span>
            </div>
        </div>
    </div>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="mt-24">
        @csrf
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
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Full Name" required>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="phone" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Phone <span class="text-danger-600">*</span></label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Phone Number" required>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="email" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="gender" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Gender</label>
                                <select name="gender" class="form-control form-select" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="date_of_birth" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Date of Birth</label>
                                <div class="position-relative">
                                    <input type="text" name="date_of_birth" class="form-control flatpickr" id="date_of_birth" placeholder="Select Date of Birth" readonly>
                                    <span class="position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light">
                                        <i class="ri-calendar-line"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-8 col-12">
                                <label for="address" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Address</label>
                                <textarea name="address" class="form-control" id="address" rows="2" placeholder="Enter Address"></textarea>
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
                                    <option value="+2">+2</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="Masters">Masters</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6" id="other_qualification_div" style="display: none;">
                                <label for="other_qualification" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Please Specify</label>
                                <input type="text" name="other_qualification" class="form-control" id="other_qualification" placeholder="Please specify qualification">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="last_score" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Last Academic Score</label>
                                <input type="text" name="last_score" class="form-control" id="last_score" placeholder="Enter Score">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="passed_year" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Passed Year</label>
                                <input type="number" name="passed_year" class="form-control" id="passed_year" placeholder="Enter Year">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="interested_country" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Interested Country</label>
                                <input type="text" name="interested_country" class="form-control" id="interested_country" placeholder="Enter Country">
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="english_test" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">English Test</label>
                                <select name="english_test" class="form-control form-select" id="english_test">
                                    <option value="">Select Test</option>
                                    <option value="IELTS">IELTS</option>
                                    <option value="TOEFL">TOEFL</option>
                                    <option value="PTE">PTE</option>
                                    <option value="Duolingo">Duolingo</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6" id="other_english_test_div" style="display: none;">
                                <label for="other_english_test" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Please Specify</label>
                                <input type="text" name="other_english_test" class="form-control" id="other_english_test" placeholder="Please specify test">
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <label for="english_test_score" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">English Test Score</label>
                                <input type="text" name="english_test_score" class="form-control" id="english_test_score" placeholder="Enter Score">
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
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Passport
                                </label>
                                <input type="file" name="passport" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <!-- LOR -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Letter of Recommendation (LOR)
                                </label>
                                <input type="file" name="lor" class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                            <!-- MOI -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Motivation of Interest (MOI)
                                </label>
                                <input type="file" name="moi" class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                            <!-- CV -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    CV/Resume
                                </label>
                                <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                            <!-- SOP -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Statement of Purpose (SOP)
                                </label>
                                <input type="file" name="sop" class="form-control" accept=".pdf,.doc,.docx">
                            </div>
                            <!-- Academic Transcripts -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Academic Transcripts
                                </label>
                                <input type="file" name="transcripts" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
                            </div>
                            <!-- English Test -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    English Test (IELTS/TOEFL)
                                </label>
                                <input type="file" name="english_test_doc" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <!-- Financial Documents -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Financial Documents
                                </label>
                                <input type="file" name="financial_docs" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
                            </div>
                            <!-- Birth Certificate -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Birth Certificate
                                </label>
                                <input type="file" name="birth_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <!-- Medical Certificate -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Medical Certificate
                                </label>
                                <input type="file" name="medical_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <!-- Student Photo -->
                            <div class="col-sm-6">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Student Photo
                                </label>
                                <input type="file" name="student_photo" class="form-control" accept=".jpg,.jpeg,.png">
                            </div>
                            <!-- Additional Documents -->
                            <div class="col-sm-12">
                                <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                                    Additional Documents
                                </label>
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
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Document Section --> -->
            <div class="col-lg-12">
                <div class="shadow-1 radius-12 bg-base h-100 overflow-hidden">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Academic Documents</h6>
                    </div>
                    <div class="card-body p-20">
                        <div id="document-sections">
                            <div class="text-center text-secondary-light mb-3" id="no-qualification-message">
                                <p>Please select your Last Academic Qualification to see relevant document upload fields.</p>
                            </div>
                            
                            <!-- Class 10 Documents -->
                            <div class="document-section" id="class10-docs" style="display: none;">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Class 10 Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Marksheet</label>
                                        <input type="file" name="class10_marksheet" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Certificate</label>
                                        <input type="file" name="class10_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="class10_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="class10_other_name" class="form-control mb-2" placeholder="Document name">
                                        <input type="file" name="class10_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Diploma Documents -->
                            <div class="document-section" id="diploma-docs" style="display: none;">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Diploma Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Marksheet</label>
                                        <input type="file" name="diploma_marksheet" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Certificate</label>
                                        <input type="file" name="diploma_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="diploma_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Registration</label>
                                        <input type="file" name="diploma_registration" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="diploma_other_name" class="form-control mb-2" placeholder="Document name">
                                        <input type="file" name="diploma_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Grade 12 Documents -->
                            <div class="document-section" id="grade12-docs" style="display: none;">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Grade 12 Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Transcript</label>
                                        <input type="file" name="grade12_transcript" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Provisional</label>
                                        <input type="file" name="grade12_provisional" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Migrational</label>
                                        <input type="file" name="grade12_migrational" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="grade12_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="grade12_other_name" class="form-control mb-2" placeholder="Document name">
                                        <input type="file" name="grade12_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bachelor Documents -->
                            <div class="document-section" id="bachelor-docs" style="display: none;">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Bachelor Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Transcript</label>
                                        <input type="file" name="bachelor_transcript" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Degree</label>
                                        <input type="file" name="bachelor_degree" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Provisional</label>
                                        <input type="file" name="bachelor_provisional" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Character</label>
                                        <input type="file" name="bachelor_character" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="bachelor_other_name" class="form-control mb-2" placeholder="Document name">
                                        <input type="file" name="bachelor_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Masters Documents -->
                            <div class="document-section" id="masters-docs" style="display: none;">
                                <h6 class="text-md fw-semibold mb-3 text-primary-light">Masters Documents</h6>
                                <div class="row gy-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Transcript</label>
                                        <input type="file" name="masters_transcript" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Degree</label>
                                        <input type="file" name="masters_degree" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Provisional</label>
                                        <input type="file" name="masters_provisional" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Others (Please specify)</label>
                                        <input type="text" name="masters_other_name" class="form-control mb-2" placeholder="Document name">
                                        <input type="file" name="masters_other_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center gap-3 mt-8">
                    <a href="{{ route('students.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8 text-decoration-none">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary-600 border border-primary-600 text-md px-28 py-12 radius-8">
                        Save Student
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize flatpickr for date of birth
    $('.flatpickr').flatpickr({
        dateFormat: "Y-m-d",
        maxDate: "today",
        yearRange: [1950, new Date().getFullYear()],
        defaultDate: null,
        allowInput: true
    });
    
    // Show/hide other qualification field
    $('#last_qualification').on('change', function() {
        const qualification = $(this).val();
        
        // Hide all document sections first
        $('.document-section').hide();
        $('#no-qualification-message').hide();
        
        if (qualification === 'Others') {
            $('#other_qualification_div').show();
        } else {
            $('#other_qualification_div').hide();
            $('#other_qualification').val('');
        }
        
        // Show relevant document section
        if (qualification === '+2') {
            $('#class10-docs, #grade12-docs').show();
        } else if (qualification === 'Diploma') {
            $('#class10-docs, #diploma-docs').show();
        } else if (qualification === 'Bachelor') {
            $('#class10-docs, #grade12-docs, #bachelor-docs').show();
        } else if (qualification === 'Masters') {
            $('#class10-docs, #grade12-docs, #bachelor-docs, #masters-docs').show();
        } else if (qualification === '') {
            $('#no-qualification-message').show();
        }
    });
    
    // Show/hide other english test field
    $('#english_test').on('change', function() {
        if ($(this).val() === 'Others') {
            $('#other_english_test_div').show();
        } else {
            $('#other_english_test_div').hide();
            $('#other_english_test').val('');
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
        
        // Show remove buttons for all items except first
        $('.remove-doc').show();
    });
    
    // Remove document functionality
    $(document).on('click', '.remove-doc', function() {
        $(this).closest('.additional-doc-item').remove();
        
        // Hide remove button if only one item left
        if ($('.additional-doc-item').length === 1) {
            $('.remove-doc').hide();
        }
    });
    
    // University and Course Management
    let universityIndex = 0;
    
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
</script>
@endpush