<?php

namespace App\Http\Controllers;
use App\Models\Circle;
use App\Models\Dailyrecord;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyrecordController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$loggedUser = auth()->user();
		if ($loggedUser->userType=='usercenter') {

			$dailyrecords = Dailyrecord::whereHas('userDailyrecordPermission',function($q)use($loggedUser){
				$q->where('user_dailyrecord_permission.user_id',$loggedUser->id);
			})->orderby('id','desc')->get();
			return view('dailyrecord.index', compact('dailyrecords'));	
		}
		abort(401);
	}

	public function store(Request $request) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$user = $teacher->usercenter();
			$this->validate($request, ['title' => 'required', 'circle_id' => 'required', 'about' => 'required']);
			$circle_id = $request->circle_id;
			//check circle
			$circle = Circle::whereHas('userCirclePermission', function ($q) use ($circle_id, $user) {
				$q->where(['user_circle_permission.circle_id' => $circle_id, 'user_circle_permission.user_id' => $user->id]);
			})->first();
			if (!$circle) {
				die('أنت لاتملك الصلاحيات');
			}
			$lastDailyrecord = Dailyrecord::latest()->where('circle_id', $circle->id)->whereDate('created_at', Carbon::today())->first();
			if ($lastDailyrecord) {
				die('doublicated');
			}
			if ($loggedUser->hasAboutPermission($request->about)) {
				$record = Dailyrecord::create($request->all());
				$record->userDailyrecordPermission()->attach($user->id);
				return redirect()->back()->with(['status' => 'success', 'message' => 'تم حفظ السجل']);
			} else {
				die('أنت لاتملك الصلاحيات');
			}

			break;

		default:
			# code...
			break;
		}

	}

	public function create(Circle $circle, $about) {

		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'teacher':
			$teacher = $loggedUser->teacherAccount;
			$user = $teacher->usercenter();

			//check circle
			$circle = Circle::whereHas('userCirclePermission', function ($q) use ($circle, $user) {
				$q->where(['user_circle_permission.circle_id' => $circle->id, 'user_circle_permission.user_id' => $user->id]);
			})->first();
			if (!$circle) {
				die('أنت لاتملك الصلاحيات');
			}
			if (auth()->user()->hasAboutPermission($about)) {
				return view('dailyrecord.create', compact('circle', 'about'));
			}
			break;

		default:
			# code...
			break;
		}

		return die('لاتملك صلاحية فتح السجل');
	}

}