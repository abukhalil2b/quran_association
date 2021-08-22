<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->integer('circle_id')->unsigned();
            $table->integer('owned_by_usercenter_id')->unsigned();
            $table->date('donedate')->nullable();//
            $table->date('tobedonedate')->nullable();//
            $table->text('todaymission')->nullable();//
            $table->text('nextmission')->nullable();//
            $table->string('evaluation')->nullable();
            $table->text('note')->nullable();
            $table->text('fathernote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_reports');
    }
}
