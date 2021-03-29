<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\MemorizeProgram;
use App\Models\Teacher;
use App\Models\Circle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}


	public function edit(Teacher $teacher) {
		return view('user.superadmin.owner.edit_teacher_owner',compact('teacher'));
	}

	public function update(Request $request,Teacher $teacher) {
		// return $request->all();
		$this->validate($request, [
			'owner' => 'required|unique:teachers',
		]);

		$loggedUser = auth()->user();

		if ($loggedUser->userType !== 'superadmin') {
			die('أنت لاتملك الصلاحية');
		}
		$teacher->update(['owner'=>$request->owner]);

		return redirect()->back()->with(['status'=>'success','message'=>'تم']);
	}



}
