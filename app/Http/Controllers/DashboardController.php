<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Building;
use App\Models\Circle;
use App\Models\Course;
use App\Models\Dailyrecord;
use App\Models\FinanceReport;
use App\Models\Permission;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Teacher;
use App\Models\Program;
use App\Models\User;
use App\Models\MemorizeProgram;
use App\Models\Year;
use App\Models\Juz;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller {
		public function __construct() {
			$this->middleware('auth');
		}
	
		public function dashboard() {

		$loggedUser = auth()->user();
		$thisyear = Year::orderby('id', 'desc')->first();
		
		switch ($loggedUser->userType) {
		case 'usercenter':
			$finance_reports = FinanceReport::whereHas('userFinanceReportPermission', function ($query) use ($loggedUser) {
				$query->where('user_finance_report_permission.user_id', $loggedUser->id);
			})->get();
			
			$dailyrecords = Dailyrecord::whereHas('userDailyrecordPermission', function ($query) use ($loggedUser) {
				$query->where('user_dailyrecord_permission.user_id', $loggedUser->id);
			})->whereDate('created_at', Carbon::today())->get();
			
			$buildings = Building::whereHas('userBuildingPermission', function ($query) use ($loggedUser) {
				$query->where('user_building_permission.user_id', $loggedUser->id);
			})->get();
			
			$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($query) use ($loggedUser) {
				$query->where('user_supervisor_permission.user_id', $loggedUser->id);
			})->get();
			
			$maleTeachers = Teacher::whereHas('userTeacherPermission', function ($query) use ($loggedUser) {
				$query->where('user_teacher_permission.user_id', $loggedUser->id);
			})->whereHas('accountOwner',function($q){
				$q->where('users.gender','male');
			})->get();

			$femaleTeachers = Teacher::whereHas('userTeacherPermission', function ($query) use ($loggedUser) {
				$query->where('user_teacher_permission.user_id', $loggedUser->id);
			})->whereHas('accountOwner',function($q){
				$q->where('users.gender','female');
			})->get();
			
			$malestudents = Student::where('gender','male')->whereHas('userStudentPermission', function ($query) use ($loggedUser) {
				$query->where('user_student_permission.user_id', $loggedUser->id);
			})->get();
			$femalestudents = Student::where('gender','female')->whereHas('userStudentPermission', function ($query) use ($loggedUser) {
				$query->where('user_student_permission.user_id', $loggedUser->id);
			})->get();
			
			$programs = Program::whereHas('userProgramPermission',function($query)use($loggedUser){
				$query->where('user_program_permission.user_id',$loggedUser->id);
			});
			$circles = Circle::whereHas('userCirclePermission',function($query)use($loggedUser){
				$query->where('user_circle_permission.user_id',$loggedUser->id);
			});

			return view('dashboard', compact(
				'loggedUser',
				'finance_reports',
				'dailyrecords',
				'buildings',
				'supervisors',
				'maleTeachers',
				'femaleTeachers',
				'malestudents',
				'femalestudents',
				'programs',
				'circles',
			));
			break;

		case 'teacher':

			//inital values
			$courses=[];
			$quarterlyProgramPresentStudents =[];
			$incessantProgramPresentStudents =[];
			$quarterlyProgramLastDailyrecord =null;
			$incessantProgramLastDailyrecord =null;
			$quarterlyProgramCircles=[];
			$incessantProgramCircles=[];
			
			$teacher = $loggedUser->teacherAccount;
			if(!$teacher){
				abort(404,'لايوجد لديك حساب مدرس');
			}
			$usercenter = $teacher->usercenter();
			
			// teacher's circle in this semester. which circle belongs to quarterly program
			$quarterlyProgramCircle = Circle::whereHas('program.semester', function ($q) use ($thisyear) {
				$q->where('semesters.id', $thisyear->lastSemester()->id);
			})->where('teacher_id', $teacher->id)->orderby('id', 'desc')->first();

			// teacher's circles.
			$incessantProgramCircle = Circle::whereHas('program',function($q){
				$q->where('programs.quarterly',0);
			})->where('teacher_id',$teacher->id)
			->orderby('id', 'desc')->first();

			if($quarterlyProgramCircle){
				//circle
				$quarterlyProgramLastDailyrecord = Dailyrecord::where('circle_id', $quarterlyProgramCircle->id)
				->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->first();
				//circles
				$quarterlyProgramCircles = Circle::where('teacher_id',$teacher->id)
				->where('id','<>',$quarterlyProgramCircle->id)
				->whereHas('program',function($q) use ($thisyear) {
					$q->where(['programs.quarterly'=>1,'semester_id'=>$thisyear->lastSemester()->id]);
				})->get();
			}
			
				
			if ($quarterlyProgramLastDailyrecord) {
				$quarterlyProgramPresentStudents = Attendance::whereHas('student', function ($q) use ($quarterlyProgramLastDailyrecord) {
					$q->where(['dailyrecord_id' => $quarterlyProgramLastDailyrecord->id]);
				})->with('student')->get();


			}

			if($incessantProgramCircle){
				$incessantProgramLastDailyrecord = Dailyrecord::where('circle_id', $incessantProgramCircle->id)
				->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->first();

				$incessantProgramCircles = Circle::where('teacher_id',$teacher->id)
				->where('id','<>',$incessantProgramCircle->id)
				->whereHas('program',function($q) use ($thisyear) {
					$q->where(['programs.quarterly'=>0]);
				})->get();
			}
			
				
			if ($incessantProgramLastDailyrecord) {
				$incessantProgramPresentStudents = Attendance::whereHas('student', function ($q) use ($incessantProgramLastDailyrecord) {
					$q->where(['dailyrecord_id' => $incessantProgramLastDailyrecord->id]);
				})->with('student')->get();
			}
			// return$incessantProgramCircle->activeStudents;

			
			return view('dashboard', compact(
				'quarterlyProgramCircles',
				'incessantProgramCircles',
				'courses',
				'loggedUser',
				'usercenter',
				'teacher',
				'quarterlyProgramCircle',
				'incessantProgramCircle',
				'quarterlyProgramLastDailyrecord',
				'incessantProgramLastDailyrecord',
				'quarterlyProgramPresentStudents',
				'incessantProgramPresentStudents'
			));
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();

			//supervisor's circles in this year.
			$quarterlyProgramCircles = Circle::whereHas('program.semester', function ($q) use ($thisyear) {
				$q->where('semesters.id', $thisyear->lastSemester()->id);
			})->where('supervisor_id', $supervisor->id)->orderby('id', 'desc')->get();

			$programs=Program::whereHas('circles', function ($q) use ($supervisor) {
				$q->where('circles.supervisor_id', $supervisor->id);
			})->where('quarterly',0)->get(); 
			return view('dashboard', compact('usercenter',  'quarterlyProgramCircles','programs', 'supervisor', 'loggedUser'));

			break;
		default:

			if(!$thisyear){
				return redirect()->route('year.create');
			}
			$years = Year::all();
			$users = User::where('id','<>',1)->paginate(50);
			$supervisors = Supervisor::paginate(50);
			$teachers = Teacher::paginate(50);
			$studentPermissions = Permission::whereCate('student')->get();
			$teacherPermissions = Permission::whereCate('teacher')->get();
			$supervisorPermissions = Permission::whereCate('supervisor')->get();
			$juzs = Juz::all();
			return view('dashboard', compact('teachers','supervisors','users','studentPermissions', 'teacherPermissions', 'supervisorPermissions','years','juzs'));
			break;
		}

	}

}