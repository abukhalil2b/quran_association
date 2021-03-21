<?php

namespace App\Http\Controllers;

use App\Models\MemorizedSowar;
use Illuminate\Http\Request;
use App\Models\Sowar;
use App\Models\Student;

class MemorizedSowarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            // $student = $teacher->checkHisStudent($student);
            $sowars = Sowar::all();
        }
        return view('student.memorized_sowar.create',compact('student','sowars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // return $request->all();
        $student = Student::find($request->student_id);
        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student); 
            MemorizedSowar::create(['student_id'=>$student->id,'sowar_id'=>$request->sowar_id]);
            return redirect()->route('student.show',['student'=>$student->id]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemorizedSowar  $memorizedSowar
     * @return \Illuminate\Http\Response
     */
    public function show(MemorizedSowar $memorizedSowar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemorizedSowar  $memorizedSowar
     * @return \Illuminate\Http\Response
     */
    public function edit(MemorizedSowar $memorizedSowar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemorizedSowar  $memorizedSowar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemorizedSowar $memorizedSowar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemorizedSowar  $memorizedSowar
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemorizedSowar $memorizedSowar)
    {
        //
    }
}
