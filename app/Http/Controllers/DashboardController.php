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
use App\Models\Trainee;
use App\Models\Trainer;
use App\Models\User;
use App\Models\MemorizeProgram;
use App\Models\Year;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller {
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
			
			$trainers = Trainer::whereHas('userTrainerPermission', function ($query) use ($loggedUser) {
				$query->where('user_trainer_permission.user_id', $loggedUser->id);
			})->get();
			
			$trainees = Trainee::all();
			
			$maleStudents = Student::whereHas('userStudentPermission', function ($query) use ($loggedUser) {
				$query->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','male')->get();
			
			$femaleStudents = Student::whereHas('userStudentPermission', function ($query) use ($loggedUser) {
				$query->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','female')->get();
			
			return view('dashboard', compact(
				'loggedUser',
				'finance_reports',
				'dailyrecords',
				'buildings',
				'supervisors',
				'maleTeachers',
				'femaleTeachers',
				'trainers',
				'trainees',
				'maleStudents',
				'femaleStudents',
			));
			break;

		case 'teacher':

			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			
			// teacher's circles in this semester.
			$circle = Circle::whereHas('program.semester', function ($q) use ($thisyear) {
				$q->where('semesters.id', $thisyear->lastSemester()->id);
			})->where('teacher_id', $teacher->id)->orderby('id', 'desc')->first();

			if ($circle) {
				$presentStudents = [];
				$lastDailyrecord = Dailyrecord::where('circle_id', $circle->id)
				->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->first();
				if ($lastDailyrecord) {
					$presentStudents = Attendance::whereHas('student', function ($q) use ($lastDailyrecord) {
						$q->where(['dailyrecord_id' => $lastDailyrecord->id]);
					})->with('student')->get();
				}
			}else{
				$lastDailyrecord =null;
				$presentStudents =null;
			}

			

			return view('dashboard', compact('loggedUser', 'teacher', 'circle', 'lastDailyrecord', 'usercenter', 'presentStudents'));
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			
			$teachers = Teacher::whereHas('userTeacherPermission', function ($q) use ($usercenter) {
				$q->where('user_teacher_permission.user_id', $usercenter->id);
			})->get();

			$students = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->get();

			//supervisor's circles in this year.
			$circles = Circle::whereHas('program.semester', function ($q) use ($thisyear) {
				$q->where('semesters.id', $thisyear->lastSemester()->id);
			})->where('supervisor_id', $supervisor->id)->orderby('id', 'desc')->get();

			return view('dashboard', compact('usercenter', 'teachers', 'students', 'circles', 'supervisor', 'loggedUser'));
			break;
		case 'trainer':
			$trainer = $loggedUser->trainerAccount;

			return view('dashboard', compact('loggedUser', 'trainer'));
			break;
		case 'trainee':

			$trainee = $loggedUser->traineeAccount;
			
			return view('dashboard', compact('loggedUser', 'trainee'));
			break;
		default:
			if(!$thisyear){
				return redirect()->route('year.create');
			}
			$years = Year::all();
			$studentPermissions = Permission::whereCate('student')->get();
			$teacherPermissions = Permission::whereCate('teacher')->get();
			$supervisorPermissions = Permission::whereCate('supervisor')->get();
			return view('dashboard', compact('studentPermissions', 'teacherPermissions', 'supervisorPermissions','years'));
			break;
		}

	}

}