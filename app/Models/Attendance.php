<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
	protected $fillable = ['student_id', 'teacher_id', 'trainer_id', 'trainee_id', 'supervisor_id', 'present', 'present_time', 'about', 'dailyrecord_id'];
	public function student() {
		return $this->belongsTo(Student::class);
	}
}
