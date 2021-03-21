<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceReportsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('finance_reports', function (Blueprint $table) {
			$table->id();
			$table->date('date');
			$table->string('title');
			$table->integer('inbank');
			$table->integer('totalExpenses');
			$table->integer('totalRevenues');
			$table->integer('balance');
			$table->integer('tax');
			$table->string('note')->nullable();
			$table->string('file')->nullable();
			$table->integer('user_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('finance_reports');
	}
}
