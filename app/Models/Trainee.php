<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Trainee extends Model {
	use HasApiTokens;
	protected $fillable = ['title', 'avatar', 'active', 'owner'];
	public function accountOwner() {
		return $this->belongsTo(User::class, 'owner');
	}

	public function courses() {
		return $this->belongsToMany(Course::class, 'trainee_course', 'trainee_id', 'course_id')->withTimestamps();
	}

	public function payments() {
		return $this->belongsToMany(Course::class, 'trainee_course', 'trainee_id', 'course_id')
			->as('payment')
			->withPivot('ispaid')->withTimestamps();
	}

	public function userTraineePermission() {
		return $this->belongsToMany(Trainee::class, 'user_trainee_permission', 'trainee_id', 'user_id');
	}
}
