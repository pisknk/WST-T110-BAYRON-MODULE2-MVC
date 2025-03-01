<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('subject_code');
            $table->decimal('grade', 3, 2);
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate grades
            $table->unique(['student_id', 'subject_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}; 