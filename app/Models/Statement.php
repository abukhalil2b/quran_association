<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model {
	protected $fillable = ['date', 'state', 'amount','details'];

	public function count($date) {
		return $this->where('date', $date)->count();
	}

}
