<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use ArPHP\I18N\Arabic; 

class CertificateController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            $courses = Course::where('user_id',$loggedUser->id)->get();
            return view('certificate.index',compact('courses'));            
        }
        abort(401);
    }

    
    public function create(Course $course,$gender)
    {
        // return $course;
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            $loggedUser->checkUsercenterHasCourse($course);
            return view('certificate.create',compact('course','gender'));            
        }
        abort(401);
    }

    public function store(Request $request,Course $course)
    {
        // return $request->all();

        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            $loggedUser->checkUsercenterHasCourse($course);
          if($request->hasFile('male_certificate_url')){
                $extension = $request->male_certificate_url->getClientOriginalExtension();
                $path=$loggedUser->id.'/'.$course->id;
                $imageUrl = $request->file('male_certificate_url')->storeAs($path,'male.'.$extension);
                $course->update(['male_certificate_url'=>$imageUrl,'path'=>$path]);
                return redirect()->back()->with(['status'=>'success','message'=>'تم']);
            }

            if($request->hasFile('female_certificate_url')){
                $extension = $request->female_certificate_url->getClientOriginalExtension();
                $path=$loggedUser->id.'/'.$course->id;
                $imageUrl = $request->file('female_certificate_url')->storeAs($path,'female.'.$extension);
                $course->update(['female_certificate_url'=>$imageUrl,'path'=>$path]);
                return redirect()->back()->with(['status'=>'success','message'=>'تم']); 
            } 
            abort(404);
        }
        abort(401);
        
       
    }

    public function studentWithCertificateIndex(Course $course)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            $loggedUser->checkUsercenterHasCourse($course);
            $studentsWithCertificates = $course->certificates()
            ->where(['course_id'=>$course->id])
            ->get();
            return view('certificate.student_with_certificate_index',compact('studentsWithCertificates','course'));
        }
        abort(401);
    }

    public function addStudentNewCreate(Student $student)
    {
        //TODO:: certificate permission.
        $students = Student::all();
        return view('certificate.add_student_new_create',compact('students','certificate'));
    }

    public function addStudentNewStore(Request $request, Certificate $certificate)
    {
        
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            $this->validate($request,['name'=>'required','phone'=>'required','gender'=>'required']); 
            $request['password']=$request->phone;
            $student = Student::create($request->all());
            $loggedUser->userStudentPermission()->attach($student);
        }

    }

    public function addStudentStore(Request $request, Certificate $certificate)
    {
         
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            if($request->studentIds){
               foreach ($request->studentIds as $student) {
                    $student=Student::findOrFail($student);
                    $loggedUser->checkUsercenterHasStudent($student);
                }  
                $certificate->students()->attach($request->studentIds);
                return redirect()->back()->with(['status'=>'success','message'=>'done']); 
            }
            
        }

    }

    public function destroy(Course $course,$gender)
    {
        $subscribers = $course->subscribers()->where('gender',$gender);
        
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            //check authorization
            $loggedUser->checkUsercenterHasCourse($course);

            if($gender=='male'){
                Storage::delete($course->male_certificate_url);
                $course->update(['male_certificate_url'=>NULL]);

            }

            if($gender=='female'){
                Storage::delete($course->female_certificate_url);
               $course->update(['female_certificate_url'=>NULL]);
            }

            $subscribers->update(['certificate_url'=>NULL]);

            foreach ($subscribers->get() as $subscriber) {
                Storage::delete($subscriber->pivot->certificate_url);
            }

        }
        return redirect()->back()->with(['status'=>'success','message'=>'تم']);
    }

    
    public function certificateShow(Student $student,Course $course)
    {
        $loggedUser = auth()->user();
        if($loggedUser->userType=='usercenter'){
            //check authorization
            $loggedUser->checkUsercenterHasCourse($course);
            // $loggedUser->checkUsercenterHasStudent($student);

            $student = $course->subscribers()->where('id',$student->id)->first();
            if(!$student){
                abort(404);
            }
            if($student->gender=='male'){
                $certificate_url = $course->male_certificate_url;
            }

            if($student->gender=='female'){
                $certificate_url = $course->female_certificate_url;
            }

            if(!$certificate_url){
                abort(404);
            }

            $course = $student->courses()->where('id',$course->id)->first();

            if($course->pivot->certificate_url){
               return view('certificate.student.show',compact('course'));
            }
            $obj = new Arabic();
            $date =date('Y-m-d',time());
           
            $name = $obj->utf8Glyphs($student->name);
            $url = public_path('storage/'.$certificate_url);
            $image = Image::make($url)
            ->text($name,780,350,function($font){
            $font->file('fonts/HelveticaNeueLTW20-Bold.ttf');
            $font->size(30);
            $font->color('#675b53');
            $font->align('center');
            // $font->valign('top');
            // $font->angle(45);
            })
            ->text($date,75,180,function($font){
            $font->file('fonts/HelveticaNeueLTW20-Bold.ttf');
            $font->size(20);
            $font->color('#675b53');
            $font->align('left');
            // $font->valign('top');
            // $font->angle(45);
            });
            $certificate_url = $course->path.'/'.$student->id.'.jpg';
            $image->save('storage/'.$certificate_url);
            $student->courses()->updateExistingPivot($course->id,['certificate_url'=>$certificate_url]);
            $course = $student->courses()->where('id',$course->id)->first();
            return view('certificate.student.show',compact('course'));
        }
        abort(401);

    }
}
