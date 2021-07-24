<?php

namespace App\Http\Controllers\api;
use Carbon\Carbon;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Circle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherStudentResource;
use App\Http\Resources\TeacherCircleWithStudentResource;
use DB;
class ApiTeacher extends Controller
{

	public function circlesWithStudentIndex(Request $request) {
		$user = auth()->user();
		$response['circles']=[];
		if ($user->userType=='teacher') {
			$teacher = $user->teacherAccount;
			$circlesWithStudents = $teacher->circles()->with('students')->get();
			// $circlesIds = $teacher->circles()->pluck('id');
			//  $students = Student::whereHas('circles',function($q)use($circlesIds){
			// 	$q->whereIn('circle_student.circle_id',$circlesIds);
			// })->get();
			//  $response['student']=TeacherStudentResource::collection($students);
			$response['circles']= TeacherCircleWithStudentResource::collection($circlesWithStudents);
			return response($response, 200);
		}
        return response($response, 200);
	}

	public function toggleWriteReport(Student $student,Circle $circle) {
		$user = auth()->user();
		
		if ($user->userType=='teacher') {
			$circle_student = DB::table('circle_student')
			->where(['student_id'=>$student->id,'circle_id'=>$circle->id])->first();
			if($circle_student->can_write_his_report==1){
				$result =DB::table('circle_student')
				->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
				->update(['can_write_his_report'=>0]);
			}else{
				$result= DB::table('circle_student')
				->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
				->update(['can_write_his_report'=>1]);
			}
			$response['updated']=$result==1?true:false;
			return response($response, 200);
		}
        
	}


}
	
