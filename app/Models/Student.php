<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        // Personal Info
        'name',
        'phone',
        'email',
        'application_email',
        'gender',
        'date_of_birth',
        'address',
        
        // Educational Info
        'last_qualification',
        'other_qualification',
        'last_score',
        'passed_year',
        'interested_country',
        'interested_course',
        'interested_university',
        'english_test',
        'other_english_test',
        'english_test_score',
        
        // Document Paths
        'passport',
        'lor',
        'moi',
        'cv',
        'sop',
        'transcripts',
        'english_test_doc',
        'financial_docs',
        'birth_certificate',
        'medical_certificate',
        'student_photo',
        
        // Academic Documents
        'class10_marksheet',
        'class10_certificate',
        'class10_character',
        'class10_other_name',
        'class10_other_file',
        'diploma_marksheet',
        'diploma_certificate',
        'diploma_character',
        'diploma_registration',
        'diploma_other_name',
        'diploma_other_file',
        'grade12_transcript',
        'grade12_provisional',
        'grade12_migrational',
        'grade12_character',
        'grade12_other_name',
        'grade12_other_file',
        'bachelor_transcript',
        'bachelor_degree',
        'bachelor_provisional',
        'bachelor_character',
        'bachelor_other_name',
        'bachelor_other_file',
        'masters_transcript',
        'masters_degree',
        'masters_provisional',
        'masters_other_name',
        'masters_other_file',
        
        // Additional Documents
        'additional_documents',
        
        // System fields
        'counselor_id',
        'application_staff_id',
        'status',
        'created_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'additional_documents' => 'array',
    ];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function applicationStaff()
    {
        return $this->belongsTo(User::class, 'application_staff_id');
    }

    public function universities()
    {
        return $this->hasMany(StudentUniversity::class);
    }

    public function notes()
    {
        return $this->hasMany(StudentNote::class)->latest();
    }

    public function getDocumentCompletionPercentage()
    {
        $requiredDocs = ['passport', 'cv', 'sop', 'transcripts'];
        $uploadedCount = 0;
        
        foreach ($requiredDocs as $doc) {
            if (!empty($this->$doc)) {
                $uploadedCount++;
            }
        }
        
        return round(($uploadedCount / count($requiredDocs)) * 100);
    }
}