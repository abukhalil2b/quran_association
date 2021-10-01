<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DailyrecordController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\MemorizeProgramController;
use App\Http\Controllers\MemorizedSowarController;
use App\Http\Controllers\MemorizedJuzController;
use App\Http\Controllers\ProgramReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');


// Route::get('/', function () {
// 	$comingcourses = App\Models\Course::where('status', 'coming')->get();
// 	$nowcourses = App\Models\Course::where('status', 'now')->get();
// 	$pastcourses = App\Models\Course::where('status', 'past')->get();
// 	return view('welcome', compact('comingcourses', 'nowcourses', 'pastcourses'));
// 	// return view('welcome');
// });


Route::get('/',function(){
	return redirect('/login');
});

/** building */
Route::prefix('building')->group(function () {
	Route::get('show_delete_form/{building}',[BuildingController::class,'showDeleteForm'])->name('building.show_delete_form');
	Route::get('confirm_building_delete/{building}',[BuildingController::class,'confirmDeleteForm'])->name('building.confirm_building_delete');
	Route::post('store',[BuildingController::class,'store'])->name('building.store');
	Route::get('index', [BuildingController::class,'index'])->name('building.index');
	Route::get('create',[BuildingController::class,'create'])->name('building.create');
	Route::get('{building}/dashboard', [BuildingController::class,'dashboard'])->name('building.dashboard');
});
/** circle */
Route::prefix('circle')->group(function () {
	Route::get('{circle}/edit',[CircleController::class,'edit'])->name('circle.edit');
	Route::get('index',[CircleController::class,'index'])->name('circle.index');
	Route::post('{circle}/update',[CircleController::class,'update'])->name('circle.update');
	Route::post('store', [CircleController::class,'store'])->name('circle.store');
	Route::get('create/{program}', [CircleController::class,'create'])->name('circle.create');
	Route::get('dashboard/{circle}',[CircleController::class,'dashboard'] )->name('circle.dashboard');
	Route::get('confirm_circle_delete/{circle}',[CircleController::class,'confirmCircleDelete'])->name('confirm_circle_delete');
	Route::get('destroy/{circle}', [CircleController::class,'destroy'])->name('circle.destroy');

	Route::get('{circle}/supervisor/create',[CircleController::class,'supervisorCreate'])->name('circle.supervisor.create');
	Route::post('supervisor/store',[CircleController::class,'supervisorStore'])->name('circle.supervisor.store');

	Route::get('{circle}/supervisor/remove/{program}',[CircleController::class,'supervisorRemove'])->name('circle.supervisor.remove');

	Route::get('{circle}/teacher/create',[CircleController::class,'teacherCreate'])->name('circle.teacher.create');
	Route::post('teacher/store',[CircleController::class,'teacherStore'])->name('circle.teacher.store');

	Route::get('{circle}/malestudent/create',[CircleController::class,'malestudentCreate'])->name('circle.malestudent.create');
	Route::get('{circle}/femalestudent/create',[CircleController::class,'femalestudentCreate'])->name('circle.femalestudent.create');
	Route::post('student/store',[CircleController::class,'studentStore'])->name('circle.student.store');
});

Route::prefix('user')->middleware('superadmin')->group(function () {
	Route::post('{user}/update',[UserController::class,'update'])->name('user.update');
	Route::get('{user}/edit',[UserController::class,'edit'])->name('user.edit');
});
Route::prefix('usercenter')->middleware('superadmin')->group(function () {
	Route::post('store',[CenterController::class,'usercenterStore'])->name('usercenter.store');
	Route::get('index',[CenterController::class,'usercenterIndex'])->name('usercenter.index');
	Route::get('create',[CenterController::class,'usercenterCreate'])->name('usercenter.create');
});

Route::prefix('year')->middleware('superadmin')->group(function () {
	Route::get('create',[YearController::class,'create'])->name('year.create');
	Route::post('store', [YearController::class,'store'])->name('year.store');
	Route::get('index', [YearController::class,'index'])->name('year.index');
	Route::get('semester-create/{year}', [YearController::class,'semesterCreate'])->name('semester.create');
	Route::post('semester-store', [YearController::class,'semesterStore'])->name('semester.store');
	Route::get('semester-index', [YearController::class,'semesterIndex'])->name('semester.index');
});



