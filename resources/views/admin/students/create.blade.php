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
                        <button type="button" id="add-document-type" class="btn btn-primary-600 btn-sm">
                            <i class="ri-add-line"></i> Add Document
                        </button>
                    </div>
                    <div class="card-body p-20">
                        <div id="document-types-container">
                            <div class="text-center text-muted py-4" id="no-documents-message">
                                <p>Click "Add Document" to upload documents</p>
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
                        <button type="button" id="add-academic-level" class="btn btn-primary-600 btn-sm">
                            <i class="ri-add-line"></i> Add Academic Level
                        </button>
                    </div>
                    <div class="card-body p-20">
                        <div id="academic-levels-container">
                            <div class="text-center text-muted py-4" id="no-academic-message">
                                <p>Click "Add Academic Level" to upload documents for different academic levels</p>
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
    
    // Upload Documents Management
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
            const select = $(this).find('.document-type-select');
            if (select.val() && select.val() !== 'other') {
                usedTypes.push(select.val());
            }
        });
        
        // Create options for unused document types
        let options = '<option value="">Select Document Type</option>';
        Object.keys(documentTypes).forEach(key => {
            if (!usedTypes.includes(key)) {
                options += `<option value="${key}">${documentTypes[key]}</option>`;
            }
        });
        
        const newDocumentItem = `
            <div class="document-type-item border border-neutral-200 rounded-8 p-16 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-md fw-semibold mb-0 text-primary-light">New Document</h6>
                    <button type="button" class="btn btn-danger-600 btn-sm remove-document-type">
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
                        <input type="file" class="form-control document-file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" disabled>
                        <small class="text-muted">Select document type first</small>
                    </div>
                </div>
                <div class="other-document-name" style="display: none;">
                    <div class="row gy-3 mt-2">
                        <div class="col-md-12">
                            <label class="text-sm fw-semibold text-primary-light d-inline-block mb-8">Document Name</label>
                            <input type="text" class="form-control other-doc-name" name="other_document_names[]" placeholder="Please specify document name">
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#document-types-container').append(newDocumentItem);
        $('#no-documents-message').hide();
    });
    
    // Remove document type
    $(document).on('click', '.remove-document-type', function() {
        $(this).closest('.document-type-item').remove();
        
        if ($('.document-type-item').length === 0) {
            $('#no-documents-message').show();
        }
    });
    
    // Document type selection
    $(document).on('change', '.document-type-select', function() {
        const selectedType = $(this).val();
        const fileInput = $(this).closest('.document-type-item').find('.document-file');
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
    
    // Show/hide other qualification field
    $('#last_qualification').on('change', function() {
        if ($(this).val() === 'Others') {
            $('#other_qualification_div').show();
        } else {
            $('#other_qualification_div').hide();
            $('#other_qualification').val('');
        }
    });
    
    // Academic Documents Management
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
    
    // Update remove buttons visibility
    function updateRemoveButtons() {
        const levelItems = $('.academic-level-item');
        if (levelItems.length > 1) {
            $('.remove-academic-level').show();
        } else {
            $('.remove-academic-level').hide();
        }
    }
    
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