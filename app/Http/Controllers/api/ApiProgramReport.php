<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\ProgramReport;
use App\Models\Student;
use App\Models\Circle;
use Illuminate\Http\Request;
use App\Http\Resources\ProgramReportResource;
class ApiProgramReport extends Controller
{
	public function store(Request $request) {
		$teacher_id = Circle::find($request->circle_id)->teacher_id;
		$teacher = Teacher::find($teacher_id);
		$usercenter = $teacher->usercenter();
		$data=[
	    	 	'student_id'=>$request->student_id,
	    	 	'teacher_id'=>$teacher_id ,
	    	 	'circle_id'=>$request->circle_id,
	    	 	'owned_by_usercenter_id'=>$usercenter->id,
	    	 	'donedate'=>$request->donedate,
	    	 	'tobedonedate'=>$request->tobedonedate,
	    	 	'todaymission'=>$request->todaymission,
	    	 	'nextmission'=>$request->nextmission,
	    	 	'evaluation'=>$request->evaluation,
	    	 	'note'=>$request->note,
	    	 ];
	    	if(ProgramReport::create($data))
			return response(200);
			else
			return response(500);
	}


	public function studentProgramReportIndex(Student $student,Circle $circle){
		$programReports = ProgramReport::where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->orderby('id','DESC')
			->limit(50)->get();
		$response = ProgramReportResource::collection($programReports);
		return response($response,201);
	}

	public function getLastProgramReport(Student $student,Circle $circle){
		$lastProgramReport = ProgramReport::where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->orderby('id','DESC')
			->first();
		$response = new ProgramReportResource($lastProgramReport);
		return response($response,201);
	}

	public function deleteLastProgramReport(Student $student,Circle $circle){
		$lastProgramReport = ProgramReport::where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->orderby('id','DESC')
			->first();
		$lastProgramReport->delete();
		$lastProgramReport = ProgramReport::where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->orderby('id','DESC')
			->first();
		$response = new ProgramReportResource($lastProgramReport);
		return response($response,201);
	}

	
}
