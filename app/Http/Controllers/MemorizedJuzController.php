<?php

namespace App\Http\Controllers;

use App\Models\MemorizedJuz;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Circle;
use App\Models\Juz;
class MemorizedJuzController extends Controller
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
             // ->circles()->where('teacher_id',$teacher->id)->get();
            
            $juzs = Juz::all();
        }else{
            abort(401);
        }
        return view('student.memorized_juz.create',compact('student','juzs'));
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
            MemorizedJuz::create(['student_id'=>$student->id,'juz_id'=>$request->juz_id]);
            return redirect()->route('student.show',['student'=>$student->id]);
        }
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemorizedJuz  $memorizedJuz
     * @return \Illuminate\Http\Response
     */
    public function show(MemorizedJuz $memorizedJuz)
    {
        //
    }


    public function juzEdit(Juz $juz)
    {
        return view('juz.edit',compact('juz'));
    }

    public function memorizedJuzDelete(MemorizedJuz $memorizedjuz)
    {
       
        $memorizedjuz->delete();
        return redirect()->back()->with(['status'=>'success','message'=>'تم']);
    }


    public function juzUpdate(Request $request, Juz $juz)
    {
        $juz->update(['title'=>$request->title]);
        return redirect()->route('dashboard')->with(['status'=>'success','message'=>'تم']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemorizedJuz  $memorizedJuz
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemorizedJuz $memorizedJuz)
    {
        //
    }
}
