<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Circle extends Model {

	protected $fillable = ['title', 'program_id', 'supervisor_id', 'teacher_id','timestart','duration'];
	
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


	public function checkStudentInCircle($student){
		 $student = $this->students()->where('students.id',$student->id)->first();
		 if($student){
		 	return $student;
		 }
		 abort(401);
		 
	}

	public function canWriteReport(Student $student){
		$subscription = DB::table('circle_student')
		->where(['student_id'=>$student->id,'circle_id'=>$this->id])
		->first();
		return$subscription->can_write_his_report==1?true:false;
			
	}


	public function studentStudyStatus(Student $student){
		$status = DB::table('circle_student')
		->where(['student_id'=>$student->id,'circle_id'=>$this->id])
		->first()->status;
		return$status;
	}

	public function getTimestartAttribute($value){
        return $value==null?'': \Carbon\Carbon::parse($value)->format('H:i');
	}

	

}
