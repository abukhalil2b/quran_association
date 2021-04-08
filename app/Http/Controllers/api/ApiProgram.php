<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Program;

class ApiProgram extends Controller
{
	public function getPrograms() {
		$programs = Program::with('circles')->get();
		$response =[
			'programs'=>$programs,
		];
		return response($response, 200);
	}
}
