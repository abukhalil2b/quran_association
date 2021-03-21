<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model {
	protected $fillable = ['title', 'year_id'];
	public function year() {
		return $this->belongsTo(Year::class);
	}

	public function programs() {
		return $this->hasMany(Program::class);
	}

	public function lastSemesterPrograms() {
		return $this->programs()->where('semester_id', $this->id)->get();
	}
}
