<div class="col-md-12">
	<h5><span class="text-primary">حلقة الطالب: </span>{{$student->name}}</h5>
</div>
<div class="col-md-12">
<div class="card mt-3">
    <a class="alert alert-secondary" href="{{route('student.circle.show',['student'=>$student->id,'circle'=>$circle->id])}}">
     {{$circle->title}} 
    </a>
    <div class="text-info px-3">
        @include('student._leftside_links')
    </div>
    @if($circle->teacher)
        @include('program_report._create')
    @else
    <center>لا يوجد مدرس</center>
    @endif
</div>
</div>