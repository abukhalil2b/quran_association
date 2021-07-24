<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Trainee;
use Illuminate\Http\Request;

class TraineeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
 
	public function index() {
		$trainees = Trainee::all();
		return view('trainee.index', compact('trainees'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Trainee  $trainee
	 * @return \Illuminate\Http\Response
	 */
	public function show(Trainee $trainee) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Trainee  $trainee
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Trainee $trainee) {
		return view('trainee.edit', compact('trainee'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Trainee  $trainee
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Trainee $trainee) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Trainee  $trainee
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Trainee $trainee) {
		//
	}

}
