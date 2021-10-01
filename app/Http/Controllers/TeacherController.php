<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\Dailyrecord;
use App\Models\Attendance;
use App\Models\MemorizeProgram;
use App\Models\Teacher;
use App\Models\Circle;
use App\Models\User;
use App\Models\Year;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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

			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where(['gender'=>'male','active'=>1]);})
			->whereHas('userTeacherPermission', function ($q) use ($loggedUser) {
				$q->where('user_teacher_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where(['gender'=>'male','active'=>1]);})
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
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where(['gender'=>'female']);})->get();
			break;
		case 'usercenter':

			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where(['gender'=>'female','active'=>1]);})
			->whereHas('userTeacherPermission', function ($q) use ($loggedUser) {
				$q->where('user_teacher_permission.user_id', $loggedUser->id);
			})->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teachers = Teacher::whereHas('accountOwner',function($q){$q->where(['gender'=>'female','active'=>1]);})
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
		return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم']);
	}

	
	public function quarterlyProgramShow(Circle $circle) {
		$loggedUser = auth()->user();
		$thisyear = Year::orderby('id', 'desc')->first();
		switch ($loggedUser->userType) {
		case 'teacher':

			//inital values
			$quarterlyProgramPresentStudents =[];
			$quarterlyProgramLastDailyrecord =null;
			$quarterlyProgramCircles=[];

			$teacher = $loggedUser->teacherAccount;
			if(!$teacher){
				abort(404,'لايوجد لديك حساب مدرس');
			}
			$usercenter = $teacher->usercenter();
			
			// teacher's circle in this semester. which circle belongs to quarterly program
			$quarterlyProgramCircle = $circle;

			if($quarterlyProgramCircle){
				//circle
				$quarterlyProgramLastDailyrecord = Dailyrecord::where('circle_id', $quarterlyProgramCircle->id)
				->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->first();
	
			}
				
			if ($quarterlyProgramLastDailyrecord) {
				$quarterlyProgramPresentStudents = Attendance::whereHas('student', function ($q) use ($quarterlyProgramLastDailyrecord) {
					$q->where(['dailyrecord_id' => $quarterlyProgramLastDailyrecord->id]);
				})->with('student')->get();


			}

			return view('user.teacher.quarterly_program.show', compact(
				'loggedUser',
				'usercenter',
				'teacher',
				'quarterlyProgramCircle',
				'quarterlyProgramLastDailyrecord',
				'quarterlyProgramPresentStudents',
			));
			break;
		default:
			# code...
			break;
		}
		die('أنت لاتملك الصلاحية');

	}


	
	public function incessantProgramShow(Circle $circle) {
		$loggedUser = auth()->user();
		$thisyear = Year::orderby('id', 'desc')->first();
		switch ($loggedUser->userType) {
		case 'teacher':

			//inital values
			$incessantProgramPresentStudents =[];
			$incessantProgramLastDailyrecord =null;
			$incessantProgramCircles=[];
			
			$teacher = $loggedUser->teacherAccount;
			if(!$teacher){
				abort(404,'لايوجد لديك حساب مدرس');
			}
			$usercenter = $teacher->usercenter();
			
			// teacher's circle in this semester. which circle belongs to incessant program
			$incessantProgramCircle = $circle;

			if($incessantProgramCircle){
				//circle
				$incessantProgramLastDailyrecord = Dailyrecord::where('circle_id', $incessantProgramCircle->id)
				->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->first();
	
			}
				
			if ($incessantProgramLastDailyrecord) {
				$incessantProgramPresentStudents = Attendance::whereHas('student', function ($q) use ($incessantProgramLastDailyrecord) {
					$q->where(['dailyrecord_id' => $incessantProgramLastDailyrecord->id]);
				})->with('student')->get();
			}

			return view('user.teacher.incessant_program.show', compact(
				'loggedUser',
				'usercenter',
				'teacher',
				'incessantProgramCircle',
				'incessantProgramLastDailyrecord',
				'incessantProgramPresentStudents',
			));
			break;
		default:
			# code...
			break;
		}
		die('أنت لاتملك الصلاحية');

	}





}