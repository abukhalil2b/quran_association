<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MemorizedSowar extends Model
{
	public $timestamps = false;
    protected $fillable = ['sowar_id'	,'student_id'];
    public function sowar() {
		return $this->belongsTo(Sowar::class);
	}
}
