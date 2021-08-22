<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Circle;
use App\Models\Dailyrecord;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function studentCreate(Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$user = $teacher->usercenter();

			//check circle Permission
			$circle->checkUserPermission($user);

			$lastDailyrecord = Dailyrecord::latest()->where('circle_id', $circle->id)->whereDate('created_at', Carbon::today())->first();
			if (!$lastDailyrecord) {
				die('لايوجد سجل');
			}

			$attendances = Attendance::where('dailyrecord_id', $lastDailyrecord->id)->get();

			$students = Student::whereHas('circles', function ($q) use ($circle) {
				$q->where(['circle_student.circle_id'=> $circle->id,'circle_student.status'=>'studying']);
			})->get();

			if (count($attendances) === 0) {
				return view('attendance.student.create', compact('students', 'circle'));
			} else {
				return view('attendance.student.index', compact('attendances', 'circle'));
			}

			break;

		default:
			# code...
			break;
		}

	}

	public function studentStore(Request $request) {

		// return $request->all();
		$studentIds = $request->studentIds;
		$presents = $request->presents;
		if (!$studentIds) {
			die('لايوجد طلاب');
		}
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$user = $teacher->usercenter();

			//check circle

			$circle = Circle::find($request->circle_id)->checkUserPermission($user);
			if (!$circle) {
				die('أنت لاتملك الصلاحيات');
			}

			$lastDailyrecord = Dailyrecord::latest()->where('circle_id', $circle->id)
				->whereDate('created_at', Carbon::today())->first();
			if (!$lastDailyrecord) {
				die('لايوجد سجل');
			}

			//students in circle and user has a permission on them
			$students = Student::whereHas('userStudentPermission', function ($q) use ($studentIds, $user) {
				$q->whereIn('user_student_permission.student_id', $studentIds)
					->where('user_student_permission.user_id', $user->id);
			})->whereHas('circles', function ($q) use ($circle) {
				$q->where('circle_student.circle_id', $circle->id);
			})->get();
			count($students) === 0 ? die('لايوجد طلبة') : null;
			// return $students;
			$attendanceCreated = [];
			foreach ($students as $key => $student) {
				$attendanceCreated[] = Attendance::create([
					'about' => 'student',
					'dailyrecord_id' => $lastDailyrecord->id,
					'student_id' => $student->id,
					'present' => $presents[$key],
					'present_time' => $presents[$key] == 1 ? Carbon::now()->toTimeString() : NULL,
				]);
			}
			if (count($attendanceCreated) > 0) {
				return redirect(route('dashboard'))->with(['status' => 'success', 'message' => 'تم تسجيل الحضور والغياب']);
			}
			return redirect(route('dashboard'))->with(['status' => 'warning', 'message' => 'لم يتم تسجيل الحضور والغياب']);
			break;

		default:
			# code...
			break;
		}

	}

	public function studentEdit(Attendance $attendance) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$user = $teacher->usercenter();
			return view('attendance.student.edit', compact('attendance'));
			break;

		default:
			# code...
			break;
		}

	}

	public function studentUpdate(Request $request) {
		$this->validate($request, ['attendance_id' => 'required']);
		$Attendance = Attendance::find($request->attendance_id);
		if (!$Attendance) {
			die('السجل غير موجود');
		}
		$student_id = $Attendance->student_id;
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			$Student = Student::find($student_id);
			if (!$Student) {
				die('غير موجود');
			}

			if (!$Student->checkUserPermission($usercenter)) {
				die('أنت لاتملك الصلاحيات');
			}

			$Attendance->update([
				'present' => $request->present,
				'present_time' => $request->present == 1 ? Carbon::now()->toTimeString() : NULL,
			]);

			return redirect(route('dashboard'))->with(['status' => 'success', 'message' => 'تم تعديل الحضور والغياب']);
			break;

		default:
			# code...
			break;
		}

	}

	public function dashboard(Dailyrecord $dailyrecord) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'usercenter':

			//check circle
			$dailyrecord = $dailyrecord->checkUserPermission($loggedUser);

			$attendances = Attendance::where('dailyrecord_id', $dailyrecord->id)->get();

			return view('attendance.dashboard', compact('attendances', 'dailyrecord'));

			break;

		default:
			# code...
			break;
		}

	}

}
