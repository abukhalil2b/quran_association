<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function store(Request $request) {
		if(auth()->user()->userType==='teacher'){
			$this->validate($request, ['circle_id' => 'required', 'student_id' => 'required','point'=>'required']);
			// return $request->all();
			Mark::create($request->all());
			return redirect()->route('student.circle.show', ['student' => $request->student_id,'circle' => $request->circle_id])
			->with(['status' => 'success', 'message' => 'تم']);
		}
		abort(401);
	}
}
