<div class="col-lg-12  mt-1">
	@foreach($quarterlyProgramCircles as $circle)
	<div class="card p-2 mt-1">
        <div>
            <small class="text-primary">البرنامج:  
            </small>{{$circle->program->title}} 
             - 
			<small class="text-primary">الحلقة: </small>
            <a href="{{route('teacher.quarterly_program.show',['circle'=>$circle->id])}}"> {{$circle->title}}</a>
        </div>
        <div>
            <small class="text-primary">المشرف على الحلقة: </small>{{$circle->supervisor->accountOwner->name}}
        </div>
        <div>
			<small class="text-primary">الفصل: </small>{{$circle->program->semester->title}} -
			<small class="text-primary">السنة الدراسية: </small>{{$circle->program->semester->year->title}}
        </div>
	</div>
	@endforeach
</div>