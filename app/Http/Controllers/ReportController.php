<?php

namespace App\Http\Controllers;
use App\Models\FinanceReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function store(Request $request) {
		FinanceReport::create($request->all());
		return redirect()->back();
	}
	public function print() {
		return view('report.print');
	}
	public function create() {
		$reports = FinanceReport::all();
		return view('report.create', compact('reports'));
	}

}