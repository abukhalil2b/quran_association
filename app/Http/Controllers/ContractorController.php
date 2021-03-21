<?php

namespace App\Http\Controllers;
use App\Models\Contractor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractorController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function show($id) {
		$contractor = Contractor::find($id);
		return view('contractor.show', compact('contractor'));
	}
	public function create() {
		$contractors = Contractor::all();
		return view('contractor.create', compact('contractors'));
	}

	public function store(Request $request) {

		$request->validate([
			'name' => 'required',
			'job' => 'required',
			'endAt' => 'required',
		]);

		$filePath = NULL;
		if ($request->hasFile('file')) {
			$extension = $request->file->getClientOriginalExtension();
			$filePath = $request->file('file')->storeAs(
				$request->category, time() . '.' . $extension
			);

		}

		Contractor::create(array_merge($request->all(), ['file' => $filePath]));
		return redirect()->route('contractor.create')->with(['status' => 'تم']);
	}

}
