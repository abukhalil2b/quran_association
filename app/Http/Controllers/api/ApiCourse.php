<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Course;

class ApiCourse extends Controller
{
	public function index() {
		$coming = Course::where('status','coming')->get();
		$now = Course::where('status','now')->get();
		$past = Course::where('status','past')->get();
		$response =[
			'coming'=>$coming,
			'now'=>$now,
			'past'=>$past
		];
		return response($response, 200);
	}
}
