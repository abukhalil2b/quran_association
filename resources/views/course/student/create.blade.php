<x-app-layout>
<div class="container">
    <div class="row ">
        <div class="col-md-12">
        	<h5>{{$course->title}}</h5>
          @if(count($students))
           <form action="{{route('course.student.store',['course'=>$course->id])}}" method="post">
           	@csrf
           	@foreach($students as $student)
           	<div class="">
           		<input type="checkbox" name="studentIds[]" value="{{$student->id}}">
           		{{$student->name}}
           	</div>
           	@endforeach
            <button class="btn btn-outline-secondary btn-block">حفظ</button>
            </form>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
