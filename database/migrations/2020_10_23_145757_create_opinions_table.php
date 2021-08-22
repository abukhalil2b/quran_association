<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpinionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('opinions', function (Blueprint $table) {
			$table->id();
			$table->integer('student_id')->nullable()->unsigned();
			$table->integer('course_id')->nullable()->unsigned();
			$table->integer('program_id')->nullable()->unsigned();
			$table->integer('point')->unsigned();
			$table->string('note')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('opinions');
	}
}
