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
class ApiFather extends Controller
{
	public function login(Request $request) {
	    $found = Father::wherePhone($request->phone)->first();
	    if($found){
	    	$father = $found->wherePassword($request->password)->first();
	    	if($father){
	    		$token = $father->createToken('father')->plainTextToken;
	    		$response = [
	            'success'=>true,
	            'usertype'=>'father',
	            'name' => $father->name,
	            'students' =>StudentResource::collection($father->students),
	            'token' => $token
	        ];
	    
	        return response($response, 200);
	    	}
	    }
	    return response(['success'=>false,'message'=>"البيانات خاطئة"], 200);
	}

	public function father(Request $request) {
		$father = $request->user();
		$name = $request->user()->name;
		$students = $request->user()->students;
		$response = [
	                'success'=>true,
		            'name' => $name,
		            'students'=>StudentResource::collection($students),
	        	];
	    return response($response, 200);
	}

}
	

