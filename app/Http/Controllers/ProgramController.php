<?php

namespace App\Http\Controllers;
use App\Models\Building;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Semester;
use Illuminate\Http\Request;

class ProgramController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	public function dashboard(Program $program) {

		return view('program.dashboard', compact('program'));
	}
	public function index() {
		$programs = Program::all();
		return view('program.index', compact('programs'));
	}
	public function quarterlyStore(Request $request) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$building_id = $request->building_id;
			$hasBuilding = $loggedUser->whereHas('buildings', function ($query) use ($building_id) {
				$query->where('buildings.id', $building_id);
			})->get();
			if ($hasBuilding) {
				$request['quarterly']=1;
				$request['semester_id']=Semester::latest()->whereActive(1)->first()->id;
				if ($program = Program::create($request->all())) {
					$program->userProgramPermission()->attach($loggedUser->id);
				}
				return redirect()->route('building.dashboard', ['building' => $building_id])->with(['message' => 'تم', 'status' => 'success']);
			}
			return redirect()->back()->with(['message' => 'البرنامج خطأ', 'status' => 'danger']);
		}
	}

	public function quarterlyCreate(Building $building) {
		$semester = Semester::latest()->whereActive(1)->first();
		if ($semester) {
			return view('program.quarterly.create', compact('building', 'semester'));
		}
		return redirect()->back()->with(['message' => 'لايوجد فصل، لايمكن اضافة برنامج', 'status' => 'danger']);
	}

	public function create(Building $building) {
		return view('program.create', compact('building'));
	}

	public function store(Request $request) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$building_id = $request->building_id;
			$hasBuilding = $loggedUser->whereHas('buildings', function ($query) use ($building_id) {
				$query->where('buildings.id', $building_id);
			})->get();
			if ($hasBuilding) {
				$request['quarterly']=0;
				if ($program = Program::create($request->all())) {
					$program->userProgramPermission()->attach($loggedUser->id);
				}
				return redirect()->route('building.dashboard', ['building' => $building_id])->with(['message' => 'تم', 'status' => 'success']);
			}
			return redirect()->back()->with(['message' => 'البرنامج خطأ', 'status' => 'danger']);
		}
	}

}