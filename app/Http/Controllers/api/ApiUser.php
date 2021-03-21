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
class ApiUser extends Controller
{
	public function getUserType(Request $request) {
		$response = [
            'userType' => $user->model;
        ];
        return response($response, 200);
}

}
	
