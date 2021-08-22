<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relations extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		
		Schema::create('circle_student', function (Blueprint $table) {
			$table->id();
			$table->integer('student_id')->unsigned();
			$table->integer('circle_id')->unsigned();
			$table->smallInteger('program')->unsigned();
			$table->bool('can_write_his_report')->default(0);//allow student to wirte his own report
			$table->string('status')->default('studying');
			$table->timestamps();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
			$table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
		});


		// permissions
		Schema::create('roles', function (Blueprint $table) {
			$table->id();
			$table->string('title');
		});

		Schema::create('permissions', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('slug');
			$table->string('cate');
		});
		Schema::create('user_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('permission_id')->unsigned();
		});
		Schema::create('role_permission', function (Blueprint $table) {
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();
		});
		Schema::create('user_role', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
		});
		Schema::create('user_finance_report_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('finance_report_id')->unsigned();
		});
		Schema::create('user_dailyrecord_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('dailyrecord_id')->unsigned();
		});
		Schema::create('user_building_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('building_id')->unsigned();
		});
		Schema::create('user_program_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('program_id')->unsigned();
		});
		
		Schema::create('user_circle_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('circle_id')->unsigned();
		});
		
		Schema::create('user_student_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('student_id')->unsigned();
		});

		Schema::create('user_teacher_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('teacher_id')->unsigned();
		});

		Schema::create('user_supervisor_permission', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('supervisor_id')->unsigned();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists(
			'trainee_course',
			'circle_student',
			'roles',
			'permissions',
			'user_permission',
			'role_permission',
			'user_role',
			'user_building',
			'user_finance_report_permission',
			'user_dailyrecord_permission',
			'user_building_permission',
			'user_teacher_permission',
			'user_student_permission',
			'user_trainee_permission',
			'user_supervisor_permission',
			'user_program_permission',
			'user_circle_permission',
			'user_trainer_permission',
		);
	}
}