Route::prefix('user')->group(function () {
	Route::get('teacher/male_index', [TeacherController::class,'maleIndex'])->name('user.teacher.male_index');
	Route::get('teacher/female_index', [TeacherController::class,'femaleIndex'])->name('user.teacher.female_index');
	Route::get('teacher/create', [TeacherController::class,'create'])->name('user.teacher.create');
	Route::get('teacher/new/create', [TeacherController::class,'newCreate'])->name('user.teacher.new.create');
	Route::post('teacher/store', [TeacherController::class,'store'])->name('user.teacher.store');
	Route::post('teacher/new/store', [TeacherController::class,'newStore'])->name('user.teacher.new.store');
	Route::get('teacher/{teacher}/show', [TeacherController::class,'show'])->name('user.teacher.show');
	Route::get('teacher/{teacher}/edit', [TeacherController::class,'edit'])->name('user.teacher.edit');
	Route::post('teacher/{teacher}/update', [TeacherController::class,'update'])->name('user.teacher.update');
	
	Route::get('supervisor/create', [SupervisorController::class,'create'])->name('user.supervisor.create');
	Route::post('supervisor/store', [SupervisorController::class,'store'])->name('user.supervisor.store');
	Route::get('supervisor/new/create', [SupervisorController::class,'newCreate'])->name('user.supervisor.new.create');
	Route::post('supervisor/new/store', [SupervisorController::class,'newStore'])->name('user.supervisor.new.store');
	Route::get('supervisor/index', [SupervisorController::class,'index'])->name('user.supervisor.index');
	Route::get('supervisor/{supervisor}/dashboard', [SupervisorController::class,'supervisorDashboard'])
		->name('supervisor.dashboard');

	Route::get('teacher/quarterly_program/{circle}/show', [TeacherController::class,'quarterlyProgramShow'])->name('teacher.quarterly_program.show');
	Route::get('teacher/incessant_program/{circle}/show', [TeacherController::class,'incessantProgramShow'])->name('teacher.incessant_program.show');


});

Route::prefix('student')->group(function () {
	Route::get('{student}/{circle}/show', [StudentController::class,'show'])->name('student.show');
	Route::get('male_index', [StudentController::class,'maleIndex'])->name('student.male_index');
	Route::get('female_index', [StudentController::class,'femaleIndex'])->name('student.female_index');
	Route::get('can-wirte-program-report/index', [StudentController::class,'canWriteProgramReportIndex'])
	->name('student.can-wirte-program-report.index');
	Route::get('create', [StudentController::class,'create'])->name('student.create');
	Route::post('store', [StudentController::class,'store'])->name('student.store');
	Route::get('{student}/circle/{circle}/show', [StudentController::class,'circleShow'])
		->name('student.circle.show');
	Route::post('mark/store',[MarkController::class,'store'])
		->name('student.mark.store');
	Route::get('{student}/edit', [StudentController::class,'edit'])->name('student.edit');
	Route::post('{student}/update', [StudentController::class,'update'])->name('student.update');
	Route::get('{student}/active/toggle', [StudentController::class,'activeToggle'])->name('student.active.toggle');

	Route::get('{student}/circle/{circle}/allow-wirte-report', [StudentController::class,'allowWirteReport'])
		->name('student.circle.allow-wirte-report');
	Route::get('{student}/circle/{circle}/disallow-wirte-report', [StudentController::class,'disallowWirteReport'])
		->name('student.circle.disallow-wirte-report');	

	Route::post('{student}/circle/{circle}/update_status', [StudentController::class,'updateStatus'])
		->name('student.circle.update_status');

	Route::get('{student}/{circle}/program_report/index', [StudentController::class,'programReportIndex'])->name('student.program_report.index');
	Route::get('{student}/{circle}/transfer/create', [StudentController::class,'studentTransferCreate'])->name('student.transfer.create');
	Route::post('{student}/{circle}/transfer/store', [StudentController::class,'studentTransferStore'])->name('student.transfer.store');
});	


