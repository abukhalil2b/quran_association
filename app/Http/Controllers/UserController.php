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



	/** all users */
	public function edit(User $user) {
		return view('user.edit', compact('user'));
	}

	public function update(User $user,Request $request) {
		$data=['name'=>$request->name,'phone'=>$request->phone,'active'=>$request->active];
		$user->update($data);
		return redirect()->back()->with(['status'=>'success','message' => 'تم']);
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

	public function shiftToAccount($account) {
		$loggedUser = Auth::user();
		switch ($account) {
			case 'teacher':
				$teacher = Teacher::where('owner', $loggedUser->id)->first();
				if (!$teacher) {
					abort(404,'الحساب غير موجود');
				}
				$loggedUser->update(['userType' => 'teacher']);
				break;
			case 'supervisor':
				$supervisor = Supervisor::where('owner', $loggedUser->id)->first();
				if (!$supervisor) {
					abort(404,'الحساب غير موجود');
				}
				$loggedUser->update(['userType' => 'supervisor']);
				break;
			case 'trainer':
			$trainer = Trainer::where('owner', $loggedUser->id)->first();
			if (!$trainer) {
				abort(404,'الحساب غير موجود');
			}
			$loggedUser->update(['userType' => 'trainer']);
			break;
			default:
				abort(404,'الحساب غير موجود');
				break;
		}
		
		return redirect()->back()->with(['status'=>'success','message' => 'تم']);
	}



	public function addSupervisorAccountForUserCreate(Teacher $teacher) {
		return view('user.add_supervisor_account_for_user', compact('teacher'));
	}

	public function addSupervisorAccountForUserStore(Request $request) {
		$loggedUser = auth()->user();
		if($loggedUser->userType==='usercenter'){
			$teacher = Teacher::findOrFail($request->teacher_id);
			$teacher->checkUserPermission($loggedUser);
			$user = $teacher->accountOwner;
			$created= null;
			if(!$user->supervisorAccount){
				$created=Supervisor::create(['title'=>$request->title,'owner'=>$user->id]);
				$loggedUser->userSupervisorPermission()->attach($created->id);
			}
			
		}else{
			abort(403);
		}

		if($created){
			return redirect()->route('user.teacher.show',['teacher'=>$teacher->id])->with(['status'=>'success','message'=>'تم']);
		}
		else{
			return redirect()->route('user.teacher.show',['teacher'=>$teacher->id])->with(['status'=>'warning','message'=>'لم يتم، قد يكون عنده نفس الحساب']);
		}
	}


	public function addTeacherAccountForUserCreate(Supervisor $supervisor) {
		return view('user.add_teacher_account_for_user', compact('supervisor'));
	}

	public function addTeacherAccountForUserStore(Request $request) {
		$loggedUser = auth()->user();
		if($loggedUser->userType==='usercenter'){
			$supervisor = Supervisor::findOrFail($request->supervisor_id);
			$supervisor->checkUserPermission($loggedUser);
			$user = $supervisor->accountOwner;
			$created= null;
			if(!$user->teacherAccount){
				$created=Teacher::create(['title'=>$request->title,'owner'=>$user->id]);
				$loggedUser->userTeacherPermission()->attach($created->id);
			}
			
		}else{
			abort(403);
		}

		if($created){
			return redirect()->route('dashboard',['supervisor'=>$supervisor->id])
			->with(['status'=>'success','message'=>'تم']);
		}
		else{
			return redirect()->route('dashboard',['supervisor'=>$supervisor->id])
			->with(['status'=>'warning','message'=>'لم يتم، قد يكون عنده نفس الحساب']);
		}
	}


}
