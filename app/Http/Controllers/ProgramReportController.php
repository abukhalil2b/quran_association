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
    
    public function index()
    {
        $todaymeeting_program_reports = ProgramReport::where(['meeting'=>'todaymeeting'])
        ->orderby('id','DESC')
        ->paginate(50);
       return view('program_report.index',compact('todaymeeting_program_reports')); 
    }

    public function studentIndex(Student $student)
    {
        $todaymeeting_program_reports = ProgramReport::where(['student_id'=>$student->id,'meeting'=>'todaymeeting'])
        ->orderby('id','DESC')
        ->get();
       return view('program_report.student.index',compact('todaymeeting_program_reports')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // return $request->all();
        if(auth()->user()->userType=='teacher'){

            $request['donedate'] = date('Y-m-d',time());
            
            if($request->meeting==='nextmeeting'){
                $this->validate($request,[
                    'tobedonedate'=>'required'
                ]);
            }
            $this->validate($request,[
                'donedate'=>'required',
                'meeting'=>'required',
                'circle_id'=>'required',
                'teacher_id'=>'required',
                'student_id'=>'required',
                'mission'=>'required'
            ]);
                
            ProgramReport::create($request->all());
            return redirect()->route('student.show',['student'=>$request->student_id]);
        }
        abort(401);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramReport  $programReport
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramReport $programReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramReport  $programReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramReport $programReport)
    {
        return view('program_report.edit',compact('programReport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramReport  $programReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramReport $programReport)
    {
        $programReport->update($request->all());
        return redirect()->back()->with(['status'=>'success','message' => 'تم']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramReport  $programReport
     * @return \Illuminate\Http\Response
     */
    public function delete(ProgramReport $programReport)
    {
        $programReport->delete();
        return redirect()->back()->with(['status'=>'success','message' => 'تم']);
    }
}
