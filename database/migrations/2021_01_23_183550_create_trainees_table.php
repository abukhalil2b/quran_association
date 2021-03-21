<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraineesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('trainees', function (Blueprint $table) {
			$table->id();
			$table->string('model')->default('trainee');
			$table->integer('owner')->unsigned()->unique();
			$table->string('title')->nullable();
			$table->string('avatar')->nullable();
			$table->boolean('active')->default(1);
			$table->string('password')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('trainees');
	}
}
