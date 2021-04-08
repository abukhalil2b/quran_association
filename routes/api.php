<?php
use App\Http\Controllers\api\ApiUser;
use App\Http\Controllers\api\ApiTrainee;
use App\Http\Controllers\api\ApiStudent;
use App\Http\Controllers\api\ApiCourse;
use App\Http\Controllers\api\ApiProgram;
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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->post('logout', function (Request $request) {
    $success = auth()->user()->tokens()->delete();
    return response(['success'=> true], 200);
});

Route::middleware('auth:sanctum')->get('/father',[ApiFather::class,'father']);

Route::post('/father/login', [ApiFather::class,'login']);


Route::post('/trainee/login', [ApiTrainee::class,'login']);

Route::get('/course/index', [ApiCourse::class,'index']);

Route::middleware('auth:sanctum')->get('/usertype', [ApiUser::class,'getUserType']);


// Route::get('/student', [ApiStudent::class,'getStudent']);


//student
Route::post('/student/login', [ApiStudent::class,'login']);

Route::middleware('auth:sanctum')->get('/student', [ApiStudent::class,'getStudent']);
Route::middleware('auth:sanctum')->get('/program_reports', [ApiStudent::class,'getProgramReports']);

Route::get('/programs', [ApiProgram::class,'getPrograms']);






