<?php

namespace App\Http\Controllers;

use App\Models\MemorizedJuz;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Circle;
use App\Models\Juz;
class MemorizedJuzController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function create(Student $student)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $studentMemorizedJuzs = $student->memorizedJuzs()->get();
            if(count($studentMemorizedJuzs)==0){
                for($id=1;$id<=30;$id++){
                    MemorizedJuz::create([
                        'student_id'=>$student->id,
                        'juz_id'=>$id
                    ]);
                }
                return redirect()->back()->with(['status'=>'success','message'=>'تم']);
            }
            return view('student.memorized_juz.create',compact('student','studentMemorizedJuzs'));
        }
        abort(401);
        
    }


    public function update(Request $request, Student $student)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student); 
            MemorizedJuz::where('student_id',$student->id)->update(['done'=>0]);
            if($request->juzIds){
              MemorizedJuz::whereIn('id',$request->juzIds)->where('student_id',$student->id)->update(['done'=>1]);  
            }
            return redirect()->route('student.show',['student'=>$student->id]);
        }
       return redirect()->route('student.show',['student'=>$student->id]);
    }

   
}
