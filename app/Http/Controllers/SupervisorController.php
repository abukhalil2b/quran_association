<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function supervisorDashboard(Supervisor $supervisor) {
		$user = null;
		$students = [];
		$teachers = [];
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$supervisor = Supervisor::whereHas('userSupervisorPermission', function ($query) use ($supervisor, $loggedUser) {
				$query->where([
					'user_supervisor_permission.supervisor_id' => $supervisor->id,
					'user_supervisor_permission.user_id' => $loggedUser->id,
				]);
			})->first();
			if (!$supervisor) {
				die('أنت لاتملك الصلاحية');
			}

			$usercenter = $supervisor->usercenter();

			if (!$usercenter) {
				die('أنت لاتملك الصلاحية');
			}

			$lastSemester = Semester::orderby('id', 'desc')->first();
			$programs = $lastSemester->programs()->whereHas('circles', function ($q) use ($supervisor) {
				$q->where('circles.supervisor_id', $supervisor->id);
			})->with('circles')->get();

			return view('supervisor.dashboard', compact('supervisor', 'usercenter', 'programs', 'lastSemester'));

		}
		die('أنت لاتملك الصلاحية');

	}

	public function index() {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$supervisors = Supervisor::all();
			break;
		case 'usercenter':
			$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($q) use ($loggedUser) {
				$q->where('user_supervisor_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($q) use ($usercenter) {
				$q->where('user_supervisor_permission.user_id', $usercenter->id);
			})->get();
			break;
		default:
			$supervisors = [];
			break;
		}
		return view('supervisor.index', compact('supervisors'));
	}

	public function create() {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			return view('supervisor.create');
		}
		die('أنت لاتملك الصلاحية');
	}
	public function store(Request $request) {
		$this->validate($request, [
			'password' => 'required',
			'email' => 'required',
			'name' => 'required',
		]);
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {

			$user = User::create([
				'userType' => 'supervisor',
				'name' => $request->name,
				'gender' => $request->gender,
				'email' => $request->email,
				'password' => Hash::make($request->password),
			]);

			$supervisor = new Supervisor;
			$supervisor->owner = $user->id;
			$supervisor->title = $request->title;
			$supervisor->save();
			$loggedUser->userSupervisorPermission()->attach($supervisor->id);
			return redirect()->route('user.supervisor.index');
		}
		die('أنت لاتملك الصلاحية');
	}

}
