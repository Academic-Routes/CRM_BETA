<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_universities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('university_name');
            $table->string('course_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_universities');
    }
};