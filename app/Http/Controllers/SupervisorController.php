<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Supervisor;
use App\Models\User;
use App\Models\Program;
use App\Models\Teacher;
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
			$supervisor->checkUserPermission($loggedUser);

			$usercenter = $supervisor->usercenter();

			if (!$usercenter) {
				die('أنت لاتملك الصلاحية');
			}

			$lastSemester = Semester::orderby('id', 'desc')->first();
			$quarterlyPrograms = $lastSemester->programs()->whereHas('circles', function ($q) use ($supervisor) {
				$q->where('circles.supervisor_id', $supervisor->id);
			})->with('circles')->get();
			$programs=Program::whereHas('circles', function ($q) use ($supervisor) {
				$q->where('circles.supervisor_id', $supervisor->id);
			})->with('circles')->get(); 
			return view('supervisor.dashboard', compact('supervisor', 'usercenter', 'quarterlyPrograms', 'programs', 'lastSemester'));

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
			})
			->whereHas('accountOwner',function($q){
				$q->whereActive(1);
			})
			->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($q) use ($usercenter) {
				$q->where('user_supervisor_permission.user_id', $usercenter->id);
			})
			->whereHas('accountOwner',function($q){
				$q->whereActive(1);
			})
			->get();
			break;
		default:
			$supervisors = [];
			break;
		}
		return view('supervisor.index', compact('supervisors'));
	}

	public function create() {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$teachers = Teacher::whereHas('userTeacherPermission',function($q)use($loggedUser){
				$q->where(['user_teacher_permission.user_id'=>$loggedUser->id]);
			})->get();
			return view('supervisor.create',compact('teachers'));
		}
		abort(401,'أنت لاتملك الصلاحية');
		
	}

	public function store(Request $request) {

		$user = User::findOrFail($request->user_id);
		$loggedUser = auth()->user();
		
		$accounts = $user->accounts();
		
		if ($loggedUser->userType === 'usercenter') {
			foreach ($accounts as $account) {
				if($account=='supervisor'){
					return redirect()->back()->with(['status'=>'danger','message'=>'الحساب موجود سابقا']);
				}
			}
			$supervisor = Supervisor::create(['title'=>$request->title,'owner'=>$user->id]);;
			$loggedUser->userSupervisorPermission()->attach($supervisor->id);
			return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم اضافة الحساب']);
		}
		die('أنت لاتملك الصلاحية');
	}

	public function newCreate() {
		return view('supervisor.new.create');
	}

	public function newStore(Request $request) {

		$this->validate($request, [
			'password' => 'required',
			'email' => 'required',
			'name' => 'required',
		]);
		$loggedUser = auth()->user();

		$request['password'] = Hash::make($request->password);
		$request['userType'] = 'supervisor';

		switch ($loggedUser->userType) {
		case 'usercenter':
			$user = User::create($request->all());
			$request['owner'] = $user->id;
			$supervisor = Supervisor::create($request->all());
			$loggedUser->userSupervisorPermission()->attach($supervisor->id);
			break;
		default:
			# code...
			break;
		}

		return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم اضافة الحساب']);
	}
	

}
