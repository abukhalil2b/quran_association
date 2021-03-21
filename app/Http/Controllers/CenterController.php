<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CenterController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function usercenterCreate() {
		return view('usercenter.create');
	}

	public function usercenterIndex() {
		$usercenters = User::where('userType', 'usercenter')->get();
		return view('usercenter.index', compact('usercenters'));
	}

	public function usercenterStore(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required',
			'password' => 'required',
		]);
		$user = User::create([
			'name' => $request->name,
			'userType' => 'usercenter',
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);

		return redirect(route('usercenter.index'))->with(['status' => 'تم']);
	}

}
