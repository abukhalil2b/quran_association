<x-app-layout>
<div class="container">
    <div class="row ">
        <div class="col-md-12">
        	<h5>{{$course->title}}</h5>
        	<a class="pull-left" href="{{route('course.student.male_create',['course'=>$course->id])}}">
          +متدرب جديد ({{__('males')}})
          </a>

          <a class="ml-3 pull-left" href="{{route('course.student.female_create',['course'=>$course->id])}}">
          +متدرب جديد ({{__('females')}})
          </a>

           	@foreach($students as $student)
           	<div class="">
              {{$student->name}}
           		<small>{{__('join_date')}} {{$student->pivot->join_date}}</small>
              <span class="text-left">
                <a href="{{route('course.student.delete',['student'=>$student->id,'course'=>$course->id])}}">{{__('delete')}}</a>
              </span>
           	</div>
           	@endforeach
        </div>
    </div>
</div>
</x-app-layout>
