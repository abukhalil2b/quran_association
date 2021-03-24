<div class="col-lg-12  mt-1">
	<div class="card p-2">
		الطلاب المسجلون في الحلقة
		<ol>
		@if($quarterlyProgramCircle)
			@foreach($quarterlyProgramCircle->students as $student)
				<li>
					<a href="{{route('student.show',['student'=>$student->id])}}">
					{{$student->name}}
					</a>
				</li>
			@endforeach
		@else
		<h5>لايوجد حلقة</h5>
		@endif
		</ol>
	</div>
</div>