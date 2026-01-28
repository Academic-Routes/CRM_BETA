<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentUniversity extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'university_name',
        'course_name',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}