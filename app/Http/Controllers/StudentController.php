<?php

namespace App\Http\Controllers;
use App\Models\Circle;
use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\Semester;
use App\Models\ProgramReport;
use App\Models\MemorizedJuz;
use App\Models\MemorizedSowar;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class StudentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function show(Student $student,Circle $circle) {
		$loggedUser = auth()->user();
		$programReport=ProgramReport::orderby('id','DESC')->where('student_id',$student->id);
		$memorizedJuzs=MemorizedJuz::where('student_id',$student->id)->get();
		$memorizedSowars=MemorizedSowar::where('student_id',$student->id)->get();

		switch ($loggedUser->userType) {
		case 'usercenter':
			$programReport = $programReport->where('circle_id',$circle->id)->first();
			$usercenter = $loggedUser;
			$student = $student->checkUserPermission($usercenter);
			$circle = Circle::where(['id'=>$circle->id])->orderby('id','DESC')->first();
			return view('student.show', compact('student', 'circle', 'usercenter','programReport','memorizedJuzs','memorizedSowars'));
			break;

		case 'supervisor':
			$programReport = $programReport->first();
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$student = $student->checkUserPermission($usercenter);
			$circle = Circle::where(['id'=>$circle->id])->orderby('id','DESC')->first();
			return view('student.show', compact('student', 'circle', 'usercenter','programReport','memorizedJuzs','memorizedSowars'));
			break;

		case 'teacher':

			$teacher = $loggedUser->teacherAccount;
			$usercenter = $teacher->usercenter();
			$circle = Circle::where(['teacher_id'=>$teacher->id,'id'=>$circle->id])->orderby('id','DESC')->first();
			$programReport = $programReport->where('circle_id',$circle->id)->first();
			//check if teacher has permission
			$student = $student->checkUserPermission($usercenter);
			//check if student belongs to this teacher
			$student = $circle->checkStudentInCircle($student);
			return view('student.show', compact('student', 'circle', 'usercenter','programReport','memorizedJuzs','memorizedSowars'));
			break;
		default:
			# code...
			break;
		}
	}

	public function maleIndex() {

		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$malestudents = Student::where('gender','male')->get();
			$femalestudents = Student::where('gender','female')->get();
			break;
		case 'usercenter':
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','male')->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','female')->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->where('gender','male')->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->where('gender','female')->get();
			break;
		default:
			$malestudents = [];
			$femalestudents = [];
			break;
		}
		$gender='male';
		return view('student.index', compact('malestudents','femalestudents','gender'));
	}

	public function femaleIndex() {

		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$malestudents = Student::where('gender','male')->get();
			$femalestudents = Student::where('gender','female')->get();
			break;
		case 'usercenter':
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','male')->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','female')->get();
			break;
		case 'supervisor':
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->where('gender','male')->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($usercenter) {
				$q->where('user_student_permission.user_id', $usercenter->id);
			})->where('gender','female')->get();
			break;
		default:
			$malestudents = [];
			$femalestudents = [];
			break;
		}
		$gender='female';
		return view('student.index', compact('malestudents','femalestudents','gender'));
	}

	public function create() {
		return view('student.create');
	}

	public function store(Request $request) {
		$user = auth()->user();
		$request['password'] = $request->phone;
		// only supervisor and usercenter to add new students
		if ($user->userType == 'usercenter') {
			$request['createdby_model'] = 'usercenter';
			$request['createdby_id'] = $user->id;
			$request['usercenter_id'] = $user->id;
			$student = Student::create($request->all());

			$student->userStudentPermission()->attach($user->id);
		}
		if ($user->userType == 'supervisor') {
			$supervisor = $user->supervisorAccount;
			$request['createdby_model'] = 'supervisor';
			$request['createdby_id'] = $supervisor->id;
			$request['usercenter_id'] = $supervisor->usercenter()->id;
			$student = Student::create($request->all());

			$student->userStudentPermission()->attach($supervisor->usercenter()->id);
		}

		//grant permissions
		switch ($user->userType) {
		case 'usercenter':

			break;
		case 'supervisor':

			break;
		case 'superadmin':
			die('لاتملك الصلاحية');
			break;
		default:
			# code...
			break;
		}
		
		if($student->gender=='male')
			return redirect()->route('student.male_index');
		if($student->gender=='female')
			return redirect()->route('student.female_index');

	}

	public function circleShow(Student $student,Circle $circle) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
			case 'usercenter':
				$student->checkUserPermission($loggedUser);
				break;
			case 'supervisor':
			$usercenter = $loggedUser->supervisorAccount->usercenter();
				$student->checkUserPermission($usercenter);
				break;
			case 'teacher':
			$usercenter = $loggedUser->teacherAccount->usercenter();
			$student->checkUserPermission($usercenter);	
				break;	
			default:
				
				break;
		}
		$marks = Mark::where(['circle_id' => $circle->id,'student_id'=>$student->id])->get();
		return view('student.circle.show', compact('circle', 'marks','student'));
	}

	public function edit(Student $student) {
		return view('student.edit', compact('student'));
	}

	public function update(Request $request,Student $student) {
		$student->update($request->all());
		if($student->gender=='male')
			return redirect()->route('student.male_index');
		if($student->gender=='female')
			return redirect()->route('student.female_index');
	}

	public function activeToggle(Student $student) {
		$student->update(['active'=>!$student->active]);
		if($student->gender=='male')
			return redirect()->route('student.male_index');
		if($student->gender=='female')
			return redirect()->route('student.female_index');
	}

	public function allowWirteReport(Student $student,Circle $circle) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='teacher'){
			$teacher = $loggedUser->teacherAccount;
			$teacher->checkHisStudent($student);
			$subscription = DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['can_write_his_report'=>1]);
			return redirect()->back();
		}

		if($loggedUser->userType=='supervisor'){
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$usercenter->checkUsercenterHasStudent($student);
			$subscription = DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['can_write_his_report'=>1]);
			return redirect()->back();
		}

		if($loggedUser->userType=='usercenter'){
			$loggedUser->checkUsercenterHasStudent($student);
			$subscription = DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['can_write_his_report'=>1]);
			return redirect()->back();
		}

		die('لاتملك الصلاحية');
	}

	public function disallowWirteReport(Student $student,Circle $circle) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='teacher'){
			$teacher = $loggedUser->teacherAccount;
			$teacher->checkHisStudent($student);
			$subscription = DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['can_write_his_report'=>0]);
			return redirect()->back();
		}

		if($loggedUser->userType=='supervisor'){
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$usercenter->checkUsercenterHasStudent($student);
			$subscription = DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['can_write_his_report'=>0]);
			return redirect()->back();
		}

		if($loggedUser->userType=='usercenter'){
			$loggedUser->checkUsercenterHasStudent($student);
			$subscription = DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['can_write_his_report'=>0]);
			return redirect()->back();
		}

		die('لاتملك الصلاحية');
	}

	public function updateStatus(Request $request,Student $student,Circle $circle) {
		$this->validate($request,['status'=>'required']);
		$loggedUser = auth()->user();
		if($loggedUser->userType=='teacher'){
			$teacher = $loggedUser->teacherAccount;
			$teacher->checkHisStudent($student);
			DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['status'=>$request->status]);
			return redirect()->back();
		}

		if($loggedUser->userType=='supervisor'){
			$supervisor = $loggedUser->supervisorAccount;
			$usercenter = $supervisor->usercenter();
			$usercenter->checkUsercenterHasStudent($student);
			DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['status'=>$request->status]);
			return redirect()->back();
		}

		if($loggedUser->userType=='usercenter'){
			$loggedUser->checkUsercenterHasStudent($student);
			DB::table('circle_student')->where(['student_id'=>$student->id,'circle_id'=>$circle->id])
			->update(['status'=>$request->status]);
			return redirect()->back();
		}

		die('لاتملك الصلاحية');
	}


	 
	public function canWriteProgramReportIndex() {

		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'superadmin':
			$malestudents = Student::where('gender','male')->whereHas('circles',function($q){
				$q->where('circle_student.can_write_his_report',1);
			})->get();
			$femalestudents = Student::where('gender','female')->whereHas('circles',function($q){
				$q->where('circle_student.can_write_his_report',1);
			})->get();
			break;
		case 'usercenter':
			$malestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','male')->whereHas('circles',function($q){
				$q->where('circle_student.can_write_his_report',1);
			})->get();
			$femalestudents = Student::whereHas('userStudentPermission', function ($q) use ($loggedUser) {
				$q->where('user_student_permission.user_id', $loggedUser->id);
			})->where('gender','female')->whereHas('circles',function($q){
				$q->where('circle_student.can_write_his_report',1);
			})->get();
			break;
		
		default:
			$malestudents = [];
			$femalestudents = [];
			break;
		}
		return view('student.can_write_program_report_index', compact('malestudents','femalestudents'));
	}


	public function programReportIndex(Student $student,Circle $circle)
    {
        $programReports=[];

        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
        	$teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student);
            $programReports = ProgramReport::where(['circle_id'=>$circle->id,'student_id'=>$student->id])
            ->orderby('id','DESC')
            ->paginate(50);
        }elseif($loggedUser->userType==='usercenter'){
            $loggedUser->checkUsercenterHasStudent($student);
            $programReports = ProgramReport::where(['circle_id'=>$circle->id,'student_id'=>$student->id])
            ->orderby('id','DESC')
            ->paginate(50);
        }elseif($loggedUser->userType==='supervisor'){
            $supervisor = $loggedUser->supervisorAccount;
            $supervisor->checkSupervisorHasStudent($student);
            $programReports = ProgramReport::where(['circle_id'=>$circle->id,'student_id'=>$student->id])
            ->orderby('id','DESC')
            ->paginate(50);
        }else{
            abort(401);
        }
        
       return view('program_report.index',compact('programReports','circle','student')); 
    }

    public function studentTransferCreate(Student $student,Circle $circle)
    {
        $circles=[];

        $loggedUser = auth()->user();
        if($loggedUser->userType==='usercenter'){
            $loggedUser->checkUsercenterHasStudent($student);
            $availableCircles = Circle::whereHas('userCirclePermission',function($q) use($loggedUser){
            	$q->where('user_circle_permission.user_id',$loggedUser->id);
            })->get();
        }else{
            abort(401);
        }
        
       return view('student.transfer.create',compact('circle','availableCircles','student')); 
    }

    public function studentTransferStore(Request $request,Student $student,Circle $circle)
    {
    	$newCircle = Circle::find($request->circle_id);
    	$loggedUser = auth()->user();
    	if($loggedUser->userType==='usercenter'){
			$loggedUser->checkUsercenterHasStudent($student);
			if($newCircle->id != $circle->id){
				$student->circles()->detach($circle->id);
				$student->circles()->attach($newCircle->id,['program'=>$newCircle->program_id]);
				return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم']);
			}else{
				return redirect()->back();
			}
        }else{
            abort(401);
        }
       
       
    }



}