Route::prefix('certificate')->group(function () {

	Route::get('{course}/upload_male_certificate_create',[CertificateController::class,'uploadMaleCertificateCreate'])
	->name('certificate.upload_male_certificate_create');
	Route::get('{course}/upload_female_certificate_create',[CertificateController::class,'uploadFemaleCertificateCreate'])
	->name('certificate.upload_female_certificate_create');
	
	Route::post('{course}/upload_male_certificate_store',[CertificateController::class,'uploadMaleCertificateStore'])
	->name('certificate.upload_male_certificate_store');
	Route::post('{course}/upload_female_certificate_store',[CertificateController::class,'uploadFemaleCertificateStore'])
	->name('certificate.upload_female_certificate_store');

});

Route::prefix('contractor')->group(function () {
	Route::get('create',[ContractorController::class,'create'])->name('contractor.create');
	Route::post('store',[ContractorController::class,'store'])->name('contractor.store');
	Route::get('edit/{id}',[ContractorController::class,'edit'])->name('contractor.edit');
	Route::post('update',[ContractorController::class,'update'])->name('contractor.update');
});

Route::prefix('course')->group(function () {
	Route::post('student/{course}/male_search', [CourseController::class,'studentMaleSearch'])->name('course.student.male_search');
	Route::post('student/{course}/female_search', [CourseController::class,'studentFemaleSearch'])->name('course.student.female_search');
	Route::get('student/{course}/male_index', [CourseController::class,'studentMaleIndex'])->name('course.student.male_index');
	Route::get('student/{course}/female_index', [CourseController::class,'studentFemaleIndex'])->name('course.student.female_index');
	Route::get('student/{course}/male_create', [CourseController::class,'studentMaleCreate'])->name('course.student.male_create');
	Route::get('student/{course}/female_create', [CourseController::class,'studentFemaleCreate'])->name('course.student.female_create');
	Route::post('student/{course}/{gender}/store', [CourseController::class,'studentStore'])->name('course.student.store');
	Route::get('student/{student}/{course}/delete', [CourseController::class,'studentDelete'])->name('course.student.delete');
	Route::get('index', [CourseController::class,'index'])->name('course.index');
	Route::get('create', [CourseController::class,'create'])->name('course.create');
	Route::post('store', [CourseController::class,'store'])->name('course.store');
	Route::post('update', [CourseController::class,'update'])->name('course.update');
	Route::get('{course}/show', [CourseController::class,'show'])->name('course.show');
	Route::get('{course}/edit', [CourseController::class,'edit'])->name('course.edit');
	Route::get('{course}/status/edit', [CourseController::class,'statusEdit'])->name('course.status.edit');
	Route::post('status/update', [CourseController::class,'statusUpdate'])->name('course.status.update');
	Route::get('{course}/detail/create', [CourseController::class,'detailTitleCreate'])->name('course.detail.create');
	Route::post('detail/store', [CourseController::class,'detailTitleStore'])->name('course.detail.store');

});

Route::prefix('program')->group(function () {
	Route::get('{program}/edit',[ProgramController::class,'edit'])->name('program.edit');
	Route::post('{program}/update',[ProgramController::class,'update'])->name('program.update');
	Route::get('{program}/dashboard',[ProgramController::class,'dashboard'])->name('program.dashboard');
	Route::get('index',[ProgramController::class,'index'])->name('program.index');
	Route::get('{building}/create', [ProgramController::class,'create'])->name('program.create');
	Route::get('{building}/quarterly/create', [ProgramController::class,'quarterlyCreate'])->name('program.quarterly.create');
	Route::post('store', [ProgramController::class,'store'])->name('program.store');
	Route::post('quarterly/store', [ProgramController::class,'quarterlyStore'])->name('program.quarterly.store');
	Route::get('{program}/prepare_for_delete',[ProgramController::class,'prepareForDelete'])->name('program.prepare_for_delete');
	Route::get('{program}/destroy',[ProgramController::class,'destroy'])->name('program.destroy');
});



Route::prefix('program_report')->group(function () {
	Route::get('index', [ProgramReportController::class,'index'])->name('program_report.index');
	Route::get('{program}/{student}/create', [ProgramReportController::class,'create'])->name('program_report.create');
	Route::post('store', [ProgramReportController::class,'store'])->name('program_report.store');
	Route::get('{programReport}/{student}/confirm_delete', [ProgramReportController::class,'confirmDelete'])->name('program_report.confirm_delete');
	Route::get('{programReport}/{student}/delete', [ProgramReportController::class,'delete'])->name('program_report.delete');
	Route::get('{programReport}/{student}/edit', [ProgramReportController::class,'edit'])->name('program_report.edit');
	Route::post('{programReport}/{student}/update', [ProgramReportController::class,'update'])->name('program_report.update');
});

