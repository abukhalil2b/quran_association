<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\api\ApiCourse;
use App\Http\Resources\MemorizedJuzResource;
use App\Http\Resources\MemorizedSowarResource;
use App\Http\Resources\ProgramReportResource;
use App\Http\Resources\CircleStudentResource;
use App\Models\ProgramReport;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\MemorizedJuz;
use App\Models\MemorizedSowar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ApiStudent extends Controller
{
	public function login(Request $request) {
	    $student = Student::whereId($request->id)->wherePassword($request->password)->first();
        if($student){
            $response = [
            'success'=>true,
            'userType'=>'student',
            'token' => $student->createToken('student')->plainTextToken,
        	];
        return response($response, 201);
        }
	    return response(['success'=>false,'message'=>"البيانات خاطئة"], 201);
	}

	public function getStudent(Request $request) {
	   	$student = auth()->user();
	    if($student)
	    {
			$programReports = ProgramReport::where(['student_id'=>$student->id])
			->orderby('id','DESC')
			->limit(50)->get();
			$memorizedJuzs = MemorizedJuz::where(['done'=>1,'student_id'=>$student->id])->get();
			$memorizedSowars = MemorizedSowar::where(['done'=>1,'student_id'=>$student->id])->get();
			$student=[
				'id' => $student->id,
				'name' => $student->name,
				'usercenter' => $student->usercenter()->name,
				'fathername' => $student->father?$student->father->name:'',
				'avatar'=>$student->avatar?$student->avatar:'',
				'memorizedJuzs'=>MemorizedJuzResource::collection($memorizedJuzs),
				'memorizedSowars'=>MemorizedSowarResource::collection($memorizedSowars),
				'programReports'=>ProgramReportResource::collection($programReports),
				'circles'=>CircleStudentResource::collection($student->circles()->get()),
			];

			$response = [
				'success'=>true,
				'userType'=>'student',
				'student'=>$student
			];

			return response($response, 201);
	    }
	    
	    return response(['success'=>false,'message'=>"البيانات خاطئة"], 201);
	}


}
	