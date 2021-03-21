<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\MemorizeProgram;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$teachers = Teacher::all();
			break;
		case 'usercenter':

			$teachers = Teacher::whereHas('userTeacherPermission', function ($q) use ($loggedUser) {
				$q->where('user_teacher_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teachers = Teacher::whereHas('userTeacherPermission', function ($q) use ($usercenter) {
				$q->where('user_teacher_permission.user_id', $usercenter->id);
			})->get();
			break;
		default:
			$teachers = [];
			break;
		}
		return view('teacher.index', compact('teachers'));
	}

	public function create() {
		$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($query) {
			$query->where('user_supervisor_permission.user_id', auth()->user()->id);
		})->get();
		return view('teacher.create', compact('supervisors'));
	}

	public function show(Teacher $teacher) {
		$loggedUser = auth()->user();

		switch ($loggedUser->userType) {
		case 'usercenter':
			$teacher = $teacher->checkUserPermission($loggedUser);
			return view('teacher.show', compact('teacher'));
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount()->first();
			$user = $supervisor->usercenter();
			$teacher = $teacher->checkUserPermission($user);
			return view('teacher.show', compact('teacher'));
			break;
		default:
			# code...
			break;
		}
		die('أنت لاتملك الصلاحية');

	}

	public function store(Request $request) {
		// return $request->all();
		$this->validate($request, [
			'password' => 'required',
			'email' => 'required',
			'name' => 'required',
		]);
		$loggedUser = auth()->user();

		if ($loggedUser->userType !== 'usercenter' && $loggedUser->userType !== 'supervisor') {
			die('أنت لاتملك الصلاحية');
		}
		$request['password'] = Hash::make($request->password);
		$request['userType'] = 'teacher';
		if ($user = User::create($request->all())) {
			$request['owner'] = $user->id;
			$teacher = Teacher::create($request->all());
		}

		switch ($loggedUser->userType) {
		case 'usercenter':
			$loggedUser->userTeacherPermission()->attach($teacher->id);

			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount()->first();
			$usercenter = $supervisor->usercenter();
			$usercenter->userTeacherPermission()->attach($teacher->id);
			break;
		default:
			# code...
			break;
		}

		return redirect()->route('user.teacher.index');
	}

}