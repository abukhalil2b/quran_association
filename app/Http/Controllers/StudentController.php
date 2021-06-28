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
use Carbon\Carbon;
class StudentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function show(Student $student) {
		$loggedUser = auth()->user();
		$programReports=ProgramReport::orderby('id','DESC')->where('student_id',$student->id)->paginate(10);
		$memorizedJuzs=MemorizedJuz::where('student_id',$student->id)->get();
		$memorizedSowars=MemorizedSowar::where('student_id',$student->id)->get();

		switch ($loggedUser->userType) {
		case 'usercenter':
			$usercenter = $loggedUser;
			$student = $student->checkUserPermission($usercenter);
			$circles = $student->circles;
			return view('student.show', compact('student', 'circles', 'usercenter','programReports','memorizedJuzs','memorizedSowars'));
			break;

		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$student = $student->checkUserPermission($usercenter);
			$circles = $student->circles;
			return view('student.show', compact('student', 'circles', 'usercenter','programReports','memorizedJuzs','memorizedSowars'));
			break;

		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			$circle = Circle::where('teacher_id',$teacher->id)->orderby('id','DESC')->first();
			//check if teacher has permission
			$student = $student->checkUserPermission($usercenter);
			//check if student belongs to this teacher
			$student = $circle->checkStudentInCircle($student);
			return view('student.show', compact('student', 'circle', 'usercenter','programReports','memorizedJuzs','memorizedSowars'));
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
			$malestudents = Student::where('gender','male')->get();
			$femalestudents = Student::where('gender','female')->get();
			break;
		case 'usercenter':
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','male')->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','female')->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->where('gender','male')->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->where('gender','female')->get();
			break;
		default:
			$students = [];
			break;
		}
		return view('student.index', compact('malestudents','femalestudents'));
	}
	public function create() {
		return view('student.create');
	}

	public function store(Request $request) {
		$user = auth()->user();
		$request['password'] = $request->phone;
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

	public function edit(Student $student) {
		return view('student.edit', compact('student'));
	}

	public function update(Request $request,Student $student) {
		$student->update($request->all());
		return redirect()->route('student.index');
	}

	public function activeToggle(Student $student) {
		$student->update(['active'=>!$student->active]);
		return redirect()->route('student.index');
	}
}
