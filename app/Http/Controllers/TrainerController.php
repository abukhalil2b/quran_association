<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TrainerController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$trainers = Trainer::all();
		return view('trainer.index', compact('trainers'));
	}


	public function create() {
		$users = User::where('userType','teacher')->OrWhere('userType','supervisor')->get();
		return view('trainer.create',compact('users'));
	}

	public function newCreate() {
		return view('trainer.new.create');
	}
	
	public function store(Request $request) {


		$loggedUser = auth()->user();
		if ($loggedUser->userType == 'usercenter') {

			if(!$request->user_id){
				$this->validate($request, [
					'password' => 'required',
					'email' => 'required',
					'name' => 'required',
				]);

				$user = User::create([
					'userType' => 'trainer',
					'name' => $request->name,
					'email' => $request->email,
					'password' => Hash::make($request->password),
				]);

			}else{
				$user = User::find($request->user_id);
			}
			
			$trainer = Trainer::where('owner',$user->id)->first();
			if($trainer){
				abort(401,'الحساب موجود سابقا');
			}
			$trainer = new Trainer;
			$trainer->owner = $user->id;
			$trainer->title = $request->title;
			$trainer->save();
			$loggedUser->userTrainerPermission()->attach($trainer->id);
			return redirect()->route('user.trainer.index');
		}
		die('أنت لاتملك الصلاحية');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Trainer  $trainer
	 * @return \Illuminate\Http\Response
	 */
	public function show(Trainer $trainer) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Trainer  $trainer
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Trainer $trainer) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Trainer  $trainer
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Trainer $trainer) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Trainer  $trainer
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Trainer $trainer) {
		//
	}
}
