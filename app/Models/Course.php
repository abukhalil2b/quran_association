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
		'language',
		'level',
		'deliveryMeans',
		'active',
		'trainer_id',
		'cate_id',
		'building_id',
		'user_id',
	];

	public function trainees() {
		return $this->belongsToMany(Trainee::class, 'trainee_course', 'course_id', 'trainee_id')->withTimestamps();
	}

	public function trainer() {
		return $this->belongsTo(Trainer::class);
	}
	public function user() {
		return $this->belongsTo(User::class);
	}

	public function marks() {
		return $this->hasMany(Mark::class);
	}

	public function details() {
		return $this->hasMany(Coursedetail::class);
	}

	public function subscribers() {
		return $this->belongsToMany(Trainee::class, 'trainee_course', 'course_id', 'trainee_id')
			->withPivot(['ispaid', 'free', 'fee'])->withTimestamps();
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
