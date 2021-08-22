<x-app-layout>
<div class="container">
    <div class="row ">
        <div class="col-md-12">
        	<h5>{{$course->title}}</h5>
        	<a class="pull-left" href="{{route('course.student.create',['course'=>$course->id])}}">+متدرب جديد</a>
           	@foreach($students as $student)
           	<div class="">
           		{{$student->name}}
           	</div>
           	@endforeach
        </div>
    </div>
</div>
</x-app-layout>
