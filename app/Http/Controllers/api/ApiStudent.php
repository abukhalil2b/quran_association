<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\api\ApiCourse;
use App\Http\Resources\MemorizedJuzResource;
use App\Http\Resources\MemorizedSowarResource;
use App\Http\Resources\ProgramReportResource;
use App\Models\ProgramReport;
use Carbon\Carbon;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ApiStudent extends Controller
{
	public function login(Request $request) {
	    $found = Student::find($request->id);
	    if($found){
	        $student = $found->wherePassword($request->password)->first();
	        if($student){
	            $response = [
	            'success'=>true,
	            'userType'=>'student',
	            'token' => $student->createToken('student')->plainTextToken,
	        	];
	        return response($response, 200);
	        }
	    }
	    return response(['success'=>false,'message'=>"البيانات خاطئة"], 200);
	}

	public function getStudent(Request $request) {
	   	$student = auth()->user();
	    if($student)
	    {
			$todaymeeting = ProgramReport::where(['student_id'=>$student->id,'meeting'=>'todaymeeting'])
			->orderby('id','DESC')
			->first();

			$nextmeeting = ProgramReport::where(['student_id'=>$student->id,'meeting'=>'nextmeeting'])
			->orderby('id','DESC')
			->first();
			
			$todaymeeting = $todaymeeting? new ProgramReportResource($todaymeeting): null;
			$nextmeeting = $nextmeeting? new ProgramReportResource($nextmeeting): null;

			$student=[
			'name' => $student->name,
			'fathername' => $student->father?$student->father->name:'',
			'avatar'=>$student->avatar,
			'memorizedJuzs'=>MemorizedJuzResource::collection($student->memorizedJuzs),
			'memorizedSowars'=>MemorizedSowarResource::collection($student->memorizedSowars),
			'todaymeeting'=>$todaymeeting,
			'nextmeeting'=>$nextmeeting
			];

			$response = [
			'success'=>true,
			'userType'=>'student',
			'student'=>$student
			];

			return response($response, 200);
	    }
	    
	    return response(['success'=>false,'message'=>"البيانات خاطئة"], 200);
	}

}
	