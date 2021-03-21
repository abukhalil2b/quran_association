<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model {
	protected $fillable = ['title', 'program_id', 'supervisor_id', 'teacher_id'];
	public function students() {
		return $this->belongsToMany(Student::class, 'circle_student', 'circle_id', 'student_id')
			->withPivot('program')
			->withTimestamps();
	}
	public function teacher() {
		return $this->belongsTo(Teacher::class);
	}
	public function program() {
		return $this->belongsTo(Program::class);
	}
	public function supervisor() {
		return $this->belongsTo(Supervisor::class);
	}
	public function dailyrecords() {
		return $this->hasMany(Dailyrecord::class);
	}
	public function userCirclePermission() {
		return $this->belongsToMany(User::class, 'user_circle_permission', 'circle_id', 'user_id');
	}

	public function lastDailyrecord() {
		return $this->dailyrecords()->orderby('id', 'desc')->first();
	}

	public function checkUserPermission($user) {
		$circle = $this->whereHas('userCirclePermission', function ($q) use ($user) {
			$q->where([
				'user_circle_permission.user_id' => $user->id,
				'user_circle_permission.circle_id' => $this->id,
			]);
		})->first();
		if ($circle) return $circle;
			abort(401,'لا تملك الصلاحيات');
		
	}

}
