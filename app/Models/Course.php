<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
	protected $fillable = [
		'title',
		'imgurl',
		'shortDescription',
		'longDescription',
		'startAt',
		'endAt',
		'startTime',
		'duration',
		'registerStartAt',
		'registerEndAt',
		'weekDays',
		'requireNumber',
		'status',
		'free',
		'price',
		'level',
		'deliveryMeans',
		'active',
		'teacher_id',
		'cate_id',
		'building_id',
		'user_id',
		'male_certificate_url',
		'path',
		'female_certificate_url'
	];


	public function user() {
		return $this->belongsTo(User::class);
	}

	public function teacher() {
		return $this->belongsTo(Teacher::class);
	}

	public function marks() {
		return $this->hasMany(Mark::class);
	}

	public function details() {
		return $this->hasMany(Coursedetail::class);
	}

	public function subscribers() {
		return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id')
			->withPivot(['paid','join_date','certificate_url']);
	}

	public function certificates(){
    	return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id')
			->as('certificate')
			->withPivot(['paid','join_date']);
    }

	public function getWeekDaysAttribute($value) {
		if ($value) {
			return explode(' ', $value);
		}
		return [];
	}

	public function setWeekDaysAttribute($value) {
		$this->attributes['weekDays'] = is_array($value) ? implode(' ', $value) : NULL;
	}

	public function checkUserPermission($user) {
		$course = $this->where('user_id', $user->id)->first();
		if (!$course) {
			abort(401,'لا تملك الصلاحيات');
		}
		return $course;
	}

}
