<div class="col-md-12 mt-3">
	<div>
		<span class="text-primary">برامج فصلية</span>
		@foreach($quarterlyProgramCircles as $circle)
			<div class="card mt-1">

				<a href="{{route('circle.dashboard',['circle'=>$circle->id])}}">
				<div class="alert alert-secondary">

                    <small class="text-primary">البرنامج: </small>{{$circle->program->title}} -
	    			<small class="text-primary">الحلقة: </small>{{$circle->title}}

                </div>
                </a>


                <div class="px-1">
	    			<small class="text-primary">الفصل: </small>{{$circle->program->semester->title}} -
	    			<small class="text-primary">السنة الدراسية: </small>{{$circle->program->semester->year->title}}
                </div>
				<div class="divider"></div>
				<div class="px-1">
                    <small class="text-primary">المشرف على الحلقة: </small>{{$circle->supervisor->accountOwner->name}}
                </div>
				<div class="px-1">
					<small class="text-primary">المدرس: </small>
					@if($circle->teacher)
					{{$circle->teacher->accountOwner->name}}
					@else
					لا يوجد مدرس
					@endif
				</div>
				<div class="divider"></div>
				<div class="px-1">
					<small class="text-primary">الطلاب: </small>
					@foreach($circle->students as $student)
					<div>{{$student->name}}</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</div>