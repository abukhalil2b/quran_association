<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MemorizedJuz extends Model
{
	public $timestamps=false;
    protected $fillable = ['juz_id'	,'student_id'];
    public function juz() {
		return $this->belongsTo(Juz::class);
	}
}
