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
class ApiTrainee extends Controller
{
	public function login(Request $request) {
    $found = Trainee::wherePhone($request->phone)->first();
    if($found){
        $trainee = $found->wherePassword($request->password)->first();
        if($trainee){
            $token = $trainee->createToken('trainee')->plainTextToken;
            $response = [
            'success'=>true,
            'usertype'=>'trainee',
            'name' => $trainee->name,
            'avatar' => $trainee->avatar,
            'token' => $token
        ];
    
        return response($response, 200);
        }
    }
    return response(['success'=>false,'message'=>"البيانات خاطئة"], 200);
}

}
	