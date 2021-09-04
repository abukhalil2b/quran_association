<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use ArPHP\I18N\Arabic; 

class CertificateController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function uploadMaleCertificateCreate(Course $course)
    {
        
        $subscribers = $course->subscribers()->where('gender','male')
        ->whereDoesntHave('certificates',function($q) use($course){
            $q->where('certificates.course_id',$course->id);
        })
        ->get();
        $subscriberIds = $course->subscribers()->where('gender','male')->pluck('id');
        $certificates = Certificate::whereIn('student_id',$subscriberIds)
        ->where('course_id',$course->id)
        ->get();
      
        return view('certificate.upload.male_certificate_create',compact('course','certificates','subscribers'));  
    }

    public function uploadFemaleCertificateCreate(Course $course)
    {
        $subscribers = $course->subscribers()->where('gender','female')
        ->whereDoesntHave('certificates',function($q) use($course){
            $q->where('certificates.course_id',$course->id);
        })
        ->get();
        $subscriberIds = $course->subscribers()->where('gender','female')->pluck('id');
        $certificates = Certificate::whereIn('student_id',$subscriberIds)
        ->where('course_id',$course->id)
        ->get();
        return view('certificate.upload.female_certificate_create',compact('course','certificates','subscribers'));  
    }

    
    public function uploadMaleCertificateStore(Request $request,Course $course)
    {
        if(!$request->hasFile('images')){
            abort(404,'لم تختر أي ملف');
        }
        foreach ($request->file('images') as $image) {
            if($image->getMimeType()!=='image/jpeg'){
                abort(403,'صيغة الملف غير صحيحة');
            }
            $fileName[] = json_decode(pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME));
            //studentIds from image name.
            $imageIds=array_filter($fileName, fn($value) => !is_null($value));
        }
        $subscriberIds = $course->subscribers()->where('gender','male')
        ->whereDoesntHave('certificates',function($q) use($course){
            $q->where('certificates.course_id',$course->id);
        })
        ->limit(20)
        ->pluck('id')->toArray();
        
        $array_equal = $this->array_equal($subscriberIds, $imageIds);
         // dd($array_equal);
        if(!$array_equal){
             abort(403,'يجب أن يكون اسم الشهادات هو نفس أرقم الطلاب الموجودين في القائمة');
        }
        foreach ($imageIds as $id) {
            
            $path=$image->storePubliclyAs(
                    'certificates',
                    $course->id.'/'.$id.'.'.'jpg',
                    's3'
                );
            Certificate::create([
                'course_id'=>$course->id,
                'student_id'=>$id,
                'url'=>'https://abukhalil2b-store-image.s3.ap-south-1.amazonaws.com/'.$path
            ]);
        }

        return redirect()->back()->with(['status'=>'success','message'=>'تم']);
    }

    public function uploadFemaleCertificateStore(Request $request,Course $course)
    {
        if(!$request->hasFile('images')){
            abort(404,'لم تختر أي ملف');
        }
        foreach ($request->file('images') as $image) {
            if($image->getMimeType()!=='image/jpeg'){
                abort(403,'صيغة الملف غير صحيحة');
            }
            $fileName[] = json_decode(pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME));
            //studentIds from image name.
            $imageIds=array_filter($fileName, fn($value) => !is_null($value));
        }

        $subscriberIds = $course->subscribers()->where('gender','female')
        ->whereDoesntHave('certificates',function($q) use($course){
            $q->where('certificates.course_id',$course->id);
        })
        ->limit(20)
        ->pluck('id')->toArray();
        
        $array_equal = $this->array_equal($subscriberIds, $imageIds);
         // dd($imageIds);
        if(!$array_equal){
             abort(403,'يجب أن يكون اسم الشهادات هو نفس أرقم الطلاب الموجودين في القائمة');
        }

        foreach ($imageIds as $id) {
            $path=$image->storePubliclyAs(
                    'certificates',
                    $course->id.'/'.$id.'.'.'jpg',
                    's3'
                );
            Certificate::create([
                'course_id'=>$course->id,
                'student_id'=>$id,
                'url'=>'https://abukhalil2b-store-image.s3.ap-south-1.amazonaws.com/'.$path
            ]);
        }

        return redirect()->back()->with(['status'=>'success','message'=>'تم']);
    }

    public function array_equal($subscriberIds, $imageIds) {
        return (
             is_array($subscriberIds) 
             && is_array($imageIds) 
             && count($subscriberIds) == count($imageIds) 
             && array_diff($subscriberIds, $imageIds) === array_diff($imageIds, $subscriberIds)
        );
    }

}
