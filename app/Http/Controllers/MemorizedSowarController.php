<?php

namespace App\Http\Controllers;

use App\Models\MemorizedSowar;
use Illuminate\Http\Request;
use App\Models\Sowar;
use App\Models\Student;

class MemorizedSowarController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }


    public function create(Student $student)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            // $student = $teacher->checkHisStudent($student);
            $sowars = Sowar::all();
        }else{
            abort(401);
        }
        return view('student.memorized_sowar.create',compact('student','sowars'));
    }


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

    public function memorizedSowarDelete(MemorizedSowar $memorizedSowar)
    {
       
        $memorizedSowar->delete();
        return redirect()->back()->with(['status'=>'success','message'=>'تم']);
    }



}
