<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Teacher;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    public function aboutStudent()
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='usercenter'){
            $teachers = Teacher::whereHas('userTeacherPermission',function($q)use($loggedUser){
                $q->where('user_teacher_permission.user_id',$loggedUser->id);
            })->get();
            return view('permission.about.student',compact('teachers'));
        }
        die('لا تملك الصلاحية');
    }
    
    public function aboutStudentToggle(Teacher $Teacher)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType==='usercenter'){
            $teacher = $Teacher->whereHas('userTeacherPermission',function($q)use($loggedUser,$Teacher){
                $q->where(['user_teacher_permission.user_id'=>$loggedUser->id,'user_teacher_permission.teacher_id'=>$Teacher->id]);
            })->first();
            $owner = $teacher->accountOwner;
            $hasAbout = About::where('user_id',$owner->id)->first();
            if($hasAbout){
                $hasAbout->delete();
            }else{
                About::create(['name'=>'student','user_id'=>$owner->id]);
            }
            return redirect()->back();
        }
        die('لا تملك الصلاحية');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, About $about)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
    }
}
