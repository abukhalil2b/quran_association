<x-app-layout>
<div class="container">
    <div class="row ">
        <div class="col-md-12">
        	<h5>{{$course->title}}</h5>
          <center>
            <a class="font-bold text-blue-700 ml-2" href="{{route('certificate.upload_male_certificate_create',['course'=>$course->id])}}">
            رفع الشهادات
            </a>
          </center>
        	<a class="pull-left" href="{{route('course.student.male_create',['course'=>$course->id])}}">
          +متدرب جديد
          </a>
            المشتركين في الدورة
           	@foreach($students as $student)
           	<div class="">
              <div>({{$student->id}}) {{$student->name}}</div>
           		<small class="text-extra-small">{{__('join_date')}} {{$student->pivot->join_date}}</small>
              <span class="text-left">
                <a href="{{route('course.student.delete',['student'=>$student->id,'course'=>$course->id])}}" class="text-danger mr-2">{{__('delete')}}</a>
              </span>
           	</div>
           	@endforeach
            
        </div>
    </div>
</div>
</x-app-layout>
