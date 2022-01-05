<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Statement;
use Illuminate\Http\Request;

class StatementController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function create() {
		$months = Statement::selectRaw("MONTH(date) as month , date")->distinct()->get();
		return view('statement.create', compact('months'));
	}
	
	public function store(Request $request) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$this->validate($request, [
				'amount' => 'required',
			]);

			$details = $request->details;
			$date = $request->date;
			$state = $request->state;
			$course_id = $request->course_id;
			$amount = $state == 'income' ? $request->amount : -($request->amount);
			Statement::create([
				'date' => $date,
				'state' => $state,
				'amount' => $amount,
				'user_id'=>$loggedUser->id,
				'details'=>$details
			]);
			return redirect()->back();			
		}
		abort(401);

	}
	

	public function details($date) {
		$loggedUser = auth()->user();
		if($loggedUser->userType=='usercenter'){
			$statements = Statement::where(['date'=> $date,'user_id'=>$loggedUser->id])->get();
			return view('statement.details', compact('statements'));			
		}
		abort(403);
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
