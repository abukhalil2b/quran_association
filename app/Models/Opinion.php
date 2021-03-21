<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model {
	protected $fillable = ['trainee_id', 'student_id', 'point', 'course_id', 'program_id', 'note'];
}
