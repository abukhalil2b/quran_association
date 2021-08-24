<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCirclesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('circles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->integer('teacher_id')->nullable();
			$table->integer('supervisor_id')->nullable();
			$table->integer('program_id');
			$table->timestamps();
			$table->time('timestart')->currentTime();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('circles');
	}
}
