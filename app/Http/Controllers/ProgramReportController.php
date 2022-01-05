<?php

namespace App\Http\Controllers;

use App\Models\ProgramReport;
use App\Models\Program;
use App\Models\MemorizedJuz;
use App\Models\MemorizedSowar;
use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;
class ProgramReportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $programReports=[];

        $loggedUser = auth()->user();
        if($loggedUser->userType==='usercenter'){
            $programReports = ProgramReport::orderby('id','DESC')
            ->where('owned_by_usercenter_id',$loggedUser->id)
            ->paginate(50);
        }else{
            abort(401);
        }
        
       return view('program_report.index',compact('programReports')); 
    }

    public function create(Program $program,Student $student)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $program = $teacher->checkHisStudentHasProgram($program,$student);
            $programReports = ProgramReport::where(['student_id'=>$student->id,'program_id'=>$program->id])->whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->get();
            $memorizedJuzs = MemorizedJuz::where('student_id',$student->id)->get();
            $memorizedSowars = MemorizedSowar::where('student_id',$student->id)->get();
            return view('program_report.create',compact('teacher','student','program','programReports','memorizedJuzs','memorizedSowars'));
        }
        abort(401);
    }

    public function store(Request $request){
         // return $request->all();
        $loggedUser = auth()->user();
        if($loggedUser->userType=='teacher'){
            if(!$request->donedate){
                $request['donedate'] = date('Y-m-d',time());
            }
            $this->validate($request,[
                'donedate'=>'required',
                'todaymission'=>'required',
                'circle_id'=>'required',
                'teacher_id'=>'required',
                'student_id'=>'required'
            ]);
             $teacher=$loggedUser->teacherAccount; 
             $usercenter = $teacher->usercenter();
             $request['owned_by_usercenter_id']=$usercenter->id;

            ProgramReport::create($request->all());
            return redirect()->route('student.show',['student'=>$request->student_id,'circle'=>$request->circle_id]);
        }
        abort(401);
    }
 
    public function show(ProgramReport $programReport)
    {
        //
    }
 
    public function edit(ProgramReport $programReport,Student $student)
    {
        return view('program_report.edit',compact('programReport','student'));
    }

    public function update(Request $request, ProgramReport $programReport,Student $student)
    {
        
        //data to be update
        $data=[
            'todaymission'=>$request->todaymission,
            'note'=>$request->note,
            'evaluation'=>$request->evaluation,
            'nextmission'=>$request->nextmission
        ];

        $loggedUser = auth()->user();
        if($loggedUser->userType=='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student);
            $programReport->update($data);
            // ProgramReport::where(['student_id'=>$student->id,'id'=>$programReport->id])->update($data);
            return redirect()->route('student.show',['student'=>$student->id,'circle'=>$programReport->circle_id])
            ->with(['status'=>'success','message' => 'تم التعديل']);
         }
         abort(401);
    }
    
    public function confirmDelete(ProgramReport $programReport,Student $student)
    {
        return view('program_report._confirm_delete',compact('programReport','student'));
    }

    public function delete(ProgramReport $programReport,Student $student)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType=='teacher'){
            $teacher = $loggedUser->teacherAccount;
            $teacher->checkHisStudent($student);
            ProgramReport::where(['student_id'=>$student->id,'id'=>$programReport->id])->delete();
            return redirect()->route('student.show',['student'=>$student->id])
            ->with(['status'=>'success','message' => 'تم الحذف']);
        }
        abort(401);
    }
}
