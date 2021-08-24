<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dailyrecord extends Model {
	protected $fillable = ['title', 'circle_id'];
	
	public function userDailyrecordPermission() {
		return $this->belongsToMany(User::class, 'user_dailyrecord_permission', 'dailyrecord_id', 'user_id');
	}
	public function circle() {
		return $this->belongsTo(Circle::class);
	}

	public function Attendances() {
		return $this->hasMany(Attendance::class);
	}

	public function checkUserPermission($user) {
		$dailyrecord = $this->whereHas('userDailyrecordPermission', function ($q) use ($user) {
			$q->where([
				'user_dailyrecord_permission.user_id' => $user->id,
				'user_dailyrecord_permission.dailyrecord_id' => $this->id,
			]);
		})->first();
		if (!$dailyrecord) {
			abort(401,'لا تملك الصلاحيات');
		}
		return $dailyrecord;
	}
}
