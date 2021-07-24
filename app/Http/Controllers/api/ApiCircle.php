<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CircleResource;
use App\Models\Circle;
use App\Models\Student;
use Illuminate\Http\Request;
use DB;
class ApiCircle extends Controller
{
	public function circles(Request $request,Student $student) {
		$user = auth()->user();
		$teacher =$user->teacherAccount;
		$circles = Circle::whereHas('students',function($q)use($student){
			$q->where(['circle_student.student_id'=>$student->id]);
		})->where('teacher_id',$teacher->id)->get();
		return response(CircleResource::collection($circles), 201);
	}
}
