<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model {
	protected $fillable = ['name', 'job', 'join', 'endAt', 'file'];
}
