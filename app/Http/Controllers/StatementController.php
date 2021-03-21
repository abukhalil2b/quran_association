<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Statement;
use Illuminate\Http\Request;

class StatementController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function store(Request $request) {
		$this->validate($request, [
			'amount' => 'required',
		]);

		$date = $request->date;
		$state = $request->state;
		$course_id = $request->course_id;
		$amount = $state == 'income' ? $request->amount : -($request->amount);
		Statement::create(['date' => $date, 'state' => $state, 'amount' => $amount, 'course_id' => $course_id]);
		return redirect()->back();
	}

	public function create() {
		$courses = Course::limit(20)->get();
		$months = Statement::selectRaw("MONTH(date) as month , date")->distinct()->get();

		return view('statement.create', compact('courses', 'months'));
	}

	public function details($date) {
		$statements = Statement::where('date', $date)->get();
		return view('statement.details', compact('statements'));
	}

	public function search(Request $request) {
		$request->validate(
			['fromDate' => 'required', 'toDate' => 'required']
		);
		$Statement = Statement::whereBetween('date', [$request->fromDate, $request->toDate]);
		if ($request->state != null) {
			$statements = $Statement->where('state', $request->state)->get();
		} else {
			$statements = $Statement->get();
		}
		return view('statement.details', compact('statements'));
	}
}
