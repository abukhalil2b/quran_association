<x-app-layout>
<div class="container">
     <h5>الدورات</h5>
    <div class="row">
        @foreach($courses as $course)
        <div class="col-md-4 mt-2">
        	<div class="round-box">
                {{$course->title}}
                <hr>
                <a href="{{route('certificate.create',['course'=>$course->id,'gender'=>'male'])}}">+ اضافة الشهادة ({{__('male')}})</a>
                <a class="mr-2" href="{{route('certificate.create',['course'=>$course->id,'gender'=>'female'])}}">+ اضافة الشهادة ({{__('female')}})</a>
        		<a class="mr-2" href="{{route('certificate.student_with_certificate_index',['course'=>$course->id])}}">
                ال{{__('students')}}
                </a>
        	</div>
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>