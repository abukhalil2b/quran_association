<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model {
	protected $fillable = ['trainee_id', 'student_id', 'point', 'trainer_id', 'teacher_id', 'course_id', 'circle_id', 'note', 'cate'];
	public function student() {
		return $this->belongsTo(Student::class);
	}
}
