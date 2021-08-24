<?php

namespace App\Http\Controllers;
use App\Models\Building;
use App\Models\Program;
use App\Models\Semester;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;

class BuildingController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}



	public function index() {
		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter' || $loggedUser->userType === 'superadmin') {
			$buildings = Building::whereHas('userBuildingPermission',
				function ($q) use ($loggedUser) {
					$q->where('user_building_permission.user_id', $loggedUser->id);
				}
			)->get();
			return view('building.index', compact('buildings'));
		}
		die('لا تملك الصلاحية');

	}

	public function create() {
		$thisyear = Year::orderby('id', 'desc')->first();
		if(!$thisyear)die('لم تحدد السنة');

		$loggedUser = auth()->user();
		if ($loggedUser->userType === 'usercenter' || $loggedUser->userType === 'superadmin') {
			return view('building.create');
		}
		die('لا تملك الصلاحية');
			}

	public function store(Request $request) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType == 'usercenter') {
			$this->validate($request, [
				'title' => 'required',
			]);
			$building = Building::create([
				'title' => $request->title,
				'user_id' => $loggedUser->id,
			]);
			$loggedUser->userBuildingPermission()->attach($building->id);
			return redirect()->route('building.dashboard', ['building' => $building->id])
			->with(['status' => 'success', 'message' => 'تم']);
		}

		die('أنت لاتملك الصلاحية');

	}

	public function dashboard(Building $building) {
		$loggedUser = auth()->user();
		$building = Building::whereHas('userBuildingPermission', function ($q) use ($loggedUser, $building) {
			$q->where('user_building_permission.user_id', $loggedUser->id)
				->where('user_building_permission.building_id', $building->id);
		})->first();
		if (!$building) {
			die('أنت لاتملك الصلاحية');
		}
		$thisyear = Year::orderby('id', 'desc')->first();
		$programs = Program::where(['building_id' => $building->id, 'quarterly' => 0])->get();
		$quarterlyPrograms = Program::where(['building_id' => $building->id, 'semester_id' => $thisyear->lastSemester()->id])->get();
		$semester = Semester::latest()->first();
		return view('building.dashboard', compact('building', 'semester', 'programs', 'quarterlyPrograms'));
	}

	public function showDeleteForm(Building $building) {
		$loggedUser = auth()->user();
		$building = Building::whereHas('userBuildingPermission', function ($q) use ($loggedUser, $building) {
			$q->where('user_building_permission.user_id', $loggedUser->id)
				->where('user_building_permission.building_id', $building->id);
		})->first();
		if (!$building) {
			die('أنت لاتملك الصلاحية');
		}
		
		$programs = Program::where(['building_id' => $building->id])->get();
		
		return view('building.delete_form', compact('building', 'programs'));
	}

	
	public function confirmDeleteForm(Building $building) {
		$loggedUser = auth()->user();
		if ($loggedUser->userType == 'usercenter') {
			$loggedUser->checkUsercenterHasBuilding($building);
			if($building->programs()->count()){
				abort(401,'لايمكن الحذف');
			}
			$building->userBuildingPermission()->detach();
			$building->delete();
			return redirect()->route('dashboard')->with(['message' => 'تم', 'status' => 'success']);
		}
		
	}
}
