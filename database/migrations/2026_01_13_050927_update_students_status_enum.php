<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop the existing enum and recreate with new values
        DB::statement("ALTER TABLE students MODIFY COLUMN status ENUM(
            'New',
            'Assigned to Counselor',
            'Documents Pending', 
            'Documents Completed',
            'Sent to Application',
            'Application In Review',
            'Completed',
            'On Hold',
            'Rejected'
        ) DEFAULT 'New'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE students MODIFY COLUMN status ENUM(
            'pending',
            'approved', 
            'rejected'
        ) DEFAULT 'pending'");
    }
};