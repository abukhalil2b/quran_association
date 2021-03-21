<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$years = Year::all();
		return view('year.index', compact('years'));
	}
	public function store(Request $request) {
		$this->validate($request, [
			'title' => 'required',
		]);
		Year::create(['title' => $request->title]);
		return redirect()->route('year.index');
	}

	public function create() {
		return view('year.create');
	}

	public function semesterIndex() {
		$semesters = Semester::all();
		return view('year.semester.index', compact('semesters'));
	}
	public function semesterStore(Request $request) {
		$this->validate($request, [
			'title' => 'required',
			'year_id' => 'required',
		]);
		Semester::create(['title' => $request->title, 'year_id' => $request->year_id]);
		return redirect()->route('semester.index');
	}

	public function semesterCreate(Year $year) {

		return view('year.semester.create', compact('year'));
	}
}
