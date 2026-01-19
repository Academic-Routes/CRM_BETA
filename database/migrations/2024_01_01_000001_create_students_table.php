<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // Personal Info
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            
            // Educational Info
            $table->string('last_qualification')->nullable();
            $table->string('other_qualification')->nullable();
            $table->string('last_score')->nullable();
            $table->year('passed_year')->nullable();
            $table->string('interested_country')->nullable();
            $table->string('interested_course')->nullable();
            $table->string('interested_university')->nullable();
            $table->string('english_test')->nullable();
            $table->string('other_english_test')->nullable();
            $table->string('english_test_score')->nullable();
            
            // Document Paths
            $table->string('passport')->nullable();
            $table->string('lor')->nullable();
            $table->string('moi')->nullable();
            $table->string('cv')->nullable();
            $table->string('sop')->nullable();
            $table->string('transcripts')->nullable();
            $table->string('english_test_doc')->nullable();
            $table->string('financial_docs')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->string('student_photo')->nullable();
            
            // Academic Documents
            $table->string('class10_marksheet')->nullable();
            $table->string('class10_certificate')->nullable();
            $table->string('class10_character')->nullable();
            $table->string('class10_other_name')->nullable();
            $table->string('class10_other_file')->nullable();
            
            $table->string('diploma_marksheet')->nullable();
            $table->string('diploma_certificate')->nullable();
            $table->string('diploma_character')->nullable();
            $table->string('diploma_registration')->nullable();
            $table->string('diploma_other_name')->nullable();
            $table->string('diploma_other_file')->nullable();
            
            $table->string('grade12_transcript')->nullable();
            $table->string('grade12_provisional')->nullable();
            $table->string('grade12_migrational')->nullable();
            $table->string('grade12_character')->nullable();
            $table->string('grade12_other_name')->nullable();
            $table->string('grade12_other_file')->nullable();
            
            $table->string('bachelor_transcript')->nullable();
            $table->string('bachelor_degree')->nullable();
            $table->string('bachelor_provisional')->nullable();
            $table->string('bachelor_character')->nullable();
            $table->string('bachelor_other_name')->nullable();
            $table->string('bachelor_other_file')->nullable();
            
            $table->string('masters_transcript')->nullable();
            $table->string('masters_degree')->nullable();
            $table->string('masters_provisional')->nullable();
            $table->string('masters_other_name')->nullable();
            $table->string('masters_other_file')->nullable();
            
            // Additional Documents (JSON for multiple documents)
            $table->json('additional_documents')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};