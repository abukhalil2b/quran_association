<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model {
	protected $fillable = ['title', 'building_id', 'semester_id','quarterly'];
	public function building() {
		return $this->belongsTo(Building::class);
	}
	public function semester() {
		return $this->belongsTo(Semester::class);
	}
	public function circles() {
		return $this->hasMany(Circle::class);
	}
	public function userProgramPermission() {
		return $this->belongsToMany(User::class, 'user_program_permission', 'program_id', 'user_id');
	}

	public function checkUserPermission($user) {
		$program = $this->whereHas('userProgramPermission', function ($q) use ($user) {
			$q->where([
				'user_program_permission.user_id' => $user->id,
				'user_program_permission.program_id' => $this->id,
			]);
		})->first();
		if (!$program) {
			abort(401,'لا تملك الصلاحيات');
		}
		return $program;
	}
}
