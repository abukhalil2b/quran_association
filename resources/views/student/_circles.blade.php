<div class="col-md-12">
	<h5><span class="text-primary">حلقات الطالب: </span>{{$student->name}}</h5>
</div>
@foreach($circles as $circle)
<div class="col-md-12">
    <div class="card mt-3">
        <a class="alert alert-secondary" href="{{route('student.circle.show',['student'=>$student->id,'circle'=>$circle->id])}}">
         {{$circle->title}} 
        </a>
        <div class="text-info px-3">
            @include('student._leftside_links')
        </div>
        @if($circle->teacher)
        <div class="card-body">

        </div>
        @else
        <center>لا يوجد مدرس</center>
        @endif
    </div>
</div>
@endforeach