Route::prefix('student/memorized_juz')->group(function () {
	Route::get('{student}/create', [MemorizedJuzController::class,'create'])
	->name('student.memorized_juz.create');
	Route::post('{student}/update', [MemorizedJuzController::class,'update'])
	->name('student.memorized_juz.update');
});

Route::prefix('student/memorized_sowar')->group(function () {
	Route::get('{student}/create', [MemorizedSowarController::class,'create'])
	->name('student.memorized_sowar.create');
	Route::post('{student}/update', [MemorizedSowarController::class,'update'])
	->name('student.memorized_sowar.update');
});

Route::prefix('dailyrecord')->group(function () {
	Route::get('index', [DailyrecordController::class,'index'])->name('dailyrecord.index');
	Route::post('store', [DailyrecordController::class,'store'])->name('dailyrecord.store');
});
// admin student

/** statement */
Route::prefix('statement')->group(function () {
	Route::get('{date}/details',[StatementController::class,'details'] )->name('statement.details');
	Route::get('create', [StatementController::class,'create'])->name('statement.create');
	Route::post('store', [StatementController::class,'store'])->name('statement.store');
	Route::post('search', [StatementController::class,'search'])->name('statement.search');
});
/**  */

/** attendance */
Route::prefix('attendance')->group(function () {
	Route::get('{dailyrecord}/dashboard', [AttendanceController::class,'dashboard'])->name('attendance.dashboard');
	Route::get('student/{circle}/create', [AttendanceController::class,'studentCreate'])->name('attendance.student.create');
	Route::get('student/{attendance}/edit', [AttendanceController::class,'studentEdit'])->name('attendance.student.edit');
	Route::post('student/update', [AttendanceController::class,'studentUpdate'])->name('attendance.student.update');
	Route::post('student/store', [AttendanceController::class,'studentStore'])->name('attendance.student.store');
});

Route::post('register/student', [StudentController::class,'registerStudent'])->name('register.student');
Route::post('course/subscribe', [CourseController::class,'courseSubscribe'])->name('course.subscribe');

Route::get('course/{courseId}/teacher/{teacherId}/student/index', [TeacherController::class,'studentIndex'])
	->name('course.teacher.student.index');
Route::get('course/{courseId}/teacher/{teacherId}/student/{studentId}/show', [TeacherController::class,'studentShow'])
	->name('course.teacher.student.show');

Route::get('user/shiftaccount/tostudent', [UserController::class,'shiftaccountToStudent'])
	->name('user.shiftaccount.tostudent');
Route::get('user/shiftaccount/{account}', [UserController::class,'shiftToAccount'])
	->name('user.shift_to_account');


//add supervisor account
Route::get('add_supervisor_account_for_user/{teacher}/create', [UserController::class,'addSupervisorAccountForUserCreate'])
->name('add_supervisor_account_for_user.create');
Route::post('add_supervisor_account_for_user/store', [UserController::class,'addSupervisorAccountForUserStore'])
->name('add_supervisor_account_for_user.store');

//add teacher account
Route::get('add_teacher_account_for_user/{supervisor}/create', [UserController::class,'addTeacherAccountForUserCreate'])
->name('add_teacher_account_for_user.create');
Route::post('add_teacher_account_for_user/store', [UserController::class,'addTeacherAccountForUserStore'])
->name('add_teacher_account_for_user.store');

/*	permissions	*/
Route::prefix('permission')->group(function () {
	// Route::get('centerstudent/index', function () {
	// 	return auth()->user()->students()->get();
	// });

	Route::get('index',[PermissionController::class,'index'])->name('permission.index');
	Route::get('about/student',[PermissionController::class,'aboutStudent'])->name('permission.about.student');
	Route::get('about/student/toggle/{teacher}',[PermissionController::class,'aboutStudentToggle'])->name('permission.about.student.toggle');
});

/*	owner	*/
Route::prefix('owner')->group(function () {
	Route::get('{teacher}/edit_teacher_owner',[OwnerController::class,'edit'])->name('edit_teacher_owner');
	Route::post('{teacher}/update_teacher_owner',[OwnerController::class,'update'])->name('update_teacher_owner');

});

