<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model {
	protected $fillable = ['title'];
	public function semesters() {
		return $this->hasMany(Semester::class, 'year_id');
	}

	public function lastSemester() {
		$lastSemester = $this->semesters()->orderby('semesters.id', 'desc')->first();
		if (!$lastSemester) {
			die('لا يوجد فصول دراسية');
		}
		return $lastSemester;

	}
}
