<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\MemorizeProgram;
use App\Models\Teacher;
use App\Models\Circle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function maleIndex() {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where('gender','male');})->get();
			break;
		case 'usercenter':

			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where('gender','male');})
			->whereHas('userTeacherPermission', function ($q) use ($loggedUser) {
				$q->where('user_teacher_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where('gender','male');})
			->whereHas('userTeacherPermission', function ($q) use ($usercenter) {
				$q->where('user_teacher_permission.user_id', $usercenter->id);
			})->get();
			break;
		default:
			$teachers = [];
			break;
		}
		return view('teacher.index', compact('teachers'));
	}

	public function femaleIndex() {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where('gender','female');})->get();
			break;
		case 'usercenter':

			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where('gender','female');})
			->whereHas('userTeacherPermission', function ($q) use ($loggedUser) {
				$q->where('user_teacher_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where('gender','female');})
			->whereHas('userTeacherPermission', function ($q) use ($usercenter) {
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
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$supervisors = Supervisor::whereHas('userSupervisorPermission',function($q)use($loggedUser){
			$q->where(['user_supervisor_permission.user_id'=>$loggedUser->id]);
			})->get();
			return view('teacher.create',compact('supervisors'));
		}
		abort(401,'أنت لاتملك الصلاحية');
		
	}

	public function store(Request $request) {
		$user = User::findOrFail($request->user_id);
		$loggedUser = auth()->user();
		
		$accounts = $user->accounts();
		
		switch ($loggedUser->userType) {
		case 'usercenter':
			foreach ($accounts as $account) {
				if($account=='teacher'){
					return redirect()->back()->with(['status'=>'danger','message'=>'الحساب موجود سابقا']);
				}
			}
			$teacher = Teacher::create(['title'=>$request->title,'owner'=>$user->id]);
			$loggedUser->userTeacherPermission()->attach($teacher->id);
			return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم اضافة الحساب']);
			break;
		case 'supervisor':
			abort(401,'أنت لاتملك الصلاحية');
			// $supervisor = $loggedUser->supervisorAccount()->first();
			// $usercenter = $supervisor->usercenter();
			// $usercenter->userTeacherPermission()->attach($teacher->id);
			break;
		default:
			abort(401,'أنت لاتملك الصلاحية');
			break;
		}

	}

	public function show(Teacher $teacher) {
		$loggedUser = auth()->user();
		$accountOwner = $teacher->accountOwner;
		switch ($loggedUser->userType) {
		case 'usercenter':
			$teacher = $teacher->checkUserPermission($loggedUser);
			$circles = Circle::where('teacher_id',$teacher->id)->get();
			return view('teacher.show', compact('teacher','circles','accountOwner'));
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount()->first();
			$user = $supervisor->usercenter();
			$teacher = $teacher->checkUserPermission($user);
			return view('teacher.show', compact('teacher','accountOwner'));
			break;
		default:
			# code...
			break;
		}
		die('أنت لاتملك الصلاحية');

	}

	public function newCreate() {
		$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($query) {
			$query->where('user_supervisor_permission.user_id', auth()->user()->id);
		})->get();
		return view('teacher.new.create', compact('supervisors'));
	}

	public function newStore(Request $request) {

		$this->validate($request, [
			'password' => 'required',
			'email' => 'required',
			'name' => 'required',
		]);
		$loggedUser = auth()->user();

		$request['password'] = Hash::make($request->password);
		$request['userType'] = 'teacher';

		switch ($loggedUser->userType) {
		case 'usercenter':
			$user = User::create($request->all());
			$request['owner'] = $user->id;
			$teacher = Teacher::create($request->all());
			$loggedUser->userTeacherPermission()->attach($teacher->id);
			break;
		case 'supervisor':
			abort(401,'أنت لاتملك الصلاحية');
			$supervisor = $loggedUser->supervisorAccount()->first();
			$usercenter = $supervisor->usercenter();
			$usercenter->userTeacherPermission()->attach($teacher->id);
			break;
		default:
			# code...
			break;
		}

		return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم اضافة الحساب']);
	}
	
	public function edit(Teacher $teacher) {
		$loggedUser = auth()->user();

		switch ($loggedUser->userType) {
		case 'usercenter':
			$teacher = $teacher->checkUserPermission($loggedUser);
			return view('teacher.edit', compact('teacher'));
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount()->first();
			$user = $supervisor->usercenter();
			$teacher = $teacher->checkUserPermission($user);
			return view('teacher.edit', compact('teacher'));
			break;
		default:
			# code...
			break;
		}
		die('أنت لاتملك الصلاحية');

	}

	public function update(Request $request,Teacher $teacher) {
		// return $request->all();
		$this->validate($request, [
			'name' => 'required',
		]);
		$loggedUser = auth()->user();

		if ($loggedUser->userType !== 'usercenter' && $loggedUser->userType !== 'supervisor') {
			die('أنت لاتملك الصلاحية');
		}
		

		switch ($loggedUser->userType) {
		case 'usercenter':
			$teacher->checkUserPermission($loggedUser);

			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teacher->checkUserPermission($usercenter);


			break;
		default:
			abort(404);
			break;
		}

		$teacher->update($request->all());
		$user = $teacher->accountOwner;
		$user->update($request->all());
		return redirect()->route('user.teacher.index');
	}

	


}