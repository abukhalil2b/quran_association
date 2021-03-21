<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model {
	protected $fillable = ['date', 'state', 'amount', 'course_id'];

	public function count($date) {
		return $this->where('date', $date)->count();
	}

	public function course() {
		return $this->belongsTo(Course::class);
	}
}
