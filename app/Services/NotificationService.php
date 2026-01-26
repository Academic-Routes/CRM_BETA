<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function notifyStudentAdded($student, $fromUser)
    {
        $recipients = User::whereHas('role', function($query) {
            $query->whereIn('name', ['Super Admin', 'Admin', 'Supervisor']);
        })->where('id', '!=', $fromUser->id)->get();

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
        Notification::createNotification(
            'student_assigned',
            'Student Assigned',
            "Student '{$student->name}' has been assigned to you by {$fromUser->name}",
            $counselor->id,
            $fromUser->id,
            ['student_id' => $student->id]
        );
    }

    public static function notifyStatusChanged($student, $oldStatus, $newStatus, $fromUser)
    {
        $recipients = collect();

        // Notify assigned counselor if exists
        if ($student->assigned_counselor_id) {
            $recipients->push(User::find($student->assigned_counselor_id));
        }

        // Notify admins and supervisors
        $adminUsers = User::whereHas('role', function($query) {
            $query->whereIn('name', ['Super Admin', 'Admin', 'Supervisor']);
        })->where('id', '!=', $fromUser->id)->get();

        $recipients = $recipients->merge($adminUsers)->unique('id');

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