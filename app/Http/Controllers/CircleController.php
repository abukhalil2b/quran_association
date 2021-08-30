<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Circle;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Teacher;
use App\Models\Mark;
use App\Models\Dailyrecord;
use App\Models\ProgramReport;
use Illuminate\Http\Request;

class CircleController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$circles = Circle::whereHas('userCirclePermission',function($q)use($loggedUser){
				$q->where('user_circle_permission.user_id',$loggedUser->id);
			})->get();
			return view('circle.index', compact('circles'));
		}
		abort(401);
	}


	public function create(Program $program) {
		$loggedUser = auth()->user();
		$program = Program::whereHas('userProgramPermission', function ($query) use ($loggedUser, $program) {
			$query->where(['user_program_permission.user_id' => $loggedUser->id, 'user_program_permission.program_id' => $program->id]);
		})->first();
		if(!$program)abort(404,'لايوجد برنامج');
		$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($query) use ($loggedUser) {
			$query->where('user_supervisor_permission.user_id', $loggedUser->id);
		})->get();
		$teachers = Teacher::whereHas('userTeacherPermission', function ($query) use ($loggedUser) {
			$query->where('user_teacher_permission.user_id', $loggedUser->id);
		})->get();
		if(count($supervisors))
		return view('circle.create', compact('program', 'supervisors', 'teachers'));
		abort(404,'لا يوجد مشرفين');
	}


	public function store(Request $request) {
		$this->validate($request, [
			'title' => 'required',
			'program_id' => 'required' ,
			'teacher_id' => 'required',
			'supervisor_id' => 'required'
		]);

		$loggedUser = auth()->user();
		$program_id = $request->program_id;

		switch ($loggedUser->userType) {
		case 'supervisor':
			abort(404,'لاتملك الصلاحية');
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$user = User::whereHas('userSupervisorPermission', function ($q) use ($supervisor_id, $usercenter) {
				$q->where([
					'user_supervisor_permission.user_id' => $usercenter->id,
					'user_supervisor_permission.supervisor_id' => $supervisor_id,
				]);
			})->first();

			if (!$user) {
				abort(404);
			}

			//check program
			$program = Program::find($program_id);
			if (!$program) {
				abort(404);
			}
			$program->checkUserPermission($user);
			$circle = Circle::create([
				'timestart' => $request->timestart,
				'duration' => $request->duration,
				'title' => $request->title,
				'program_id' => $program->id,
				'supervisor_id' => $supervisor->id
			]);
			if ($circle) {
				$circle->userCirclePermission()->attach($user->id);
				return redirect()->route('program.dashboard', ['program' => $request->program_id])->with(['status' => 'تم']);
			} else {
				abort(404,'حدثت مشكلة');
			}

			break;
		case 'usercenter':
			$supervisor_id = $request->supervisor_id;
			$teacher_id = $request->teacher_id;
			//check supervisor
			$supervisor = Supervisor::whereHas('userSupervisorPermission', function ($q) use ($supervisor_id, $loggedUser) {
				$q->where([
					'user_supervisor_permission.user_id' => $loggedUser->id,
					'user_supervisor_permission.supervisor_id' => $supervisor_id,
				]);
			})->first();

			//check program
			$program = Program::whereHas('userProgramPermission', function ($q) use ($program_id, $loggedUser) {
				$q->where([
					'user_program_permission.user_id' => $loggedUser->id,
					'user_program_permission.program_id' => $program_id,
				]);
			})->first();

			if (!$supervisor || !$program) {
				abort(404);
			}

			$circle = Circle::create([
				'timestart' => $request->timestart,
				'duration' => $request->duration,
				'title' => $request->title,
				'program_id' => $program->id,
				'supervisor_id' => $supervisor_id,
				'teacher_id' => $teacher_id
				]);
			if ($circle) {
				$circle->userCirclePermission()->attach($loggedUser->id);
				return redirect()->route('program.dashboard', ['program' => $request->program_id])->with(['status' => 'تم']);
			} else {
				abort(404,'حدثت مشكلة');
			}

			break;
		default:
			# code...
			break;
		}

		return redirect(route('program.dashboard', ['program' => $program->id]))->with(['status' => 'success', 'message' => 'تم']);

	}


	public function show(Circle $circle) {
		//
	}


	public function edit(Circle $circle) {
		return view('circle.edit',compact('circle'));
	}


	public function update(Request $request, Circle $circle) {

		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$loggedUser->checkUsercenterHasCircle($circle);
			$circle->update([
					'title'=>$request->title,
					'timestart' => $request->timestart,
					'duration' => $request->duration
				]);	
				return redirect()->route('dashboard')->with(['message' => 'تم', 'status' => 'success']);		
		}
		abort(401);
	}

	public function confirmCircleDelete(Circle $circle) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$studentsCount= $circle->students()->count();
			$programReportsCount = ProgramReport::where('circle_id',$circle->id)->count();
			$dailyrecordsCount = Dailyrecord::where('circle_id',$circle->id)->count();
			$marksCount = Mark::where('circle_id',$circle->id)->count();
			
			return view('circle.confirm_circle_delete',compact(
				'circle',
				'studentsCount',
				'programReportsCount',
				'marksCount',
				'dailyrecordsCount'
			));
		}
		abort(401);
	}

	public function destroy(Circle $circle) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$loggedUser->checkUsercenterHasCircle($circle);
			ProgramReport::where('circle_id',$circle->id)->delete();
			$dailyrecordIds = $circle->dailyrecords()->pluck('id');
			$loggedUser->userDailyrecordPermission()->detach($dailyrecordIds);
			Attendance::whereIn('dailyrecord_id',$dailyrecordIds)->delete();
			Dailyrecord::where('circle_id',$circle->id)->delete();
			Mark::where('circle_id',$circle->id)->delete();
			$circle->students()->detach();
			$circle->userCirclePermission()->detach();
			$circle->delete();
			return redirect()->route('dashboard')->with(['status' => 'success', 'message' => 'تم الحذف']);
		}
		abort(401);
	}

	public function dashboard(Circle $circle) {
		$loggedUser = auth()->user();

		switch ($loggedUser->userType) {
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$circle = $circle->checkUserPermission($usercenter);
			return$students = $circle->students()->get();
			$lastDailyrecord = $circle->lastDailyrecord();
			if ($lastDailyrecord) {
				$attendances = Attendance::where('dailyrecord_id', $lastDailyrecord->id)->get();
			} else {
				$attendances = [];
			}

			return view('circle.dashboard', compact('circle', 'attendances'));
			break;

		case 'usercenter':

			$circle = $circle->checkUserPermission($loggedUser);
			$students = $circle->students()->get();
			$lastDailyrecord = $circle->lastDailyrecord();
			if ($lastDailyrecord) {
				$attendances = Attendance::where('dailyrecord_id', $lastDailyrecord->id)->get();
			} else {
				$attendances = [];
			}

			return view('circle.dashboard', compact('circle','students', 'attendances'));
			break;

		case 'teacher':

			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			$circle = $circle->checkUserPermission($usercenter);
			return$students = $circle->students()->get();
			$lastDailyrecord = $circle->lastDailyrecord();
			if ($lastDailyrecord) {
				$attendances = Attendance::where('dailyrecord_id', $lastDailyrecord->id)->get();
			} else {
				$attendances = [];
			}

			return view('circle.dashboard', compact('circle', 'attendances'));
			break;
		default:
			# code...
			break;
		}

	}

	//supervisor

	public function supervisorRemove(Circle $circle, Program $program) {

		$loggedUser = auth()->user();

		if ($loggedUser->userType === 'usercenter') {
			$circle->checkUserPermission($loggedUser);
		}

		if ($loggedUser->userType === 'supervisor') {
			$circle = Circle::where(['supervisor_id' => $supervisor_id, 'id' => $circle->id])->first();
			if(!$circle)abort(401,'لا تملك الصلاحيات');
		}
		
		if ($circle && Circle::where('id', $circle->id)->update(['supervisor_id' => NULL])) {
			return redirect(route('program.dashboard', ['program' => $program->id]))->with(['status' => 'success', 'message' => 'تم']);
		} else {
			return redirect()->back()->with(['status' => 'danger', 'message' => 'حدثت مشكلة']);
		}
	}

	public function supervisorCreate(Circle $circle) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($q) use ($loggedUser) {
				$q->where('user_supervisor_permission.user_id', $loggedUser->id);
			})->get();
			$circle->checkUserPermission($loggedUser);
			if(count($supervisors)){
				return view('circle.supervisor.create', compact('circle', 'supervisors'));
			}
			abort(404,'لا يوجد مشرفين');
		}
		abort(401,'أنت لاتملك الصلاحية ');
	}

	public function supervisorStore(Request $request) {

		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {

			$supervisor = Supervisor::find($request->supervisor_id);
			if (Circle::where('id', $request->circle_id)->update(['supervisor_id' => $supervisor->id])) {
				return redirect(route('circle.dashboard', ['circle' => $request->circle_id]))
					->with(['status' => 'success', 'message' => 'تم إضافة المشرف']);
			} else {
				return redirect()->back()->with(['status' => 'danger', 'message' => 'حدثت مشكلة']);
			}

		}
		abort(401,'أنت لاتملك الصلاحية ');
	}

	//teacher

	public function teacherCreate(Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'usercenter':
			$teachers = Teacher::whereHas('userTeacherPermission', function ($q) use ($loggedUser) {
				$q->where('user_teacher_permission.user_id', $loggedUser->id);
			})->get();
			if(count($teachers)==0)
				abort(404,'لا يوجد مدرسين');
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$teachers = Teacher::whereHas('userTeacherPermission', function ($q) use ($usercenter) {
				$q->where('user_teacher_permission.user_id', $usercenter->id);
			})->get();
			if(count($teachers)==0)
				abort(404,'لا يوجد مدرسين');
			break;
		default:
			abort(401,'لا تملك الصلاحية');
			break;
		}

		return view('circle.teacher.create', compact('circle', 'teachers'));
	}

	public function teacherStore(Request $request) {
		// return $request->all();
		$this->validate($request, ['teacher_id' => 'required', 'circle_id' => 'required']);

		$Teacher = Teacher::find($request->teacher_id);
		if (!$Teacher) {
			abort(404);
		}

		$Circle = Circle::find($request->circle_id);
		if (!$Circle) {
			abort(404);
		}

		$loggedUser = auth()->user();
		// return $loggedUser;
		switch ($loggedUser->userType) {
		case 'usercenter':

			//check user permission on teacher
			$teacher = $Teacher->checkUserPermission($loggedUser);
			if (!$teacher) {
				abort(401,'أنت لاتملك الصلاحية ');
			}

			//check circle
			$circle = $Circle->checkUserPermission($loggedUser);
			if (!$circle) {
				abort(401,'أنت لاتملك الصلاحية ');
			}

			break;
		case 'supervisor':

			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();

			//check teacher
			$teacher = $Teacher->checkUserPermission($usercenter);
			if (!$teacher) {
				abort(401,'أنت لاتملك الصلاحية ');
			}

			//check circle
			$circle = $Circle->checkUserPermission($usercenter);
			if (!$circle) {
				abort(401,'أنت لاتملك الصلاحية ');
			}

			break;

		default:
			abort(404,'حدثت مشكلة');
			break;
		}

		//teacher cannot be in same program twice.
		$program = $circle->program;
		$teacherInOtherCircle = $circle->where(['program_id' => $program->id, 'teacher_id' => $teacher->id])->first();
		if ($teacherInOtherCircle) {
			return redirect()->back()->with(['status' => 'warning', 'message' => 'لايمكن إضافة مدرس في نفس البرنامج مرتين']);
		}

		if ($circle->update(['teacher_id' => $teacher->id])) {
			return redirect(route('circle.dashboard', ['circle' => $circle->id]))
				->with(['status' => 'success', 'message' => 'تم إضافة المدرس']);
		}

	}

	//student doesntHave whereDoesntHave

	public function malestudentCreate(Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();

			//check circle
			$circle = $circle->checkUserPermission($usercenter);
			
			$program = $circle->program;
			$malestudents = Student::where('gender','male')->whereDoesntHave('circles', function ($q) use ($program) {
				$q->where('circle_student.program', $program->id);
			})->whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->get();

			return view('circle.malestudent.create', compact('circle', 'malestudents'));
			break;

		case 'usercenter':
			//check circle
			$circle = $circle->checkUserPermission($loggedUser);
			
			$program = $circle->program;
			$malestudents = Student::where('gender','male')->whereDoesntHave('circles', function ($q) use ($program) {
				$q->where('circle_student.program', $program->id);
			})->whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->get();

			return view('circle.malestudent.create', compact('circle', 'malestudents'));
			break;
		default:
			abort(401,'أنت لاتملك الصلاحية ');
			break;
		}

	}

	public function femalestudentCreate(Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();

			//check circle
			$circle = $circle->checkUserPermission($usercenter);
			
			$program = $circle->program;
			$femalestudents = Student::where('gender','female')->whereDoesntHave('circles', function ($q) use ($program) {
				$q->where('circle_student.program', $program->id);
			})->whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->get();

			return view('circle.femalestudent.create', compact('circle', 'femalestudents'));
			break;

		case 'usercenter':
			//check circle
			$circle = $circle->checkUserPermission($loggedUser);
			
			$program = $circle->program;
			$femalestudents = Student::where('gender','female')->whereDoesntHave('circles', function ($q) use ($program) {
				$q->where('circle_student.program', $program->id);
			})->whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->get();

			return view('circle.femalestudent.create', compact('circle', 'femalestudents'));
			break;
		default:
			abort(401,'أنت لاتملك الصلاحية ');
			break;
		}

	}

	public function studentStore(Request $request) {

		if (!$request->student_ids) {
			abort(404,'لايوجد طلاب');
		}

		$Circle = Circle::find($request->circle_id);

		foreach ($request->student_ids as $id) {
			$students[$id] = ['program' => $Circle->program_id];
		}
		// dd($students);

		if ($Circle->students()->syncWithoutDetaching($students)) {
			return redirect(route('circle.dashboard', ['circle' => $request->circle_id]))
				->with(['status' => 'success', 'message' => 'تم إضافة الطلاب']);
		} else {
			return redirect()->back()->with(['status' => 'danger', 'message' => 'حدثت مشكلة']);
		}

	}


}
