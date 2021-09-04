<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStudentTable extends Migration
{


    public function up()
    {
        Schema::create('course_student', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->boolean('paid')->default(0);
            $table->date('join_date')->currentTime();
        });
    }

               

    public function down()
    {
        Schema::dropIfExists('course_student');
    }
}
