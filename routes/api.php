<?php
use App\Http\Controllers\api\ApiTeacher;
use App\Http\Controllers\api\ApiUser;
use App\Http\Controllers\api\ApiTrainee;
use App\Http\Controllers\api\ApiCircle;
use App\Http\Controllers\api\ApiStudent;
use App\Http\Controllers\api\ApiCourse;
use App\Http\Controllers\api\ApiProgram;
use App\Http\Controllers\api\ApiProgramReport;
use App\Http\Resources\MemorizedJuzResource;
use App\Http\Resources\MemorizedSowarResource;
use App\Http\Resources\ProgramReportResource;
use App\Models\ProgramReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Father;
use App\Models\Student;
use App\Models\Trainee;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;

Route::middleware('auth:sanctum')->get('logout', function (Request $request) {
    $success = auth()->user()->tokens()->delete();
    if($success>0)
    return response(200);
	else
	return response(500);
});

// //trainee
// Route::post('/trainee/login', [ApiTrainee::class,'login']);

//App Version
Route::get('/app_version',function(){
	return '1';
});

//student
Route::post('/student/login', [ApiStudent::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
	Route::get('/get_student', [ApiStudent::class,'getStudent']);
	Route::get('/{course}/get_student_certificate', [ApiStudent::class,'certificateShow']);
});


//program report
Route::middleware('auth:sanctum')->group(function(){
	Route::post('/program_report/store', [ApiProgramReport::class,'store']);
	Route::get('{student}/{circle}/student_program_report/index', [ApiProgramReport::class,'studentProgramReportIndex']);
	Route::get('/get_last_program_report/{student}/{circle}',[ApiProgramReport::class,'getLastProgramReport']);
	Route::get('/delete_last_program_report/{student}/{circle}',[ApiProgramReport::class,'deleteLastProgramReport']);
});

//circle
Route::middleware('auth:sanctum')->group(function(){
	Route::get('/{student}/circles', [ApiCircle::class,'circles']);
});

//program
Route::get('/programs', [ApiProgram::class,'getPrograms']);

//course
Route::get('/course/index', [ApiCourse::class,'index']);


//user => teacher - supervisor
Route::post('/user/login', [ApiUser::class,'login']);
Route::middleware('auth:sanctum')->get('/getuserinfo', [ApiUser::class,'getUserInfo']);
Route::middleware('auth:sanctum')->group(function(){
	Route::get('/teacher/student_circles_with_students', [ApiTeacher::class,'circlesWithStudentIndex']);
	Route::get('/teacher/circle_index', [ApiTeacher::class,'circleIndex']);
	Route::get('{student}/{circle}/toggle_write_report', [ApiTeacher::class,'toggleWriteReport']);
});





