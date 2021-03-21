<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model {
	protected $fillable = ['title', 'user_id'];
	public function programs() {
		return $this->hasMany(Program::class);
	}
	public function user() {
		return $this->belongsTo(User::class, 'user_id');
	}
	public function userBuildingPermission() {
		return $this->belongsToMany(User::class, 'user_building_permission', 'building_id', 'user_id');
	}
}
