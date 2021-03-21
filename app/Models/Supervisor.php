<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model {
	protected $fillable = ['title', 'avatar', 'active', 'owner'];
	public function accountOwner() {
		return $this->belongsTo(User::class, 'owner');
	}
	public function circles() {
		return $this->hasMany(Circle::class);
	}

	public function userSupervisorPermission() {
		return $this->belongsToMany(User::class, 'user_supervisor_permission', 'supervisor_id', 'user_id');
	}

	public function usercenter() {
		return User::whereHas('userSupervisorPermission', function ($q) {
			$q->where('user_supervisor_permission.supervisor_id', $this->id);
		})->first();
	}

}
