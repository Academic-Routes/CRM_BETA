<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
            // Counselors see students they sent to application (not yet completed)
            $students = Student::with(['counselor', 'applicationStaff'])
                ->where('counselor_id', $user->id)
                ->whereIn('status', ['Sent to Application', 'Application In Review'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Others see all sent to application (not yet completed)
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
        $studentData['additional_documents'] = json_encode($additionalDocs);

        // Handle other qualification names
        $studentData['class10_other_name'] = $request->class10_other_name;
        $studentData['diploma_other_name'] = $request->diploma_other_name;
        $studentData['grade12_other_name'] = $request->grade12_other_name;
        $studentData['bachelor_other_name'] = $request->bachelor_other_name;
        $studentData['masters_other_name'] = $request->masters_other_name;

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
        
        // Send notification when student is added (except when counselor creates for themselves)
        if (!$user->hasRole('Counselor')) {
            NotificationService::notifyStudentAdded($student, $user);
        }
        
        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $user = Auth::user();
        
        // Check if counselor/frontdesk can edit
        if ($user->hasRole('Counselor') || $user->hasRole('FrontDesk')) {
            if (in_array($student->status, ['Sent to Application', 'Application In Review', 'Completed'])) {
                return redirect()->route('students.show', $student)
                               ->with('info', 'You can only view this student as it has been sent to application.');
            }
            
            if ($user->hasRole('Counselor') && $student->counselor_id !== $user->id && $student->created_by !== $user->id) {
                abort(403);
            }
            
            // FrontDesk gets special edit view for status management only
            if ($user->hasRole('FrontDesk')) {
                $counselors = User::whereHas('role', function($q) {
                    $q->where('name', 'Counselor');
                })->get();
                return view('admin.students.edit-frontdesk', compact('student', 'counselors'));
            }
        } elseif ($user->hasRole('Application')) {
            // Application users can only edit status management
            if (!in_array($student->status, ['Sent to Application', 'Application In Review'])) {
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
        } elseif ($user->hasRole('Application')) {
            // Application users can only update status - skip other fields
            $studentData = [];
            if ($request->has('status')) {
                $studentData['status'] = $request->status;
            }
        }

        // Handle file uploads (skip for Application users)
        if (!$user->hasRole('Application')) {
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

        return response()->file($filePath);
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
}