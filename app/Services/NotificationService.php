<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function notifyStudentAdded($student, $fromUser)
    {
        $recipients = collect();
        
        // Always notify Admin, Super Admin, Supervisor, and FrontDesk when any student is added
        $managementAndFrontDesk = User::whereHas('role', function($query) {
            $query->whereIn('name', ['Super Admin', 'Admin', 'Supervisor', 'FrontDesk']);
        })->where('id', '!=', $fromUser->id)->get();
        
        $recipients = $recipients->merge($managementAndFrontDesk);
        
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            Notification::createNotification(
                'student_added',
                'New Student Added',
                "A new student '{$student->name}' has been added by {$fromUser->name}",
                $recipient->id,
                $fromUser->id,
                ['student_id' => $student->id]
            );
        }
    }

    public static function notifyStudentAssigned($student, $counselor, $fromUser)
    {
        // Notify the assigned counselor
        Notification::createNotification(
            'student_assigned',
            'Student Assigned',
            "Student '{$student->name}' has been assigned to you by {$fromUser->name}",
            $counselor->id,
            $fromUser->id,
            ['student_id' => $student->id]
        );
        
        // Also notify Admin, Supervisor, Super Admin about the assignment
        $managementUsers = User::whereHas('role', function($query) {
            $query->whereIn('name', ['Super Admin', 'Admin', 'Supervisor']);
        })->where('id', '!=', $fromUser->id)->get();
        
        foreach ($managementUsers as $recipient) {
            Notification::createNotification(
                'student_assigned_info',
                'Student Assignment Update',
                "Student '{$student->name}' has been assigned to {$counselor->name} by {$fromUser->name}",
                $recipient->id,
                $fromUser->id,
                ['student_id' => $student->id, 'counselor_id' => $counselor->id]
            );
        }
    }

    public static function notifyStatusChanged($student, $oldStatus, $newStatus, $fromUser)
    {
        $recipients = collect();

        // Notify assigned counselor if exists
        if ($student->counselor_id) {
            $counselor = User::find($student->counselor_id);
            if ($counselor) {
                $recipients->push($counselor);
            }
        }

        // Notify admins, supervisors, and frontdesk
        $managementAndFrontDesk = User::whereHas('role', function($query) {
            $query->whereIn('name', ['Super Admin', 'Admin', 'Supervisor', 'FrontDesk']);
        })->where('id', '!=', $fromUser->id)->get();

        $recipients = $recipients->merge($managementAndFrontDesk)->unique('id');

        foreach ($recipients as $recipient) {
            if ($recipient) {
                Notification::createNotification(
                    'status_changed',
                    'Student Status Updated',
                    "Student '{$student->name}' status changed from '{$oldStatus}' to '{$newStatus}' by {$fromUser->name}",
                    $recipient->id,
                    $fromUser->id,
                    ['student_id' => $student->id, 'old_status' => $oldStatus, 'new_status' => $newStatus]
                );
            }
        }
    }

    public static function notifyAssignmentByRole($student, $assignedUser, $fromUser, $assignmentType)
    {
        $title = ucfirst($assignmentType) . ' Assignment';
        $message = "Student '{$student->name}' has been assigned to you as {$assignmentType} by {$fromUser->name}";

        Notification::createNotification(
            'assignment_' . $assignmentType,
            $title,
            $message,
            $assignedUser->id,
            $fromUser->id,
            ['student_id' => $student->id, 'assignment_type' => $assignmentType]
        );
    }
}