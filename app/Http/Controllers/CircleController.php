<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Circle;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CircleController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Program $program) {
		$user = auth()->user();
		$program = Program::whereHas('userProgramPermission', function ($query) use ($user, $program) {
			$query->where(['user_program_permission.user_id' => $user->id, 'user_program_permission.program_id' => $program->id]);
		})->first();
		if(!$program)abort(404,'لايوجد برنامج');
		$supervisors = Supervisor::whereHas('userSupervisorPermission', function ($query) use ($user) {
			$query->where('user_supervisor_permission.user_id', $user->id);
		})->get();
		$teachers = Teacher::whereHas('userTeacherPermission', function ($query) use ($user) {
			$query->where('user_teacher_permission.user_id', $user->id);
		})->get();
		if(count($supervisors))
		return view('circle.create', compact('program', 'supervisors', 'teachers'));
		abort(404,'لا يوجد مشرفين');
	}

	/**
	 * user_id - supervisor_id
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, ['title' => 'required', 'program_id' => 'required']);

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

			if ($circle = Circle::create(['title' => $request->title, 'program_id' => $program->id, 'supervisor_id' => $supervisor->id])) {
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

			if ($circle = Circle::create([
					'title' => $request->title,
				 	'program_id' => $program->id,
				 	'supervisor_id' => $supervisor_id,
				 	'teacher_id' => $teacher_id
				])) {
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

	/**die
	 * Display the specified resource.
	 *
	 * @param  \App\Circle  $circle
	 * @return \Illuminate\Http\Response
	 */
	public function show(Circle $circle) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Circle  $circle
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Circle $circle) {
		return view('circle.edit',compact('circle'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Circle  $circle
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Circle $circle) {
		$circle->update(['title'=>$request->title]);
		return redirect()->route('dashboard')->with(['message' => 'تم', 'status' => 'success']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Circle  $circle
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Circle $circle) {
		$circle->delete();
		return redirect()->back()->with(['status' => 'success', 'message' => 'تم الحذف']);
	}

	public function dashboard(Circle $circle) {
		$loggedUser = auth()->user();

		switch ($loggedUser->userType) {
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$circle = $circle->checkUserPermission($usercenter);

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

			$lastDailyrecord = $circle->lastDailyrecord();
			if ($lastDailyrecord) {
				$attendances = Attendance::where('dailyrecord_id', $lastDailyrecord->id)->get();
			} else {
				$attendances = [];
			}

			return view('circle.dashboard', compact('circle', 'attendances'));
			break;

		case 'teacher':

			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			$circle = $circle->checkUserPermission($usercenter);

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

	public function studentCreate(Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();

			//check circle
			$circle = $circle->checkUserPermission($usercenter);
			
			$program = $circle->program;
			$students = Student::whereDoesntHave('circles', function ($q) use ($program) {
				$q->where('circle_student.program', $program->id);
			})->whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->get();

			return view('circle.student.create', compact('circle', 'students'));
			break;

		case 'usercenter':
			//check circle
			$circle = $circle->checkUserPermission($loggedUser);
			
			$program = $circle->program;
			$students = Student::whereDoesntHave('circles', function ($q) use ($program) {
				$q->where('circle_student.program', $program->id);
			})->whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->get();
			return view('circle.student.create', compact('circle', 'students'));
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
