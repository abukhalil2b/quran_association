<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Student extends Model {
	use HasApiTokens;
	protected $fillable = 
	[
		'active',
		'avatar',
		'name',
		'phone',
		'gender',
		'createdby_model',
		'createdby_id',
		'usercenter_id',
		'password',
		'father_id'
	];
	
	public function father() {
		return $this->belongsTo(Father::class);
	}

	public function marks() {
		return $this->hasMany(Mark::class);
	}

	public function attendances() {
		return $this->hasMany(Attendance::class);
	}

	public function course($id) {
		return Course::find($id);
	}

	public function courses() {
		return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
			->withPivot('paid','join_date');
	}

	public function certificates(){
    	return $this->hasMany(Certificate::class);
    }
    
	public function semester() {
		return $this->belongsToMany(Semester::class, 'circle_student', 'student_id', 'semester_id');
	}

	public function circles() {
		return $this->belongsToMany(Circle::class, 'circle_student', 'student_id', 'circle_id')
			->withPivot('program','can_write_his_report')
			->withTimestamps();
	}

	public function userStudentPermission() {
		return $this->belongsToMany(User::class, 'user_student_permission', 'student_id', 'user_id');
	}

	public function usercenter() {
		$usercenter = User::whereHas('userStudentPermission', function ($q) {
			$q->where('user_student_permission.student_id', $this->id);
		})->first();
		if($usercenter){
			return $usercenter;
		}
		abort(404);
	}

	public function checkUserPermission($user) {
		$student = $this->whereHas('userStudentPermission', function ($q) use ($user) {
			$q->where([
				'user_student_permission.user_id' => $user->id,
				'user_student_permission.student_id' => $this->id,
			]);
		})->first();
		if (!$student) {
			abort(401,'لا تملك الصلاحيات');
		}
		return $student;
	}

	public function memorizePrograms() {
		return $this->belongsToMany(MemorizeProgram::class, 'student_memorize_program', 'student_id', 'memorize_program_id');
	}

	public function memorizedJuzs() {
		return $this->hasMany(MemorizedJuz::class);
	}

	public function memorizedSowars() {
		return $this->hasMany(MemorizedSowar::class);
	}

}
