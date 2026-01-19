@extends('layouts.admin.master')

@section('title', 'View Student')

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
            <a href="{{ route('students.index') }}" class="btn btn-primary-600">Back to Students</a>
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
                        <div class="col-md-4">
                            <strong>Interested Course:</strong> {{ $student->interested_course ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Interested University:</strong> {{ $student->interested_university ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>English Test:</strong> {{ $student->english_test ?? 'Not provided' }}
                        </div>
                        <div class="col-md-4">
                            <strong>English Test Score:</strong> {{ $student->english_test_score ?? 'Not provided' }}
                        </div>
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
                    <a href="#" id="downloadBtn" class="btn btn-success shadow-lg" style="border-radius: 25px; padding: 12px 24px; font-weight: 600; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; transition: all 0.3s ease;" download onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(40,167,69,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.2)'">
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
    document.querySelectorAll('.preview-doc').forEach(function(button) {
        button.addEventListener('click', function() {
            const fileUrl = this.getAttribute('data-file');
            const fileType = this.getAttribute('data-type');
            const title = this.getAttribute('data-title');
            
            document.getElementById('documentModalTitle').textContent = title;
            document.getElementById('downloadBtn').href = fileUrl;
            const content = document.getElementById('documentContent');
            const spinner = document.getElementById('loadingSpinner');
            
            // Show loading spinner
            content.innerHTML = '';
            spinner.classList.remove('d-none');
            
            setTimeout(() => {
                spinner.classList.add('d-none');
                
                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                    content.innerHTML = `
                        <img src="${fileUrl}" style="max-width: 95%; max-height: 95%; object-fit: contain; box-shadow: 0 10px 40px rgba(255,255,255,0.1);" onload="this.style.opacity=1" style="opacity: 0; transition: opacity 0.5s ease;">
                    `;
                } else if (fileType === 'pdf') {
                    content.innerHTML = `
                        <embed src="${fileUrl}" type="application/pdf" width="100%" height="100%" style="border: none;">
                    `;
                } else {
                    content.innerHTML = `
                        <div style="padding: 60px; text-align: center; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                            <iconify-icon icon="solar:file-text-bold" style="font-size: 64px; color: #fff; margin-bottom: 20px;"></iconify-icon>
                            <h5 style="color: #fff; margin-bottom: 10px;">Preview not available</h5>
                            <p style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">This file type cannot be previewed in the browser.</p>
                            <a href="${fileUrl}" class="btn btn-light" style="border-radius: 25px; padding: 12px 25px; font-weight: 600;" download>
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
        });
    });
});
</script>
@endsection