<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration {

	public function up() {
		Schema::create('students', function (Blueprint $table) {
			$table->increments('id');
			$table->string('model')->default('student');
			$table->string('name')->nullable();
			$table->string('phone',8)->nullable();
			$table->string('gender',6);
			$table->string('avatar')->nullable();
			$table->string('createdby_model');
			$table->integer('createdby_id');
			$table->integer('usercenter_id');
			$table->string('password')->nullable();
			$table->boolean('active')->default(1);
			$table->integer('father_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('students');
	}
}
