<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentNote;
use App\Models\StudentUniversity;
use App\Models\Department;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->hasRole('Counselor')) {
            $query = Student::select('id', 'name', 'phone', 'status', 'counselor_id', 'created_at')
                           ->with(['counselor:id,name'])
                           ->where(function($q) use ($user) {
                               $q->where('counselor_id', $user->id)
                                 ->orWhere('created_by', $user->id);
                           });
            
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%');
                });
            }
            
            $students = $query->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.students.index', compact('students'));
        } elseif ($user->hasRole('FrontDesk')) {
            $query = Student::select('id', 'name', 'phone', 'status', 'counselor_id', 'created_at')
                           ->with(['counselor:id,name']);
            
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%');
                });
            }
            
            $students = $query->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.students.index', compact('students'));
        } elseif ($user->hasRole('Application')) {
            $query = Student::select('id', 'name', 'phone', 'status', 'counselor_id', 'application_staff_id', 'created_at')
                           ->with(['counselor:id,name', 'applicationStaff:id,name'])
                           ->where('application_staff_id', $user->id)
                           ->whereIn('status', ['Sent to Application', 'Application In Review']);
            
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%');
                });
            }
            
            $students = $query->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.students.sent-for-application', compact('students'));
        } else {
            $query = Student::select('id', 'name', 'phone', 'status', 'counselor_id', 'application_staff_id', 'created_at')
                          ->with(['counselor:id,name', 'applicationStaff:id,name']);
            
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%');
                });
            }
            
            if ($request->counselor_id) {
                $query->where('counselor_id', $request->counselor_id);
            }
            if ($request->application_staff_id) {
                $query->where('application_staff_id', $request->application_staff_id);
            }
            if ($request->status) {
                $query->where('status', $request->status);
            }
            if ($request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            $students = $query->orderBy('created_at', 'desc')->paginate(10);
            $counselors = User::select('id', 'name')->whereHas('role', function($q) { $q->where('name', 'Counselor'); })->get();
            $applicationStaff = User::select('id', 'name')->whereHas('role', function($q) { $q->where('name', 'Application'); })->get();
            $statuses = ['New', 'Assigned to Counselor', 'Documents Pending', 'Documents Completed', 'Sent to Application', 'Application In Review', 'Completed', 'On Hold', 'Rejected'];
            
            return view('admin.students.admin-index', compact('students', 'counselors', 'applicationStaff', 'statuses'));
        }
    }

    public function sentForApplication()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Counselor')) {
            $students = Student::with(['counselor', 'applicationStaff'])
                ->where('counselor_id', $user->id)
                ->whereIn('status', ['Sent to Application', 'Application In Review'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($user->hasRole('Application')) {
            $students = Student::with(['counselor', 'applicationStaff'])
                ->where('application_staff_id', $user->id)
                ->whereIn('status', ['Sent to Application', 'Application In Review'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $students = Student::with(['counselor', 'applicationStaff'])
                ->whereIn('status', ['Sent to Application', 'Application In Review'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
            
        return view('admin.students.sent-for-application', compact('students'));
    }

    public function applicationCompleted()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Counselor')) {
            // Show completed applications for students assigned to this counselor
            $students = Student::with(['counselor', 'applicationStaff'])
                ->where('counselor_id', $user->id)
                ->where('status', 'Completed')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($user->hasRole('Application') || $user->hasRole('FrontDesk') || $user->canManageRoles()) {
            // Show all completed applications for Application staff, FrontDesk and Admins
            $students = Student::with(['counselor', 'applicationStaff'])
                ->where('status', 'Completed')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            abort(403);
        }
            
        return view('admin.students.application-completed', compact('students'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Counselors, FrontDesk and Admins/Supervisors can create students
        if (!$user->hasRole('Counselor') && !$user->hasRole('FrontDesk') && !$user->canManageRoles()) {
            abort(403);
        }
        
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Counselors, FrontDesk and Admins/Supervisors can create students
        if (!$user->hasRole('Counselor') && !$user->hasRole('FrontDesk') && !$user->canManageRoles()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            // File validation for all document fields
            'passport' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'lor' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'moi' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'cv' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'sop' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'transcripts' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'english_test_doc' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'financial_docs' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'birth_certificate' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'medical_certificate' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'student_photo' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
            'additional_doc_files.*' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf,xls,xlsx,ppt,pptx,zip,rar',
        ]);

        // Prepare data for student creation
        $studentData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'last_qualification' => $request->last_qualification,
            'other_qualification' => $request->other_qualification,
            'last_score' => $request->last_score,
            'passed_year' => $request->passed_year,
            'interested_country' => $request->interested_country,
            'english_test' => $request->english_test,
            'other_english_test' => $request->other_english_test,
            'english_test_score' => $request->english_test_score,
            'created_by' => $user->id,
        ];
        
        // Auto-assign to counselor if created by counselor, FrontDesk creates with New status
        if ($user->hasRole('Counselor')) {
            $studentData['counselor_id'] = $user->id;
            $studentData['status'] = 'Assigned to Counselor';
        } else {
            $studentData['status'] = 'New';
        }

        // Handle file uploads with optimized storage
        $documentFields = [
            'passport', 'lor', 'moi', 'cv', 'sop', 'transcripts', 'english_test_doc',
            'financial_docs', 'birth_certificate', 'medical_certificate', 'student_photo',
            'class10_marksheet', 'class10_certificate', 'class10_character', 'class10_other_file',
            'diploma_marksheet', 'diploma_certificate', 'diploma_character', 'diploma_registration', 'diploma_other_file',
            'grade12_transcript', 'grade12_provisional', 'grade12_migrational', 'grade12_character', 'grade12_other_file',
            'bachelor_transcript', 'bachelor_degree', 'bachelor_provisional', 'bachelor_character', 'bachelor_other_file',
            'masters_transcript', 'masters_degree', 'masters_provisional', 'masters_other_file'
        ];

        $studentName = preg_replace('/[^A-Za-z0-9_-]/', '_', $request->name);
        $studentFolder = 'students/' . $studentName . '_' . time() . '/files';

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $studentData[$field] = $request->file($field)->store($studentFolder, 'public');
            }
        }

        // Handle additional documents with optimized storage
        $additionalDocs = [];
        if ($request->has('additional_doc_names')) {
            foreach ($request->additional_doc_names as $index => $name) {
                if ($name && $request->hasFile("additional_doc_files.{$index}")) {
                    $additionalDocs[] = [
                        'name' => $name,
                        'file' => $request->file("additional_doc_files.{$index}")->store($studentFolder, 'public')
                    ];
                }
            }
        }
        
        // Handle other documents
        if ($request->has('other_document_names') && $request->hasFile('other_documents')) {
            foreach ($request->other_document_names as $index => $name) {
                if ($name && $request->hasFile("other_documents.{$index}")) {
                    $additionalDocs[] = [
                        'name' => $name,
                        'file' => $request->file("other_documents.{$index}")->store($studentFolder, 'public')
                    ];
                }
            }
        }
        
        $studentData['additional_documents'] = json_encode($additionalDocs);

        // Handle academic documents
        $academicDocs = [];
        if ($request->has('academic_documents')) {
            foreach ($request->file('academic_documents') as $level => $files) {
                $academicDocs[$level] = [];
                foreach ($files as $file) {
                    $academicDocs[$level][] = $file->store($studentFolder, 'public');
                }
            }
        }
        $studentData['academic_documents'] = json_encode($academicDocs);

        $student = Student::create($studentData);
        
        // Handle universities and courses
        if ($request->has('universities') && $request->has('courses')) {
            foreach ($request->universities as $index => $university) {
                if ($university && isset($request->courses[$index])) {
                    foreach ($request->courses[$index] as $course) {
                        if ($course) {
                            $student->universities()->create([
                                'university_name' => $university,
                                'course_name' => $course,
                            ]);
                        }
                    }
                }
            }
        }
        
        // Send notification when student is added
        NotificationService::notifyStudentAdded($student, $user);
        
        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        $user = Auth::user();
        
        // Application users can only see students assigned to them
        if ($user->hasRole('Application') && $student->application_staff_id !== $user->id) {
            abort(403);
        }
        
        // Counselors can see students assigned to them or created by them
        if ($user->hasRole('Counselor') && $student->counselor_id !== $user->id && $student->created_by !== $user->id) {
            abort(403);
        }
        
        $student->load(['notes.user', 'universities']);
        
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $user = Auth::user();
        
        // Check if counselor/frontdesk can edit
        if ($user->hasRole('Counselor') || $user->hasRole('FrontDesk')) {
            if ($user->hasRole('Counselor') && $student->counselor_id !== $user->id && $student->created_by !== $user->id) {
                abort(403);
            }
            
            // Counselors can edit students sent to application (for notes only)
            if ($user->hasRole('Counselor') && in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed'])) {
                return view('admin.students.edit-counselor-notes', compact('student'));
            }
            
            // FrontDesk cannot edit students sent to application
            if ($user->hasRole('FrontDesk') && in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed'])) {
                return redirect()->route('students.show', $student)
                               ->with('info', 'You can only view this student as it has been sent to application.');
            }
            
            // FrontDesk gets special edit view for status management only
            if ($user->hasRole('FrontDesk')) {
                $counselors = User::whereHas('role', function($q) {
                    $q->where('name', 'Counselor');
                })->get();
                return view('admin.students.edit-frontdesk', compact('student', 'counselors'));
            }
        } elseif ($user->hasRole('Application')) {
            if (!in_array($student->status, ['Sent to Application', 'Application In Review']) || $student->application_staff_id !== $user->id) {
                abort(403);
            }
            
            return view('admin.students.edit-application', compact('student'));
        }
        
        $counselors = User::whereHas('role', function($q) { $q->where('name', 'Counselor'); })->get();
        $applicationStaff = User::whereHas('role', function($q) { $q->where('name', 'Application'); })->get();
        
        return view('admin.students.edit', compact('student', 'counselors', 'applicationStaff'));
    }

    public function update(Request $request, Student $student)
    {
        $user = Auth::user();
        
        // Admins/Supervisors can update any student, Counselors/FrontDesk can update their own
        if (!$user->canManageRoles() && !$user->hasRole('Application') && !$user->hasRole('Counselor') && !$user->hasRole('FrontDesk')) {
            abort(403);
        }

        // Validation - different for Application users
        if ($user->hasRole('Application')) {
            $request->validate([
                'status' => 'required|string',
            ]);
        } elseif ($user->hasRole('FrontDesk')) {
            $request->validate([
                'status' => 'required|string',
                'counselor_id' => 'nullable|exists:users,id',
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                // File validation for all document fields
                'passport' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'lor' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'moi' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'cv' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'sop' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'transcripts' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'english_test_doc' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'financial_docs' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'birth_certificate' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'medical_certificate' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'student_photo' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf',
                'additional_docs.*' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf,xls,xlsx,ppt,pptx,zip,rar',
                'app_additional_doc_files.*' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf,xls,xlsx,ppt,pptx,zip,rar',
            ]);
        }

        // Prepare data for student update
        if ($user->hasRole('Application')) {
            $studentData = [];
        } elseif ($user->hasRole('FrontDesk')) {
            $studentData = [];
        } else {
            $studentData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'last_qualification' => $request->last_qualification,
                'other_qualification' => $request->other_qualification,
                'last_score' => $request->last_score,
                'passed_year' => $request->passed_year,
                'interested_country' => $request->interested_country,
                'english_test' => $request->english_test,
                'other_english_test' => $request->other_english_test,
                'english_test_score' => $request->english_test_score,
            ];
        }

        // Admins can update status and assignments, Counselors can update status and application_staff_id
        if ($user->canManageRoles()) {
            if ($request->has('status')) {
                $studentData['status'] = $request->status;
            }
            if ($request->has('counselor_id')) {
                $studentData['counselor_id'] = $request->counselor_id;
            }
            if ($request->has('application_staff_id')) {
                $studentData['application_staff_id'] = $request->application_staff_id;
            }
        } elseif ($user->hasRole('Counselor') || $user->hasRole('FrontDesk')) {
            // Counselors and FrontDesk can update status and assign to application staff
            if ($request->has('status')) {
                $studentData['status'] = $request->status;
            }
            if ($request->has('application_staff_id')) {
                $studentData['application_staff_id'] = $request->application_staff_id;
            }
            // Both Counselors and FrontDesk can assign counselors
            if ($request->has('counselor_id')) {
                $studentData['counselor_id'] = $request->counselor_id;
            }
            
            // Handle counselor note addition
            if ($request->has('counselor_note') && $request->counselor_note) {
                $student->notes()->create([
                    'user_id' => $user->id,
                    'type' => 'counselor',
                    'note' => $request->counselor_note
                ]);
                
                // Notify application staff and management
                $recipients = collect();
                if ($student->applicationStaff) {
                    $recipients->push($student->applicationStaff);
                }
                $management = \App\Models\User::whereHas('role', function($q) {
                    $q->whereIn('name', ['Super Admin', 'Admin', 'Supervisor']);
                })->where('id', '!=', $user->id)->get();
                $recipients = $recipients->merge($management)->unique('id');
                
                foreach ($recipients as $recipient) {
                    \App\Models\Notification::createNotification(
                        'note_added',
                        'Counselor Note Added',
                        "Counselor note added for student '{$student->name}' by {$user->name}",
                        $recipient->id,
                        $user->id,
                        ['student_id' => $student->id]
                    );
                }
            }
        } elseif ($user->hasRole('Application')) {
            if ($student->application_staff_id !== $user->id) {
                abort(403);
            }
            $studentData = [];
            if ($request->has('status')) {
                $studentData['status'] = $request->status;
            }
            if ($request->has('application_email')) {
                $studentData['application_email'] = $request->application_email;
            }
            
            // Handle note addition
            if ($request->has('note') && $request->note) {
                $student->notes()->create([
                    'user_id' => $user->id,
                    'type' => 'application',
                    'note' => $request->note
                ]);
                
                // Notify counselor and management
                $recipients = collect();
                if ($student->counselor) {
                    $recipients->push($student->counselor);
                }
                $management = \App\Models\User::whereHas('role', function($q) {
                    $q->whereIn('name', ['Super Admin', 'Admin', 'Supervisor']);
                })->where('id', '!=', $user->id)->get();
                $recipients = $recipients->merge($management)->unique('id');
                
                foreach ($recipients as $recipient) {
                    \App\Models\Notification::createNotification(
                        'note_added',
                        'Application Note Added',
                        "Application note added for student '{$student->name}' by {$user->name}",
                        $recipient->id,
                        $user->id,
                        ['student_id' => $student->id]
                    );
                }
            }
        }

        // Handle file uploads
        if ($user->hasRole('Application')) {
            $studentName = preg_replace('/[^A-Za-z0-9_-]/', '_', $student->name);
            $studentFolder = 'students/' . $studentName . '_' . $student->id . '/files';
            
            if ($request->hasFile('sop')) {
                $studentData['sop'] = $request->file('sop')->store($studentFolder, 'public');
            }
            if ($request->hasFile('cv')) {
                $studentData['cv'] = $request->file('cv')->store($studentFolder, 'public');
            }
            
            if ($request->has('app_additional_doc_names')) {
                $existingDocs = is_string($student->additional_documents) ? json_decode($student->additional_documents, true) : $student->additional_documents;
                $existingDocs = $existingDocs ?? [];
                $newDocs = [];
                
                foreach ($request->app_additional_doc_names as $index => $name) {
                    if ($name && $request->hasFile("app_additional_doc_files.{$index}")) {
                        $newDocs[] = [
                            'name' => $name,
                            'file' => $request->file("app_additional_doc_files.{$index}")->store($studentFolder, 'public')
                        ];
                    }
                }
                
                if (!empty($newDocs)) {
                    $studentData['additional_documents'] = json_encode(array_merge($existingDocs, $newDocs));
                }
            }
        } elseif (!$user->hasRole('FrontDesk')) {
            $documentFields = [
                'passport', 'lor', 'moi', 'cv', 'sop', 'transcripts', 'english_test_doc',
                'financial_docs', 'birth_certificate', 'medical_certificate', 'student_photo',
                'class10_marksheet', 'class10_certificate', 'class10_character', 'class10_other_file',
                'diploma_marksheet', 'diploma_certificate', 'diploma_character', 'diploma_registration', 'diploma_other_file',
                'grade12_transcript', 'grade12_provisional', 'grade12_migrational', 'grade12_character', 'grade12_other_file',
                'bachelor_transcript', 'bachelor_degree', 'bachelor_provisional', 'bachelor_character', 'bachelor_other_file',
                'masters_transcript', 'masters_degree', 'masters_provisional', 'masters_other_file'
            ];
            
            $studentName = preg_replace('/[^A-Za-z0-9_-]/', '_', $student->name);
            $studentFolder = 'students/' . $studentName . '_' . $student->id . '/files';
            
            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $studentData[$field] = $request->file($field)->store($studentFolder, 'public');
                }
            }

            // Handle additional documents
            if ($request->has('additional_doc_names')) {
                $additionalDocs = [];
                foreach ($request->additional_doc_names as $index => $name) {
                    if ($name) {
                        $docData = ['name' => $name];
                        if ($request->hasFile("additional_docs.{$index}")) {
                            $docData['file'] = $request->file("additional_docs.{$index}")->store($studentFolder, 'public');
                        } elseif (isset($student->additional_documents[$index]['file'])) {
                            $docData['file'] = $student->additional_documents[$index]['file'];
                        }
                        $additionalDocs[] = $docData;
                    }
                }
                $studentData['additional_documents'] = $additionalDocs;
            }
            
            // Handle other documents
            if ($request->has('other_document_names') && $request->hasFile('other_documents')) {
                $existingDocs = is_string($student->additional_documents) ? json_decode($student->additional_documents, true) : $student->additional_documents;
                $existingDocs = $existingDocs ?? [];
                
                foreach ($request->other_document_names as $index => $name) {
                    if ($name && $request->hasFile("other_documents.{$index}")) {
                        $existingDocs[] = [
                            'name' => $name,
                            'file' => $request->file("other_documents.{$index}")->store($studentFolder, 'public')
                        ];
                    }
                }
                
                $studentData['additional_documents'] = json_encode($existingDocs);
            }
            
            // Handle upload document deletions
            if ($request->has('delete_upload_documents')) {
                foreach ($request->delete_upload_documents as $field) {
                    if ($student->$field && Storage::disk('public')->exists($student->$field)) {
                        Storage::disk('public')->delete($student->$field);
                    }
                    $studentData[$field] = null;
                }
            }
            
            // Handle academic documents deletion and addition
            $currentAcademicDocs = is_string($student->academic_documents) ? json_decode($student->academic_documents, true) : $student->academic_documents;
            $currentAcademicDocs = $currentAcademicDocs ?? [];
            
            // Handle deletions
            if ($request->has('delete_academic_documents')) {
                foreach ($request->delete_academic_documents as $deleteData) {
                    $deleteInfo = json_decode($deleteData, true);
                    $level = $deleteInfo['level'];
                    $path = $deleteInfo['path'];
                    
                    if (isset($currentAcademicDocs[$level])) {
                        $currentAcademicDocs[$level] = array_filter($currentAcademicDocs[$level], function($docPath) use ($path) {
                            return $docPath !== $path;
                        });
                        
                        // Remove level if empty
                        if (empty($currentAcademicDocs[$level])) {
                            unset($currentAcademicDocs[$level]);
                        }
                        
                        // Delete physical file
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                }
            }
            
            // Handle new documents for existing levels
            if ($request->hasFile('new_academic_documents')) {
                foreach ($request->file('new_academic_documents') as $level => $files) {
                    if (!isset($currentAcademicDocs[$level])) {
                        $currentAcademicDocs[$level] = [];
                    }
                    
                    foreach ($files as $file) {
                        $currentAcademicDocs[$level][] = $file->store($studentFolder, 'public');
                    }
                }
            }
            
            // Handle new academic levels
            if ($request->has('new_academic_levels')) {
                foreach ($request->new_academic_levels as $levelData) {
                    if (isset($levelData['level']) && $levelData['level'] && isset($levelData['documents'])) {
                        $level = $levelData['level'];
                        if (!isset($currentAcademicDocs[$level])) {
                            $currentAcademicDocs[$level] = [];
                        }
                        
                        foreach ($levelData['documents'] as $file) {
                            $currentAcademicDocs[$level][] = $file->store($studentFolder, 'public');
                        }
                    }
                }
            }
            
            $studentData['academic_documents'] = json_encode($currentAcademicDocs);
        }

        // Store original values before update for comparison
        $originalCounselorId = $student->counselor_id;
        $originalApplicationStaffId = $student->application_staff_id;
        $originalStatus = $student->status;
        
        $student->update($studentData);
        
        // Handle universities and courses update (skip for Application users)
        if (!$user->hasRole('Application') && $request->has('universities') && $request->has('courses')) {
            // Delete existing universities
            $student->universities()->delete();
            
            // Add new universities and courses
            foreach ($request->universities as $index => $university) {
                if ($university && isset($request->courses[$index])) {
                    foreach ($request->courses[$index] as $course) {
                        if ($course) {
                            $student->universities()->create([
                                'university_name' => $university,
                                'course_name' => $course,
                            ]);
                        }
                    }
                }
            }
        }

        // Send notifications for assignments and status changes
        if (isset($studentData['counselor_id']) && $studentData['counselor_id'] != $originalCounselorId) {
            $counselor = User::find($studentData['counselor_id']);
            if ($counselor) {
                NotificationService::notifyStudentAssigned($student, $counselor, $user);
            }
        }
        
        if (isset($studentData['application_staff_id']) && $studentData['application_staff_id'] != $originalApplicationStaffId) {
            $appStaff = User::find($studentData['application_staff_id']);
            if ($appStaff) {
                NotificationService::notifyAssignmentByRole($student, $appStaff, $user, 'application');
            }
        }
        
        if (isset($studentData['status']) && $studentData['status'] != $originalStatus) {
            NotificationService::notifyStatusChanged($student, $originalStatus, $studentData['status'], $user);
        }

        // Redirect based on user role
        if ($user->hasRole('Application')) {
            return redirect()->route('students.sent-for-application')->with('success', 'Student status updated successfully');
        } else {
            return redirect()->route('students.index')->with('success', 'Student updated successfully');
        }
    }

    public function submit(Student $student)
    {
        if ($student->counselor_id !== Auth::id() || $student->submitted) {
            abort(403);
        }

        $student->update([
            'submitted' => true,
            'submitted_at' => now(),
        ]);

        // Notify Application department
        $applicationUsers = User::whereHas('role', function($q) {
            $q->where('name', 'Application');
        })->get();

        return redirect()->route('students.index')->with('success', 'Student submitted to Application department');
    }

    public function getThumbnail(Student $student, $field)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id) && !$user->hasRole('Application')) {
            abort(403);
        }

        if (!$student->$field) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $student->$field);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = pathinfo($student->$field, PATHINFO_EXTENSION);
        
        if (strtolower($extension) === 'pdf') {
            try {
                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($filePath . '[0]'); // First page only
                $imagick->setImageFormat('jpeg');
                $imagick->scaleImage(200, 200, true);
                
                return response($imagick->getImageBlob())
                    ->header('Content-Type', 'image/jpeg')
                    ->header('Cache-Control', 'public, max-age=3600');
            } catch (\Exception $e) {
                // Fallback to default PDF icon if Imagick fails
                return response()->file(public_path('admin/assets/images/pdf-icon.png'));
            }
        }
        
        // For non-PDF files, return the original file
        return response()->file($filePath);
    }

    public function downloadDocument(Student $student, $field)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id) && !$user->hasRole('Application')) {
            abort(403);
        }

        if (!$student->$field) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $student->$field);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Get proper filename based on document type
        $extension = pathinfo($student->$field, PATHINFO_EXTENSION);
        $documentNames = [
            'passport' => 'Passport',
            'lor' => 'Letter_of_Recommendation',
            'moi' => 'Medium_of_Instruction',
            'cv' => 'CV_Resume',
            'sop' => 'Statement_of_Purpose',
            'transcripts' => 'Academic_Transcripts',
            'english_test_doc' => 'English_Test_Document',
            'financial_docs' => 'Financial_Documents',
            'birth_certificate' => 'Birth_Certificate',
            'medical_certificate' => 'Medical_Certificate',
            'student_photo' => 'Student_Photo'
        ];
        
        $fileName = isset($documentNames[$field]) ? $documentNames[$field] : ucfirst(str_replace('_', ' ', $field));
        $fileName = $student->name . '_' . $fileName . '.' . $extension;
        
        return response()->download($filePath, $fileName);
    }

    public function previewDocument(Student $student, $field)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id) && !$user->hasRole('Application')) {
            abort(403);
        }

        if (!$student->$field) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $student->$field);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = pathinfo($student->$field, PATHINFO_EXTENSION);
        $mimeType = mime_content_type($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline'
        ]);
    }

    public function deleteDocument(Student $student, $field)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id)) {
            abort(403);
        }

        if (!$student->$field) {
            return response()->json(['success' => false, 'message' => 'Document not found']);
        }

        $filePath = storage_path('app/public/' . $student->$field);
        
        if (file_exists($filePath)) {
            Storage::disk('public')->delete($student->$field);
        }

        $student->update([$field => null]);

        return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
    }

    public function deleteAdditionalDocument(Student $student, $index)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id)) {
            abort(403);
        }

        $additionalDocs = is_string($student->additional_documents) ? json_decode($student->additional_documents, true) : $student->additional_documents;
        $additionalDocs = $additionalDocs ?? [];

        if (!isset($additionalDocs[$index])) {
            return response()->json(['success' => false, 'message' => 'Document not found']);
        }

        $docPath = $additionalDocs[$index]['file'] ?? null;
        if ($docPath && Storage::disk('public')->exists($docPath)) {
            Storage::disk('public')->delete($docPath);
        }

        unset($additionalDocs[$index]);
        $additionalDocs = array_values($additionalDocs); // Re-index array

        $student->update(['additional_documents' => json_encode($additionalDocs)]);

        return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
    }

    public function deleteAcademicDocument(Student $student, $level, $index)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id)) {
            abort(403);
        }

        $academicDocs = is_string($student->academic_documents) ? json_decode($student->academic_documents, true) : $student->academic_documents;
        $academicDocs = $academicDocs ?? [];

        if (!isset($academicDocs[$level][$index])) {
            return response()->json(['success' => false, 'message' => 'Document not found']);
        }

        $docPath = $academicDocs[$level][$index];
        if (Storage::disk('public')->exists($docPath)) {
            Storage::disk('public')->delete($docPath);
        }

        unset($academicDocs[$level][$index]);
        $academicDocs[$level] = array_values($academicDocs[$level]); // Re-index array
        
        if (empty($academicDocs[$level])) {
            unset($academicDocs[$level]);
        }

        $student->update(['academic_documents' => json_encode($academicDocs)]);

        return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
    }

    public function download($studentId, $fileIndex)
    {
        $student = Student::findOrFail($studentId);
        
        if (!Auth::user()->hasRole('Application') && !Auth::user()->canEditStudent($student)) {
            abort(403);
        }

        $files = $student->files ?? [];
        if (!isset($files[$fileIndex])) {
            abort(404);
        }

        return Storage::download($files[$fileIndex]);
    }

    public function destroy(Student $student)
    {
        $user = Auth::user();
        
        // Counselors cannot delete students sent to application
        if ($user->hasRole('Counselor')) {
            if (in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed'])) {
                return redirect()->route('students.index')
                               ->with('error', 'Cannot delete student that has been sent to application.');
            }
            
            if ($student->counselor_id !== $user->id && $student->created_by !== $user->id) {
                abort(403);
            }
        } elseif (!$user->canManageRoles()) {
            abort(403);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }

    public function sendToApplication(Student $student)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('Counselor') || $student->counselor_id !== $user->id) {
            abort(403);
        }
        
        $student->update(['status' => 'Sent to Application']);
        
        return redirect()->route('students.index')->with('success', 'Student sent to Application department');
    }

    public function updateStatus(Request $request, Student $student)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('Application')) {
            abort(403);
        }
        
        $student->update(['status' => $request->status]);
        
        return redirect()->route('students.index')->with('success', 'Student status updated');
    }

    public function replaceDocument(Request $request, Student $student, $field)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id)) {
            abort(403);
        }

        $request->validate([
            'document' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,gif,doc,docx,txt,rtf'
        ]);

        $studentName = preg_replace('/[^A-Za-z0-9_-]/', '_', $student->name);
        $studentFolder = 'students/' . $studentName . '_' . $student->id . '/files';

        // Delete old file if exists
        if ($student->$field && Storage::disk('public')->exists($student->$field)) {
            Storage::disk('public')->delete($student->$field);
        }

        // Store new file
        $newPath = $request->file('document')->store($studentFolder, 'public');
        $student->update([$field => $newPath]);

        return response()->json([
            'success' => true, 
            'message' => 'Document replaced successfully',
            'file_url' => url('/storage/' . $newPath),
            'file_name' => basename($newPath)
        ]);
    }

    public function downloadAdditionalDocument(Student $student, $index)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id) && !$user->hasRole('Application')) {
            abort(403);
        }

        $additionalDocs = is_string($student->additional_documents) ? json_decode($student->additional_documents, true) : $student->additional_documents;
        $additionalDocs = $additionalDocs ?? [];

        if (!isset($additionalDocs[$index])) {
            abort(404);
        }

        $doc = $additionalDocs[$index];
        $filePath = storage_path('app/public/' . $doc['file']);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = pathinfo($doc['file'], PATHINFO_EXTENSION);
        $fileName = $student->name . '_' . ($doc['name'] ?? 'Additional_Document') . '.' . $extension;
        
        return response()->download($filePath, $fileName);
    }

    public function downloadAcademicDocument(Student $student, $level, $index)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !($user->hasRole('Counselor') && $student->counselor_id === $user->id) && !$user->hasRole('Application')) {
            abort(403);
        }

        $academicDocs = is_string($student->academic_documents) ? json_decode($student->academic_documents, true) : $student->academic_documents;
        $academicDocs = $academicDocs ?? [];

        if (!isset($academicDocs[$level][$index])) {
            abort(404);
        }

        $docPath = $academicDocs[$level][$index];
        $filePath = storage_path('app/public/' . $docPath);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = pathinfo($docPath, PATHINFO_EXTENSION);
        $levelNames = [
            'class10' => 'Class_10',
            'grade12' => 'Grade_12',
            'diploma' => 'Diploma',
            'bachelor' => 'Bachelor',
            'masters' => 'Masters'
        ];
        
        $levelName = isset($levelNames[$level]) ? $levelNames[$level] : ucfirst($level);
        $fileName = $student->name . '_' . $levelName . '_Document_' . ($index + 1) . '.' . $extension;
        
        return response()->download($filePath, $fileName);
    }
}