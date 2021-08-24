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
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$programs = Program::whereHas('userProgramPermission',function($q)use($loggedUser){
				$q->where('user_program_permission.user_id',$loggedUser->id);
			})->get();
			return view('program.index', compact('programs'));
		}
		abort(401);
		
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

	public function edit(Program $program) {
		return view('program.edit', compact('program'));
	}

	public function update(Request $request,Program $program) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$loggedUser->checkUsercenterHasProgram($program);
			$program->update(['title'=>$request->title]);
			return redirect()->route('dashboard')->with(['message' => 'تم', 'status' => 'success']);		
		}
		abort(401);
		
	}


	

	public function prepareForDelete(Program $program) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$circles = $program->circles()->get();
			return view('program.prepare_for_delete', compact('circles','program'));			
		}
	}

	public function destroy(Program $program) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter') {
			$loggedUser->checkUsercenterHasProgram($program);
			$circles = $program->circles()->get();
			if(count($circles)){
				abort(401,'لايمكن الحذف');
			}
			$program->userProgramPermission()->detach();
			$program->delete();
			return redirect()->route('dashboard')->with(['message' => 'تم', 'status' => 'success']);		
		}

	}
	

}