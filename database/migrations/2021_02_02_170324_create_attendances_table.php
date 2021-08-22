<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('attendances', function (Blueprint $table) {
			$table->id();
			$table->integer('student_id')->nullable();
			$table->integer('teacher_id')->nullable();
			$table->integer('supervisor_id')->nullable();
			$table->boolean('present')->default(0);
			$table->time('present_time')->nullable();
			$table->string('about')->default('student');
			$table->integer('dailyrecord_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('attendances');
	}
}
