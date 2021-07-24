<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FatherController extends Controller
{
   public function __construct() {
		$this->middleware('auth');
	}
}
