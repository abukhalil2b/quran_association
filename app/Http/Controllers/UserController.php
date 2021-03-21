<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Building;
use App\Models\Circle;
use App\Models\Course;
use App\Models\Dailyrecord;
use App\Models\FinanceReport;
use App\Models\Permission;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Teacher;
use App\Models\Trainee;
use App\Models\Trainer;
use App\Models\User;
use App\Models\Year;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}




	/** Student */
	public function studentIndex() {
		$students = Student::all();
		return view('student.index', compact('students'));
	}

	/** Course */
	public function courseIndex() {
		$courses = Course::all();
		return view('course.index', compact('courses'));
	}

	public function courseCreate() {

	}

	public function courseStore(Request $request) {

	}

	public function shiftaccountToStudent() {
		$loggedUser = Auth::user();
		$student = Student::where('user_id', $loggedUser->id)->first();
		if (!$student) {
			Student::create(['user_id' => $loggedUser->id]);
		}
		$loggedUser->update(['userType' => 'student']);
		return redirect()->back();
	}

	public function shiftaccountToTeacher() {
		$loggedUser = Auth::user();
		$teacher = Teacher::where('user_id', $loggedUser->id)->first();
		if (!$teacher) {
			return redirect()->back()->with(['status' => 'هذا الحساب اطلبه من الإدارة']);
		}
		$loggedUser->update(['userType' => 'teacher']);
		return redirect()->back();
	}

}
