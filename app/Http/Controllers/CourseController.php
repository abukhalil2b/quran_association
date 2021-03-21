<?php

namespace App\Http\Controllers;
use App\Models\Building;
use App\Models\Course;
use App\Models\Coursedetail;
use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class CourseController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$courses = Course::all();
		return view('course.index', compact('courses'));
	}
	public function show(Course $course) {

		// $course = Course::find($id);
		return view('course.show', compact('course'));
	}
	public function create() {
		$buildings = Building::whereUserId(auth()->user()->id)->get();
		$trainers = Trainer::all();
		return view('course.create', compact('trainers', 'buildings'));
	}

	public function store(Request $request) {
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'usercenter':
			$request['user_id'] = $loggedUser->id;
			if ($request->deliveryMeans == 'attend-building') {
				$this->validate($request, ['building_id' => 'required']);
			} else {
				$request->request->remove('building_id');
			}

			$request['status'] = 'coming';
			$course = Course::create($request->all());
			return redirect()->route('course.index');
			break;

		default:
			die('لاتملك الصلاحية');
			break;
		}

	}

	public function edit(Course $course) {
		$buildings = Building::whereUserId(auth()->user()->id)->get();
		// $course = Course::find($id);

		$trainers = Trainer::all();
		return view('course.edit', compact('course', 'trainers', 'buildings'));
	}

	public function update(Request $request) {
		// return $request->all();
		$loggedUser = auth()->user();
		switch ($loggedUser->userType) {
		case 'usercenter':
			if ($request->deliveryMeans == 'attend-building') {
				$this->validate($request, ['building_id' => 'required']);
			} else {
				$request->request->remove('building_id');
			}
			$course = Course::find($request->course_id);
			if (!$course) {
				die('لاتملك الصلاحية');
			}
			$course = $course->checkUserPermission($loggedUser); //die if not found
			if (!$request->weekDays) {
				$request['weekDays'] = NULL;
			}
			$course->update($request->all());
			return redirect()->route('course.show', ['course' => $course->id]);
			break;

		default:
			die('لاتملك الصلاحية');
			break;
		}

	}

	public function statusEdit(Course $course) {
		// $course = Course::find($id);
		return view('course.status.edit', compact('course'));
	}

	public function statusUpdate(Request $request) {
		// return $request->all();
		$course = Course::find($request->id);
		$course->update(['status' => $request->status]);
		return redirect()->route('course.index');
	}

	public function detailTitleCreate(Course $course) {
		// $course = Course::find($id);
		$details = Coursedetail::where(['course_id' => $course->id])->get();
		return view('course.detail.create', compact('course', 'details'));
	}

	public function detailTitleStore(Request $request) {
		// return $request->all();
		$this->validate($request, [
			'title' => 'required',
			'ishead' => 'required',
		]);
		if ($request->ishead == 1) {
			$this->validate($request, [
				'icon' => 'required',
			]);
		}
		$course = Course::find($request->course_id);
		Coursedetail::create(
			[
				'ishead' => $request->ishead,
				'icon' => $request->icon,
				'title' => $request->title,
				'course_id' => $request->course_id,
			]);

		return redirect()->route('course.detail.create', ['id' => $course->id]);
	}

}