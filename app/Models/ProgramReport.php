<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramReport extends Model
{
	// protected $table='program_reports';
    use HasFactory;
    protected $fillable = [
    	'student_id',
	    'teacher_id',
	    'circle_id',
	    'owned_by_usercenter_id',
	    'donedate',
	    'tobedonedate',
	    'todaymission',
	    'nextmission',
	    'evaluation',
	    'note'
	];

	public function student(){
		return $this->belongsTo(Student::class);
	}
	public function teacher(){
		return $this->belongsTo(Teacher::class);
	}
	public function circle(){
		return $this->belongsTo(Circle::class);
	}
}
