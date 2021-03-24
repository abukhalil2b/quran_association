<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('programs', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->integer('building_id');
			$table->integer('semester_id')->nullable();
			$table->boolean('quarterly')->default(0);// type of program weather every semester or daily until finsh his program
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('programs');
	}
}
