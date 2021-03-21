<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model {
	protected $fillable = ['title', 'avatar', 'active', 'owner'];
	public function accountOwner() {
		return $this->belongsTo(User::class, 'owner');
	}

	public function userTrainerPermission() {
		return $this->belongsToMany(User::class, 'user_trainer_permission', 'trainer_id', 'user_id');
	}
}
