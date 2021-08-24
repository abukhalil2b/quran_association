<div class="col-lg-12 mt-1">
    @foreach($incessantProgramCircles as $circle)
	<div class="card p-2 mt-1">
        <div>
            <small class="text-primary">البرنامج:  {{$circle->program->title}}
            </small>
             - 
			<small class="text-primary">الحلقة: </small>
            <a href="{{route('teacher.incessant_program.show',['circle'=>$circle->id])}}"> {{$circle->title}}</a>
        </div>
        <div>
            <small class="text-primary">المشرف على الحلقة: </small>
        </div>
	</div>
    @endforeach
</div>