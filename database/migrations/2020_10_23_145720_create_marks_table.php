<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('marks', function (Blueprint $table) {
			$table->id();
			$table->integer('student_id')->nullable()->unsigned();
			$table->integer('teacher_id')->nullable()->unsigned();
			$table->integer('point');
			$table->integer('course_id')->nullable()->unsigned();
			$table->integer('circle_id')->nullable()->unsigned();
			$table->string('note')->nullable();
			$table->string('cate')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('marks');
	}
}
