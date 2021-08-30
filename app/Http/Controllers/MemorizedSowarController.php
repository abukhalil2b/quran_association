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

    public function create(Student $student)
    {
        $loggedUser = auth()->user();

        

        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student); 
        }elseif($loggedUser->userType==='usercenter'){
            $loggedUser->checkUsercenterHasStudent($student);
        }else{
            abort(401);
        }

        $studentMemorizedSowars = $student->memorizedSowars()->get();

        if(count($studentMemorizedSowars)==0){
            for($id=1;$id<=114;$id++){
                MemorizedSowar::create([
                    'student_id'=>$student->id,
                    'sowar_id'=>$id
                ]);
            }
            return redirect()->back()->with(['status'=>'success','message'=>'تم']);
        }

         return view('student.memorized_sowar.create',compact('student','studentMemorizedSowars'));
        
    }


    public function update(Request $request, Student $student)
    {
        $loggedUser = auth()->user();

        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student); 
        }elseif($loggedUser->userType==='usercenter'){
            $loggedUser->checkUsercenterHasStudent($student);
        }else{
            abort(401);
        }

        MemorizedSowar::where('student_id',$student->id)->update(['done'=>0]);
        if($request->sowarIds){
          MemorizedSowar::whereIn('id',$request->sowarIds)->where('student_id',$student->id)->update(['done'=>1]);  
        }

       return redirect()->route('dashboard')->with(['status'=>'success','message' => 'تم']);;
    }
}
