<?php

namespace App\Http\Controllers;
use App\Models\Circle;
use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\Semester;
use App\Models\ProgramReport;
use App\Models\MemorizedJuz;
use App\Models\MemorizedSowar;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function show(Student $student) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'usercenter':
			$usercenter = $loggedUser;
			$student = $student->checkUserPermission($usercenter);
			$circles = $student->circles;
			$programReports=ProgramReport::where('student_id',$student->id)->get();
			$memorizedJuzs=MemorizedJuz::where('student_id',$student->id)->get();
			$memorizedSowars=MemorizedSowar::where('student_id',$student->id)->get();
			return view('student.show', compact('student', 'circles', 'usercenter','programReports','memorizedJuzs','memorizedSowars'));
			break;

		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$student = $student->checkUserPermission($usercenter);
			$circles = $student->circles;
			$programReports=ProgramReport::where('student_id',$student->id)->get();
			$memorizedJuzs=MemorizedJuz::where('student_id',$student->id)->get();
			$memorizedSowars=MemorizedSowar::where('student_id',$student->id)->get();
			return view('student.show', compact('student', 'circles', 'usercenter','programReports','memorizedJuzs','memorizedSowars'));
			break;
		case 'teacher':

			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			$lastSemester = Semester::orderby('id', 'desc')->first();
			if (!$lastSemester) {
				die('لايوجد فصل دراسي');
			}
			$lastSemesterPrograms = $lastSemester->lastSemesterPrograms();
			$teacherCircleIds = Circle::where('teacher_id', $teacher->id)
				->whereIn('program_id', $lastSemesterPrograms->pluck('id'))
				->pluck('id');

			//check if teacher has permission
			$student = $student->checkUserPermission($usercenter);
			$programReports=ProgramReport::where('student_id',$student->id)->get();
			$memorizedJuzs=MemorizedJuz::where('student_id',$student->id)->get();
			$memorizedSowars=MemorizedSowar::where('student_id',$student->id)->get();
			$circles = Circle::whereHas('students', function ($q) use ($teacherCircleIds, $student) {
				$q->whereIn('circle_student.circle_id', $teacherCircleIds)
					->where('circle_student.student_id', $student->id);
			})->get();

			return view('student.show', compact('student', 'circles', 'usercenter','programReports','memorizedJuzs','memorizedSowars'));
			break;
		default:
			# code...
			break;
		}

	}

	public function index() {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$students = Student::all();
			break;
		case 'usercenter':
			$students = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$students = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->get();
			break;
		default:
			$students = [];
			break;
		}
		return view('student.index', compact('students'));
	}
	public function create() {
		return view('student.create');
	}

	public function store(Request $request) {
		$user = auth()->user();

		// only supervisor and usercenter to add new students
		if ($user->userType == 'usercenter') {
			$request['createdby_model'] = 'usercenter';
			$request['createdby_id'] = $user->id;
			$request['usercenter_id'] = $user->id;
			$student = Student::create($request->all());

			$student->userStudentPermission()->attach($user->id);
		}
		if ($user->userType == 'supervisor') {
			$supervisor = $user->supervisorAccount;
			$request['createdby_model'] = 'supervisor';
			$request['createdby_id'] = $supervisor->id;
			$request['usercenter_id'] = $supervisor->usercenter()->id;
			$student = Student::create($request->all());

			$student->userStudentPermission()->attach($supervisor->usercenter()->id);
		}

		//grant permissions
		switch ($user->userType) {
		case 'usercenter':

			break;
		case 'supervisor':

			break;
		case 'superadmin':
			die('لاتملك الصلاحية');
			break;
		default:
			# code...
			break;
		}
		return redirect(Route('student.index'));

	}

	public function circleShow(Student $student,Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
			case 'usercenter':
				$student->checkUserPermission($loggedUser);
				break;
			case 'supervisor':
			$usercenter = $loggedUser->supervisorAccount->usercenter();
				$student->checkUserPermission($usercenter);
				break;
			case 'teacher':
			$usercenter = $loggedUser->teacherAccount->usercenter();
			$student->checkUserPermission($usercenter);	
				break;	
			default:
				
				break;
		}
		$marks = Mark::where(['circle_id' => $circle->id,'student_id'=>$student->id])->get();
		return view('student.circle.show', compact('circle', 'marks','student'));
	}

}
