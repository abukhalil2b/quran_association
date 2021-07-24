<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {
	protected $fillable = ['title', 'avatar', 'active', 'owner'];
	public function accountOwner() {
		return $this->belongsTo(User::class, 'owner');
	}

	public function canOpenRecordAbout($about) {
		return $this->accountOwner->hasAboutPermission($about);
	}

	public function userTeacherPermission() {
		return $this->belongsToMany(User::class, 'user_teacher_permission', 'teacher_id', 'user_id');
	}

	public function circles() {
		return $this->hasMany(Circle::class);
	}

	public function usercenter() {
		$usercenter = User::whereHas('userTeacherPermission', function ($q) {
			$q->where('user_teacher_permission.teacher_id', $this->id);
		})->first();
		if($usercenter){
			return $usercenter;
		}
		abort(404);
	}

	public function checkUserPermission($user) {
		$teacher = $this->whereHas('userTeacherPermission', function ($q) use ($user) {
			$q->where([
				'user_teacher_permission.user_id' => $user->id,
				'user_teacher_permission.teacher_id' => $this->id,
			]);
		})->first();
		if (!$teacher) {
			abort(401,'لا تملك الصلاحيات');
		}
		return $teacher;
	}


	public function checkHisStudent($student) {
		// $teacher = $this->whereHas('circles', function ($q) use ($student) {
		// 	$q->whereHas('students',function($q) use($student){
		// 		$q->where('student_id',$student->id);
		// 	});
		// })->first();
		// if (!$teacher) {
		// 	abort(401,'لا تملك الصلاحيات');
		// }
		// return $teacher;

		$circle = $student->circles()->where('teacher_id',$this->id)->first();
		if(!$circle){
			abort(401,'لا تملك الصلاحيات');
		}
		return $circle;
	}
	
}
