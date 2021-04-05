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
            <small>
                <div>
                    <span class="text-primary">المدرس: </span>
                    @if($circle->teacher)
                    {{$circle->teacher->accountOwner->name}}
                    @endif
                </div>
                <div><span class="text-primary">البرنامج: </span>{{$circle->program->title}}</div>
                @if($circle->program->semester)
                {{$circle->program->semester->year->title}} -
                {{$circle->program->semester->title}}
                @else
                برنامج مستمر
                @endif
            </small>
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