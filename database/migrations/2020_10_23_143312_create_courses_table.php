<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('courses', function (Blueprint $table) {
			$table->id();
			$table->string('title')->nullable();
			$table->string('imgurl')->nullable();
			$table->string('shortDescription')->nullable();
			$table->text('longDescription')->nullable();
			$table->date('startAt')->nullable();
			$table->date('endAt')->nullable();
			$table->time('startTime')->nullable();
			$table->smallInteger('duration')->nullable();
			$table->date('registerStartAt')->nullable();
			$table->date('registerEndAt')->nullable();
			$table->string('weekDays')->nullable();
			$table->string('requireNumber')->nullable();
			$table->string('status')->nullable();
			$table->boolean('free')->default(0);
			$table->double('price')->nullable();
			$table->string('language')->nullable();
			$table->string('level')->nullable();
			$table->string('deliveryMeans')->nullable();
			$table->string('forgender')->default('both');
			$table->boolean('active')->default(0);
			$table->integer('teacher_id')->unsigned();
			$table->integer('cate_id')->nullable()->unsigned();
			$table->integer('building_id')->nullable()->unsigned();
			$table->integer('user_id')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('courses');
	}
}
